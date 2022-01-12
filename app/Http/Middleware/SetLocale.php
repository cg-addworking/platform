<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        App::setLocale($this->getLocale($request));

        return $next($request);
    }

    private function getLocale(Request $request): string
    {
        $locales = Config::get('app.available_locales', []);
        $default = Config::get('app.locale', 'en');

        // get locale from request query string (?locale=fr)
        if ($request->has('locale') && in_array(strtolower($request->locale), $locales)) {
            return $this->storeUserLocale($request, $this->setSessionLocale($request->locale));
        }

        // get locale from session
        if (Session::has('locale') && in_array(strtolower(Session::get('locale')), $locales)) {
            return Session::get('locale');
        }

        // get locale from user
        if ($request->user() && in_array($request->user()->locale, $locales)) {
            return $this->setSessionLocale($request->user()->locale);
        }

        // get locale from request headers (accept-language)
        if (false != $accept = $request->server('HTTP_ACCEPT_LANGUAGE')) {
            return $this->parseAcceptLanguage($accept, $locales, $default);
        }

        // fallback locale (set in config/app.php)
        return $default;
    }

    private function setSessionLocale(string $locale): string
    {
        Session::put('locale', $locale);

        return $locale;
    }

    private function storeUserLocale(Request $request, string $locale): string
    {
        if ($locale && $request->user() && $request->user() instanceof Model) {
            $request->user()->update(compact('locale'));
        }

        return $locale;
    }

    private function parseAcceptLanguage(string $value, array $locales, string $default): string
    {
        $accept = [];

        // @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Accept-Language
        foreach (explode(',', $value) as $locale) {
            $q = 1;

            if (preg_match('/;q=(.*)$/', $locale, $matches)) {
                $q = (float) $matches[1];
            }

            if (false !== $pos = strpos($locale, ';')) {
                $locale = substr($locale, 0, $pos);
            }

            $accept[] = [$q, substr($locale, 0, 2)];
        }

        usort($accept, fn($a, $b) => $a[0] <=> $b[0]);

        while (list(,$lang) = array_pop($accept)) {
            if (in_array($lang, $locales)) {
                return $lang;
            }
        }

        return $default;
    }
}
