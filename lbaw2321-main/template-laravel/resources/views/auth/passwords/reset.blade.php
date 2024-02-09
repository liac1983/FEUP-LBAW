<!-- resources/views/auth/passwords/reset.blade.php -->

@extends('layouts.minimal')

@section('content')
    <div class="container">
        <p style="color: #f0ba4b; font-size: 35px; font-weight: bold; font-family: 'Gill Sans', sans-serif;">Reset Password</p>
        <div class="custom-message-container">
            <p style="color: #000; font-size: 17px; font-family: 'Gill Sans', sans-serif; margin-bottom:30px;">Enter your username and new password to reset it.</p>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('password.reset') }}">
            @csrf

            <div class="custom-input-container">
                <label for="username">Username</label>
                <input id="username" class="custom-input" type="text" name="username" required>
            </div>

            <div class="custom-input-container">
                <label for="password">New Password</label>
                <input id="password" class="custom-input" type="password" name="password" required>
            </div>

            <div class="custom-input-container">
                <label for="password_confirmation">Confirm New Password</label>
                <input id="password_confirmation" class="custom-input" type="password" name="password_confirmation" required>
            </div>

            <div class="login-button-container">
                <button type="submit" class="login-button">
                    Reset Password
                </button>
            </div>
        </form>
    </div>
@endsection
