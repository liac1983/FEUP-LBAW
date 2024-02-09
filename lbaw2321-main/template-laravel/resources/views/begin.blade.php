@extends('layouts.app')

@section('content')
<!-- Search Bar -->
<form action="{{ route('events.search') }}" method="GET" class="rounded-search-bar">
    <input type="text" name="query" placeholder="Search Events">
    <div class="notification-container">
        <img src="{{ asset('icons/notifications.png') }}" alt="Notifications" class="notification-bell" style="width: 35px; height: 35px;">
        <div class="notification-dropdown">
            <!-- Notification items will be appended here dynamically using JavaScript -->
        </div>
    </div>
</form>


<div class="filter-by-dropdown">
    <label for="tag-filter">Filter by:</label>
    <select id="tag-filter" class="tag-dropdown" onchange="filterByTag(this.value)">
        <option value="all">All Events</option>
        @foreach ($tags as $tag)
            <option value="{{ $tag->id }}">{{ $tag->name }}</option>
        @endforeach
    </select>
</div>
<div class="event-gallery">
    @if(isset($events) && count($events) > 0)
        @foreach ($events as $event)
            <div class="event-box">
                <a href="{{ route('event.show', ['id' => $event['id']]) }}">
                    <div class="event-photo">
                        <img src="{{ asset('photos/' . $event['photo']) }}" alt="Event Photo">
                    </div>
                    <div class="event-details">
                        <p style="font-size: 17px; color: #ef9db2;">Start Date: {{ $event['startdatetime'] }}</p>
                        <h2 style="font-size: 25px; font-weight: bold; color: #7a7a7a;">{{ $event['eventname'] }}</h2>
                        <p2 style="font-size: 17px; color: #d3d3d3;">{{ $event['description'] }}</p2>
                    </div>
                </a>
                
                <div class="wishlist-and-going">
        <div class="wishlist">
            @if($event['inWishlist'])
                <form action="{{ route('events.removeFromWishlist', ['eventId' => $event['id']]) }}" method="POST">
                    @csrf
                    <button type="submit" style="display: none;">
                        <img src="{{ asset('icons/bookmark.png') }}" alt="Event on Wishlist" style="width: 40px; height: 40px;">
                    </button>
                </form>
            @else
                <form action="{{ route('events.addToWishlist', ['eventId' => $event['id']]) }}" method="POST">
                    @csrf
                    <button type="submit" style="display: none;">
                        <img src="{{ asset('icons/bookmark_cinzento.png') }}" alt="Add to Wishlist" style="width: 40px; height: 40px;">
                    </button>
                </form>
            @endif
            <a href="#" onclick="event.preventDefault(); this.previousElementSibling.submit();">
                @if($event['inWishlist'])
                    <img src="{{ asset('icons/bookmark.png') }}" alt="Event on Wishlist" style="width: 40px; height: 40px;">
                @else
                    <img src="{{ asset('icons/bookmark_cinzento.png') }}" alt="Add to Wishlist" style="width: 40px; height: 40px;">
                @endif
            </a>
        </div>

        <form method="post" action="{{ route('events.toggleAttendance', ['eventId' => $event['id'], 'participation' => $event['isGoing'] ? 'Not Going' : 'Going']) }}">
    @csrf
    <button type="submit" class="{{ $event['isGoing'] ? 'going' : 'not-going' }}" style="width: 100px; float:right;">
        @if($event['isGoing'])
            Going
        @else
            Not going
        @endif
    </button>
</form>

    </div>




            </div>
        @endforeach
    @else
        <p>No events found.</p>
    @endif

    @if(isset($newEvent))
        <div class="alert alert-success">
            New Event Created: {{ $newEvent['eventname'] }}
        </div>
    @endif
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
    const bellIcon = document.querySelector(".notification-bell");
    const notificationDropdown = document.querySelector(".notification-dropdown");
    let isDropdownVisible = false;

    bellIcon.addEventListener("click", function (event) {
        isDropdownVisible = !isDropdownVisible;
        notificationDropdown.classList.toggle("show", isDropdownVisible);

        if (isDropdownVisible) {
        fetch('/notifications')
            .then(response => response.json())
            .then(data => updateNotificationDropdown(data))
            .catch(error => console.error('Error:', error));
    }

        event.stopPropagation();
    });

    document.addEventListener("click", function () {
        if (isDropdownVisible) {
            notificationDropdown.classList.remove("show");
            isDropdownVisible = false;
        }
    });

    function updateNotificationDropdown(data) {
    notificationDropdown.innerHTML = '';

    // Handle notifications
    data.notifications.forEach(notification => {
        const notificationItem = document.createElement('div');
        notificationItem.textContent = notification.description || 'No description';
        notificationDropdown.appendChild(notificationItem);
    });

    

    // Handle invitations
    data.invitations.forEach(invitation => {
        const invitationItem = document.createElement('div');
        invitationItem.textContent = invitation.message; // Using 'message' from the backend
        notificationDropdown.appendChild(invitationItem);
    });

    const receivedInvitationsLink = document.createElement('a');
        receivedInvitationsLink.href = "{{ route('received_invitations.index') }}";
        receivedInvitationsLink.textContent = "See all received invitations here";
        notificationDropdown.appendChild(receivedInvitationsLink);
}


});



</script>

<script>
    const filterByTagRoute = "{{ route('events.filterByTag') }}";
</script>
<script src="{{ asset('js/filterEvents.js') }}"></script>

@endsection
