<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm(Request $request)
    {
        // Force a clean auth state when explicitly opening login to prevent auto redirect bounce.
        if (Auth::check()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email', 'max:180'],
            'password' => ['required', 'string', 'max:255'],
        ]);

        if (! Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']])) {
            return back()
                ->withErrors(['email' => 'Invalid email or password. Please check your credentials and try again.'])
                ->withInput();
        }

        $request->session()->regenerate();

        return redirect()->route('portal.index');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function bootstrapSuperAdmin()
    {
        $existing = User::query()->where('role', 'superadmin')->first();
        if ($existing) {
            return response()->json([
                'message' => 'Superadmin already exists.',
                'username' => $existing->username,
            ]);
        }

        $user = User::query()->create([
            'name' => 'Platform Super Admin',
            'username' => 'superadmin',
            'email' => 'superadmin@platform.local',
            'password' => 'superadmin123',
            'role' => 'superadmin',
            'school_id' => null,
            'status' => 'active',
        ]);

        return response()->json([
            'message' => 'Superadmin created successfully.',
            'username' => $user->username,
            'password' => 'superadmin123',
        ]);
    }
}
