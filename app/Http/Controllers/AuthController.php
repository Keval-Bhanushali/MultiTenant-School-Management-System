<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Support\RoleMap;
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

        $user = $request->user();

        if ($user && ((int) $user->role_id === RoleMap::SUPERADMIN || $user->role === 'superadmin')) {
            return redirect()->route('superadmin.dashboard');
        }

        return redirect()->route('portal.school');
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
        $existing = User::query()->where('role_id', RoleMap::SUPERADMIN)->orWhere('role', 'superadmin')->first();
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
            'role_id' => RoleMap::SUPERADMIN,
            'role' => 'superadmin',
            'tenant_id' => null,
            'school_id' => null,
            'status' => 'active',
            'preferred_language' => 'en',
        ]);

        return response()->json([
            'message' => 'Superadmin created successfully.',
            'username' => $user->username,
            'password' => 'superadmin123',
        ]);
    }
}
