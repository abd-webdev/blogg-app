<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class RefreshTokenExpiry
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if ($user) {
            $token = $user->currentAccessToken();

            if ($token) {
                $lastUsedAt = Carbon::parse($token->updated_at);
                $now = Carbon::now();

                // If token is inactive for more than 1 hour, revoke it
                if ($lastUsedAt->diffInMinutes($now) >= 60) {
                    $token->delete();
                    return response()->json(['message' => 'Token expired due to inactivity'], Response::HTTP_UNAUTHORIZED);
                }

                // Extend the token expiry by updating `updated_at`
                $token->forceFill(['updated_at' => now()])->save();
            }
        }

        return $next($request);
    }
}
