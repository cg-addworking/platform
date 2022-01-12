<?php

namespace App\Http\Middleware\Redirect;

use Closure;

class SogetrelSoconnext
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
        if (config('app.subdomain') != 'sogetrel') {
            return $next($request);
        }

        if ($request->query('utm_source') == 'soconnext-moins-15-salaries') {
            session()->put('utm_source', 'soconnext-moins-15-salaries');
            return redirect()->route('sogetrel.login');
        }

        return $next($request);
    }
}
