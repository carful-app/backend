<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class SetLocaleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $defaultLocale = config('app.locale');
        $locale = Cookie::get('locale', $defaultLocale);

        if (!in_array($locale, config('app.available_locales'))) {
            $locale = $defaultLocale;
        }

        app()->setLocale($locale);
        Cookie::queue('locale', config('app.locale'), 1000 * 60 * 60 * 24 * 365);

        return $next($request);
    }
}
