<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('admin.profile-edit');
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,' . $user->id],
            'profile_picture' => ['nullable', 'image', 'mimes:jpeg,png,webp', 'max:5120'],
            'current_password' => ['nullable', 'required_if:password,!=null', 'string'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        // Update name and email
        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        // Update password if provided
        if ($request->filled('password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Kata sandi saat ini tidak sesuai']);
            }
            $user->update(['password' => Hash::make($request->password)]);
        }

        // Update profile picture if provided
        if ($request->hasFile('profile_picture')) {
            // Delete old picture if exists
            if ($user->profile_picture && \Storage::disk('public')->exists($user->profile_picture)) {
                \Storage::disk('public')->delete($user->profile_picture);
            }

            $path = $request->file('profile_picture')->store('profile-pictures', 'public');
            $user->update(['profile_picture' => $path]);
        }

        return redirect()->route('admin.dashboard')->with('success', 'Profil berhasil diperbarui!');
    }
}
