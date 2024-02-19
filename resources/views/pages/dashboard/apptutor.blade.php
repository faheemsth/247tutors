<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Bootstrap Css file -->
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/tutordashboard.css') }}">
    <!-- font awesome icons -->
    <link rel="stylesheet" href="{{ asset('assets/webicons/css/all.css') }}">
    <link rel="stylesheet" href="{{ asset('tutornavbar.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    {{-- jsdelivr --}}
    <link rel="stylesheet" href="{{ asset('css/jsdelivr.css') }}">
    <script src="{{ asset('js/jsdelivrcore.js') }}"></script>
    <script src="{{ asset('js/jsdelivr.js') }}"></script>

</head>

<body>
    <div id="app">
        @include('layouts/buttons')
        @include('layouts/topbar')
        @if (Auth::check())
        @if (Auth::user()->role_id == '4')
            @include('layouts.studentnav')
        @elseif (Auth::user()->role_id == '3')
            @include('layouts.tutornav')
        @elseif (Auth::user()->role_id == '5' || Auth::user()->role_id == '6'))
            @include('layouts.parentnav')

        @elseif (Auth::user()->role_id == '1' || Auth::user()->role_id == '2')
          @include('layouts.navbar')
        @endif
    @else
        @include('layouts.navbar')
    @endif

        <main>
            @yield('content')
        </main>

        @include('layouts/footer')
    </div>


    <script src="{{ asset('vendor/jquery/jquery3.7.0.js') }}"></script>

    <script>
        // Function to open the popup when the page is loaded
        window.onload = function() {
            document.getElementById('popupContainer').style.display = 'flex';
        }

        // Function to close the popup
        function closePopup() {
            document.getElementById('popupContainer').style.display = 'none';
        }
    </script>



</body>

</html>
