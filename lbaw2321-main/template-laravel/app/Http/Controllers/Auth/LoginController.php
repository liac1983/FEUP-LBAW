<?php
 
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Socialite;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

use Illuminate\View\View;
use App\Http\Controllers\EventsController;

class LoginController extends Controller
{

    /**
     * Display a login form.
     */
    public function showLog()
    {
        if (Auth::check()) {
            return redirect()->route('events.begin');
        } else {
            return view('auth.login');
        }
    }

    /**
     * Handle an authentication attempt.
     */
    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
 
        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
 
            return redirect()->route('events.begin')->withSuccess('Login successful!');
        }
 
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Log out the user from application.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')
            ->withSuccess('You have logged out successfully!');
    }

    public function redirectToGoogle()
{
    return Socialite::driver('googlelogin')->redirect();
}


public function handleGoogleCallback(){
    Log::error('1');
    try {
        $user = Socialite::driver('googlelogin')->user();
        $finduser = User::where('email', $user->email)->first();
        Log::error('2');
        if ($finduser) {
            Auth::login($finduser);
            Log::error('3');
            return redirect()->intended('events-begin');
            
        } else {
            Log::error('4');
            // Flash a message to the session and redirect to the registration page
            return redirect()->route('register')->with('message', 'You do not have an account already. Please register.');
        }
    } catch (Exception $e) {
        dd($e->getMessage());
    }
}
}
