@extends('layouts.minimal')

@section('content')

<link rel="icon" href="{{ asset('icons/shaking_hands.png') }}" type="image/png">

<div class="header-container">
    <img src="{{ asset('photos/GetTogether.png') }}" alt="Logo" class="logo">
    <a class="button button-outline" style="color: #000; font-size: 17px; font-family: 'Gill Sans', sans-serif; margin-right:2%;" href="{{ route('login') }}">Sign In</a>
</div>

@if (session('message'))
    <div class="message-container">
        <div class="alert alert-info">
            {{ session('message') }}
        </div>
    </div>
@endif

<div class="container">
    <p style="color: #f0ba4b; font-size: 35px; font-weight: bold; font-family: 'Gill Sans', sans-serif;">Sign Up</p>
    <div class="custom-message-container">
    <p style="color: #000; font-size: 17px; font-family: 'Gill Sans', sans-serif; margin-bottom:30px;">Hello! Enter your details to get sign up into your new account.</p>
</div>


    <form id="login-form" method="POST" action="{{ route('register') }}">
        {{ csrf_field() }}

        <div class="custom-input-container">
            <label for="name">Name</label>
            <input id="name" class="custom-input" type="text" name="name" value="{{ old('name') }}" required autofocus>
            @if ($errors->has('name'))
                <span class="error">
                    {{ $errors->first('name') }}
                </span>
            @endif
        </div>

        <div class="custom-input-container">
            <label for="username">Username</label>
            <input id="username" class="custom-input" type="text" name="username" value="{{ old('username') }}" required autofocus>
            @if ($errors->has('username'))
                <span class="error">
                    {{ $errors->first('username') }}
                </span>
            @endif
        </div>

        <div class="custom-input-container">
            <label for="email">E-Mail Address</label>
            <input id="email" class="custom-input" type="email" name="email" value="{{ old('email') }}" required>
            @if ($errors->has('email'))
                <span class="error">
                    {{ $errors->first('email') }}
                </span>
            @endif
        </div>

        <div class="custom-input-container">
            <label for="password">Password</label>
            <input id="password" class="custom-input" type="password" name="password" required>
            @if ($errors->has('password'))
                <span class="error">
                    {{ $errors->first('password') }}
                </span>
            @endif
        </div>

        <div class="custom-input-container">
            <label for="password-confirm">Confirm Password</label>
            <input id="password-confirm" class="custom-input" type="password" name="password_confirmation" required>
        </div>


        <div class="login-button-container">
          <button type="submit" class="login-button">
            Sign Up
          </button>
        </div>

        
    </form>

    <p style="color: #000; font-size: 15px; font-family: 'Gill Sans', sans-serif;">--- Or sign up with Google ---</p>
    <div>
        <a href="{{ route('google.register') }}">Sign up using Google</a>
    </div>





@endsection

