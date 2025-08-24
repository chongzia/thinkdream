<?php

namespace App\Http\Middleware;

use App\Enums\Code;
use App\Exceptions\TokenMissedException;
use Closure;
use App\Exceptions\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\InvalidClaimException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\PayloadException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\UserNotDefinedException;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $guard): Response
    {
        if (! $request->bearerToken()) {
            throw new TokenMissedException();
        }

        $user = Auth::guard($guard)->user();

        if (! $user) {
            throw new AuthenticationException();
        }

        return $next($request);
    }
}
