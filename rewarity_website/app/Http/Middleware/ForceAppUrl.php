<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class ForceAppUrl
{
    public function handle(Request $request, Closure $next)
    {
        URL::forceRootUrl($request->getSchemeAndHttpHost());

        return $next($request);
    }
}
