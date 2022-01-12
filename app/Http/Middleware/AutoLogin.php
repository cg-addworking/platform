<?php

namespace App\Http\Middleware;

use App\Models\Addworking\User\User;
use Closure;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AutoLogin
{
    /**
     * allows to automatically connect a user, to the desired account, in staging
     * and that one sends in parameter GET "login" with as parameter an email, corresponding
     * to a user
     */
    public function handle($request, Closure $next)
    {
        if ($request->has('login') && in_array(app()->environment(), ['local', 'review'])) {
            try {
                auth()->login(User::fromEmail($request->get('login')));
            } catch (ModelNotFoundException $e) {
                /* noop */
            }
        }

        return $next($request);
    }
}
