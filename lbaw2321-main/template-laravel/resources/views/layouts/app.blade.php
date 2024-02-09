<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <link rel="icon" href="{{ asset('icons/shaking_hands.png') }}" type="image/png">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Styles -->
    <link href="{{ url('css/milligram.min.css') }}" rel="stylesheet">
    <link href="{{ url('css/app.css') }}" rel="stylesheet">
    <script type="text/javascript">
        // Fix for Firefox autofocus CSS bug
        // See: http://stackoverflow.com/questions/18943276/html-5-autofocus-messes-up-css-loading/18945951#18945951
    </script>
    <script type="text/javascript" src="{{ url('js/app.js') }}" defer></script>
    <style>
        .logout-dropdown {
            display: none;
            position: absolute;
            background-color: #fff;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            z-index: 1;
            right: 0;
        }

        .logout-dropdown a {
            display: block;
            padding: 10px;
            text-decoration: none;
            color: #333;
        }
    </style>
</head>
<body>
    <main>
        <header>
            <h1>
                <a href="{{ url('/events-begin') }}">
                    <img src="{{ asset('photos/GetTogether.png') }}" alt="GetTogether Logo" style="width: 170px; height: auto;">
                </a>
            </h1>

            @if (Auth::check())
                <!-- Navigation Links -->
                <nav>
                    <!-- Home Button -->
                    <span class="home_button @if(Request::is('events-begin')) active @endif">
                        <a href="{{ url('/events-begin') }}">
                            @if(Request::is('events-begin'))
                            <img src="{{ asset('icons/icons8-casa-24.png') }}" alt="Ícone" style="width: 20px; height: auto;">
                            @else
                            <img src="{{ asset('icons/icons8-casa-24-2.png') }}" alt="Ícone" style="width: 20px; height: auto;">
                            @endif
                            Home
                        </a>
                    </span>

                    <!-- Create MyEvents Button -->
                    <span class="home_button @if(Request::is('events/myevents')) active @endif">
                        <a href="{{ url('events/myevents') }}">
                            @if(Request::is('events/myevents'))
                            <img src="{{ asset('icons/shaking_yellow.png') }}" alt="Ícone" style="width: 20px; height: auto;">
                            @else
                            <img src="{{ asset('icons/shaking_grey.png') }}" alt="Ícone" style="width: 20px; height: auto;">
                            @endif
                            My Events
                        </a>
                    </span>

                    <!-- Sent Invitations Button -->
                    <span class="home_button @if(Request::is('sent-invitations')) active @endif">
                        <a href="{{ url('sent-invitations') }}">
                            @if(Request::is('sent-invitations'))
                            <img src="{{ asset('icons/sent_yellow.png') }}" alt="Ícone" style="width: 20px; height: auto;">
                            @else
                            <img src="{{ asset('icons/sent_grey.png') }}" alt="Ícone" style="width: 20px; height: auto;">
                            @endif
                            Sent Invitations
                        </a>
                    </span>




                    <!-- My schedule Button -->
                    <span class="home_button @if(Request::is('events/going')) active @endif">
                        <a href="{{ url('/events/going') }}">
                            @if(Request::is('events/going'))
                            <img src="{{ asset('icons/schedule_yellow.png') }}" alt="Ícone" style="width: 20px; height: auto;">
                            @else
                            <img src="{{ asset('icons/schedule_grey.png') }}" alt="Ícone" style="width: 20px; height: auto;">
                            @endif
                            My Schedule
                        </a>
                    </span>



                    <!-- Create Event Button -->
                    <a href="{{ route('events.create') }}" class="create-event-button">Create Event</a>

                    @if( Auth::user()->isadmin == 'true')
                        <a href="{{ route('admin.dashboard') }}">Admin Dashboard</a>
                    @endif
                    
                    <a href="{{ route('about') }}">About</a>

                    <a href="{{ route('faq') }}">FAQs</a>

                    <!-- User Profile Section with Dots -->
                    <span class="username">
                        <img src="{{ asset(Auth::user()->profile_photo ?: 'profile_photos/user_profile.png') }}" alt="Profile Icon" class="profile-icon" style="width: 40px; height: 40px;border-radius: 50%; margin-right: 10px">
                        <a href="{{ route('profile.show') }}">{{ Auth::user()->name }}</a>
                        <img src="{{ asset('icons/3dots.png') }}" alt="3 Dots" class="dots" style="margin-left: 25px">
                        <div class="logout-dropdown">
                            <a href="{{ url('/logout') }}">Logout</a>
                        </div>
                    </span>
                </nav>

            @endif
        </header>
        <section id="content">
            @yield('content')
        </section>
    </main>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const dots = document.querySelector(".dots");
            const logoutDropdown = document.querySelector(".logout-dropdown");

            dots.addEventListener("click", function () {
                logoutDropdown.style.display = (logoutDropdown.style.display === "block") ? "none" : "block";
            });

            document.addEventListener("click", function (event) {
                if (!event.target.matches('.dots')) {
                    logoutDropdown.style.display = "none";
                }
            });
        });
    </script>
</body>
</html>
