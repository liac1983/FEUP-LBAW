<!-- resources/views/auth/google-username.blade.php -->

@extends('layouts.minimal') <!-- Make sure to adjust the layout as needed -->

@section('content')

<div class="container">
    <p style="color: #f0ba4b; font-size: 35px; font-weight: bold; font-family: 'Gill Sans', sans-serif;">Sign Up</p>
    <div class="custom-message-container">
        <p style="color: #000; font-size: 17px; font-family: 'Gill Sans', sans-serif; margin-bottom:30px;">
            Hello! Enter your details to sign up into your new account.
        </p>
    </div>

    <form id="google-username-form" method="POST" action="{{ route('register') }}">
        {{ csrf_field() }}

        <input type="hidden" name="email" value="{{ $user->email }}">
        <input type="hidden" name="name" value="{{ $user->name }}">

        <div class="custom-input-container">
            <label for="username">Username</label>
            <input id="username" class="custom-input" type="text" name="username" required autofocus>
        </div>

        <div class="login-button-container">
            <button type="submit" class="login-button">
                Sign Up
            </button>
        </div>
    </form>

</div>

@endsection
