<?php

namespace App\Policies\Addworking\Mission;

use App\Models\Addworking\Mission\MissionTracking;
use App\Models\Addworking\Mission\MissionTrackingLine;
use App\Models\Addworking\User\User;
use App\Repositories\Addworking\Mission\MissionTrackingLineRepository;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\App;

class MissionTrackingLinePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user, MissionTracking $tracking)
    {
        if ($user->isSupport()) {
            return Response::allow();
        }

        if (! $user->hasRoleFor($tracking->mission->customer, [User::IS_ADMIN, User::IS_OPERATOR]) &&
            ! $user->hasRoleFor($tracking->mission->vendor, [User::IS_ADMIN, User::IS_OPERATOR])
        ) {
            return Response::deny("you must be admin or operator");
        }

        if (! $user->hasAccessFor($tracking->mission->customer, [User::ACCESS_TO_MISSION]) &&
            ! $user->hasAccessFor($tracking->mission->vendor, [User::ACCESS_TO_MISSION])
        ) {
            return Response::deny("you must have access to mission");
        }

        return Response::allow();
    }

    public function create(User $user, MissionTracking $tracking)
    {
        return $this->viewAny($user, $tracking);
    }

    public function view(User $user, MissionTrackingLine $line)
    {
        return $this->viewAny($user, $line->missionTracking);
    }

    public function edit(User $user, MissionTrackingLine $line)
    {
        if ($user->isSupport()) {
            return Response::allow();
        }

        if (is_null($line->createdBy()->first())) {
            return Response::deny('Not editable by non support');
        }

        if (! App::make(MissionTrackingLineRepository::class)->isValidated($line) &&
            ! App::make(MissionTrackingLineRepository::class)->isRejected($line) &&
            ! is_null($line->createdBy()->first()) &&
            $line->createdBy()->first()->enterprise->users()->get()->contains($user->id)
        ) {
            return Response::allow();
        }

        return Response::deny("you can't edit this mission tracking line");
    }

    public function destroy(User $user, MissionTrackingLine $line)
    {
        return $this->edit($user, $line);
    }

    public function forceDelete(User $user, MissionTrackingLine $line)
    {
        return Response::deny();
    }

    public function validationCustomer(User $user, MissionTrackingLine $line)
    {
        if ($user->isSupport()) {
            return Response::allow();
        }

        if (! $user->hasRoleFor($line->missionTracking->mission->customer, [User::IS_ADMIN, User::IS_OPERATOR])) {
            return Response::deny("you must be admin or operator");
        }

        if (! $user->hasAccessFor($line->missionTracking->mission->customer, [User::IS_ADMIN, User::IS_OPERATOR])) {
            return Response::deny("you must have access to mission");
        }

        return Response::allow();
    }

    public function validationVendor(User $user, MissionTrackingLine $line)
    {
        if ($user->isSupport()) {
            return Response::allow();
        }

        if (! $user->hasRoleFor($line->missionTracking->mission->vendor, [User::IS_ADMIN, User::IS_OPERATOR])) {
            return Response::deny("you must be admin or operator");
        }

        if (! $user->hasAccessFor($line->missionTracking->mission->vendor, [User::IS_ADMIN, User::IS_OPERATOR])) {
            return Response::deny("you must have access to mission");
        }

        return Response::allow();
    }
}
