@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>My Events</h2>

        @if(count($myEvents) > 0)
            <ul>
                @foreach($myEvents as $event)
                    <div class="event-box">
                        <div class="event-photo">
                            <img src="{{ asset('photos/' . $event->photo) }}" alt="Event Photo">
                        </div>
                        <div class="event-details">
                            <p style="font-size: 17px; color: #ef9db2;">Start Date: {{ $event['startdatetime'] }}</p>
                            <h2 style="font-size: 25px; font-weight: bold; color: #7a7a7a;">{{ $event['eventname'] }}</h2>

                            <div class="see_more">
                                <a href="{{ route('event.show', ['id' => $event->id]) }}">
                                    <span style="font-size: 12px" class = "see-more-text">See more</span>
                                    <div class="see-more-icon">
                                        <img src="{{ asset('icons/seemore.png') }}" alt="See More" class="icon" style="width: 20px; height: 20px;">
                                    </div>
                                </a>
                            </div>

                            <br>
                        </div>

                        <div class="share">
                            <a href="{{ route('event.invite', ['eventId' => $event->id]) }}">
                            <img src="{{ asset('icons/share.png') }}" alt="Share Icon" style="width: 30px; height: 30px;">
                            </a>
                        </div>

                        <br>
                        
                    </div>

                    <!-- Display "Going" Attendees -->
                    <h3>Going Attendees:</h3>
                    @if(count($event->attendances) > 0)
                        <ul>
                            @foreach($event->attendances->where('participation', 'Going') as $attendance)
                                <li>
                                    {{ $attendance->user->name }} - {{ $attendance->participation }}
                                    <!-- Add a delete button/link here -->
                                    <a href="{{ route('remove.attendee', ['eventId' => $event->id, 'userId' => $attendance->user->id]) }}">Remove</a>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p>No "Going" attendees yet.</p>
                    @endif
                @endforeach
            </ul>
        @else
            <p>No events found.</p>
        @endif
    </div>
@endsection
