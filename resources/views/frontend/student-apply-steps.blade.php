{{-- @extends('layouts.app')
@section('content')
    @if (Auth::check())
        @if (Auth::user()->role_id == '4')
            @include('layouts.studentnav')
        @elseif (Auth::user()->role_id == '3')
            @include('layouts.tutornav')
        @elseif (Auth::user()->role_id == '5')
            @include('layouts.parentnav')
        @elseif (Auth::user()->role_id == '1' || Auth::user()->role_id == '2')
            @include('layouts.navbar')
        @endif
    @else
        @include('layouts.navbar')
    @endif
    @php
    $pathSegments = request()->segments();
    $headerfooter = \App\Models\Page::where('page_name', $pathSegments[0])->first();

    @endphp
    {!! $headerfooter->student_apply_steps !!}
    <!-- Tutor apply step cards end -->
@endsection --}}

@extends('layouts.app')
@section('content')
    @if (Auth::check())
        @if (Auth::user()->role_id == '4')
            @include('layouts.studentnav')
        @elseif (Auth::user()->role_id == '3')
            @include('layouts.tutornav')
        @elseif (Auth::user()->role_id == '5')
            @include('layouts.parentnav')
        @elseif (Auth::user()->role_id == '1' || Auth::user()->role_id == '2')
            @include('layouts.navbar')
        @endif
    @else
        @include('layouts.navbar')
    @endif
      <style>
    @media only screen and (max-width:425px){
        .stepcard{
            margin:10px auto;
        }
    }
    @media only screen and (max-width:768px){
        .fourth-card{
            margin-bottom:7rem !important;
        }
        .first-card{
            margin-top: 3% !important;
        }
       
    }
    @media only screen and (max-width:1024px){
        .fourth-card{
            margin-bottom:4rem !important;
        }
    }
   @media screen and (min-device-width: 425px) and (max-device-width: 768px){
    .card-title{
        font-size: 17px !important;
    }
    .card-text{
         font-size: 15px !important;
    }
    }
    </style>

    <div class="container">
        <div class="row pt-5 text-center">
            <div class="col">
                <h1 class="fw-bolder simple-title" id="text-color">It is Simple</h1>
            </div>
        </div>
    </div>
    <div class="d-flex flex-column flex-md-row justify-content-center align-items-center mb-5 pb-5">

        <div class="card border-0 d-flex align-items-center text-center first-card stepcard" style="width: 18rem; margin-top: 10%">
            <div
                style="
              width: 100px;
              background: #abfe10;
              padding: 20px;
              border-radius: 50%;
              height: 90px;
              text-align: center;
            ">
                <img src="{{ asset('assets/images/icons8-register-50 1.png') }}" class="card-img-top" style="width: 50px" />
            </div>
            <div class="card-body">
                <a href="{{ url('/select-user-type') }}" class="text-decoration-none">
                    <h5 class="card-title p-1 text-dark" style="background-color: #0096ff; border-radius: 5px">
                        Get Started
                    </h5>
                </a>
                <p class="card-text">@isset($web_settings['st_one']) {{$web_settings['st_one'] ?? '' }} @endisset</p>
            </div>
        </div>
        <div class="card border-0 d-flex align-items-center text-center  stepcard " style="width: 18rem; margin-top: 11%">
            <div
                style="
              width: 100px;
              background: #abfe10;
              padding: 20px;
              border-radius: 50%;
              height: 90px;
            ">
                <img src="{{ asset('assets/images/icons8-online-class-64 1.png') }}" class="card-img-top" style="width: 50px" />
            </div>
            <div class="card-body">
                <a href="{{ url('/find-tutor') }}" class="text-decoration-none">
                    <h5 class="card-title p-1 text-dark" style="background-color: #0096ff; border-radius: 5px">
                        Connect With Tutor
                    </h5>
                </a>
                <p class="card-text">
                    @isset($web_settings['st_two']) {{$web_settings['st_two'] ?? '' }} @endisset
                </p>
            </div>
        </div>
        <div class="card border-0 d-flex align-items-center text-center stepcard" style="width: 18rem; margin-top: 7%">
            <div
                style="
              width: 100px;
              background: #abfe10;
              padding: 20px;
              border-radius: 50%;
              height: 90px;
            ">
                <img src="{{ asset('assets/images/icons8-online-class-60 1.png') }}" class="card-img-top" style="width: 50px" />
            </div>
            <div class="card-body">
                <h5 class="card-title p-1" style="background-color: #0096ff; border-radius: 5px">
                    Take Free Demo
                </h5>
                <p class="card-text">
                    @isset($web_settings['st_three']) {{$web_settings['st_three'] ?? '' }} @endisset
                </p>
            </div>
        </div>
        <div class="card border-0 d-flex align-items-center text-center fourth-card stepcard" style="width: 18rem; margin-top: 1%">
            <div
                style="
              width: 100px;
              background: #abfe10;
              padding: 20px;
              border-radius: 50%;
              height: 90px;
            ">
                <img src="{{ asset('assets/images/icons8-tuition-30 1.png') }}" class="card-img-top" style="width: 50px" />
            </div>
            <div class="card-body">
                <h5 class="card-title p-1" style="background-color: #0096ff; border-radius: 5px">
                    Start Tuition
                </h5>
                <p class="card-text">
                    @isset($web_settings['st_four']) {{$web_settings['st_four'] ?? '' }} @endisset
                </p>
            </div>
        </div>
    </div>
    <!-- Student apply step cards end -->
    <script>
        var botmanWidget = {
            aboutText: '247Tutors',
            title: 'Chat Support',
            mainColor: '#0096FF',
            bubbleBackground: '#0096FF',
            introMessage: "✋ Hi! I'm from 247tutors.com"
        };
    </script>

    <script src='https://cdn.jsdelivr.net/npm/botman-web-widget@0/build/js/widget.js'></script>
@endsection
