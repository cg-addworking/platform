<?php

namespace App\Policies\Addworking\Enterprise;

use App\Models\Addworking\User\User;
use App\Models\Addworking\Enterprise\Iban;
use Illuminate\Auth\Access\HandlesAuthorization;

class IbanPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can index the iban.
     *
     * @param  \App\Models\Addworking\User\User  $user
     * @param  \App\App\Models\Addworking\Enterprise\Iban  $iban
     * @return mixed
     */
    public function index(User $user, Iban $iban)
    {
        return $user->isSupport();
    }

    /**
     * Determine whether the user can create the iban.
     *
     * @param  \App\Models\Addworking\User\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->isSupport()
            || $user->hasRole(User::IS_ADMIN)
            && $user->hasAccessToEnterprise()
            && $user->enterprise->isVendor();
    }

    /**
     * Determine whether the user can store the iban.
     *
     * @param  \App\Models\Addworking\User\User  $user
     * @return mixed
     */
    public function store(User $user)
    {
        return $this->create($user);
    }

    /**
     * Determine whether the user can show the iban.
     *
     * @param  \App\Models\Addworking\User\User  $user
     * @param  \App\App\Models\Addworking\Enterprise\Iban  $iban
     * @return mixed
     */
    public function show(User $user, Iban $iban)
    {
        return $user->isSupport()
            || $user->hasRoleFor($iban->enterprise, User::IS_ADMIN)
            && $user->hasAccessFor($iban->enterprise, User::ACCESS_TO_ENTERPRISE);
    }

    /**
     * Determine whether the user can edit the iban.
     *
     * @param  \App\Models\Addworking\User\User  $user
     * @param  \App\App\Models\Addworking\Enterprise\Iban  $iban
     * @return mixed
     */
    public function edit(User $user, Iban $iban)
    {
        return $this->show($user, $iban) && !$iban->isPending();
    }

    /**
     * Determine whether the user can update the iban.
     *
     * @param  \App\Models\Addworking\User\User  $user
     * @param  \App\App\Models\Addworking\Enterprise\Iban  $iban
     * @return mixed
     */
    public function update(User $user, Iban $iban)
    {
        return $this->show($user, $iban);
    }

    /**
     * Determine whether the user can destroy the iban.
     *
     * @param  \App\Models\Addworking\User\User  $user
     * @param  \App\App\Models\Addworking\Enterprise\Iban  $iban
     * @return mixed
     */
    public function destroy(User $user, Iban $iban)
    {
        return $this->show($user, $iban);
    }

    /**
     * Determine whether the user can confirm the iban.
     *
     * @param  \App\Models\Addworking\User\User  $user
     * @param  \App\App\Models\Addworking\Enterprise\Iban  $iban
     * @return mixed
     */
    public function confirm(User $user, Iban $iban)
    {
        return $this->show($user, $iban);
    }

    /**
     * Determine whether the user can cancel the iban.
     *
     * @param  \App\Models\Addworking\User\User  $user
     * @param  \App\App\Models\Addworking\Enterprise\Iban  $iban
     * @return mixed
     */
    public function cancel(User $user, Iban $iban)
    {
        return $this->show($user, $iban);
    }

    /**
     * Determine whether the user can resend the iban change confirmation email.
     *
     * @param  \App\Models\Addworking\User\User  $user
     * @param  \App\App\Models\Addworking\Enterprise\Iban  $iban
     * @return mixed
     */
    public function resend(User $user, Iban $iban)
    {
        return $this->show($user, $iban);
    }
}
