<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckSubscription
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the user is authenticated
        $user = Auth::user();

        if ($user) {
            // Check if the user has a subscription
            if (!$user->subscription_status == 1) {
                // Redirect to the homepage with an error message
                return redirect('/')->with('error', 'You must subscribe to a plan to access this page.');
            }
        }

        return $next($request);
    }
}
