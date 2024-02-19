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
        <div class="row">
            <div class="col-md-12 d-flex justify-content-between mt-5 mb-4">
                <img src="{{ asset('assets/images/247 NEW Logo 2.png') }}" alt="Logo" width="150" height="auto">
                <div class="col-md-1 text-center">
                    <a href="{{ url('') }}" class="link-dark"><i class="fa-solid fa-xmark fa-2x"></i></a>
                </div>
            </div>
        </div>
    </div>

    <!-- logo end -->

    <!-- prograss bar -->

    <div class="container mt-3">
        <div class="d-flex justify-content-center align-items-center">
            <div class=" col-8 col-md-10">
                <div class="progress" style="position: relative; overflow: visible;">
                    <div class="progress-bar active" role="progressbar" style="background: #ABFF00;"></div>
                    <span class="flag flag-1">1</span>
                    <span class="flag flag-2">2</span>
                    <span class="flag flag-3">3</span>
                    <span class="flag flag-4">4</span>
                </div>
            </div>

        </div>
    </div>

    <!-- End prograss bar -->
    <div class="container">
        <div class="panel-group">
            <div class="row panel panel-primary justify-content-center">

                {{-- student payment process --}}
                <form class="form-horizontal" id="registration-form">
                    @csrf
                    <input id="role_id" name="role_id" value="4" type="hidden">
                    <fieldset id="account">
                        <div class="col-6 mx-auto">
                            <div class="container mt-5 ">
                                <div class="card-content  pb-3">
                                    <img src="{{ asset('assets/images/tutor img.jpg') }}" alt="" width="70%"
                                        class="mx-auto d-block">
                                    <h3 class="card-head  px-5 fw-bold"
                                        style="color: rgba(0, 150, 255, 1); text-align: left;">Welcome to the 247Tutors
                                        Application Process &#128075;</h3>
                                    <p class="card-para px-5 my-3 " style="font-size: 12px;">This shouldn't take more than
                                        10 minutes to
                                        complete. Ready to get going?</p>
                                    <!-- list items -->
                                    <div class="card-lists px-5">
                                        <p class="card-list-items "><i class="fa-solid fa-circle-check  "
                                                style="font-size: 16px;"></i>Sign up
                                        </p>
                                        <p class="card-list-items "><span><img src="{{ asset('assets/images/track.png') }}"
                                                    alt="" style="padding-right: 10px;"></span>Submit
                                            application</p>
                                        <p class="card-list-items "><span><img src="{{ asset('assets/images/three.png') }}"
                                                    alt="" style="padding-right: 10px;"></span>Complete interview
                                        </p>
                                    </div>
                                </div>


                            </div>
                        </div>
                        <div class="d-flex col-2 col-md-3 justify-content-center m-auto my-5 gap-2">
                            <a href="#" class="link-dark previous btn " id="previous1"><i
                                    class="fa fa-light fa-arrow-left"></i>
                                Back</a>
                            <input type="button" required name="password" class=" next btn btn-primary px-5" value="Next"
                                id="next1" />
                        </div>
                    </fieldset>

                    <fieldset id="personal">
                        <div class="panel-body mt-5">
                            <div class="container">
                                <div class="row justify-content-center">
                                    <div class="col-5">
                                        <h2 class="fs-1" id="text-color"><strong>Do you have additional
                                                qualifications?</strong>
                                        </h2><br>

                                        <p>
                                            This could include university admissions tests, music grades, <br> academic
                                            degrees etc.
                                        </p>
                                        <div class="d-flex flex-column flex-md-row ">
                                            <div class="col-md-12 col-12 ">
                                                <div class="row mt-4 justify-content-center">
                                                    <div class="col-md-12 mb-3">
                                                        <label class="text-secondary">Qualifications type</label><br>
                                                        <select class=" w-100 p-3" aria-label="Default select example">
                                                            <option selected></option>
                                                            <option value="foundation">Foundation</option>
                                                            <option value="bachelors">Bachelors</option>
                                                            <option value="integrated">Integrated Masters</option>
                                                            <option value="master">Master</option>
                                                            <option value="doctorate">Doctorate</option>
                                                            <option value="other">Other</option>
                                                        </select>
                                                    </div>

                                                    <div class="col-md-12 mb-3">
                                                        <label class="text-secondary">Title</label><br>
                                                        <input type="text" id="title" name="title"
                                                            class="w-100 p-3">
                                                        <span id="Title-validation-message" style="color: red;"></span>
                                                    </div>
                                                    <div class="col-md-12 mb-3">
                                                        <label class="text-secondary">Name of institution</label><br>
                                                        <input type="text" class="w-100 p-3">
                                                        <span id="Name-validation-message" style="color: red;"></span>
                                                    </div>
                                                    <div class="col-md-12 mb-3">
                                                        <label class="text-secondary">Grade</label><br>
                                                        <input type="text" id="grade" name="grade"
                                                            class="w-100 p-3">
                                                        <span id="grade-validation-message" style="color: red;"></span>
                                                    </div>
                                                    <div class="col-md-12 mb-3">
                                                        <label class="text-secondary">Year Completed</label><br>
                                                        <input type="text" name="" class="w-100 p-3">
                                                        {{-- <span id="email-validation-message" style="color: red;"></span> --}}
                                                    </div>
                                                    <div class="border-top"></div>
                                                    <div class="col-12 text-center my-3">
                                                        <button class="btn btn-dark w-75 py-2">ADD ANOTHER</button>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex col-2 col-md-3 justify-content-center m-auto my-5 gap-2">
                            <a href="#" class="link-dark previous btn " id="previous2"><i
                                    class="fa fa-light fa-arrow-left"></i>
                                Back</a>
                            <input type="button" required name="password" class=" next btn btn-primary px-5"
                                value="Next" id="next2" />
                        </div>
                    </fieldset>


                    <fieldset id="subjects">
                        <div class="container ">
                            <div class="row">
                                <div class="col-6 mx-auto">
                                    <div class="panel-body mt-5">
                                        <h2 class="fs-1" id="text-color"><strong>
                                                Please upload a copy of your graduation ceartification
                                            </strong></h2><br>
                                        <p>
                                            We need your graduation certificate for verifiction purposes
                                        </p>
                                        <div class="container mx-0 px-0">
                                            <div class="row">
                                                <div class="col-md-12 mb-3" style="border: 1px solid rgb(199, 199, 199)">
                                                    <div class="formbold-main-wrapper">
                                                        <!-- Author: FormBold Team -->
                                                        <!-- Learn More: https://formbold.com -->
                                                        <div class="formbold-form-wrapper">
                                                            <form action="https://formbold.com/s/FORM_ID" method="POST">
                                                                <div class="formbold-mb-5">
                                                                    <label for="image" class="formbold-form-label">
                                                                        Profile image:
                                                                    </label>
                                                                    <input type="file" name="profile"
                                                                        class="formbold-form-input" />
                                                                </div>

                                                                <div class="mb-6 pt-4">
                                                                    <label
                                                                        class="formbold-form-label formbold-form-label-2">
                                                                        Upload File
                                                                    </label>

                                                                    <div class="formbold-mb-5 formbold-file-input">
                                                                        <input type="file" name="file"
                                                                            id="file" />
                                                                        <label for="file">
                                                                            <div>
                                                                                <span class="formbold-drop-file"> Drop
                                                                                    files here </span>
                                                                                <span class="formbold-or"> Or </span>
                                                                                <span class="formbold-browse"> Browse
                                                                                </span>
                                                                            </div>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <div style="border: 1px solid rgb(201, 201, 201)"></div>
                                                                <div class="my-4">
                                                                    <button class="formbold-btn w-full">ADD
                                                                        ANOTHER</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="d-flex col-5 justify-content-center m-auto my-5 gap-2">
                                        <a href="#" class="link-dark previous btn " id="previous2"><i
                                                class="fa fa-light fa-arrow-left"></i>
                                            Back</a>
                                        <input type="button" required name="password" class=" next btn btn-primary px-5"
                                            value="Next" id="next2" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>

                    <fieldset id="personal">
                        <div class="panel-body mt-5">
                            <div class="container">
                                <div class="col-md-5 center-box m-auto heih">
                                    {{-- <div>
                                        <h2 class="cen"> <img src="{{ asset('assets/images/247 NEW Logo 1.png') }}" alt="img">
                                    </div> --}}
                                    <div class="box py-5">
                                        <i style="font-size: 3.2rem">"&#128077"</i>
                                        <h4 class="fw-bold my-4" style="color: rgba(0, 150, 255, 1)">Thank you for your application.</h4>
                                        <p>We are currently reviewing your application and will be in touch by email within
                                            7 working days to let you know about next steps. If you need any help,just get
                                            in touch.</p>
                                    </div>
                                    <div class="mt-1 mb-5">
                                        <p class="cen">Need help? Call us <a href="tel: +44 7851 012039 " class="text-decoration-none"><span style="color: rgb(162, 244, 10)"> +44 7851 012039 </span></a> or
                                            <span style="color: rgb(162, 244, 10)">email us</span>. </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>



    <script src="{{ asset('js/timeslot.min.js') }}"></script>
    {{-- <script>
        $(document).ready(function() {
            $('#email').on('keyup', function() {
                var email = $(this).val();

                $.ajax({
                    type: 'POST',
                    url: 'email-check',
                    data: {
                        email: email
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.unique === false) {
                            $('#email-validation-message').text(
                                'This email is already registered.');
                            $('#next2').prop('disabled', true);
                        } else {
                            $('#email-validation-message').text('');
                            $('#next2').prop('disabled', false);
                        }
                    }
                });
            });
        });
    </script> --}}

    {{-- <script>
    $(document).ready(function() {
        $('#username').on('keyup', function() {
            var username = $(this).val();

            $.ajax({
                type: 'POST',
                url: 'username-check',
                data: {
                    username: username
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.unique === false) {
                        $('#username-validation-message').text(
                            'This username is already registered.');
                        $('#register').prop('disabled', true);
                    } else {
                        $('#username-validation-message').text('');
                        $('#register').prop('disabled', false);
                    }
                }
            });
        });
    });
</script> --}}
    {{-- <script>
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

            // function validateStep(step) {
            //     var isValid = true;
            //     if (step === 1) {
            //         if ($('#fname').val() === '' || $('#lname').val() === '' || $('#dob').val() === '') {
            //             isValid = false;
            //         }
            //     } else if (step === 2) {
            //         var email = $('#email').val();

            //         if ($('#phone').val() === '' || $('#email').val() === '') {
            //             isValid = false;
            //         }
            //     } else if (step === 3) {
            //         if ($('#subject').val() === '') {
            //             isValid = false;
            //         }
            //     } else if (step === 3) {
            //         if ($('#confirm-password').val() === '' || $('#password').val() === '' || $('#username')
            //             .val() === '') {
            //             isValid = false;
            //         }

            //     }
            //     return isValid;
            // }

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
                showNextStep();
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
    </script> --}}

    <script>
        $(document).ready(function() {
            $('#register').click(function() {
                var formData = $('#registration-form').serialize();
                $.ajax({
                    url: '/register',
                    method: 'POST',
                    data: formData,
                    // beforeSend:function(){
                    //     $('.submit-button').addClass('d-none');
                    //     $('.spiner').removeClass('d-none');
                    // },
                    success: function(response) {
                        window.location.reload();
                    },
                });
            });
        });
    </script>
@endsection
