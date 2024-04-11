<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\App;
use Closure;

class Localize
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
        $language = request()->header('Language');

        App::setLocale($language);

        return $next($request);
    }
}
