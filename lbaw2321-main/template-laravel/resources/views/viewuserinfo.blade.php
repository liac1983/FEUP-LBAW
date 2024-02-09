<!-- resources/views/admin/viewUserInfo.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">User Information</div>

                    <div class="card-body">
                        <p>User Name: {{ $user->name }}</p>
                        <p>Email: {{ $user->email }}</p>
                        <p>User Status: {{ $user->userstatus }}</p>
                        <p>Is Admin: {{ $user->isadmin ? 'Yes' : 'No' }}</p>

                        @if($user->profile_photo)
                            <p>Profile Photo: <img src="{{ asset('path/to/profile-photos/' . $user->profile_photo) }}" alt="Profile Photo"></p>
                        @else
                            <p>No profile photo available.</p>
                        @endif

                        <p>Events Created:</p>
                       <!-- FIX THIS --> 
                        @if($user->events && count($user->events) > 0)
                            <ul>
                                @foreach($user->events as $event)
                                    <li>
                                        {{ $event->eventName }} - Start Time: {{ $event->startDateTime }}
                                        <!-- Add more event details as needed -->
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p>No events created by this user.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
