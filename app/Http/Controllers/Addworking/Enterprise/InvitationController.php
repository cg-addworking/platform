<?php

namespace App\Http\Controllers\Addworking\Enterprise;

use App\Http\Controllers\Controller;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Enterprise\Invitation;
use App\Repositories\Addworking\Enterprise\InvitationRepository;
use App\Support\Token\InvitationTokenManager;
use Components\Infrastructure\Foundation\Application\Http\Controller\HandlesIndex;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Log\Logger;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;

class InvitationController extends Controller
{
    use HandlesIndex;

    protected $repository;
    protected $manager;

    public function __construct(InvitationRepository $repository, InvitationTokenManager $manager)
    {
        $this->repository = $repository;
        $this->manager = $manager;
    }

    public function index(Request $request, Enterprise $enterprise)
    {
        $this->authorize('showInvitation', $enterprise);

        $items = $this->getPaginatorFromRequest($request, function (Builder $query) use ($enterprise) {
            return $query->where('host_id', $enterprise->id);
        });

        return view('addworking.enterprise.invitation.index', compact('enterprise', 'items'));
    }

    public function indexRelaunch(Enterprise $enterprise)
    {
        $this->authorize('indexRelaunch', $enterprise);

        $items = $this->repository->getItemsThatCanBeRelaunched($enterprise);

        return view('addworking.enterprise.invitation.index_relaunch', compact('enterprise', 'items'));
    }

    public function relaunchMultiple(Enterprise $enterprise, Request $request)
    {
        $this->authorize('indexRelaunch', $enterprise);

        foreach ($request->input('invitation.id') as $id) {
            $invitation = Invitation::where('id', $id)->first();

            if (is_null($invitation)) {
                throw new \Exception("Invitation doesn't exist.");
            }

            if (! $this->repository->canBeRelaunched($invitation)) {
                throw new \Exception("Invitation hasn't right status for to be relaunched.");
            }

            $this->repository->sendInvitation($invitation);
        }

        return redirect(route('addworking.enterprise.invitation.index', compact('enterprise')));
    }

    public function destroy(Enterprise $enterprise, Invitation $invitation)
    {
        $this->authorize('deleteInvitation', $enterprise);

        $invitation->delete();

        return redirect(route('addworking.enterprise.invitation.index', compact('enterprise')));
    }

    public function show(Enterprise $enterprise, Invitation $invitation)
    {
        $this->authorize('showInvitation', $enterprise);

        return view('addworking.enterprise.invitation.show', compact('enterprise', 'invitation'));
    }

    public function relaunch(Enterprise $enterprise, Invitation $invitation)
    {
        $this->authorize('relaunchInvitation', [$enterprise, $invitation]);

        if (!$invitation->markAs(Invitation::STATUS_PENDING)->resetExpiringDate()->save()) {
            throw new \RuntimeException("Cannot relaunch this invitation [{$invitation->id}]");
        }

        $this->repository->sendInvitation($invitation);

        return redirect(route('addworking.enterprise.invitation.index', compact('enterprise')));
    }

    public function response(Request $request)
    {
        $token = $request->get('token', '');
        if (($decodedToken = $this->decodeToken($request)) === null) {
            return redirect(route('dashboard'));
        }

        $invitation = $this->repository->find($decodedToken->invitation_id);

        if (isset($decodedToken->is_accepted) && !$decodedToken->is_accepted) {
            $invitation->markAs(Invitation::STATUS_REJECTED)->save();
            return redirect(route('dashboard'));
        }

        switch ($invitation->type) {
            case Invitation::TYPE_MEMBER:
                return redirect(route('addworking.enterprise.member.invitation.review', compact('token')));
            case Invitation::TYPE_MISSION:
            case Invitation::TYPE_VENDOR:
                return redirect(route('addworking.enterprise.vendor.invitation.review', compact('token')));

            default:
                throw new InvalidArgumentException("Invalid invitation type [{$invitation->type}]");
        }
    }

    /** @deprecated To be removed when no more url are referencing this route */
    public function refuse(Request $request)
    {
        if (($decodedToken = $this->decodeToken($request->get('token', ''))) === null) {
            return redirect(route('dashboard'));
        }
        $this->repository->find($decodedToken->invitation_id)->markAs(Invitation::STATUS_REJECTED)->save();

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
