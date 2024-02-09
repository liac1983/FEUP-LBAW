<!-- resources/views/admin/viewEventInfo.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Event Information</div>

                    <div class="card-body">
                        <!-- Display the event name -->
                        <h2>{{ $event->eventname }}</h2>

                        <!-- Display the start time of the event -->
                        <p>Start Time: {{ $event->startdatetime }}</p>

                        <!-- Display the end time of the event -->
                        <p>End Time: {{ $event->enddatetime }}</p>

                        <!-- Display the registration end time -->
                        <p>Registration End Time: {{ $event->registrationendtime }}</p>

                        <!-- Display the location of the event -->
                        <p>Location: {{ $event->local }}</p>

                        <!-- Display the description of the event -->
                        <p>Description: {{ $event->description }}</p>

                        <!-- Display the capacity of the event -->
                        <p>Capacity: {{ $event->capacity }}</p>

                        <!-- Display whether the event is public or not -->
                        <p>Public: {{ $event->ispublic ? 'Yes' : 'No' }}</p>

                        <!-- Display the status of the event -->
                        <p>Status: {{ $event->status }}</p>

                        <!-- Display the owner of the event DO THIS  -->
                        

                        <!-- Display the tag associated with the event FIX THIS -->
                        @if($event->tag)
                            <p>Tag: {{ $event->tag->name }}</p>
                        @else
                            <p>No Tag Assigned</p>
                        @endif

                        <!-- Display the photo (assuming it's a URL) -->
                        @if($event->photo)
                            <img src="{{ $event->photo }}" alt="Event Photo">
                        @else
                            <p>No Photo Available</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
