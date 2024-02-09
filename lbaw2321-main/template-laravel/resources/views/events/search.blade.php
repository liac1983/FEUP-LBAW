@extends('layouts.app')

@section('content')
    <h4>Search Results for "{{ $query }}"</h1>

    @if(count($events) > 0)
        <div class="event-container">
            @foreach ($events as $event)
                <div class="event-box">
                    <div class="event-photo">
                        <img src="{{ asset('photos/' . $event->photo) }}" alt="Event Photo">
                    </div>
                    <p style="font-size: 17px; color: #ef9db2;">Start Date: {{ $event['startdatetime'] }}</p>
                    <h2 style="font-size: 25px; font-weight: bold; color: #7a7a7a;">{{ $event['eventname'] }}</h2>
                    <p2 style="font-size: 17px; color: #d3d3d3;">{{ $event['description'] }}</p2>
                </div>
            @endforeach
        </div>
    @else
        <p>No events found for the query "{{ $query }}"</p>
    @endif
@endsection
