<?php

namespace Components\Sogetrel\Mission\Application\Policies;

use App\Models\Addworking\User\User;
use Components\Sogetrel\Mission\Application\Models\MissionTrackingLineAttachment;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class MissionTrackingLineAttachmentPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        if (! $user->isSupport()) {
            return Response::deny(
                __("components.sogetrel.mission.application.policies.index.denied_must_be_support_user")
            );
        }

        return Response::allow();
    }

    public function create(User $user)
    {
        if (! $user->isSupport()) {
            return Response::deny(
                __("components.sogetrel.mission.application.policies.create.denied_must_be_support_user")
            );
        }

        return Response::allow();
    }

    public function view(User $user, MissionTrackingLineAttachment $mission_tracking_line_attachment)
    {
        if (! $user->isSupport()) {
            return Response::deny(
                __("components.sogetrel.mission.application.policies.view.denied_must_be_support_user")
            );
        }

        return Response::allow();
    }

    public function update(User $user, MissionTrackingLineAttachment $mission_tracking_line_attachment)
    {
        if (! $user->isSupport()) {
            return Response::deny(
                __("components.sogetrel.mission.application.policies.update.denied_must_be_support_user")
            );
        }

        return Response::allow();
    }

    public function delete(User $user, MissionTrackingLineAttachment $mission_tracking_line_attachment)
    {
        return false;
    }
}
