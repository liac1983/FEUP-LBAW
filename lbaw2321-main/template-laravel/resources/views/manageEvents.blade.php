@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/table.css') }}">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h2>All Events</h2>

                        @if(session('success'))
                            <div id="success-message" class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif

                        <table>
                            <thead>
                                <tr>
                                    <th>Event Name</th>
                                    <th>Start Time</th>
                                    <th>Action</th>
                                    <th>Event Page</th>
                                </tr>
                            </thead>
                            <tbody> 
                                @forelse($events as $event)
                                    <tr>
                                        <td>{{ htmlspecialchars($event->eventname) }}</td>
                                        <td>{{ $event->startdatetime }}</td>
                                        <td>
                                            <form method="POST" action="{{ route('admin.deleteEvent', ['id' => $event->id]) }}" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this event?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Delete Event</button>
                                            </form>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.viewEventInfo', ['id' => $event->id]) }}" class="btn btn-info btn-sm">View Event Info</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4">No events found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <!-- JavaScript Timer for Flash Message --> 
                        <script>
                            document.addEventListener('DOMContentLoaded', function () {
                                setTimeout(function () {
                                    var successMessage = document.getElementById('success-message');
                                    if (successMessage) {
                                        successMessage.style.display = 'none';
                                    }
                                }, 5000); // Set the duration in milliseconds (e.g., 5000ms for 5 seconds)
                            });
                        </script>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
