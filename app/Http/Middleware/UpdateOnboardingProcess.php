<?php

namespace App\Http\Middleware;

use Closure;

class UpdateOnboardingProcess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        if (auth()->check()) {
            auth()->user()->current_onboarding_process->advance();
        }

        return $response;
    }
}
