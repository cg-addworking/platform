<?php

namespace App\Policies\Spie\Enterprise;

use App\Models\Addworking\User\User;
use App\Models\Spie\Enterprise\Order;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any orders.
     *
     * @param  \App\Models\Addworking\User\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the order.
     *
     * @param  \App\Models\Addworking\User\User  $user
     * @param  \App\App\Models\Spie\Enterprise\Order  $order
     * @return mixed
     */
    public function view(User $user, Order $order)
    {
        //
    }

    /**
     * Determine whether the user can create orders.
     *
     * @param  \App\Models\Addworking\User\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the order.
     *
     * @param  \App\Models\Addworking\User\User  $user
     * @param  \App\App\Models\Spie\Enterprise\Order  $order
     * @return mixed
     */
    public function update(User $user, Order $order)
    {
        //
    }

    /**
     * Determine whether the user can delete the order.
     *
     * @param  \App\Models\Addworking\User\User  $user
     * @param  \App\App\Models\Spie\Enterprise\Order  $order
     * @return mixed
     */
    public function delete(User $user, Order $order)
    {
        //
    }

    /**
     * Determine whether the user can restore the order.
     *
     * @param  \App\Models\Addworking\User\User  $user
     * @param  \App\App\Models\Spie\Enterprise\Order  $order
     * @return mixed
     */
    public function restore(User $user, Order $order)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the order.
     *
     * @param  \App\Models\Addworking\User\User  $user
     * @param  \App\App\Models\Spie\Enterprise\Order  $order
     * @return mixed
     */
    public function forceDelete(User $user, Order $order)
    {
        //
    }
}
