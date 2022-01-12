<?php

namespace App\Policies\Addworking\User;

use App\Models\Addworking\User\User;

trait ProfilePolicy
{
    /**
     * This method checks the right of access to the index method in
     * ProfileController
     *
     * Determines whether the user can view his profile.
     *
     * @param  \App\Models\Addworking\User\User $user
     * @return Boolean
     */
    public function indexProfile(User $user)
    {
        return true;
    }

    /**
     * This method checks the right of access to the edit method in
     * ProfileController
     *
     * Determines whether the user can edit his profile.
     *
     * @param  \App\Models\Addworking\User\User $user
     * @return Boolean
     */
    public function editProfile(User $user)
    {
        return true;
    }

    /**
     * This method checks the right of access to the store method in
     * ProfileController
     *
     * Determines whether the user can store his profile.
     *
     * @param  \App\Models\Addworking\User\User $user
     * @return Boolean
     */
    public function storeProfile(User $user)
    {
        return true;
    }

    /**
     * This method checks the right of access to the editEmail method in
     * ProfileController
     *
     * Determines whether the user can change his email.
     *
     * @param  \App\Models\Addworking\User\User $user
     * @return Boolean
     */
    public function editEmailProfile(User $user)
    {
        return true;
    }

    /**
     * This method checks the right of access to the storeEmail method in
     * ProfileController
     *
     * Determines whether the user can save his email.
     *
     * @param  \App\Models\Addworking\User\User $user
     * @return Boolean
     */
    public function storeEmailProfile(User $user)
    {
        return true;
    }

    /**
     * This method checks the right of access to the editPassword method in
     * ProfileController
     *
     * Determines whether the user can edit his password.
     *
     * @param  \App\Models\Addworking\User\User $user
     * @return Boolean
     */
    public function editPasswordProfile(User $user)
    {
        return true;
    }

    /**
     * This method checks the right of access to the storePassword method in
     * ProfileController
     *
     * Determines whether the user can save password.
     *
     * @param  \App\Models\Addworking\User\User $user
     * @return mixed
     */
    public function storePasswordProfile(User $user)
    {
        return true;
    }

    /**
     * This method checks the right of access to the storeAccountType method in
     * ProfileController
     *
     * Determines whether the user can save account type.
     *
     * @param  \App\Models\Addworking\User\User $user
     * @return Boolean
     */
    public function storeAccountTypeProfile(User $user)
    {
        return true;
    }

    /**
     * This method checks the right of access to the customers method in
     * ProfileController
     *
     * Determines whether the user can list customers.
     *
     * @param  \App\Models\Addworking\User\User  $user
     * @return Boolean
     */
    public function customersProfile(User $user)
    {
        return true;
    }
}
