<?php

namespace App\Http\Middleware;

use Closure;

class language
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
        $uri = explode('/',$request->path());
        if(in_array($uri[0], config('app.locales'))){
            \App::setLocale($uri[0]);
            return $next($request);
        }
        $uri[0] = config('app.fallback_locale');
        \App::setLocale($uri[0]);
        return redirect(implode('/', $uri));
    }
}
