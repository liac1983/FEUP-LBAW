<!-- resources/views/profile/edit_photo.blade.php -->

@extends('layouts.app')

@section('content')

<a href="{{ route('profile.show', ['id' => Auth::id()]) }}" class="back-to-profile-link">
    <img src="{{ asset('icons/arrow_back.png') }}" alt="Back to Profile" style="transform: rotate(180deg) scale(0.7); margin-left: 10px">
</a>
<h2 style="display: inline-block;">Edit Profile</h2>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<form action="{{ route('profile.update') }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label for="profile_photo">Profile Photo:</label>
        <input type="file" name="profile_photo" accept="image/*">

        <label for="username">Username:</label>
        <input type="text" id="username" name="username" value="{{ Auth::user()->username }}" required style="border-radius: 15px; padding: 8px;">

        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="{{ Auth::user()->name }}" required style="border-radius: 15px; padding: 8px;">

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="{{ Auth::user()->email }}" required style="border-radius: 15px; padding: 8px;">
    </div>
    <button type="submit" style="background-color: #f0ba4b; border: none; padding: 10px; border-radius: 20px; cursor: pointer;text-align: center;">Atualizar Perfil</button>
</form>
@endsection
