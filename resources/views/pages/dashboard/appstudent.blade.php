<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="icon" href="{{ asset('assets/favicon/favicon.ico.png')}}" type="image/x-icon">
    <title>{{ config('app.name', 'Laravel') }}</title>

     <!-- Bootstrap Css file -->
     <link rel="stylesheet" href="{{ asset('vendor/bootstrap/css/bootstrap.css') }}">
     <!-- Style Css -->
     <link rel="stylesheet" href="{{ asset('assets/css/profile.css') }}">
     <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
     <!-- font awesome icons -->
     <link rel="stylesheet" href="{{ asset('assets/webicons/css/all.css') }}">
     <link rel="stylesheet" href="{{ asset('vendor/slick/slick-style.css') }}">
     <link rel="stylesheet" href="{{ asset('plugins/select2/dist/css/select2.min.css') }}">
<style>
        .headline{
            font-size:2rem !important;
        }
    </style>
</head>
<body>
    <div id="app">
        @include('layouts/buttons')
        @include('layouts/topbar')


        <main>
            @yield('content')
        </main>

        @include('layouts/footer')
    </div>
    <script src="{{ asset('vendor/jquery/jquery3.7.0.js') }}"></script>
    <script src="{{ asset('vendor/slick/slick-slide.js') }}"></script>
    <script src="{{ asset('plugins/select2/dist/js/select2.min.js') }}"></script>

<script>
     $(document).ready(function() {
            $('.select2').select2({
                multiple: true
            });
        });
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

