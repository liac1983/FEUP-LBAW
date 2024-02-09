<!-- resources/views/invite/form.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Invite Someone to {{ $event->eventname }}</h2>

        <form action="{{ route('event.sendInvitation', ['eventId' => $event->id]) }}" method="post">
            @csrf

            <div class="form-group">
                <label for="inviteeId">Select User to Invite:</label>
                <select name="inviteeId" class="form-control" required>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Add any other fields you need for the invitation form -->

            <button type="submit" class="button-primary">Send Invitation</button>
        </form>
    </div>
@endsection
