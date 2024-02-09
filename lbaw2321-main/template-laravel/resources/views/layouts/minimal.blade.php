<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link href="{{ url('css/login.css') }}" rel="stylesheet">
    <!-- Other stylesheets or scripts you need -->
</head>
<body>
    <main id="app">
        @yield('content')
    </main>
</body>
</html>
