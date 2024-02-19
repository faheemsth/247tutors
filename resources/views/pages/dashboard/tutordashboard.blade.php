@extends('pages.dashboard.apptutor')
@section('content')
    @if(Auth::user()->status == "Pending")
    <style type="text/css">
        body {
            font-family: "Inter", sans-serif;
        }

        .formbold-mb-5 {
            margin-bottom: 20px;
        }

        .formbold-pt-3 {
            padding-top: 12px;
        }

        .formbold-main-wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 48px;
        }

        .formbold-form-wrapper {
            margin: 0 auto;
            max-width: 550px;
            width: 100%;
            background: white;
        }

        .formbold-form-label {
            display: block;
            font-weight: 500;
            font-size: 16px;
            color: #07074d;
            margin-bottom: 12px;
        }

        .formbold-form-label-2 {
            font-weight: 600;
            font-size: 20px;
            margin-bottom: 20px;
        }

        .formbold-form-input {
            width: 100%;
            padding: 12px 24px;
            border-radius: 6px;
            border: 1px solid #e0e0e0;
            background: white;
            font-weight: 500;
            font-size: 16px;
            color: #6b7280;
            outline: none;
            resize: none;
        }

        .formbold-form-input:focus {
            border-color: #6a64f1;
            box-shadow: 0px 3px 8px rgba(0, 0, 0, 0.05);
        }

        .formbold-btn {
            text-align: center;
            font-size: 16px;
            border-radius: 6px;
            padding: 14px 32px;
            border: none;
            font-weight: 600;
            background-color: black;
            color: white;
            cursor: pointer;
        }

        .formbold-btn:hover {
            box-shadow: 0px 3px 8px rgba(0, 0, 0, 0.05);
        }

        .formbold--mx-3 {
            margin-left: -12px;
            margin-right: -12px;
        }

        .formbold-px-3 {
            padding-left: 12px;
            padding-right: 12px;
        }

        .flex {
            display: flex;
        }

        .flex-wrap {
            flex-wrap: wrap;
        }

        .w-full {
            width: 100%;
        }

        .formbold-file-input input {
            opacity: 0;
            position: absolute;
            /* width: 100%; */
            /* height: 100%; */
        }

        .formbold-file-input label {
            position: relative;
            border: 1px dashed #e0e0e0;
            border-radius: 6px;
            min-height: 200px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 48px;
            text-align: center;
        }

        .formbold-drop-file {
            display: block;
            font-weight: 600;
            color: #07074d;
            font-size: 20px;
            margin-bottom: 8px;
        }

        .formbold-or {
            font-weight: 500;
            font-size: 16px;
            color: #6b7280;
            display: block;
            margin-bottom: 8px;
        }

        .formbold-browse {
            font-weight: 500;
            font-size: 16px;
            color: #07074d;
            display: inline-block;
            padding: 8px 28px;
            border: 1px solid #e0e0e0;
            border-radius: 4px;
        }

        .formbold-file-list {
            border-radius: 6px;
            background: #f5f7fb;
            padding: 16px 32px;
        }

        .formbold-file-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .formbold-file-item button {
            color: #07074d;
            border: none;
            background: transparent;
            cursor: pointer;
        }

        .formbold-file-name {
            font-weight: 500;
            font-size: 16px;
            color: #07074d;
            padding-right: 12px;
        }

        .formbold-progress-bar {
            margin-top: 20px;
            position: relative;
            width: 100%;
            height: 6px;
            border-radius: 8px;
            background: #e2e5ef;
        }

        .formbold-progress {
            position: absolute;
            width: 75%;
            height: 100%;
            left: 0;
            top: 0;
            background: #6a64f1;
            border-radius: 8px;
        }

        @media (min-width: 540px) {
            .sm\:w-half {
                width: 50%;
            }
        }

        /* //// */
        #multistep_form fieldset:not(:first-of-type) {
            display: none;
        }

        .appo-picker.is-large {
            max-width: 500px !important;
        }

        .appo-picker.is-large .appo-picker-list {
            max-width: 340px;
            padding-top: 10px !important;
        }

        .text-left-1 {
            text-align: left !important;
        }

        .flag {
            display: inline-block;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            text-align: center;
            border: 1px solid #0D99FF;
            position: absolute;
            top: -5px;
            background: #0D99FF;
            z-index: 10;
            font-size: 12px;
            color: #ffffff;
        }

        .flag-1 {
            left: -12px;
        }

        .flag-2 {
            left: 354px;
        }

        .flag-3 {
            left: 710px;
        }

        .flag-4 {
            left: 1068px;
        }

        @media only screen and (max-width: 1240px) {
            .flag-2 {
                left: 250px;
            }

            .flag-3 {
                left: 512px;
            }

            .flag-4 {
                left: 772px;
            }
        }

        @media only screen and (max-width: 999px) {
            .flag-2 {
                left: 190px;
            }

            .flag-3 {
                left: 390px;
            }

            .flag-4 {
                left: 575px;
            }
        }

        @media only screen and (max-width: 768px) {
            .flag-2 {
                left: 185px;
            }

            .flag-3 {
                left: 380px;
            }

            .flag-4 {
                left: 580px;
            }
        }

        @media only screen and (max-width: 425px) {
            .flag-2 {
                left: 85px;
            }

            .flag-3 {
                left: 175px;
            }

            .flag-4 {
                left: 265px;
            }
        }

        @media only screen and (max-width: 375px) {
            .flag-2 {
                left: 70px;
            }

            .flag-3 {
                left: 145px;
            }

            .flag-4 {
                left: 225px;
            }
        }

        @media only screen and (max-width: 320px) {
            .flag-2 {
                left: 57px;
            }

            .flag-3 {
                left: 130px;
            }

            .flag-4 {
                left: 200px;
            }
        }

        .card-content {
            /* border: 2px solid black; */
            width: 400px;
            height: auto;
            margin: auto;
            box-shadow: 0px 0px 4px 3px rgb(234, 228, 228);
        }

        .card-lists i {
            padding-right: 10px;
            color: rgb(139, 233, 139);


        }

        .box {
            text-align: center;
            padding: 20px;
            width: auto;
            border: 1px solid #ffffff;
            background-color: #eeeeee;
        }

        .cen {
            text-align: center;
        }
    </style>
    <div class="container">
        <div class="panel-group">
            <div class="row panel panel-primary justify-content-center">
                <form class="form-horizontal" id="registration-form">
                <fieldset id="personal">
                        <div class="panel-body mt-5">
                            <div class="container">
                                <div class="col-md-5 center-box m-auto heih">
                                    <div class="box py-5">
                                        <i style="font-size: 3.2rem">"&#128077"</i>
                                        <h4 class="fw-bold my-4" style="color: rgba(0, 150, 255, 1)">Thank you for your application.</h4>
                                        <p>We are currently reviewing your application and will be in touch by email within
                                            7 working days to let you know about next steps. If you need any help,just get
                                            in touch.</p>
                                    </div>
                                    <div class="mt-1 mb-5">
                                        <p class="cen">Need help? Call us <a href="tel:+447851012039" class="text-decoration-none"><span style="color: rgb(162, 244, 10)"> +44 7851 012039 </span></a> or<a href="mailto:hello@247tutors.co.uk" class="text-decoration-none">
                                            <span style="color: rgb(162, 244, 10)">email us</span></a>. </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
    @else
    {{-- <div class="container-fluid top-margin">
        <div class="boxes-center">
            <div class="boxes row gap-2 d-flex justify-content-center">
                <div class="box mt-3 col-12 col-md-2 " id="box1">
                    <img src="{{ asset('assets/images/graduating-student 1.png') }}" alt="">
                    <h1 class="pt-2">{{ $student }}</h1>
                    <h1 class="pt-2">Students</h1>
                </div>
                <div class="box  mt-3 col-12 col-md-2 " id="box2">
                    <img src="{{ asset('assets/images/atom 2.png') }}" alt="">
                    <h1 class="pt-2">{{ $subject }}</h1>
                    <h1 class="pt-2">Subjects</h1>
                </div>
                <a href="{{ url('bookings') }}"
                    class="box  mt-3 col-12 col-md-2  text-dark text-decoration-none" id="box3">
                    <img src="{{ asset('assets/images/booking-icon-png-2 1.png') }}" alt="">
                    <h1 class="pt-2">{{ $booking }}</h1>
                    <h1 class="pt-2">Bookings</h1>
                </a>
                <div class="box  mt-3 col-12 col-md-2 " id="box2">
                    <img src="{{ asset('assets/images/euro.png') }}" alt="">
                    <h1 class="pt-2">{{ $Wallettotal }}</h1>
                    <h1 class="pt-2">Total Earning</h1>
                </div>
            </div>
        </div>
    </div> --}}
    <div class="container pt-5">
        <div class="row mt-5">
            <div class="col-xl-3 col-md-6 mb-2">
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
                                <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="0">{{ $student }}</span></h4>
                                <a href="{{ url('/bookings') }}" class="text-decoration-none text-muted">View all
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
            <div class="col-xl-3 col-md-6 mb-2">
                <!-- card -->
                <div class="card card-animate" style="background-color: rgb(162, 244, 10);">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="text-uppercase fw-bold mb-0">
                                    <img src="{{ asset('assets/images/atom 2.png') }}" alt="" width="11%">
                                    Subject</p>
                            </div>
                            <div class="flex-shrink-0">

                            </div>
                        </div>
                        <div class="d-flex align-items-end justify-content-between mt-4" >
                            <div>
                                <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="0">{{ $subject }}</span></h4>
                                <a href="{{ url('/tutor_profile') }}" class="text-decoration-none text-muted">View all
                                    Subject</a>
                            </div>
                            <div style="width: 16%;">
                                <span class="avatar-title bg-info-subtle rounded fs-3">
                                    <img src="{{ asset('assets/images/atom 2.png') }}" alt="" width="100%">
                                </span>
                            </div>
                        </div>
                    </div><!-- end card body -->
                </div><!-- end card -->
            </div>
            <div class="col-xl-3 col-md-6 mb-2">
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
                                <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="0">{{ $booking }}</span></h4>
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
            <div class="col-xl-3 col-md-6 mb-2">
                <!-- card -->
                <div class="card card-animate" style="background-color: rgb(162, 244, 10);">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="text-uppercase fw-bold mb-0">
                                    <img src="{{ asset('assets/images/euro.png') }}" alt="" width="10%">
                                    Total Earning</p>
                            </div>
                            <div class="flex-shrink-0">

                            </div>
                        </div>
                        <div class="d-flex align-items-end justify-content-between mt-4" >
                            <div>
                                <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="0">{{ $Wallettotal }}</span></h4>
                                <a href="{{ url('/tutor/payments') }}" class="text-decoration-none text-muted">View all
                                    Amount</a>
                            </div>
                            <div style="width: 16%;">
                                <span class="avatar-title bg-info-subtle rounded fs-3">
                                    <img src="{{ asset('assets/images/euro.png') }}" alt="" width="90%">
                                </span>
                            </div>
                        </div>
                    </div><!-- end card body -->
                </div><!-- end card -->
            </div>


        </div>
    </div>

    <!-- Popup container -->
    @if (empty($disclaimer))
    <div class="popup-container" id="popupContainer">
        <div class="popup-content">
            <button onclick="closePopup()" class="btn close-popup" style="float: right;"> <img
                    src="./assets/images/close (1).png" alt="">
            </button>
            <h1>Disclaimer</h1>
            <ul>
                <li>Lorem ipsum dolor sit amet.</li>
                <li>Est magni cupiditate ad laboriosam vitae a Dicta nisi qui corrupti laborum non repellat molestiae.
                </li>
                <li>Lorem ipsum dolor sit amet.</li>
                <li>Est magni cupiditate ad laboriosam vitae a Dicta nisi qui corrupti laborum non repellat molestiae.
                </li>

                <form method="POST" action="{{ url('disclaimer/request') }}">
                    <div class="form-check mt-3 d-flex align-items-baseline justify-content-between">
                        @csrf
                        <div>
                            <input class="form-check-input" type="checkbox" value="1" name="disclaimer" required id="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">
                                I would like to Receive, Tips, and offers by Email
                            </label>
                        </div>
                        <button type="submit" id="checkButton" class="btn btn-primary">Check the Checkbox</button>
                    </div>
                <form>

            </ul>
        </div>
    </div>
    @endif
    <div class="container mt-5 pt-3 pb-5">
        <div class="last-image">
            <video controls muted autoplay width="100%">
                <source src="example.mp4" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </div>
    </div>
    @endif
@endsection
