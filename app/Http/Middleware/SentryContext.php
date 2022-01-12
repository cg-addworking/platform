<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\URL;
use Sentry\State\Scope;

class SentryContext
{
    public function handle($request, Closure $next)
    {
        if (auth()->check() && app()->bound('sentry')) {
            \Sentry\configureScope(function (Scope $scope): void {
                $scope->setUser([
                    'id' => auth()->user()->id ?? "guest",
                    'email' => auth()->user()->email ?? "guest",
                    'enterprise' => auth()->user()->enterprise->name ?? "guest",
                    'previous_url' => URL::previous(),
                ]);
            });
        }

        return $next($request);
    }
}
