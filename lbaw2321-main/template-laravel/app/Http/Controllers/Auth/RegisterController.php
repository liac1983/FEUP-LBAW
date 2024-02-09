<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

use Illuminate\View\View;

use App\Models\User;
use App\Http\Controllers\EventsController;

class RegisterController extends Controller
{
    /**
     * Display a login form.
     */
    public function showReg(): View
    {
        return view('auth.register');
    }

    /**
     * Register a new user.
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:250',
            'username' => 'required|string|max:25',
            'email' => 'required|email|max:250|unique:users',
            'password' => 'required|min:8|confirmed'
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'userStatus' => 'Active'
        ]);

        $credentials = $request->only('email', 'password');
        Auth::attempt($credentials);
        $request->session()->regenerate();
        return redirect()->route('events.begin')
            ->withSuccess('You have successfully registered & logged in!');
    }



    public function redirectToGoogle()
{
    return Socialite::driver('google')->redirect();
}



// Handle Google callback
public function handleGoogleCallback()
{

    try {
        $googleUser = Socialite::driver('google')->user();

        Log::info('Google User Information:', ['user' => $googleUser]);

        // Check if user already exists
        $user = User::where('email', $googleUser->getEmail())->first();

        if ($user) {
            // If user already exists, you might want to log them in
            Auth::login($user, true);
            return redirect()->intended('events.begin'); // Redirect to a desired location
        } else {
            // Store Google user info in session and redirect to username form
            session(['googleUser' => $googleUser]);
            return redirect()->route('register.username');
        }
    } catch (\Exception $e) {
        Log::error('Google callback error:', ['exception' => $e]);
        // Handle the exception as needed
        return redirect()->route('login')->with('error', 'There was a problem signing you up with Google.');
    }
}

public function completeRegistration(Request $request)
{
    $request->validate([
        'username' => 'required|string|max:25|unique:users,username',
    ]);

    $googleUser = session('googleUser');
    if (!$googleUser) {
        return redirect()->route('login')->with('error', 'Google user not found in session.');
    }

    $newUser = User::create([
        'name' => $googleUser->getName(),
        'email' => $googleUser->getEmail(),
        'username' => $request->username,
        'password' => Hash::make(uniqid()),
    ]);

    Auth::login($newUser, true);
    return redirect()->intended('events-begin');
}

}
