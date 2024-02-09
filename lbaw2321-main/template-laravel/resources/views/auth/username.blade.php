<!-- resources/views/auth/username.blade.php -->
@extends('layouts.minimal')

<link rel="icon" href="{{ asset('icons/shaking_hands.png') }}" type="image/png">

<div class="container">
<form id="login-form" method="POST" action="{{ route('register.finish') }}">
    @csrf
    <div class="custom-input-container">
    <label for="username">Username</label>
    <input id="username" class="custom-input" type="text" name="username" required autofocus>
    <div class="login-button-container">
        <button type="submit" class="login-button">Complete Registration</button>
    </div>
    </div>
</form>
</div>