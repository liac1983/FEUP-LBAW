<!-- resources/views/events/index.blade.php -->

@extends('layouts.app')

@section('content')
    <h1>Search Results</h1>

    @if(count($events) > 0)
        <div class="event-container">
            @foreach ($events as $event)
                <div class="event-box">
                    <div class="event-photo">
                        <img src="{{ asset('photos/' . $event->photo) }}" alt="Event Photo">
                    </div>
                    <h2>{{ $event->eventname }}</h2>
                    <p>Start Date: {{ $event->startdatetime }}</p>
                    <p>End Date: {{ $event->enddatetime }}</p>
                    <!-- Add other event details as needed -->
                </div>
            @endforeach
        </div>
    @else
        <p>No events found for the query "{{ $query }}"</p>
    @endif
@endsection

