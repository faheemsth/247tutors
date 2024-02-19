@extends('layouts/app')
@section('title', '404 - Page Not Found')

@section('content')
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

<!-- push external head elements to head -->
@push('head')
<link rel="stylesheet" href="{{ asset('plugins/DataTables/datatables.min.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/bootstrap/css/bootstrap.css') }}">
<link rel="stylesheet" href="{{ asset('assets/webicons/css/all.css') }}">
@endpush

    <div class="container py-5">
        <div class="row  justify-content-center text-center py-5">
            <div class="col-md-6 py-5">
                <h1>Error</h1>
                <p>An error occurred:</p>
                <p class="fw-bolder" style="font-size:3rem;">{{ $exception }}</p>
                <a href="{{ url('/') }}">Go to Home Page</a>
            </div>
        </div>
    </div>

@endsection
