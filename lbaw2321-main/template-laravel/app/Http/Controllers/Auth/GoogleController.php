<?php

// app/Http/Controllers/Auth/GoogleController.php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class GoogleController extends Controller
{
    public function googlepage(){
        return socialite::driver('google')->redirect();
    }

    public function googlecallback(){
        try {
            $user = Socialite::driver('google')->user();
            $finduser = User::where('email', $user->email)->first();
    
            if ($finduser) {
                Auth::login($finduser);
                return redirect()->route('events.begin')->withSuccess('You have successfully logged in!');
            } else {
                // Flash a message to the session and redirect to the registration page
                return redirect()->route('register')->with('message', 'You do not have an account already. Please register.');
            }
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
    
}

