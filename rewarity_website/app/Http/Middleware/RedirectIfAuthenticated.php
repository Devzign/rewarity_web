<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            $authGuard = auth()->guard($guard);

            if ($authGuard->check()) {
                $user = $authGuard->user();

                if ($user && strcasecmp((string) $user->user_type, 'admin') === 0) {
                    return redirect('/admin');
                }

                if ($user && strcasecmp((string) $user->user_type, 'dealer') === 0) {
                    return redirect('/products');
                }

                return redirect('/');
            }
        }

        return $next($request);
    }
}
