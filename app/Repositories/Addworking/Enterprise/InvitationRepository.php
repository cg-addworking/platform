<?php

namespace App\Repositories\Addworking\Enterprise;

use App\Models\Addworking\Enterprise\Invitation;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use App\Notifications\Addworking\Enterprise\InviteMemberNotification;
use App\Notifications\Addworking\Enterprise\InviteVendorMissionNotification;
use App\Notifications\Addworking\Enterprise\InviteVendorNotification;
use App\Repositories\Addworking\Mission\OfferRepository;
use App\Repositories\Addworking\Mission\ProposalRepository;
use App\Repositories\Addworking\User\UserRepository;
use App\Support\Token\InvitationTokenManager;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use App\Repositories\BaseRepository;
use InvalidArgumentException;
use Carbon\Carbon;

class InvitationRepository extends BaseRepository
{
    protected $model = Invitation::class;
    protected $manager;
    protected $offerRepository;
    protected $userRepository;

    public function __construct(
        InvitationTokenManager $manager,
        OfferRepository $offerRepository,
        UserRepository $userRepository
    ) {
        $this->manager = $manager;
        $this->offerRepository = $offerRepository;
        $this->userRepository = $userRepository;
    }

    public function list(?string $search = null, ?array $filter = null): Builder
    {
        return Invitation::query()
            ->when($filter['invite'] ?? null, function ($query, string $invite) {
                return $query->filterInvite($invite);
            })
            ->when($filter['contact'] ?? null, function ($query, $contact) {
                return $query->where('contact', 'like', "%{$contact}%");
            })
            ->when($filter['status'] ?? null, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->when($filter['type'] ?? null, function ($query, $type) {
                return $query->where('type', $type);
            });
    }

    public function createInvitation(array $data, Enterprise $enterprise): Invitation
    {
        /** @var Invitation $invitation */
        $invitation = $this->make([
            'contact' => $data['contact'],
            'contact_name' => $data['contact_name'],
            'contact_enterprise_name' => $data['contact_enterprise_name'],
            'status' => Invitation::STATUS_PENDING,
            'type' => $data['type'],
            'additional_data' => $data['additional_data'] ?? [],
            'valid_until' => Carbon::now()->addDays(Invitation::DELAY_IN_DAYS),
        ]);

        $invitation->host()->associate($enterprise);
        $invitation->save();

        return $invitation;
    }

    public static function canSend(string $contact, string $host)
    {
        if (!is_email($contact)) {
            return 'Addresse email invalide';
        }

        if (Invitation::where('contact', $contact)->doesntExist()) {
            return true;
        }

        if (Invitation::where('contact', $contact)->where('host_id', $host)->doesntExist()) {
            return true;
        }

        $invitations = Invitation::where('contact', $contact)->where('host_id', $host)->whereIn('status', [
            Invitation::STATUS_ACCEPTED,
            Invitation::STATUS_PENDING,
            Invitation::STATUS_IN_PROGRESS
        ])->get();

        if ($invitations->isEmpty()) {
            return true;
        }

        return Invitation::getMessageByStatus()[$invitations->first()->status];
    }

    public function sendInvitation(Invitation $invitation)
    {
        $notification = null;

        switch ($invitation->type) {
            case Invitation::TYPE_MEMBER:
                $notification = new InviteMemberNotification($invitation, $this->manager);
                break;
            case Invitation::TYPE_VENDOR:
                $notification = new InviteVendorNotification($invitation, $this->manager);
                break;
            case Invitation::TYPE_MISSION:
                $notification = new InviteVendorMissionNotification($invitation, $this->manager);
                break;
            default:
                throw new InvalidArgumentException("Invalid invitation type [{$invitation->type}]");
        }

        Notification::route('mail', $invitation->contact)->notify($notification);
    }

    public function sendVendorInvitationForMissionProposal(string $host_id, array $additional_data = [])
    {
        Invitation::where('host_id', $host_id)
            ->where('type', Invitation::TYPE_VENDOR)
            ->each(function (Invitation $invitation) use ($additional_data) {
                $invitation->update(['additional_data' => $additional_data, 'type' => Invitation::TYPE_MISSION]);
                $this->sendInvitation($invitation);
            });
    }

    public function acceptInvitation(Invitation $invitation, Enterprise $guest_enterprise): Invitation
    {
        $result = $invitation->guestEnterprise()->associate($guest_enterprise)
            ->markAs(Invitation::STATUS_ACCEPTED)
            ->save();

        if (!$result) {
            throw new \RuntimeException("Cannot validate invitation for '{$invitation->contact}'");
        }

        if ($invitation->type === Invitation::TYPE_MISSION) {
            $this->createMissionProposalFromInvitation($invitation);
        }

        return $invitation;
    }

    public function validateInvitation(Invitation $invitation, User $guest, ?Enterprise $guest_enterprise)
    {
        DB::transaction(function () use ($invitation, $guest, $guest_enterprise) {
            $invitation->guest()->associate($guest)->update(['contact' => $guest->email]);
            if (isset($guest_enterprise->id)) {
                $this->acceptInvitation($invitation, $guest_enterprise);
            }
        });
    }

    public function checkIfPendingInvitationExistsFor(User $user, Enterprise $enterprise)
    {
        /** @var Builder $result */
        $result = Invitation::where('guest_id', $user->id)
            ->where('status', Invitation::STATUS_IN_PROGRESS)
            ->whereIn('type', [Invitation::TYPE_VENDOR, Invitation::TYPE_MISSION]);

        if ($result->exists()) {
            DB::transaction(function () use ($result, $enterprise) {
                $result->each(function (Invitation $invitation) use ($enterprise) {
                    $this->acceptInvitation($invitation, $enterprise)->host->vendors()->attach(
                        $enterprise,
                        ['activity_starts_at' => Carbon::now()]
                    );
                });
            });
        }
    }

    public function createMissionProposalFromInvitation(Invitation $invitation)
    {
        $mandatory_keys = ['offer_id', 'created_by', 'mission_proposal'];

        if (!Arr::has($invitation->additional_data, $mandatory_keys)) {
            throw new \LogicException(
                sprintf(
                    "Missing infos for creating mission proposal, got only [%s], expected [%s]",
                    implode(', ', $invitation->additional_data),
                    implode(', ', $mandatory_keys)
                )
            );
        }

        App::make(ProposalRepository::class)->createProposal(
            $this->offerRepository->find($invitation->additional_data['offer_id']),
            $invitation->guestEnterprise,
            $invitation->additional_data['mission_proposal'],
            $this->userRepository->find($invitation->additional_data['created_by']),
            false
        );
    }

    public function getItemsThatCanBeRelaunched(Enterprise $enterprise)
    {
        return Invitation::whereHas('host', function ($query) use ($enterprise) {
            return $query->where('id', $enterprise->id);
        })->whereIn('status', [Invitation::STATUS_PENDING, Invitation::STATUS_REJECTED])
        ->paginate(100);
    }

    public function canBeRelaunched(Invitation $invitation)
    {
        if ($invitation->getStatus() === Invitation::STATUS_ACCEPTED
                || $invitation->getStatus() === Invitation::STATUS_IN_PROGRESS) {
            return false;
        }

        return true;
    }
}
