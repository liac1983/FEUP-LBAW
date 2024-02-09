@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/table.css') }}">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Admin Dashboard</div>
                    <div class="card-body">

                        <div class="btn-group">
                            <button id="btnUsers" class="btn btn-secondary" onclick="changeContent('users')">Users</button>
                            <button id="btnEvents" class="btn btn-secondary" onclick="changeContent('events')">Events</button>
                        </div>

                        <div id="usersContent">
                            <h2>Non-Admin Users:</h2>
                            <table>
                                <thead>
                                    <tr>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>User Status</th>
                                        <th>User Profile</th>
                                    </tr>
                                </thead>
                                <tbody> 
                                    @forelse($nonAdminUsers->sortBy('username') as $user)
                                        <tr>
                                            <td>{{ htmlspecialchars($user->username) }}</td>
                                            <td>{{ htmlspecialchars($user->email) }}</td>
                                            <td>
                                                <form method="POST" action="{{ route('admin.updateUserStatus', ['id' => $user->id]) }}" style="display: inline; margin: 0;">
                                                    @csrf
                                                    @method('PUT')

                                                    <input type="hidden" name="token" value="{{ uniqid() }}">

                                                    <select name="userstatus" style="width: 120px; padding: 2px;">
                                                        <option value="Active" {{ $user->userstatus == 'Active' ? 'selected' : '' }}>Active</option>
                                                        <option value="Suspended" {{ $user->userstatus == 'Suspended' ? 'selected' : '' }}>Suspended</option>
                                                        <option value="Banned" {{ $user->userstatus == 'Banned' ? 'selected' : '' }}>Banned</option>
                                                    </select>

                                                    <button type="submit" class="btn btn-primary btn-sm" style="padding: 2px;">Update</button>
                                                </form>
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.viewUserInfo', ['id' => $user->id]) }}" class="btn btn-info btn-sm">View Profile</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4">No non-admin users found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div id="eventsContent" style="display: none;">
                            <h2>Events:</h2>
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
                        </div>

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

                            function changeContent(contentType) {
                                var btnUsers = document.getElementById('btnUsers');
                                var btnEvents = document.getElementById('btnEvents');
                                var usersContent = document.getElementById('usersContent');
                                var eventsContent = document.getElementById('eventsContent');

                                if (contentType === 'users') {
                                    btnUsers.classList.add('active');
                                    btnEvents.classList.remove('active');
                                    usersContent.style.display = 'block';
                                    eventsContent.style.display = 'none';
                                } else {
                                    btnUsers.classList.remove('active');
                                    btnEvents.classList.add('active');
                                    usersContent.style.display = 'none';
                                    eventsContent.style.display = 'block';
                                }
                            }
                        </script>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
