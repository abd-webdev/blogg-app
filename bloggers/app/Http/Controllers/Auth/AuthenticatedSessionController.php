<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Auth\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request)
    {
        try {
          
            $request->authenticate();

            $user = Auth::user();

            if (!$user) {
                return response()->json(['message' => 'Authentication failed.'], 401);
            }

            if (!empty($user->createToken('auth_token')->plainTextToken)) {
                $token = $user->createToken('auth_token')->plainTextToken;
            }

            return redirect()->route('dashboard.home')->with('success', 'Logged In successfully.');

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Login failed. Please check your credentials.',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request)
{
    $user = $request->user();

    if (!$user) {
        return response()->json([
            'message' => 'Unauthenticated.',
        ], Response::HTTP_UNAUTHORIZED);
    }

    if ($request->bearerToken()) {
        $user->tokens()->delete();
    } else {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }

    return redirect()->route('login-form')->with('success', 'Logged out successfully.');
}

}
