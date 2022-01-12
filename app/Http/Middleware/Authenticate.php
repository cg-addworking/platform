<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Base;

class Authenticate extends Base
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    protected function redirectTo($request)
    {
        session()->flash('status', error_status(
            __('Vous avez été déconnecté. Merci de vous authentifier à nouveau.')
        )['status']);

        return route('login');
    }
}
