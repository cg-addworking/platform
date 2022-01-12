<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\View\View;

class Excerpt
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

        if ($request->has('excerpt') && $response->original instanceof View) {
            $sections = $response->original->renderSections();

            if ($excerpt = array_get($sections, $request->input('excerpt'))) {
                return response($excerpt);
            }
        }

        return $response;
    }
}
