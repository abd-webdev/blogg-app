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
            // Log incoming request
            Log::info('Login attempt: ', $request->only('email'));

            $request->authenticate();

            $user = Auth::user();

            if (!$user) {
                Log::error('Authentication failed: User not found.');
                return response()->json(['message' => 'Authentication failed.'], 401);
            }

            if (!empty($user->createToken('auth_token')->plainTextToken)) {
                $token = $user->createToken('auth_token')->plainTextToken;
            }

            // return response()->json([
            //     'message' => 'Login successfully',
            //     'user' => $user,
            //     'token' => $token,
            // ], Response::HTTP_OK);
            return redirect()->route('login-form')->with('success', 'Logged out successfully.');

        } catch (\Exception $e) {
            Log::error('Login failed: ' . $e->getMessage());
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

    // Check if request has a Bearer Token (API token-based authentication)
    if ($request->bearerToken()) {
        $user->tokens()->delete(); // Delete all personal access tokens
    } else {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }

    // return response()->json([
    //     'message' => 'Logged out successfully',
    // ], Response::HTTP_OK);
    return redirect()->route('login-form')->with('success', 'Logged out successfully.');

}

}
