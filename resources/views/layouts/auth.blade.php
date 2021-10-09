<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="stylesheet" href="{{ asset('auth_panel/fonts/material-icon/css/material-design-iconic-font.min.css')}}">

    <!-- Styles -->
    <link href="{{ asset('auth_panel/css/style.css') }}" rel="stylesheet">
</head>
<body>
    <main class="main">
        @yield('content')
    </main>

    <script src="{{ asset('auth_panel/vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{ asset('auth_panel/js/main.js')}}"></script>
</body>
</html>
