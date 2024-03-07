@extends('pages.dashboard.appstudent')
@section('content')
    @if (Auth::check())
        @if (Auth::user()->role_id == '4')
            @include('layouts.studentnav')
        @elseif (Auth::user()->role_id == '3')
            @include('layouts.tutornav')
        @elseif (Auth::user()->role_id == '5' || Auth::user()->role_id == '6')
            @include('layouts.parentnav')
        @elseif (Auth::user()->role_id == '1' || Auth::user()->role_id == '2')
            @include('layouts.navbar')
        @endif
    @else
        @include('layouts.navbar')
    @endif
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/appointment-slot-picker@1.2.8/css/appointment-picker.css">
    <link href="{{ URL::asset('assets/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    <style>
        .select2-container {
            width: 100% !important;
        }
    </style>
    <script src="{{ asset('vendor/jquery/jquery3.7.0.js') }}"></script>
    <script src="{{ asset('js/jsdelivrcore.js') }}"></script>
    <script src="{{ URL::asset('assets/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('js/jsdelivr.js') }}"></script>
    <style type="text/css">
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
            display:
                inline-block;
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
            left:
                -12px;
        }

        .flag-2 {
            left: 211px;
        }

        .flag-3 {
            left: 437px;
        }

        .flag-4 {
            left: 659px;
        }

        .flag-5 {
            left: 883px;
        }

        .flag-6 {
            left: 1100px;
        }




        @media only screen and (min-width: 1440px) {

            .flag-2 {
                left: 247px;
            }

            .flag-3 {
                left: 507px;
            }

            .flag-4 {
                left: 764px;
            }

            .flag-5 {
                left: 1024px;
            }

            .flag-6 {
                left: 1280px;
            }
        }

        @media only screen and (max-width: 1025px) {
            .flag-2 {
                left: 175px;
            }

            .flag-3 {
                left: 362px;
            }

            .flag-4 {
                left: 550px;
            }

            .flag-5 {
                left: 739px;
            }

            .flag-6 {
                left: 921px;
            }

        }


        @media only screen and (max-width: 768px) {
            .flag-2 {
                left: 130px;
            }

            .flag-3 {
                left: 268px;
            }

            .flag-4 {
                left: 408px;
            }

            .flag-5 {
                left: 550px;
            }

            .flag-6 {
                left: 684px;
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
    </style>
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

        #chekboxId {}

        @media only screen and (max-width : 425px) {
            .card-content {
                width: 100%;
            }
        }
    </style>
    <div id="topscroll" class="container">
        <div class="row">
            <div class="col-md-12 d-flex justify-content-between mt-5 mb-4">
                <img src="{{ asset('assets/images/247 NEW Logo 2.png') }}" alt="Logo" width="165px" height="auto">
                <div class="col-md-1 text-center">
                    <a href="{{ url('') }}" class="link-dark"><i class="fa-solid fa-xmark fa-2x"></i></a>
                </div>
            </div>
        </div>
    </div>

    <!-- logo end -->

    <!-- prograss bar -->

    <div class="container mt-3">
        <div class=" justify-content-center align-items-center d-none d-md-flex ">
            <div class=" col-md-12">
                <div class="progress" style="position: relative; overflow: visible;">
                    <div class="progress-bar active" role="progressbar" style="background: #ABFF00;"></div>
                    <span class="flag flag-1">1</span>
                    <span class="flag flag-2">2</span>
                    <span class="flag flag-3">3</span>
                    <span class="flag flag-4">4</span>
                    <span class="flag flag-5">5</span>
                    <span class="flag flag-6">6</span>
                </div>
            </div>

        </div>
    </div>

    <!-- End prograss bar -->
    <div class="container">
        <div class="panel-group">
            <div class="row panel panel-primary">

                {{-- student payment process --}}
                <form class="form-horizontal" id="registration_form" method="post">
                    @csrf
                    <input id="role_id" name="role_id" value="4" type="hidden">
                    <fieldset id="step-1">
                        <div class="panel-body mt-5">
                            <div class="container px-0">

                                <div class="d-flex flex-column flex-md-row ">
                                    <!-- main code here -->
                                    <div class="col-md-12 col-12 ">
                                        <div class="card-content  pb-3">
                                            <img src="{{ asset('assets/images/tutor img.jpg') }}" alt=""
                                                width="70%" class="mx-auto d-block">
                                            <h4 class="card-head  px-5 fw-bold"
                                                style="color: rgba(0, 150, 255, 1); text-align: left;">Welcome to the
                                                247Tutors
                                                Application Process &#128075;</h4>
                                            <p class="card-para px-5 my-3 " style="font-size: 12px;">This shouldn't take
                                                more than
                                                10 minutes to
                                                complete. Ready to get going?</p>
                                            <!-- list items -->
                                            <div class="card-lists px-5">
                                                <p class="card-list-items "><i class="fa-solid fa-circle-check  "
                                                        style="font-size: 16px;"></i>Sign up
                                                </p>
                                                <p class="card-list-items "><span><img
                                                            src="{{ asset('assets/images/track.png') }}" alt=""
                                                            style="padding-right: 10px;"></span>Submit
                                                    application</p>
                                                <p class="card-list-items "><span><img
                                                            src="{{ asset('assets/images/three.png') }}" alt=""
                                                            style="padding-right: 10px;"></span>Complete interview
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex col-12 justify-content-center m-auto my-5 gap-2">
                            <a href="#" class="link-dark previous btn " id="previous1"><i
                                    class="fa fa-light fa-arrow-left"></i>
                                Back</a>
                            <a href="#topscroll" class="text-decoration-none"> <input type="button" required
                                    data-id="1"; name="password" class=" next btn btn-primary px-5" value="Next"
                                    id="next1" /></a>
                        </div>
                    </fieldset>

                    <fieldset id="step-2">
                        <div class="panel-body mt-5">
                            <div class="container">

                                <div class="d-flex flex-column flex-md-row ">
                                    <!-- main code here -->
                                    <div class=" col-12 ">
                                        <div class="row justify-content-center">
                                            <div class="col-md-6  col-12">
                                                <h2 class="text-center fs-1" id="text-color">
                                                    <strong>
                                                        Indicates Required Question
                                                    </strong>
                                                </h2><br>
                                                <div class="d-flex flex-column flex-md-row ">
                                                    <div class=" col-12 ">
                                                        <div class="row mt-4 justify-content-center">
                                                            <div class="col-md-12 mb-3">
                                                                <label class="text-secondary">Full Name<span
                                                                        id="Title-validation-message"
                                                                        style="color: red;">*</span></label><br>
                                                                <input type="text" id="title" readonly
                                                                    name="fullname"
                                                                    value="{{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}"
                                                                    class="w-100 p-2">
                                                            </div>
                                                            <div class="col-md-12 mb-3">
                                                                <label class="text-secondary">E-mail <span
                                                                        id="Title-validation-message"
                                                                        style="color: red;">*</span></label><br>
                                                                <input type="text" id="title" readonly
                                                                    name="email" value="{{ Auth::user()->email }}"
                                                                    class="w-100 p-2">
                                                            </div>

                                                            <div class="col-md-12 mb-3">
                                                                <label class="text-secondary">Gender<span
                                                                        id="Title-validation-message"
                                                                        style="color: red;">*</span></label><br>

                                                                <select class=" w-100 p-2" name="gender" id="gender"
                                                                    aria-label="Default select example">
                                                                    <option selected value="">Select Option</option>
                                                                    <option value="Male">Male</option>
                                                                    <option value="Female">Female</option>
                                                                    <option value="Other">Other</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-12 mb-3">
                                                                <label class="text-secondary">Biography<span
                                                                        id="Title-validation-message"
                                                                        style="color: red;">*</span></label><br>
                                                                <textarea name="biography" id="biography" class="w-100 p-2"></textarea>
                                                            </div>


                                                            <div class="col-md-12 mb-3">
                                                                <label class="text-secondary">Postcode<span
                                                                        id="Title-validation-message"
                                                                        style="color: red;">*</span></label><br>
                                                                <textarea type="text" name="address" id="address" class="w-100"></textarea>
                                                            </div>
                                                            <div class="col-md-12 mb-3">
                                                                <label class="text-secondary">Do you have any criminal
                                                                    records ? <span id="Title-validation-message"
                                                                        style="color: red;">*</span></label><br>

                                                                <select class=" w-100 p-2" name="c_record" id="c-record"
                                                                    aria-label="Default select example">
                                                                    <option selected value="">Select Option</option>
                                                                    <option value="1">Yes</option>
                                                                    <option value="0">No</option>
                                                                </select>
                                                            </div>






                                                            <div class="col-md-12 mb-3 c-record">
                                                                <label class="text-secondary">Description of criminal
                                                                    record<span id="Title-validation-message"
                                                                        style="color: red;">*</span></label><br>
                                                                <textarea id="criminal_description" name="criminal_description" class="w-100 p-2"></textarea>
                                                            </div>
                                                        </div>

                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex col-12 justify-content-center m-auto my-5 gap-2">
                            <a href="#" class="link-dark previous btn " id="previous2"><i
                                    class="fa fa-light fa-arrow-left"></i>
                                Back</a>
                            <a href="#topscroll" class="text-decoration-none"> <input type="button" data-id="2"
                                    required name="password" class=" next btn btn-primary px-5" value="Next"
                                    id="next2" /></a>
                        </div>
                    </fieldset>

                    <fieldset id="step-3">
                        <div class="panel-body mt-5">
                            <h2 class="text-center fs-1" id="text-color"><strong>Choose Your Interest</strong></h2><br>
                            <div class="d-flex flex-column flex-md-row ">
                                <!-- main code here -->
                                <div class=" col-12 ">
                                    <div class="row justify-content-center">
                                        <div class="col-md-6 col-12">
                                            <div class="d-flex flex-column flex-md-row ">
                                                <div class=" col-12 ">
                                                    <div class="row mt-4 justify-content-center">

                                                        <div class="col-md-12 mb-3">
                                                            <label class="text-secondary">Interest <span
                                                                    id="Title-validation-message"
                                                                    style="color: red;">*</span></label><br>

                                                            <select class=" w-100 p-2" name="tutortype" id="tutortype"
                                                                aria-label="Default select example">
                                                                <option value="" selected>Select Option</option>
                                                                <option value="1">Online Tutoring</option>
                                                                <option value="2">Home Tutoring</option>
                                                                <option value="3">Both</option>
                                                            </select>
                                                        </div>
                                                        <!--  -->
                                                        <span id="onlinetutor">

                                                            <span id="bothhome">
                                                                <h4>Are you willing to travel ?</h4>
                                                                <div class="col-md-12 mb-3">
                                                                    <label class="text-secondary">Choose <span
                                                                            id="Title-validation-message"
                                                                            style="color: red;">*</span></label><br>

                                                                    <select class=" w-100 p-2" name="is_willing_travel"
                                                                        id="is_willing_travel"
                                                                        aria-label="Default select example">
                                                                        <option value="" selected>Select Option
                                                                        </option>
                                                                        <option value="1">Yes</option>
                                                                        <option value="2">No</option>
                                                                    </select>
                                                                </div>
                                                                <span id="willing">
                                                                    <h4>How far are you willing to travel to pupils home?
                                                                    </h4>
                                                                    <div class="col-md-12 mb-3">
                                                                        <label class="text-secondary">Choose <span
                                                                                id="Title-validation-message"
                                                                                style="color: red;">*</span></label><br>

                                                                        <select class=" w-100 p-2"
                                                                            name="traveling_distance"
                                                                            id="traveling_distance"
                                                                            aria-label="Default select example">
                                                                            <option value="" selected>Select Option
                                                                            </option>
                                                                            <option value="5">Upto 5 Miles</option>
                                                                            <option value="10">Upto 10 Miles</option>
                                                                            <option value="15">Upto 15 Miles</option>
                                                                            <option value="20">Upto 20 Miles</option>
                                                                        </select>
                                                                    </div>



                                                                    <h4>Are you allowed to drive in UK ?</h4>
                                                                    <div class="col-md-12 mb-3">
                                                                        <label class="text-secondary">Choose <span
                                                                                id="Title-validation-message"
                                                                                style="color: red;">*</span></label><br>

                                                                        <select class=" w-100 p-2" name="allowed_drive"
                                                                            onchange="checkDrivePermission(this)"
                                                                            id="allowed_drive"
                                                                            aria-label="Default select example">
                                                                            <option value="" selected>Select Option
                                                                            </option>
                                                                            <option value="1">Yes</option>
                                                                            <option value="2">No</option>
                                                                        </select>
                                                                    </div>




                                                                    <span id="DrivePermission" style="display: none">
                                                                        <div class="col-md-12 mb-3">
                                                                            <label class="text-secondary">Licence
                                                                                number<span id="Title-validation-message"
                                                                                    style="color: red;">*</span></label><br>
                                                                            <input type="text"
                                                                                class="w-100 p-2 licence_number"
                                                                                id="licence_number" name="licence_number"
                                                                                placeholder="Enter Licence number">
                                                                            <span id="Title-validation-message"
                                                                                style="color: red;"></span>
                                                                        </div>
                                                                    </span>

                                                                </span>
                                                            </span>
                                                            <h4>How many hours are you available per week ? </h4>
                                                            <div class="col-md-12 mb-3">
                                                                <label class="text-secondary">Choose
                                                                    <span id="Title-validation-message"
                                                                        style="color: red;">*</span></label><br>

                                                                <select class=" w-100 p-2" name="week_hours"
                                                                    id="week_hours" aria-label="Default select example">
                                                                    <option value="" selected>Select Option</option>
                                                                    <option value="5">5</option>
                                                                    <option value="10">10</option>
                                                                    <option value="15">15</option>
                                                                    <option value="20">20</option>
                                                                    <option value="25">25</option>
                                                                    <option value="30">30</option>
                                                                    <option value="35">35</option>
                                                                    <option value="40">40</option>
                                                                    <option value="45">45</option>
                                                                    <option value="50">50</option>
                                                                    <option value="55">55</option>
                                                                    <option value="60">60</option>
                                                                </select>
                                                            </div>

                                                            <h4 class="text-bold">What days are you available ?
                                                                <span id="Title-validation-message"
                                                                    style="color: red;">*</span>
                                                            </h4>

                                                            <div class="custom-table">
                                                                <table
                                                                    class="table table-bordered border-dark mt-4 custom-table">
                                                                    <thead class="qualification">
                                                                        <tr class="thh">

                                                                            <th class="col" scope="col"></th>
                                                                            <th scope="col">Mon</th>
                                                                            <th scope="col">Tue</th>
                                                                            <th scope="col">Wed</th>
                                                                            <th scope="col">Thu</th>
                                                                            <th scope="col">Fri</th>
                                                                            <th scope="col">Sat</th>
                                                                            <th scope="col">Sun</th>
                                                                            <!-- <th scope="col">Action</th> -->
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody id="userRecordsTableBody">
                                                                        <tr>
                                                                            <td class="tdd">
                                                                                <img src="/assets/images/11111.png"
                                                                                    alt="Morning">Morning
                                                                            </td>
                                                                            @for ($i = 1; $i <= 7; $i++)
                                                                                <td class="text-end">
                                                                                    <input class="form-check-input"
                                                                                        type="checkbox"
                                                                                        name="day_of_the_week[]"
                                                                                        value="{{ $i }}"
                                                                                        id="flexCheckChecked{{ $i }}">
                                                                                </td>
                                                                            @endfor
                                                                        </tr>
                                                                        <tr>
                                                                            <td class="tdd">
                                                                                <img src="/assets/images/sunny 1.png"
                                                                                    alt="Afternoon">Afternoon
                                                                            </td>

                                                                            @for ($i = 1; $i <= 7; $i++)
                                                                                <td class="text-end">
                                                                                    <input class="form-check-input"
                                                                                        type="checkbox"
                                                                                        name="day_of_the_week[]"
                                                                                        value="{{ $i }}"
                                                                                        id="flexCheckChecked{{ $i }}">
                                                                                </td>
                                                                            @endfor
                                                                        </tr>
                                                                        <tr>
                                                                            <td class="tdd">
                                                                                <img src="/assets/images/sunrise 1.png"
                                                                                    alt="Evening">Evening
                                                                            </td>

                                                                            @for ($i = 1; $i <= 7; $i++)
                                                                                <td class="text-end">
                                                                                    <input class="form-check-input"
                                                                                        type="checkbox"
                                                                                        name="day_of_the_week[]"
                                                                                        value="{{ $i }}"
                                                                                        id="flexCheckChecked{{ $i }}">
                                                                                </td>
                                                                            @endfor
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>



                                                            <h4 class="text-bold">Tutoring Experience?
                                                                <span id="Title-validation-message"
                                                                    style="color: red;">*</span>
                                                            </h4>
                                                            <div class="col-md-12 mb-3">
                                                                <label class="text-secondary">Choose <span
                                                                        id="Title-validation-message"
                                                                        style="color: red;">*</span></label><br>

                                                                <select class=" w-100 p-2" name="experience"
                                                                    id="experience" aria-label="Default select example">
                                                                    <option value="" selected>Select Option</option>
                                                                    <option value="1">1 Year</option>
                                                                    <option value="2">2 Year</option>
                                                                    <option value="3">3 Year</option>
                                                                    <option value="4">4 Year</option>
                                                                    <option value="5">5 Year</option>
                                                                    <option value="6">6 Year</option>
                                                                    <option value="7">7 Year</option>
                                                                    <option value="8">8 Year</option>
                                                                    <option value="9">9 Year</option>
                                                                    <option value="10">10 Year</option>
                                                                    <option value="11">11 Year</option>
                                                                    <option value="12">12 Year</option>
                                                                    <option value="13">13 Year</option>
                                                                    <option value="14">14 Year</option>
                                                                    <option value="15">15 Year</option>
                                                                    <option value="16">16 Year</option>
                                                                    <option value="17">17 Year</option>
                                                                    <option value="18">18 Year</option>
                                                                    <option value="19">19 Year</option>
                                                                    <option value="20">20 Year</option>
                                                                </select>
                                                            </div>


                                                            <h4 class="text-bold">Which Subjects you can teach what Level?
                                                                <span id="Title-validation-message"
                                                                    style="color: red;">*</span>
                                                            </h4>
                                                            <div class="col-md-12 mb-3">
                                                                <div class="row">
                                                                    @php
                                                                        $i = 0;
                                                                    @endphp
                                                                    @foreach ($subjects as $subject)
                                                                        @php
                                                                            $selected = in_array($subject->id, explode(',', Auth::user()->subjects)) ? 1 : 0;
                                                                        @endphp
                                                                        @if ($selected == 1)
                                                                            <span id="remover_{{ $i }}"
                                                                                style="display: flex;align-items: center;gap: 30px;">
                                                                                <div class="col-md-4 mb-3">
                                                                                    <label class="text-secondary">Subject
                                                                                        <span id="Title-validation-message"
                                                                                            style="color: red;">*</span></label><br>
                                                                                    <select class="w-10 p-2"
                                                                                        name="subject" id="subjects"
                                                                                        aria-label="Default select example">

                                                                                        <option
                                                                                            value="{{ $subject->id }}"
                                                                                            {{ $selected }}>
                                                                                            {{ $subject->name }}
                                                                                        </option>
                                                                                        @foreach ($subjects as $subject)
                                                                                            <option
                                                                                                value="{{ $subject->id }}"
                                                                                                {{ $selected }}>
                                                                                                {{ $subject->name }}
                                                                                            </option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>

                                                                                <div class="col-md-4 mb-3">
                                                                                    <label class="text-secondary">Level
                                                                                        <span id="Title-validation-message"
                                                                                            style="color: red;">*</span></label><br>
                                                                                    <select class=" w-100 p-2"
                                                                                        name="teaching_level"
                                                                                        id="teaching_level"
                                                                                        aria-label="Default select example">
                                                                                        <option value="" selected>
                                                                                            Select
                                                                                            Option</option>
                                                                                        <option value="KS1 (Primary)"
                                                                                            data-level="KS1 (Primary)">KS1
                                                                                            (Primary)
                                                                                        </option>
                                                                                        <option value="KS2 (Primary)"
                                                                                            data-level="KS2 (Primary)">KS2
                                                                                            (Primary)</option>
                                                                                        <option value="KS3 (GCSE)"
                                                                                            data-level="KS3 (GCSE)">KS3
                                                                                            (GCSE)</option>
                                                                                        <option value="KS4 (A Level)"
                                                                                            data-level="KS4 (A Level)">KS4
                                                                                            (A Level)</option>
                                                                                        <option value="University"
                                                                                            data-level="University">
                                                                                            University</option>
                                                                                    </select>
                                                                                </div>
                                                                                <div class="col-md-2 text-center">
                                                                                    @if ($i != 0)
                                                                                        <i class="fa-solid fa-xmark fa-2x"
                                                                                            onclick="removebox({{ $i }})"></i>
                                                                                    @endif
                                                                                </div>
                                                                            </span>
                                                                            @php
                                                                                $i++;
                                                                            @endphp
                                                                        @endif
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                            <span id="appendmore2">
                                                            </span>
                                                            <div class="border-top"></div>
                                                            <div class="col-12 text-center my-3">
                                                                <button class="btn btn-dark w-75 py-2"
                                                                    id="addbuttonsubject">ADD ANOTHER</button>
                                                            </div>






                                                        </span>



                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="d-flex col-12 justify-content-center m-auto my-5 gap-2">
                            <a href="#" class="link-dark previous btn " id="previous2"><i
                                    class="fa fa-light fa-arrow-left"></i>
                                Back</a>
                            <a href="#topscroll" class="text-decoration-none"> <input type="button" data-id="3"
                                    required name="password" class=" next btn btn-primary px-5" value="Next"
                                    id="next2" /></a>
                        </div>
                    </fieldset>

                    <fieldset id="step-4">
                        <div class="panel-body mt-5">
                            <div class="d-flex flex-column flex-md-row ">
                                <!-- main code here -->
                                <div class="col-md-12 col-12 ">
                                    <div class="container">
                                        <div class="row justify-content-center">
                                            <div class="col-md-6 col-12">
                                                <h2 class=" fs-1" id="text-color"><strong>Do You Have Additional
                                                        Qualifications?</strong>
                                                </h2><br>

                                                <p>
                                                    This could include university admissions tests, music grades, <br>
                                                    academic
                                                    degrees etc.
                                                </p>
                                                <div class="d-flex flex-column flex-md-row ">
                                                    <div class="col-md-12 col-12 ">
                                                        <div class="row mt-4 justify-content-center">
                                                            <div class="col-md-12 mb-3">
                                                                <label class="text-secondary">Qualifications
                                                                    type<span id="Title-validation-message"
                                                                        style="color: red;">*</span></label><br>
                                                                <select class=" w-100 p-2 qualification_type"
                                                                    onchange="changeQualification()"
                                                                    aria-label="Default select example"
                                                                    id="qualification_type">
                                                                    <option selected> </option>
                                                                    <option value="GCSE">GCSE</option>
                                                                    <option value="A-Level">A Level</option>
                                                                    <option value="university">University</option>
                                                                </select>
                                                            </div>


                                                            <div class="col-md-12 mb-3">
                                                                <label class="text-secondary">Title<span
                                                                        id="Title-validation-message"
                                                                        style="color: red;">*</span></label><br>
                                                                <input type="text"
                                                                    class="w-100 p-2 qualification_title"
                                                                    id="qualification_title" name="qualification_title"
                                                                    class="w-100 p-3">
                                                                <span id="Title-validation-message"
                                                                    style="color: red;"></span>
                                                            </div>
                                                            <div class="col-md-12 mb-3">
                                                                <label class="text-secondary">Name of
                                                                    institution <span id="Title-validation-message"
                                                                        style="color: red;">*</span></label><br>
                                                                <input type="text"
                                                                    class="w-100 p-2 qualification_institution"
                                                                    id="qualification_institution">
                                                                <span id="Name-validation-message"
                                                                    style="color: red;"></span>
                                                            </div>
                                                            <div class="col-md-12 mb-3">
                                                                <label class="text-secondary">Grade <span
                                                                        id="Title-validation-message"
                                                                        style="color: red;">*</span></label><br>
                                                                <select class=" w-100 p-2 qualification_grade"
                                                                    aria-label="Default select example"
                                                                    name="qualification_grade" id="qualification_grade">

                                                                </select>
                                                            </div>
                                                            <div class="col-md-12 mb-3">
                                                                <label class="text-secondary">Year Completed <span
                                                                        id="Title-validation-message"
                                                                        style="color: red;">*</span></label><br>
                                                                <input type="date" class="w-100 p-2 year_completed"
                                                                    name="year_completed" id="year_completed"
                                                                    max="9999-12-31">

                                                            </div>
                                                            <span id="appendmore">

                                                            </span>
                                                            <div class="border-top"></div>
                                                            <div class="col-12 text-center my-3">
                                                                <button class="btn btn-dark w-75 py-2" id="addbutton">ADD
                                                                    ANOTHER</button>
                                                            </div>
                                                        </div>

                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="d-flex col-12 justify-content-center m-auto my-5 gap-2">
                            <a href="#" class="link-dark previous btn " id="previous3"><i
                                    class="fa fa-light fa-arrow-left"></i>
                                Back</a>
                            <a href="#topscroll" class="text-decoration-none"> <input type="button" required
                                    name="password" class=" next btn btn-primary px-5" value="Next" id="next2"
                                    data-id="4" /></a>
                        </div>
                    </fieldset>
                    <fieldset id="step-5">
                        <div class="panel-body mt-5">

                            <div class="d-flex flex-column flex-md-row  justify-content-center">
                                <!-- main code here -->

                                <div class="col-md-6 col-12 ">
                                    <h2 class="fs-1" id="text-color"><strong>
                                            Please Upload a Copy Of Your Documents<span id="Title-validation-message"
                                                style="color: red;"></span>
                                        </strong></h2><br>
                                    <p>
                                        We need your graduation certificate for verifiction purposes
                                    </p>
                                    <div class="formbold-mb-5">
                                        <label for="text" class="formbold-form-label">
                                            Upload your ID:<span id="Title-validation-message"
                                                style="color: red;">*</span>
                                        </label>
                                        <input type="file" name="user_id" id="user_id"
                                            class="formbold-form-input" />
                                    </div>
                                    <div class="formbold-mb-5">
                                        <label for="text" class="formbold-form-label">
                                            your ID Expiry:<span id="Title-validation-message"
                                                style="color: red;">*</span>
                                        </label>
                                        <input type="date" name="user_id_expiry" id="user_id_expiry"
                                            class="formbold-form-input" max="9999-12-31" />
                                    </div>

                                    <div class="formbold-mb-5">
                                        <label for="file" class="formbold-form-label">
                                            Proof of address:<span id="Title-validation-message"
                                                style="color: red;">*</span>
                                        </label>
                                        <input type="file" name="address_proof" class="formbold-form-input"
                                            id="address_proof" />
                                    </div>


                                    <div class="formbold-mb-5">
                                        <label for="text" class="formbold-form-label">
                                            Upload Enhaced DBS:<span id="Title-validation-message"
                                                style="color: red;">*</span>
                                        </label>
                                        <input type="file" name="enhaced_dbs" id="enhaced_dbs"
                                            class="formbold-form-input" />
                                    </div>
                                    <div class="formbold-mb-5">
                                        <label for="text" class="formbold-form-label">
                                            Enhaced DBS Expiry:<span id="Title-validation-message"
                                                style="color: red;">*</span>
                                        </label>
                                        <input type="date" name="enhaced_dbs_expiry" id="enhaced_dbs_expiry"
                                            class="formbold-form-input" max="9999-12-31" />
                                    </div>
                                    <div class="formbold-mb-5">
                                        <label for="text" class="formbold-form-label">
                                            Cv Upload:<span id="Title-validation-message" style="color: red;">*</span>
                                        </label>
                                        <input type="file" id="cv" name="cv" name="cv"
                                            class="formbold-form-input" />
                                    </div>
                                    <div class="formbold-mb-5">
                                        <label for="text" class="formbold-form-label">
                                            Upload a Profile Photo:<span id="Title-validation-message"
                                                style="color: red;">*</span>
                                        </label>
                                        <input type="file" id="selfie" name="selfie" name="selfie"
                                            class="formbold-form-input" />
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="d-flex col-12 justify-content-center m-auto my-5 gap-2">
                            <a href="#" class="link-dark previous btn " id="previous3"><i
                                    class="fa fa-light fa-arrow-left"></i>
                                Back</a>
                            <a href="#topscroll" class="text-decoration-none"> <input type="button" required
                                    name="password" class=" next btn btn-primary px-5" value="Next" id="next2"
                                    data-id="5" /></a>
                        </div>
                    </fieldset>

                    <fieldset id="step-6">
                        <div class="panel-body mt-5">
                            <div class="d-flex flex-column flex-md-row ">
                                <!-- main code here -->
                                <div class="col-md-12 col-12 ">
                                    <div class="container">
                                        <div class="row justify-content-center">
                                            <div class="col-md-6 col-12">
                                                <h2 class="fs-1" id="text-color"><strong>Reference And
                                                        Undertaking</strong>
                                                </h2><br>

                                                <p>
                                                    Do you have any reference ?
                                                </p>
                                                <div class="d-flex flex-column flex-md-row ">
                                                    <div class="col-md-12 col-12 ">
                                                        <div class="row mt-4 justify-content-center">


                                                            <div class="col-md-12 mb-3">
                                                                <label class="text-secondary">Do you have any reference?
                                                                </label><br>
                                                                <select class=" w-100 p-2" name="reference"
                                                                    id="refr" aria-label="Default select example">
                                                                    <option selected value="">Select Reference<span
                                                                            id="Title-validation-message"
                                                                            style="color: red;">*</span>
                                                                    </option>
                                                                    <option value="1">Yes</option>
                                                                    <option value="0">No</option>
                                                                </select>
                                                            </div>

                                                            <span id="refrmore">

                                                                <div class="col-md-12 mb-3">
                                                                    <label class="text-secondary">Select
                                                                        Relationship</label><br>
                                                                    <select class=" w-100 p-2" id="refrance_relationship"
                                                                        name="refrance_relationship"
                                                                        aria-label="Default select example">
                                                                        <option selected value="">
                                                                        </option>

                                                                        <option value="linkedin">Linkedin</option>

                                                                        <option value="family_member">Family Members
                                                                        </option>
                                                                        <option value="friend">Friend</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-12 mb-3">
                                                                    <label class="text-secondary">Reference Contact
                                                                        Number</label><br>
                                                                    <input type="text" id="refrance_contact_number"
                                                                        name="refrance_contact_number" class="w-100 p-3">
                                                                </div>

                                                                <div class="col-md-12 mb-3">
                                                                    <label class="text-secondary">Reference Email
                                                                        Id</label><br>
                                                                    <input type="email" name="refrance_email"
                                                                        id="refrance_email" class="w-100 p-3">
                                                                </div>

                                                            </span>
                                                            <h4>Disclaimer</h4>
                                                            <p>i hereby declare that information provided is true and
                                                                correct. i also understand
                                                                that only willful dishonesty may</p>
                                                            <div class="col-md-12 mb-3 d-flex">

                                                                <input type="checkbox" id="disclaimer" value="1"
                                                                    name="disclaimer" id="chekboxId"
                                                                    class="lastcheck mx-1" <label
                                                                    class="text-secondary">Accept<span
                                                                    id="Title-validation-message"
                                                                    style="color: red;">*</span></label><br>
                                                            </div>

                                                        </div>

                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="d-flex col-12 justify-content-center m-auto my-5 gap-2">
                            <a href="#" class="link-dark previous btn " id="previous3"><i
                                    class="fa fa-light fa-arrow-left"></i>
                                Back</a>
                            <input type="submit" name="save" class=" next btn btn-primary px-5" id="submit-bnt"
                                value="Submit" data-id="6" />
                            <button class="btn btn-primary d-none spiner" type="button" disabled>
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                Processing ...
                            </button>
                        </div>
                    </fieldset>

                </form>
            </div>
        </div>
    </div>



    <script src="{{ asset('js/timeslot.min.js') }}"></script>
    <script src="{{ asset('vendor/jquery/jquery3.7.0.js') }}"></script>

    <script>
        function changeQualification(val = '') {
            if (val === undefined) {
                console.error('Undefined value for "val".');
                return;
            }

            let option = '';
            let qualificationGrade = $('#qualification_grade' + val);

            if (qualificationGrade.length === 0) {
                console.error('Element with ID "qualification_grade' + val + '" not found.');
                return;
            }

            qualificationGrade.empty();

            let qualificationType = $('#qualification_type' + val).val();
            if (qualificationType === 'A-Level') {
                option =
                    '<option value="U">U</option><option value="E">E</option><option value="D">D</option><option value="C">C</option><option value="B">B</option><option value="A">A</option><option value="A*">A*</option>';
            } else if (qualificationType === 'GCSE') {
                option =
                    '<option value="U">U</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option>';
            } else if (qualificationType === 'university') {
                option =
                    '<option value="Fail">Fail</option><option value="Third-Class Honours">Third-Class Honours</option><option value="Lower Second-Class Honours">Lower Second-Class Honours</option><option value="Upper Second-Class Honours">Upper Second-Class Honours</option><option value="First-Class Honours">First-Class Honours</option>';
            } else {
                console.error('Invalid qualification type: ' + qualificationType);
                return;
            }

            qualificationGrade.append(option);
        }

        let divCount = 0;
        $(document).ready(function() {
            const addButton = $("#addbutton");


            addButton.click(function(event) {
                event.preventDefault();

                if (divCount < 5) {
                    const html = `<span id="step_id_${divCount+1}"><h4>Qualification ${divCount+2}  <button type="button" class="btn btn-sm btn-danger" onclick="removeItem(${divCount+1})">X</button> </h4>
                        <div class="col-md-12 mb-3">
                                                                <label class="text-secondary">Qualifications
                                                                    type</label><br>
                                                                <select class=" w-100 p-2 qualification_type"
                                                                    onchange="changeQualification(${divCount+1})"
                                                                    aria-label="Default select example"
                                                                    id="qualification_type${divCount+1}">
                                                                    <option selected></option>
                                                                    <option value="GCSE">GCSE</option>
                                                                    <option value="A-Level">A Level</option>
                                                                    <option value="university">University</option>
                                                                </select>
                                                            </div>


                                                            <div class="col-md-12 mb-3">
                                                                <label class="text-secondary">Title</label><br>
                                                                <input type="text"
                                                                    class="w-100 p-2 qualification_title"
                                                                    id="qualification_title" name="qualification_title">
                                                                <span id="Title-validation-message"
                                                                    style="color: red;"></span>
                                                            </div>
                                                            <div class="col-md-12 mb-3">
                                                                <label class="text-secondary">Name of
                                                                    institution</label><br>
                                                                <input type="text"
                                                                    class="w-100 p-2 qualification_institution"
                                                                    id="qualification_institution">
                                                                <span id="Name-validation-message"
                                                                    style="color: red;"></span>
                                                            </div>
                                                            <div class="col-md-12 mb-3">
                                                                <label class="text-secondary">Grade</label><br>
                                                                <select class=" w-100 p-2 qualification_grade"
                                                                    aria-label="Default select example"
                                                                    name="qualification_grade" id="qualification_grade${divCount+1}">

                                                                </select>
                                                            </div>
                                                            <div class="col-md-12 mb-3">
                                                                <label class="text-secondary">Year Completed</label><br>
                                                                <input type="date" class="w-100 p-2 year_completed"
                                                                    name="year_completed" id="year_completed" max="9999-12-31">
                                                            </div>
                                                    </span>`;
                    $("#appendmore").append(html);
                    divCount++;

                    if (divCount === 5) {
                        addButton.hide();
                    }
                }
            });
        });
        //  remove item
        function removeItem(id) {
            $('#step_id_' + id).remove();
            divCount--;
        }
    </script>

    <script>
        $(document).ready(function() {
            const htmlArray = [];
            const addbuttonsubject = $("#addbuttonsubject");
            let i = {{ $i }};
            addbuttonsubject.click(function(event) {
                event.preventDefault();
                const html = `
            <span id="remover_${i}">
            <div class="col-md-12 mb-3">
                <div class="row align-items-center" style="gap:30px;">
                    <div class="col-md-4 mb-3">
                        <label class="text-secondary">Subject <span id="Subject-validation-message" style="color: red;">*</span></label><br>
                        <select class="w-10 p-2" name="subject" id="subject_{{ $subject->id }}" aria-label="Default select example">
                            @foreach ($subjects as $sub)
                                @if (!in_array($sub->id, explode(',', Auth::user()->subjects)))
                                    <option value="{{ $sub->id }}">
                                        {{ $sub->name }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="text-secondary">Level <span id="Level-validation-message" style="color: red;">*</span></label><br>
                        <select class="w-100 p-2" name="teaching_level" id="teaching_level_{{ $sub->id }}" aria-label="Default select example">
                            <option value="" selected>Select Option</option>
                            <option value="KS1 (Primary)" data-level="KS1 (Primary)">KS1 (Primary)</option>
                            <option value="KS2 (Primary)" data-level="KS2 (Primary)">KS2 (Primary)</option>
                            <option value="KS3 (GCSE)" data-level="KS3 (GCSE)">KS3 (GCSE)</option>
                            <option value="KS4 (A Level)" data-level="KS4 (A Level)">KS4 (A Level)</option>
                            <option value="University" data-level="University">University</option>
                        </select>
                    </div>
                    <div class="col-md-2 text-center">
                        <i class="fa-solid fa-xmark fa-2x" onclick="removebox(${i})"></i>

                    </div>
                </div>
            </div>
            </span>

        `;
                i++;
                $("#appendmore2").append(html);
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#onlinetutor').hide();
            $('#hometutor').hide();
            $('#bothtype').hide();
            $('#tutortype').change(function() {
                if ($(this).val() == '1') {
                    $('#onlinetutor').show();
                    $('#bothhome').hide();
                    $('#bothtype').hide();
                } else if ($(this).val() == '2') {
                    $('#bothhome').show();
                    $('#onlinetutor').show();
                    // $('#hometutor').show();
                    $('#bothtype').show();
                } else if ($(this).val() == '3') {
                    $('#bothhome').show();
                    $('#onlinetutor').show();
                    $('#hometutor').hide();
                    $('#bothtype').show();
                }
            });

            $('#is_willing_travel').change(function() {
                if ($(this).val() == '2') {
                    $('#willing').hide();
                } else if ($(this).val() == '1') {
                    $('#willing').show();
                }
            });

        });
    </script>

    <script>
        $(document).ready(function() {
            // Initially hide the "c-record" div
            $('.c-record').hide();

            // Listen for the change event on the select element
            $('#c-record').change(function() {
                if ($(this).val() == '1') {
                    // If "Yes" is selected, show the "c-record" div
                    $('.c-record').show();
                } else {
                    // If "No" or "Select Option" is selected, hide the "c-record" div
                    $('.c-record').hide();
                }
            });
        });
    </script>
    <script>
        var picker = '';
        let slots = '';
        $(document).ready(function() {
            var form_count = 1;
            var total_forms = $("fieldset").length;

            var date = new Date().toISOString().slice(0, 10);
            $('#date').attr('min', date);
            $("fieldset:not(:first)").hide();
            // Function to set the progress bar
            function setProgressBar(curStep) {
                var percent = (curStep - 1) / (total_forms - 1) * 100;
                $(".progress-bar")
                    .css("width", percent + "%")
            }
            // Function to show the next step and hide the current step
            function showNextStep() {
                if (validateStep(form_count)) {
                    var currentFieldset = $("fieldset:visible");
                    var nextFieldset = currentFieldset.next("fieldset");

                    if (nextFieldset.length > 0) {
                        currentFieldset.hide();
                        nextFieldset.show();
                        form_count++;
                        setProgressBar(form_count);
                    }
                } else {
                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: 'Please fill in all required fields.',
                        showConfirmButton: false,
                        timer: 2000,
                        showCloseButton: true
                    });
                }
            }

            function validateStep(step) {
                var isValid = true;
                return isValid;
            }

            // Function to show the previous step and hide the current step
            function showPreviousStep() {
                var currentFieldset = $("fieldset:visible");
                var previousFieldset = currentFieldset.prev("fieldset");

                if (previousFieldset.length > 0) {
                    currentFieldset.hide();
                    previousFieldset.show();
                    form_count--;
                    setProgressBar(form_count);
                }
            }
            // Handle the "Next" button click
            $(".next").click(function() {
                console.log($(this).attr('data-id'));
                if (validateFun($(this).attr('data-id'))) {
                    showNextStep();
                };
                if ($(this).attr('data-id') == 1) {
                    showNextStep();
                }
            });
            // Handle the "Previous" button click
            $(".previous").click(function() {
                showPreviousStep();
            });
            // Handle the "Submit" button click (you can adjust this as needed)
            $(".submit").click(function() {
                // You can add your form submission logic here
                alert("Form submitted!");
            });
        });
        //save data .
        $('#registration_form').on('submit', function(e) {
            e.preventDefault();


            var subjectValues = [];
            $('select[name="subject"]').each(function() {
                var subjectValue = $(this).val();
                if (subjectValue !== '') {
                    subjectValues.push(subjectValue);
                }
            });
            var subjects = subjectValues;

            var levelValues = [];
            $('select[name="teaching_level"]').each(function() {
                var levelValue = $(this).val();
                if (levelValue !== '') {
                    levelValues.push(levelValue);
                }
            });
            var teaching_level = levelValues;

            var role_id = $('#role_id').val();
            var c_record = $('#c-record').val();
            var criminal_description = $('#criminal_description').val();
            if (c_record == 1) {
                if (criminal_description == null) {
                    alert('Please Write some description');
                    return false;
                }
            }
            var tutortype = $('#tutortype').val();

            var gender = $('#gender').val();
            var biography = $('#biography').val();
            var address = $('#address').val();

            var experience = $('#experience').val();
            var week_hours = $('#week_hours').val();
            var tutoring_organisation = $('#tutoring_organisation').val();
            var is_willing_travel = $('#is_willing_travel').val();
            var traveling_distance = $('#traveling_distance').val();
            var licence_number = $('#licence_number').val();
            var allowed_drive = $('#allowed_drive').val();

            var qualification_type = $('.qualification_type').map(function(idx, elem) {
                return $(elem).val();
            }).get();
            var qualification_title = $('.qualification_title').map(function(idx, elem) {
                return $(elem).val();
            }).get();
            var qualification_institution = $('.qualification_institution').map(function(idx, elem) {
                return $(elem).val();
            }).get();
            var qualification_grade = $('.qualification_grade').map(function(idx, elem) {
                return $(elem).val();
            }).get();
            var year_completed = $('.year_completed').map(function(idx, elem) {
                return $(elem).val();
            }).get();
            var user_id = document.getElementById('user_id').files[0];
            var address_proof_expiry = $('#address_proof_expiry').val();
            var user_id_expiry = $('#user_id_expiry').val();
            var enhaced_dbs_expiry = $('#enhaced_dbs_expiry').val();
            var enhaced_dbs = document.getElementById('enhaced_dbs').files[0];
            var address_proof = document.getElementById('address_proof').files[0];
            var selfie = document.getElementById('selfie').files[0];
            var cv = document.getElementById('cv').files[0];
            var reference = $('#refr').val();
            var refrance_relationship = $('#refrance_relationship').val();
            var refrance_contact_number = $('#refrance_contact_number').val();
            var refrance_email = $('#refrance_email').val();
            var disclaimer = $('#disclaimer').val();
            let fileData = new FormData();
            fileData.append('user_id', user_id);
            fileData.append('enhaced_dbs', enhaced_dbs);
            fileData.append('selfie', selfie);
            fileData.append('cv', cv);
            fileData.append('address_proof', address_proof);
            if (reference == '' || reference == null) {
                message();
                return false;
            } else {
                if (reference == 1) {
                    if (refrance_relationship == '' || refrance_relationship == null || refrance_contact_number ==
                        '' || refrance_contact_number == null || refrance_email == '' || refrance_email == null) {
                        message();
                        return false;
                    }
                }
            }
            if (disclaimer != 1) {
                message();
                return false
            }

            var userRecords = [];
            $("#userRecordsTableBody tr").each(function() {
                var rowData = {
                    period: $(this).find('.tdd img').attr('alt'),
                    checkboxes: []
                };
                $(this).find('input[type="checkbox"]').each(function(index) {
                    if ($(this).is(":checked")) {
                        rowData.checkboxes.push(index + 1);
                    }
                });
                userRecords.push(rowData);
            });
            fileData.append('userRecords', JSON.stringify(userRecords));

            var formData = {
                role_id: role_id,
                is_criminal: c_record,
                criminal_description: criminal_description,
                tutortype: tutortype,
                week_hours: week_hours,
                subjects: subjects,
                teaching_level: teaching_level,
                tutoring_organisation: tutoring_organisation,
                is_willing_travel: is_willing_travel,
                traveling_distance: traveling_distance,
                qualification_type: qualification_type,
                licence_number: licence_number,
                allowed_drive: allowed_drive,
                qualification_title: qualification_title,
                qualification_institution: qualification_institution,
                qualification_grade: qualification_grade,
                year_completed: year_completed,
                user_id_expiry: user_id_expiry,
                address_proof_expiry: address_proof_expiry,
                enhaced_dbs_expiry: enhaced_dbs_expiry,
                reference: reference,
                refrance_relationship: refrance_relationship,
                refrance_contact_number: refrance_contact_number,
                refrance_email: refrance_email,
                disclaimer: disclaimer,
                experience: experience,
                gender: gender,
                biography: biography,
                address: address,


            }
            for (var key in formData) {
                fileData.append(key, formData[key]);
            }
            $.ajax({
                url: "{{ url('save_profile_verification') }}",
                type: "POST",
                contentType: false,
                cache: false,
                processData: false,
                data: fileData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                    $('.spiner').removeClass('d-none');
                    $('#submit-bnt').addClass('d-none');
                },
                success: function(data) {
                    if (data.success == true) {
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: data.message,
                            showConfirmButton: false,
                            timer: 2000,
                            showCloseButton: true,

                        }).then((result) => {
                            window.location.href = '{{ url('tutor/home') }}';
                        });
                        $('.spiner').addClass('d-none');
                        $('#submit-bnt').removeClass('d-none');
                    } else {
                        Swal.fire({
                            position: 'center',
                            icon: 'error',
                            title: data.message,
                            showConfirmButton: false,
                            timer: 2000,
                            showCloseButton: true
                        });
                        $('.spiner').addClass('d-none');
                        $('#submit-bnt').removeClass('d-none');
                    }
                },
                error: function(data) {
                    console.log(data)
                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: data,
                        showConfirmButton: false,
                        timer: 2000,
                        showCloseButton: true,
                    });
                    $('.spiner').addClass('d-none');
                    $('#submit-bnt').removeClass('d-none');
                }

            })

        })
        //valide
        function validateFun(key) {
            if (key == 2) {
                var c_record = $('#c-record').val();
                var gender = $('#gender').val();
                var biography = $('#biography').val();
                var address = $('#address').val();
                if (c_record == '' || c_record == null || gender == '' || gender == null || biography == '' || biography ==
                    null || address == '' || address == null) {
                    message();
                    return false;
                } else {
                    var criminal_description = $('#criminal_description').val();
                    if (c_record == 1) {
                        if (criminal_description == null || criminal_description == '') {
                            message();
                            return false;
                        }
                    }

                }
                return true;
            } else if (key == 3) {


                if ($('#tutortype').val() == '' || $('#tutortype').val() == null) {
                    message();
                    return false;
                } else {

                    var experience = $('#experience').val();
                    var week_hours = $('#week_hours').val();
                    var subjects = $('#subjects').val();
                    var teaching_level = $('#teaching_level').val();
                    var tutoring_organisation = $('#tutoring_organisation').val();
                    var is_willing_travel = $('#is_willing_travel').val();
                    var traveling_distance = $('#traveling_distance').val();
                    var allowed_drive = $('#allowed_drive').val();
                    var licence_number = $('#licence_number').val();

                    if ($('#tutortype').val() == 1) {
                        if (experience == '' || experience == null || week_hours == '' || week_hours == null) {
                            message();
                            return false;
                        }
                    } else {
                        if (experience == '' || experience == null || week_hours == '' || week_hours == null || subjects ==
                            '' || subjects == null || is_willing_travel == '' || is_willing_travel == null ||
                            allowed_drive == '' || allowed_drive == null) {
                            if (is_willing_travel === 1) {
                                if (traveling_distance == '' || traveling_distance == null ||
                                    allowed_drive == '' || allowed_drive == null) {
                                    message();
                                    return false;
                                }
                            }

                        } else {
                            if (licence_number == '' || licence_number == null ||
                                allowed_drive == '' || allowed_drive == null) {
                                message();
                                return false;
                            }


                        }

                    }
                }
                return true;






            } else if (key == 4) {
                if ($('#qualification_type').val() == '' || $('#qualification_type').val() == null ||
                    $('#qualification_title').val() == '' || $('#qualification_title').val() == null ||
                    $('#qualification_institution').val() == '' || $('#qualification_institution').val() == null ||
                    $('#year_completed').val() == '' || $('#year_completed').val() == null ||
                    $('#qualification_grade').val() == '' || $('#qualification_grade').val() == null) {
                    message();
                    return false;
                }
                return true;
            } else if (key == 5) {
                var user_id = document.getElementById('user_id').files[0];
                var address_proof_expiry = $('#address_proof_expiry').val();
                var user_id_expiry = $('#user_id_expiry').val();
                var enhaced_dbs_expiry = $('#enhaced_dbs_expiry').val();
                var enhaced_dbs = document.getElementById('enhaced_dbs').files[0];
                var address_proof = document.getElementById('address_proof').files[0];
                var selfie = document.getElementById('selfie').files[0];
                if (user_id == undefined || user_id_expiry ==
                    '' || user_id_expiry == '' || enhaced_dbs_expiry == '' || enhaced_dbs_expiry == null || enhaced_dbs ==
                    undefined || selfie == undefined || selfie == undefined) {
                    message();
                    return false
                }
                return true;
            }
        }

        function message() {
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Please fill in all required fields.',
                showConfirmButton: false,
                timer: 2000,
                showCloseButton: true,
            });
        }
    </script>
    <script>
        function removebox(index) {
            $('#remover_' + index).remove();
        }
        $(document).ready(function() {
            $('#refrmore').hide();
            $('#refr').change(function() {
                if ($(this).val() == '1') {
                    $('#refrmore').show();
                } else {
                    $('#refrmore').hide();
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            // Add an input event listener to the numeric input
            $('.numericInput').on('input', function() {
                // Replace non-numeric characters with an empty string
                $(this).val($(this).val().replace(/[^0-9]/g, ''));
            });
        });
    </script>
    <script>
        function checkDrivePermission(selectElement) {
            var selectedValue = selectElement.value;
            if (selectedValue === "1") {
                $('#DrivePermission').show();
            } else if (selectedValue === "2") {
                $('#DrivePermission').hide();
            }
        }
    </script>
@endsection
