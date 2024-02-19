@extends('pages.dashboard.appstudent')


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
    <script src="{{ asset('js/jsdelivrcore.js') }}"></script>
    <script src="{{ asset('js/jsdelivr.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('assets/css/parentdashboard.css') }}">
    <style>
        .filter-search-btn{
        font-size: 20px;
        font-weight: 500;
        background-color: #abff00;
        border-top-right-radius: 4px !important;
        border-bottom-right-radius: 4px !important;
        }
        .welstd{
            font-size:2.8rem;
        }
        @media only screen 
and (max-width : 425px){
     .welstd{
            font-size:1.8rem;
        }
}
@media only screen and (max-width:330px){
      .welstd{
            font-size:1.4rem;
        }
    .msgsection{
        padding-left:5px;
        padding-right:5px;
    }
     .unreadm{
        padding-left:2px;
        padding-right:2px;
    }
     .msgprofile{
        padding-left:0px;
        padding-right:0px;
    }
}
    </style>
    <div class="container-fluid px-md-4">
        <div class="row mt-5 mb-md-3 mx-md-3">
            <div class="col-12">
                <h2 class="fw-bold ms-md-4  welstd" id="text-color">Welcome {{Auth::user()->first_name.' '.Auth::user()->last_name}}</h2>
            </div>
            {{--  --}}
        </div>
        <div class="row mb-5 mt-md-3 mx-md-3">
            <div class="col-12 col-lg-9 msgsection">
                {{--  --}}
                {{-- <div class="row py-4 mb-5 align-items-center">
                    <div class="col-md-12 col-12 align-items-baseline">
                        <div class="row mx-md-0 align-items-center">
                            @if(Auth::check() && Auth::user()->role_id == 5)
                            <a class="col-sm-6 col-md-4 text-dark text-decoration-none" href="{{url('parent/students')}}" >
                                <div class="welcome hoverstu">
                                    <div class="text-center">
                                        <img src="{{ asset('assets/images/graduating-student 1.png') }}" width="155"
                                            class="cardimg py-3" alt="">
                                    </div>
                                    <div class="cardimg py-1">
                                        <h1><b>{{ !empty($students) ? $students->count() : '0' }}</b></h1>
                                        <h2 class="text-center"><b>Students</b></h2>
                                    </div>
                                </div>
                            </a>

                            <div class="col-sm-6 col-md-4">
                                <div class="welcome hoverstu">
                                    <div class="text-center">
                                        <img src="{{ asset('assets/images/wall-clock 1.png') }}" class="cardimg py-3"
                                            alt="">
                                    </div>
                                    <div class="cardimg py-1">
                                        <h1><b>5</b></h1>
                                        <h2 class="text-center"><b>Hours</b></h2>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 col-md-4 " onclick="toggle('tutor')">
                                <div class="welcome hoverstu">
                                    <div class="text-center">
                                        <img src="{{ asset('assets/images/lec.png') }}" width="210" class="cardimg py-3"
                                            alt="">
                                    </div>
                                    <div class="cardimg py-1">
                                        <h1><b>{{ !empty($tutors) ? $tutors->count() : '0' }}</b></h1>
                                        <h2 class="welcome3 text-center py-1"><b>Hired Tutors</b></h2>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                </div> --}}
                @if(Auth::check() && Auth::user()->role_id == 5)
                <div class="row py-4 mb-5 align-items-center">
                    <div class="col-xl-4 col-md-6">
                        <!-- card -->
                        <div class="card card-animate" style="background-color: rgb(162, 244, 10);">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 overflow-hidden">
                                        <p class="text-uppercase fw-bold mb-0">
                                            <img src="{{ asset('assets/images/graduating-student 1.png') }}" alt=""  width="11%">
                                            Student</p>
                                    </div>
                                    <div class="flex-shrink-0">

                                    </div>
                                </div>
                                <div class="d-flex align-items-end justify-content-between mt-4" >
                                    <div>
                                        <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="0">{{ !empty($students) ? $students->count() : '0' }}</span></h4>
                                        <a href="{{url('parent/students')}}" class="text-decoration-none text-muted">View all
                                            Student</a>
                                    </div>
                                    <div style="width: 16%;">
                                        <span class="avatar-title bg-info-subtle rounded fs-3">
                                            <img src="{{ asset('assets/images/graduating-student 1.png') }}" alt="" width="100%">
                                        </span>
                                    </div>
                                </div>
                            </div><!-- end card body -->
                        </div><!-- end card -->
                    </div>
                    <div class="col-xl-4 my-2 my-lg-0 col-md-6">
                        <!-- card -->
                        <div class="card card-animate" style="background-color: rgb(162, 244, 10);">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 overflow-hidden">
                                        <p class="text-uppercase fw-bold mb-0">
                                            {{-- <img src="{{ asset('assets/images/user 1.png') }}" alt="" width="11%"> --}}
                                            <i class="fa-solid fa-user" style="font-size: 22px;"></i>
                                            Hired Tutor</p>
                                    </div>
                                    <div class="flex-shrink-0">

                                    </div>
                                </div>
                                <div class="d-flex align-items-end justify-content-between mt-4" >
                                    <div>
                                        <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="0">{{ !empty($tutors) ? $tutors->count() : '0' }}</span></h4>
                                        <a href="{{ url('/bookings') }}" class="text-decoration-none text-muted">View all
                                            Tutotr</a>
                                    </div>
                                    <div style="width: 16%;text-align: end;">
                                        <span class="avatar-title bg-info-subtle rounded fs-3">
                                            {{-- <img src="{{ asset('assets/images/user 1.png') }}" alt="" width="100%"> --}}
                                            <i class="fa-solid fa-user"></i>
                                        </span>
                                    </div>
                                </div>
                            </div><!-- end card body -->
                        </div><!-- end card -->
                    </div>
                    <div class="col-xl-4 col-md-6 mt-2 mt-xl-0">
                        <!-- card -->
                        <div class="card card-animate " style="background-color: rgb(162, 244, 10);">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 overflow-hidden">
                                        <p class="text-uppercase fw-bold mb-0">
                                            <img src="{{ asset('assets/images/booking-icon-png-2 1.png') }}" alt="" width="10%">
                                            Booking</p>
                                    </div>
                                    <div class="flex-shrink-0">

                                    </div>
                                </div>
                                <div class="d-flex align-items-end justify-content-between mt-4" >
                                    <div>
                                        <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="0">{{ !empty($tutors) ? $tutors->count() : '0' }}</span></h4>
                                        <a href="{{ url('/bookings') }}" class="text-decoration-none text-muted">View all
                                            Booking</a>
                                    </div>
                                    <div style="width: 16%;">
                                        <span class="avatar-title bg-info-subtle rounded fs-3">
                                            <img src="{{ asset('assets/images/booking-icon-png-2 1.png') }}" alt="" width="90%">
                                        </span>
                                    </div>
                                </div>
                            </div><!-- end card body -->
                        </div><!-- end card -->
                    </div>
                </div>

                            @endif
                <div class="row mx-0 mb-5 mt-4 msgsection" style="border: 1px solid #dee2e6;" >
                    <div class="col-12 d-flex justify-content-between pt-2 unreadm" style="border-bottom: 1px solid #dee2e6 ">
                        <h5>Unread Messages</h5>
                        <a href="{{url('/students/messages/')}}">
                            see all messages
                        </a>
                    </div>
                    <span id="AjaxFetchChatUnredList" class="msgprofile">
                        
                    </span>

                </div>

                {{--  --}}
            </div>
            
            <div class="col-12 col-md-6 col-lg-3">
                @if(\Auth::user()->role_id == 5)
                <div class="row py-4">
                    <div class="col-12">
                        <div class="card h-100 align-items-center py-4 gap-2">
                          <!-- <img src="{{url('assets/images/profile.png')}}" class="w-25 rounded-circle" alt="..."> -->
                          <div class="card-body text-center">
                            <h5 class="card-title">Disclaimer</h5>
                            <p class="card-text"> Kindly Monitor your child during sessions and payments </p>
                            <!-- <a href="#" class="text-decoration-none mt-1">Contact us</a> -->
                          </div>
                        </div>
                      </div>
                </div>
                @else
                <div class="row py-4">
                    <div class="col-12">
                        <div class="card h-100 align-items-center py-4 gap-2">
                          <img src="{{url('assets/images/profile.png')}}" class="w-25 rounded-circle" alt="...">
                          <div class="card-body text-center">
                            <h5 class="card-title">Need help? We’re here</h5>
                            <p class="card-text">Speak to the London-based team. Our office is open 8am to 7pm Mon-Thurs, 8am to 5:30pm Fri.</p>
                            <a href="tel:@isset($web_settings['Ph_num']) {{$web_settings['Ph_num'] ?? '' }} @endisset" class="text-decoration-none mt-1">Contact us</a>
                          </div>
                        </div>
                      </div>
                </div>
                @endif
                
            </div>
        </div>

    </div>
 <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    
    <script>
        setInterval(function() {
        $.ajax({
            url: "{{ url('AjaxFetchChatUnredList') }}",
            type: 'GET',
            success: function(response) {
                $('#AjaxFetchChatUnredList').html('');
                $('#AjaxFetchChatUnredList').html(response);

            }
        });
    }, 1000);
    </script>
@endsection
