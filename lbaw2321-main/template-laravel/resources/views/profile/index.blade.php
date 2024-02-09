@extends('layouts.app')

@section('content')
    <h2>{{ Auth::user()->name }}'s Profile</h2>
    <div class="profile-wrapper">
    <div class="profile-container">
        <img src="{{ asset(Auth::user()->profile_photo ?: 'profile_photos/user_profile.png') }}" class="rounded-profile">
        <h3>{{ Auth::user()->name }}</h3>
        <div class="text-secondary mb-2">
            <p><img src="icons/location.png" alt="Location Icon"> Porto, Portugal</p>
            <p><img src="icons/phone.png" alt="Phone Icon"> +(351) 123-4567</p>
        </div>

    </div>

    <div class="user-info">
    <div style="display: flex; align-items: center;">
        <h3 style="margin-right: 10px;">Account Details</h3>
        <a href="{{ route('profile.editProfileForm') }}" style="margin-left: auto;">
            <img src="icons/edit_profile.png" alt="Edit Profile Icon" class="edit-profile">
        </a>
    </div>
    <p><strong>Username:</strong> <strong class="info">{{ Auth::user()->username }}</strong></p>
    <p><strong>Name:</strong> <strong class="info">{{ Auth::user()->name }}</strong></p>
    <p><strong>Email:</strong> <strong class="info">{{ Auth::user()->email }}</strong></p>
</div>

</div>

<div class="wishlist-container">
    <div style="overflow: hidden;"> <!-- Container for clearfix -->
        <h3 style="float: left; margin-right: 10px;">Wishlist Events</h3>
        <div class="view-all-link" style="float: right; margin-right: 10px; maring-top:4px;">
            <a href="{{ route('events.wishlist') }}" style="color: #f0ba4b;">View All</a>
        </div>
    </div>

    <div class="event-box-wishlist">
        @php $counter = 0 @endphp
        @foreach($wishlist as $event)
            @if($counter < 3)
                <div class="container-events-wishlist">
                    <a href="{{ route('event.show', ['id' => $event->id]) }}">
                        <div class="event-details-wishlist">
                            <div class="event-photo-wishlist">
                                <img src="{{ asset('photos/' . $event->photo) }}" alt="Event Photo">
                            </div>
                            <div class="event-info">
                                <h2 style="font-size: 17px; font-weight: bold; color: #7a7a7a;">{{ $event->eventname }}</h2>
                                <p2 style="font-size: 14px; color: #d3d3d3;">{{ $event->description }}</p2>
                            </div>
                        </div>
                    </a>
                </div>
                @php $counter++ @endphp
            @endif
        @endforeach
    </div>
</div>


    

@endsection
