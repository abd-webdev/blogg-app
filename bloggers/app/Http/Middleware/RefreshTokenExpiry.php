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
            
            // Ensure the token is an instance of PersonalAccessToken
            if ($token instanceof PersonalAccessToken) {
                $lastUsedAt = $token->last_used_at ? Carbon::parse($token->last_used_at) : null;
                $now = Carbon::now();

                // If token was last used more than 60 minutes ago, revoke it
                if ($lastUsedAt && $lastUsedAt->diffInMinutes($now) >= 1) {
                    $token->delete();
                    return redirect()->route('login-form')->with('success', 'Logged out due to inactivity');
                }

                // Update `last_used_at` to extend expiration
                $token->forceFill(['last_used_at' => now()])->save();
            }
        }

        return $next($request);
    }
}
