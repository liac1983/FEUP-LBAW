@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Create a New Event</h2>
        <form action="{{ route('events.createEvent') }}" method="post" enctype="multipart/form-data">

            @csrf

            <div class="form-group">
                <label for="eventname">Event Name:</label>
                <input type="text" name="eventname" class="form-control" required>
            </div>
            
            <div class="form-group">
                <label for="startdatetime">Start Date and Time:</label>
                <input type="datetime-local" name="startdatetime" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="enddatetime">End Date and Time:</label>
                <input type="datetime-local" name="enddatetime" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="registrationendtime">Registration End Time:</label>
                <input type="datetime-local" name="registrationendtime" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="local">Location:</label>
                <input type="text" name="local" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="description">Description:</label>
                <textarea name="description" class="form-control" required></textarea>
            </div>

            <div class="form-group">
                <label for="capacity">Capacity:</label>
                <input type="number" name="capacity" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="isPublic">Is Public:</label>
                <input type="checkbox" name="isPublic" value="1" checked>
            </div>

            <div class="form-group">
                <label for="tag">Select a Tag:</label>
                <select name="tag" class="form-control">
                    <option value="" selected disabled>Select a Tag</option>
                    @foreach ($tags as $tag)
                        <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                    @endforeach
                </select>
            </div>


            <div class="form-group">
                <label for="isPrivate">Is Private:</label>
                <input type="checkbox" name="isPrivate" value="1">
            </div>

            <div class="form-group">
                <label for="photo">Event Photo:</label>
                <input type="file" name="photo" class="form-control-file">
            </div>

            <button type="submit" class="button-primary">Create Event</button>
        </form>
    </div>
@endsection
