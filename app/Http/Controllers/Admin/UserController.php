<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Update user verification status
     */
    public function updateVerificationStatus(User $user, Request $request): RedirectResponse
    {
        $status = $request->input('verification_status');
        $message = '';
        
        \Log::info('User verification update - User ID: ' . $user->id . ', Current verified_at: ' . $user->email_verified_at . ', New status: ' . $status);
        
        if ($status === 'verified') {
            $user->email_verified_at = now();
            $user->save();
            $message = "User {$user->name} berhasil diverifikasi!";
        } elseif ($status === 'unverified') {
            $user->email_verified_at = null;
            $user->save();
            $message = "Status verifikasi user {$user->name} telah dihapus!";
        } elseif ($status === 'pending') {
            // Set to pending (null)
            $user->email_verified_at = null;
            $user->save();
            $message = "User {$user->name} di-set ke pending!";
        }

        \Log::info('After update - User verified_at: ' . $user->email_verified_at);

        $page = $request->query('page', 1);
        return redirect()->route('admin.dashboard', ['tab' => 'users', 'page' => $page])->with('success', $message);
    }
}
