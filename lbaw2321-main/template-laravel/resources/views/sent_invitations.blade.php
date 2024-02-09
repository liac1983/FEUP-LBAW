<!-- resources/views/sent_invitations.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Sent Invitations</h2>

        @if(count($sentInvitations) > 0)
            <ul>
                @foreach($sentInvitations as $invitation)
                    <div class="invitation-container">
                        <div class="invitation-box">
                            <p>Event Name: {{ $invitation->event->eventname }}</p>
                            <p>Sent Date: {{ $invitation->sentdate }}</p>
                            <p>User Invited Name: {{ $invitation->invitedUser->name }}</p>
                        </div>
                    </div>
                @endforeach
            </ul>
        @else
            <p>No sent invitations found.</p>
        @endif
    </div>
@endsection
