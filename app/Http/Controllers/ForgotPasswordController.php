<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Mail;

class ForgotPasswordController extends Controller
{
    public function showForm(){
        return view('auth.forgot-password');
    }
    public function sendResetLink(Request $request){
        $request->validate([
            'email'=>'required|email|exists:users,email'
        ]);
        $token = Str::random(60);

        DB::table('password_resets')->updateOrInsert(
            ['email' => $request->email],
            ['token' => $token, 'created_at' => Carbon::now()]
        );

        $link = url('/reset-password/' . $token);

        Mail::raw("Click here to reset your password: $link", function ($message) use ($request) {
            $message->to($request->email)
                    ->subject('Reset Password Link');
        });

        return back()->with('status', 'We sent a password reset link to your email.');
    }
}
