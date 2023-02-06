<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetLocale
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
        if (auth()->user() != null) {

            app()->setLocale(auth()->user()->locale);
        } else {

            if (session('locale') != null && (session('locale') == 'en' || session('locale') == 'ar')) {

                app()->setLocale(session('locale'));
            } else {

                app()->setLocale('ar');
            }
        }
        return $next($request);
    }
}
