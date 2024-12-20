<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request)
    {
        try {
            // Authenticate the user
            $request->authenticate();

            // Regenerate session
            $request->session()->regenerate();

            // Determine redirect URL based on role
            $url = '';
            if ($request->user()->role === 'admin') {
                $url = '/admin/dashboard';
            } elseif ($request->user()->role === 'user') {
                $url = '/dashboard';
            }

            // Return JSON response for AJAX
            return response()->json([
                'status' => 'Success',
                'message' => 'Login successful.',
                'data' => [
                    'redirect_url' => $url,
                ],
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle validation errors
            return response()->json([
                'status' => 'Error',
                'message' => $e->getMessage(),
                'errors' => $e->errors(), 
            ], 422);
        } catch (\Exception $e) {
            // Handle general errors
            return response()->json([
                'status' => 'Error',
                'message' => 'An error occurred during login.',
            ], 500);
        }
    }


    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login/show');
    }
}
