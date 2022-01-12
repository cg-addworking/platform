<?php

namespace App\Policies\Soprema\Enterprise;

use App\Models\Addworking\User\User;
use App\Models\Soprema\Enterprise\Covid19FormAnswer;
use Illuminate\Auth\Access\HandlesAuthorization;

class Covid19FormAnswerPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, Covid19FormAnswer $covid19_form_answer)
    {
        return true;
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, Covid19FormAnswer $covid19_form_answer)
    {
        return true;
    }

    public function delete(User $user, Covid19FormAnswer $covid19_form_answer)
    {
        return true;
    }

    public function restore(User $user, Covid19FormAnswer $covid19_form_answer)
    {
        return true;
    }

    public function forceDelete(User $user, Covid19FormAnswer $covid19_form_answer)
    {
        return true;
    }
}
