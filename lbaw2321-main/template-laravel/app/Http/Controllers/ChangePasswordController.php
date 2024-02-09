<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User; 

class ChangePasswordController extends Controller
{
    

    public function showResetPasswordForm()
    {
        return view('auth.passwords.reset');
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'username' => 'required|exists:users,username',
            'password' => 'required|confirmed|min:8',
        ]);

        $user = User::where('username', $request->username)->first();

        if ($user) {
            $user->update([
                'password' => bcrypt($request->password),
            ]);

            return redirect()->route('login')->with('status', 'Password reset successfully!');
        } else {
            return back()->withErrors(['username' => 'User not found.']);
        }
    }
}
