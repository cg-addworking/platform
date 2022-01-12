<?php

namespace App\Policies\Addworking\User;

use App\Models\Addworking\User\OnboardingProcess;
use App\Models\Addworking\User\User as User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OnboardingProcessPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can index the OnboardingProcess.
     *
     * @param  User  $user
     * @param  OnboardingProcess  $onboarding_process
     * @return mixed
     */
    public function index(User $user)
    {
        return $user->isSystemSuperadmin()
            || $user->isSystemAdmin()
            || $user->isSystemOperator();
    }

    /**
     * Determine whether the user can view the OnboardingProcess.
     *
     * @param  User  $user
     * @param  OnboardingProcess  $onboarding_process
     * @return mixed
     */
    public function show(User $user, OnboardingProcess $onboarding_process)
    {
        return $user->isSystemSuperadmin()
            || $user->isSystemAdmin()
            || $user->isSystemOperator();
    }

    /**
     * Determine whether the user can create OnboardingProcess.
     *
     * @param  User  $user
     * @return mixed
     */
    public function edit(User $user, OnboardingProcess $onboarding_process)
    {
        return $user->isSystemSuperadmin()
            || $user->isSystemAdmin()
            || $user->isSystemOperator();
    }

    /**
     * Determine whether the user can create OnboardingProcess.
     *
     * @param  User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->isSystemSuperadmin()
            || $user->isSystemAdmin()
            || $user->isSystemOperator();
    }

    /**
     * Determine whether the user can create OnboardingProcess.
     *
     * @param  User  $user
     * @return mixed
     */
    public function store(User $user)
    {
        return $this->create($user);
    }

    /**
     * Determine whether the user can update the OnboardingProcess.
     *
     * @param  User  $user
     * @param  OnboardingProcess  $onboarding_process
     * @return mixed
     */
    public function update(User $user, OnboardingProcess $onboarding_process)
    {
        return $this->edit($user, $onboarding_process);
    }

    /**
     * Determine whether the user can delete the OnboardingProcess.
     *
     * @param  User  $user
     * @param  OnboardingProcess  $onboarding_process
     * @return mixed
     */
    public function destroy(User $user, OnboardingProcess $onboarding_process)
    {
        return $user->isSystemSuperadmin()
            || $user->isSystemAdmin()
            || $user->isSystemOperator();
    }
}
