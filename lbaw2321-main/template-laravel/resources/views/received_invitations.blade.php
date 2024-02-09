<!-- resources/views/sent_invitations/index.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Received Invitations</h2>

        @if(count($receivedInvitations) > 0)
            <ul>
                @foreach($receivedInvitations as $invitation)
                    <div class="invitation-container">
                        <div class="invitation-box">
                            <p>Event Name: {{ $invitation->event->eventname }}</p>
                            <p>Receipt Date: {{ $invitation->sentdate }}</p>
                            <p>User Who Invited Me: {{ $invitation->hostUser->name }}</p>
                            <p>My decision: {{ $invitation->decision}}</p>
                        </div>
                    </div>
                @endforeach
            </ul>
        @else
            <p>No received invitations found.</p>
        @endif
    </div>
@endsection
