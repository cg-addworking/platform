<?php

namespace App\Http\Middleware;

use App\Providers\Customer\SogetrelServiceProvider;
use Closure;

class SubdomainMiddleware
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
        $this->registerSubdomain($request->getHost())->registerLogo();

        if (subdomain('sogetrel')) {
            app()->register(new SogetrelServiceProvider(app()));
        }

        return $next($request);
    }

    /**
     * Registers the logo
     *
     * @return $this
     */
    protected function registerLogo(): self
    {
        $logo = sprintf('img/logo_%s.png', str_replace('-', '_', config('app.subdomain')));

        // defaults to Addworking logo
        if (!file_exists(public_path($logo))) {
            $logo = 'img/logo_addworking.png';
        }

        config(['app.logo' => $logo]);

        return $this;
    }

    /**
     * Registers the subdomain
     *
     * @return $this
     */
    protected function registerSubdomain(string $host): self
    {
        $subdomain = 'addworking';

        if (false !== $pos = strpos($host, '.')) {
            $subdomain = substr($host, 0, $pos);
        }

        // staging environments defaults to Addworking
        // local environment defaults to Addworking
        if (str_contains($host, 'addworking-staging') || in_array($subdomain, ['app', 'localhost', '127'])) {
            $subdomain = 'addworking';
        }

        // environment override
        if (env('APP_SUBDOMAIN', null)) {
            $subdomain = env('APP_SUBDOMAIN');
        }

        config(['app.subdomain' => $subdomain]);

        return $this;
    }
}
