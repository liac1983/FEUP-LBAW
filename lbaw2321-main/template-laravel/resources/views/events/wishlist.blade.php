<!-- resources/views/events/going.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
    <a href="{{ route('profile.show', ['id' => Auth::id()]) }}" class="back-to-profile-link">
        <img src="{{ asset('icons/arrow_back.png') }}" alt="Back to Profile" style="transform: rotate(180deg) scale(0.7); margin-left: 10px;">
    </a>
    <h2 style="display: inline-block;">My Wishlist</h2>

        @if(!empty($wishlist) && count($wishlist) > 0)
            <ul>
                @foreach($wishlist as $event)
                    <div class="event-box">
                        <a href="{{ route('event.show', ['id' => $event->id]) }}">
                            <div class="event-photo">
                                <img src="{{ asset('photos/' . $event->photo) }}" alt="Event Photo">
                            </div>
                            <div class="event-details">
                                <p style="font-size: 17px; color: #ef9db2;">Start Date: {{ $event->startdatetime }}</p>
                                <h2 style="font-size: 25px; font-weight: bold; color: #7a7a7a;">{{ $event->eventname }}</h2>
                                <p2 style="font-size: 17px; color: #d3d3d3;">{{ $event->description }}</p2>
                            </div>
                        </a>
                    </div>
                @endforeach
            </ul>
        @else
            <p>No events on your wishlist.</p>
        @endif

    </div>
@endsection
