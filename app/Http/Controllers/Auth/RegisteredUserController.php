<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Illuminate\Support\Facades\Validator;
use App\Models\Subscription;
use App\Models\UserSubscription;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */

     public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'Error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }
        $defaultSubscription = Subscription::where('name', 'Free')->first();
        // dd($defaultSubscription->expire_plan_days);
        
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'subscription_status' => true,
        ]);



        UserSubscription::create([
            'user_id' => $user->id,
            'subscription_id' => $defaultSubscription ? $defaultSubscription->id : null, 
            'subscription_active_date' => now(),
            'expire_plan_days' => $defaultSubscription ? $defaultSubscription->expire_plan_days : null,
        ]);

        event(new Registered($user));

        Auth::login($user);

        // return redirect(RouteServiceProvider::HOME);

        return response()->json([
            'status' => 'Success',
            'message' => 'Registration successful',
            'data' => [
                'redirect_url' => route('admin.dashboard')   
            ]
        ]);
    }
}
