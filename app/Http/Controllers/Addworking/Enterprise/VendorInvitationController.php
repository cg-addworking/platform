<?php

namespace App\Http\Controllers\Addworking\Enterprise;

use App\Events\UserRegistration;
use App\Http\Controllers\Controller;
use App\Http\Requests\Addworking\Enterprise\StoreVendorInvitationRequest;
use App\Http\Requests\Addworking\Enterprise\ValidateInvitationVendorRequest;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Enterprise\Invitation;
use App\Models\Addworking\User\User;
use App\Repositories\Addworking\Enterprise\EnterpriseRepository;
use App\Repositories\Addworking\Enterprise\InvitationRepository;
use App\Repositories\Addworking\User\UserRepository;
use App\Support\Token\InvitationTokenManager;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class VendorInvitationController extends Controller
{
    protected $repository;
    protected $userRepository;
    protected $enterpriseRepository;
    protected $manager;

    public function __construct(
        InvitationRepository $repository,
        UserRepository $userRepository,
        EnterpriseRepository $enterpriseRepository,
        InvitationTokenManager $manager
    ) {
        $this->repository = $repository;
        $this->userRepository = $userRepository;
        $this->enterpriseRepository = $enterpriseRepository;
        $this->manager = $manager;
    }

    public function create(Enterprise $enterprise)
    {
        $this->authorize('inviteVendor', $enterprise);

        return view('addworking.enterprise.vendor.invitation.create', ['enterprise' => $enterprise]);
    }

    public function store(Enterprise $enterprise, StoreVendorInvitationRequest $request)
    {
        $this->authorize('inviteVendor', $enterprise);

        $invitations = $this->prepareInvitations($request->get('emails', []));

        $errors = [];

        foreach ($invitations as $invitation) {
            $email = $invitation['email'];
            if (isset($errors[$email]) || true !== ($error = InvitationRepository::canSend($email, $enterprise->id))) {
                $errors[$email] = $errors[$email] ?? "{$email}: {$error}";
                continue;
            }

            $this->repository->sendInvitation(
                $this->repository->createInvitation([
                    'type' => Invitation::TYPE_VENDOR,
                    'contact' => $email,
                    'contact_name' => $invitation['contact_name'],
                    'contact_enterprise_name' => $invitation['contact_enterprise_name'],
                ], $enterprise)
            );
        }

        if (count($errors) > 0) {
            return redirect(route('addworking.enterprise.vendor.invitation.create', compact('enterprise')))
                ->withErrors($errors)->withInput(['emails' => implode("\n", array_keys($errors))]);
        }

        return redirect(route('addworking.enterprise.invitation.index', compact('enterprise')));
    }

    public function prepareInvitations(array $lines)
    {
        $invitations = [];

        foreach ($lines as $line) {
            $parts = explode(",", $line);
            $invitation['email'] = $parts[0];
            $invitation['contact_name'] = $parts[1] ?? 'n/a';
            $invitation['contact_enterprise_name'] = $parts[2] ?? 'n/a';

            $invitations[] = $invitation;
        }

        return $invitations;
    }

    public function review(Request $request)
    {
        if (($token = $this->decodeToken($request)) === null) {
            return redirect(route('dashboard'));
        }

        $this->repository->find($token->invitation_id)->markAs(Invitation::STATUS_IN_PROGRESS)->save();

        return view('addworking.enterprise.vendor.invitation.review', [
            'token' => $request->get('token', ''),
            'guest' => User::where('email', $token->email)->firstOrNew(['email' => $token->email]),
            'host' => $this->enterpriseRepository->find($token->host_id),
        ]);
    }

    public function accept(ValidateInvitationVendorRequest $request)
    {
        if (($token = $this->decodeToken($request)) === null) {
            return redirect(route('dashboard'));
        }

        $invitation = $this->repository->find($token->invitation_id);
        $host = $this->enterpriseRepository->find($token->host_id);
        $guest = User::where('email', $token->email)->firstOrNew([]);
        $guest_enterprise = Enterprise::where('id', $request->get('guest_enterprise'))->firstOrNew([]);

        if (isset($guest->id)) {
            $host->vendors()->attach($guest_enterprise, ['activity_starts_at' => Carbon::now()]);
        } else {
            $guest = $this->userRepository->createFromRequest($request);
            Auth::login($guest);
            event(new UserRegistration($guest));
        }

        $this->repository->validateInvitation($invitation, $guest, $guest_enterprise);

        return redirect(route('dashboard'));
    }

    private function decodeToken(Request $request)
    {
        try {
            return $this->manager->decode($request->get('token', ''));
        } catch (\Exception $e) {
            Log::debug($e->getMessage(), ['token' => $request->get('token', '')]);
            return null;
        }
    }
}
