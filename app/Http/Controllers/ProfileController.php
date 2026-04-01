<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:180'],
            'phone' => ['nullable', 'string', 'max:30'],
        ]);

        $user = Auth::user();
        $user->update($validated);

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }

    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'password' => ['required', 'string', 'min:8'],
        ]);

        $user = Auth::user();
        $user->update(['password' => bcrypt($validated['password'])]);

        return redirect()->back()->with('success', 'Password updated successfully.');
    }
}
