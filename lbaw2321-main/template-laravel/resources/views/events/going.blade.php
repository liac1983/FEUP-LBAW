<!-- resources/views/events/going.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Events I'm Going</h2>

        @if(!empty($goingEvents) && count($goingEvents) > 0)
            <ul>
                @foreach($goingEvents as $attendance)
                    <div class="event-box">
                        <a href="{{ route('event.show', ['id' => $attendance->id]) }}">
                            <div class="event-photo">
                                <img src="{{ asset('photos/' . $attendance->photo) }}" alt="Event Photo">
                            </div>
                            <div class="event-details">
                            <p style="font-size: 17px; color: #ef9db2;">Start Date: {{ $attendance->startdatetime }}</p>
                            <h2 style="font-size: 25px; font-weight: bold; color: #7a7a7a;">{{ $attendance->eventname }}</h2>
                            <p2 style="font-size: 17px; color: #d3d3d3;">{{ $attendance->description }}</p2>

                                <!-- Form to change "my decision" for events I'm going -->
                                <form action="{{ route('event.changeDecision', ['id' => $attendance->id]) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <label for="decision">My Decision:</label>
                                    <select name="decision" id="decision">
                                        <option value="Going" {{ optional($attendance)->participation === 'Going' ? 'selected' : '' }}>Going</option>
                                        <option value="Maybe" {{ optional($attendance)->participation === 'Maybe' ? 'selected' : '' }}>Maybe</option>
                                        <option value="Not Going" {{ optional($attendance)->participation === 'Not Going' ? 'selected' : '' }}>Not Going</option>
                                    </select>


                                    <button type="submit">Update Decision</button>
                                </form>
                            </div>
                        </a>
                    </div>
                @endforeach
            </ul>
        @else
            <p>No events you're going to.</p>
        @endif

        <h2>Events I'm Not Going</h2>

        @if(!empty($notgoingEvents) && count($notgoingEvents) > 0)
            <ul>
                @foreach($notgoingEvents as $attendance)
                    <div class="event-box">
                        <a href="{{ route('event.show', ['id' => $attendance->id]) }}">
                            <div class="event-photo">
                                <img src="{{ asset('photos/' . $attendance->photo) }}" alt="Event Photo">
                            </div>
                            <div class="event-details">
                            <p style="font-size: 17px; color: #ef9db2;">Start Date: {{ $attendance->startdatetime }}</p>
                            <h2 style="font-size: 25px; font-weight: bold; color: #7a7a7a;">{{ $attendance->eventname }}</h2>
                            <p2 style="font-size: 17px; color: #d3d3d3;">{{ $attendance->description }}</p2>

                                <!-- Form to change "my decision" for events I'm not going -->
                                <form action="{{ route('event.changeDecision', ['id' => $attendance->id]) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <label for="decision">My Decision:</label>
                                    <select name="decision" id="decision">
                                        <option value="Not Going" {{ optional($attendance)->participation === 'Not Going' ? 'selected' : '' }}>Not Going</option>
                                        <option value="Going" {{ optional($attendance)->participation === 'Going' ? 'selected' : '' }}>Going</option>
                                        <option value="Maybe" {{ optional($attendance)->participation === 'Maybe' ? 'selected' : '' }}>Maybe</option>
                                    </select>

                                    <button type="submit">Update Decision</button>
                                </form>
                            </div>
                        </a>
                    </div>
                @endforeach
            </ul>
        @else
            <p>No events you're not going to.</p>
        @endif

        <h2>Events I May Be Going</h2>

        @if(!empty($maybegoingEvents) && count($maybegoingEvents) > 0)
            <ul>
                @foreach($maybegoingEvents as $attendance)
                    <div class="event-box">
                        <a href="{{ route('event.show', ['id' => $attendance->id]) }}">
                            <div class="event-photo">
                                <img src="{{ asset('photos/' . $attendance->photo) }}" alt="Event Photo">
                            </div>
                            <div class="event-details">
                            <p style="font-size: 17px; color: #ef9db2;">Start Date: {{ $attendance->startdatetime }}</p>
                            <h2 style="font-size: 25px; font-weight: bold; color: #7a7a7a;">{{ $attendance->eventname }}</h2>
                            <p2 style="font-size: 17px; color: #d3d3d3;">{{ $attendance->description }}</p2>

                                <!-- Form to change "my decision" for events I may be going -->
                                <form action="{{ route('event.changeDecision', ['id' => $attendance->id]) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <label for="decision">My Decision:</label>
                                    <select name="decision" id="decision">
                                        <option value="Maybe" {{ optional($attendance)->participation === 'Maybe' ? 'selected' : '' }}>Maybe</option>
                                        <option value="Going" {{ optional($attendance)->participation === 'Going' ? 'selected' : '' }}>Going</option>
                                        <option value="Not Going" {{ optional($attendance)->participation === 'Not Going' ? 'selected' : '' }}>Not Going</option>
                                    </select>


                                    <button type="submit">Update Decision</button>
                                </form>
                            </div>
                        </a>
                    </div>
                @endforeach
            </ul>
        @else
            <p>No events you may be going to.</p>
        @endif
    </div>
@endsection
