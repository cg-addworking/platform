<?php

namespace App\Policies\Addworking\Enterprise\Concerns\Enterprise;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use Illuminate\Auth\Access\Response;

trait HasInformationPolicy
{
    public function viewPhoneNumbersInfo(User $user, Enterprise $model)
    {
        return $this->indexMember($user, $model);
    }

    public function viewIbanInfo(User $user, Enterprise $model)
    {
        return $this->indexMember($user, $model);
    }

    public function viewCustomersInfo(User $user, Enterprise $model)
    {
        return $this->indexMember($user, $model);
    }

    public function viewIdInfo(User $user, Enterprise $model)
    {
        return $this->indexMember($user, $model);
    }

    public function viewNumberInfo(User $user, Enterprise $model)
    {
        return $this->indexMember($user, $model);
    }

    public function viewClientIdInfo(User $user, Enterprise $model)
    {
        return $this->indexMember($user, $model);
    }

    public function viewTimestampInfo(User $user, Enterprise $model)
    {
        return $this->indexMember($user, $model);
    }

    public function viewTagsInfo(User $user, Enterprise $model)
    {
        return $this->indexMember($user, $model);
    }

    public function viewShowMember(User $user, Enterprise $model)
    {
        return $this->showMember($user, $model);
    }
}
