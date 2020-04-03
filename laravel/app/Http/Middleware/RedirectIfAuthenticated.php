<?php

namespace App\Http\Middleware;

use App\Support\Url;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            if (!$request->isJson()) {
                return Response::redirectTo(Url::frontend());
            }
            return Response::noContent();
        }

        return $next($request);
    }
}
