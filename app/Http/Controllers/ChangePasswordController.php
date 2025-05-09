<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ChangePasswordController extends Controller
{
    // Show the form for changing the password
    public function showChangeForm()
    {
        return view('auth.change-password');
    }

    // Handle the password change request
    public function changePassword(Request $request)
    {
        // Validate the input
        $request->validate([
            'email'                => 'required|email|exists:users,email',
            'current_password'     => 'required',
            'new_password'         => 'required|min:6|confirmed', // Ensure password is confirmed
        ]);

        // Get the currently authenticated user
        $user = Auth::user();

        // Check if the provided email matches the authenticated user's email
        if ($request->email !== $user->email) {
            return back()->withErrors(['email' => 'The email does not match our records.']);
        }

        // Check if the current password matches the one in the database
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        // Update the password and save
        $user->password = Hash::make($request->new_password);
        $user->save();

        // Redirect back with success message
        return redirect()->route('login')->with('status', 'Password changed successfully! Please log in again.');
    }
}
