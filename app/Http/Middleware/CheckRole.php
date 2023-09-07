<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle($request, Closure $next, ...$roles)
    {
        $user = Auth::user();

        if (!in_array($user->role, $roles)) {
            return response()->json(['error' => 'Unauthorized', 'status' => 403, 'success' => false], 403);
        }

        return $next($request);
    }
}
