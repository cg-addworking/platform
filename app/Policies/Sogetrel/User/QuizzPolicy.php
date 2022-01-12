<?php

namespace App\Policies\Sogetrel\User;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use App\Models\Sogetrel\User\Quizz;
use Illuminate\Auth\Access\HandlesAuthorization;

class QuizzPolicy
{
    use HandlesAuthorization;

    public function index(User $user)
    {
        if (! Enterprise::whereName('SOGETREL')->exists()) {
            return false;
        }

        $subsidiaries = Enterprise::fromName('SOGETREL')->descendants();

        return $user->isSupport()
            || $user->hasAccessToUser()
            && $subsidiaries->contains($user->enterprise);
    }

    public function create(User $user)
    {
        return $this->index($user);
    }

    public function store(User $user)
    {
        return $this->index($user);
    }

    public function show(User $user, Quizz $quizz)
    {
        return $this->index($user);
    }

    public function edit(User $user, Quizz $quizz)
    {
        return $this->index($user);
    }

    public function update(User $user, Quizz $quizz)
    {
        return $this->index($user);
    }

    public function destroy(User $user, Quizz $quizz)
    {
        return $this->index($user);
    }
}
