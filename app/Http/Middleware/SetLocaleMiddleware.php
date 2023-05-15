<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

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
        $locale = substr($request->header('Accept-Language'), 0, 2);

        if (!in_array($locale, config('app.available_locales'))) {
            $locale = $defaultLocale;
        }

        app()->setLocale($locale);

        return $next($request);
    }
}
