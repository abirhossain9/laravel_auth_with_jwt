<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class TokenVerify
{
    public function handle($request, Closure $next)
    {
        try {
            // Attempt to verify the JWT token
            $user = JWTAuth::parseToken()->authenticate();

            if (!$user) {
                return response()->json(['error' => 'Unauthorized', 'status' => 401, 'success' => false], 401);
            }

            // Set the authenticated user in the Auth facade
            Auth::setUser($user);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Unauthorized', 'status' => 401, 'success' => false], 401);
        }

        return $next($request);
    }
}
