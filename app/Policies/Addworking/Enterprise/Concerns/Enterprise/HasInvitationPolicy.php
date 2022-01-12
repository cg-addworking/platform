<?php

namespace App\Policies\Addworking\Enterprise\Concerns\Enterprise;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Enterprise\Invitation;
use App\Models\Addworking\User\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\App;
use App\Repositories\Addworking\Enterprise\InvitationRepository;

trait HasInvitationPolicy
{
    public function showInvitation(User $user, Enterprise $enterprise)
    {
        return $user->hasRoleFor($enterprise, User::ROLE_INVITE_VENDORS) || $user->isAdminFor($enterprise);
    }

    public function inviteMember(User $user, Enterprise $enterprise)
    {
        return $user->isAdminFor($enterprise);
    }

    public function inviteVendor(User $user, Enterprise $enterprise)
    {
        return $user->hasRoleFor($enterprise, User::ROLE_INVITE_VENDORS) && $enterprise->isCustomer();
    }

    public function deleteInvitation(User $user, Enterprise $enterprise)
    {
        return $user->isAdminFor($enterprise);
    }

    public function relaunchInvitation(User $user, Enterprise $enterprise, Invitation $invitation)
    {
        return ( ($user->isAdminFor($enterprise) || $user->hasRoleFor($enterprise, User::ROLE_INVITE_VENDORS))
            && !($invitation->isAccepted()|| $invitation->isValidating()));
    }

    public function indexRelaunch(User $user, Enterprise $enterprise)
    {
        if (! ($user->isAdminFor($enterprise) || $user->hasRoleFor($enterprise, User::ROLE_INVITE_VENDORS))) {
            return Response::deny("Connected user has not permission for this action");
        }

        return Response::allow();
    }

    public function relaunchInvitationInBatch(User $user, Enterprise $enterprise)
    {
        return App::make(InvitationRepository::class)->getItemsThatCanBeRelaunched($enterprise)->count()
            && auth()->user()->hasRoleFor($enterprise, User::ROLE_INVITE_VENDORS);
    }
}
