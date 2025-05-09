<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ResetPasswordController extends Controller
{
    //
    public function showResetForm(){
        return view('auth.reset-password');
    }
    public function resetPassword(Request $request){
        $request->validate([
           'email' => 'required|email|exists:users,email',
            'password' => 'required|confirmed|min:6',
            'password_confirmation'=>'required|same:password',
            'token' => 'required'
        ]);
        $reset = DB::table('password_resets')
        ->where('email', $request->email)
        ->where('token', $request->token)
        ->first();

        if(!$reset){
            return back()->withErrors(['email'=>'Invalid token or email']);

        }
        User::where('email',$request->email)->update([
            'password' => bcrypt($request->password),
        ]);

        DB::table('password_resets')->where('email', $request->email)->delete();

        return redirect('login')->with('success', 'Password has been successfully reset!');
    }
    }

