<?php

namespace App\Http\Middleware;

use App\Models\Addworking\User\UserLog;
use Closure;
use DateTime;
use Illuminate\Http\Request;

class UserLogMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if ($user = auth()->user()) {
            if (config('logging_app.user_action')) {
                $this->logRequest($request);
            }

            if (! $user->isImpersonated()) {
                $user->update([
                    'last_activity' => new DateTime(),
                ]);
            }
        }

        return $next($request);
    }

    /**
     * @param Request $request
     */
    public function logRequest(Request $request)
    {
        $log = new UserLog;
        $log->fill([
            'route'         => optional($request->route())->getName() ?? 'n/a',
            'url'           => substr($request->fullUrl(), 0, 254),
            'http_method'   => $request->getMethod(),
            'ip'            => $request->ip(),
            'input'         => $request->input(),
            'headers'       => $request->headers->all(),
            'impersonating' => app('impersonate')->isImpersonating(),
            'user_id' => $request->user()->id
        ]);

        return $log->save();
    }
}
