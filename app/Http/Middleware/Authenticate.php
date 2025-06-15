<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Middleware\Authenticate as MiddlewareAuthenticate;

class Authenticate  extends MiddlewareAuthenticate
{
    protected function unauthenticated($request, array $guards): void
    {
        $guard = $guards[0] ?? null;

        throw match ($guard) {
            'admin' => new AuthenticationException(redirectTo: route('admin.login')),
            default => new AuthenticationException(redirectTo: route('login')),
        };
    }
}
