<?php

namespace App\Http\Controllers\Api;

use App\Support\RoleMap;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // Get user profile for mobile
    public function profile(Request $request)
    {
        $user = Auth::user();
        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role_id' => (int) ($user->role_id ?? RoleMap::idFromName((string) $user->role)),
            'role' => $user->role,
            'tenant_id' => $user->tenant_id ?? $user->school_id,
        ]);
    }
}
