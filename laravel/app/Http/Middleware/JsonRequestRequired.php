<?php

namespace App\Http\Middleware;

use App\Support\Url;
use Closure;
use Illuminate\Support\Facades\Response;

class JsonRequestRequired
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
        if (!$request->isJson()) {
            return Response::redirectTo(Url::frontend());
        }
        return $next($request);
    }
}
