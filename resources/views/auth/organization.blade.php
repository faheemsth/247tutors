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
            left: 452px;
        }

        .flag-3 {
            left: 710px;
        }

        .flag-4 {
            left: 918px;
        }
        @media only screen and (min-width: 1440px){
        .flag-2 {
            left: 528px;
        }

        .flag-3 {
            left: 710px;
        }

        .flag-4 {
            left: 1063px;
        }
}

        @media only screen and (max-width: 1240px) {
            .flag-2 {
                left: 380px;
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
                left: 280px;
            }

            .flag-3 {
                left: 380px;
            }

            .flag-4 {
                left: 570px;
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
      <div id="toplinkup"  class="container-fluid ">
            <div class="row" style="background-color:#dcdcdc8f;">
                <div class="col-12 py-1" style="text-align:end;">
                    <a href="{{ url('auth/google?role=').$_GET['role'] }}" class="btn btn-outline-primary px-2 fw-bold py-1">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/c/c1/Google_%22G%22_logo.svg/2048px-Google_%22G%22_logo.svg.png" style="width: 29px;
                     padding: 3px ;">
                        Sign-Up With Google</a>
                    <!--<a href="" class="btn bg-transparent p-0" type="button">-->
                    <!--    <img src="https://portal.kedasrd.com/images/GButton.png" class="w-25">-->
                    <!--</a>-->
                </div>
            </div>
    </div>
    <div  class="container">
        <div class="row">
            <div class="col-md-12 d-flex justify-content-between align-items-center mt-5 mb-4">
                <!--<img src="{{ asset('assets/images/247 NEW Logo 2.png') }}" alt="Logo" width="15%" height="auto">-->
                <h3 class="fw-bold mb-0" style="font-size:1.6rem">
                  <span id="text-color">
                      ORGANISATION
                  </span>   REGISTRATION
                </h3>
                <div class="col-md-1 text-center">
                    <a href="{{ url('') }}" class="link-dark"><i class="fa-solid fa-xmark fa-2x"></i></a>
                </div>
            </div>
        </div>
    </div>

    <!-- logo end -->

    <!-- prograss bar -->

    <div class="container mt-3">
        <div class=" justify-content-center align-items-center d-none d-md-flex">
            <div class=" col-8 col-md-10">
                <div class="progress" style="position: relative; overflow: visible;">
                    <div class="progress-bar active" role="progressbar" style="background: #ABFF00;"></div>
                    <span class="flag flag-1">1</span>
                    <span class="flag flag-2">2</span>
                    <span class="flag flag-4">3</span>
                </div>
            </div>

        </div>
    </div>

    <!-- End prograss bar -->
    <div class="container">
        <div class="panel-group">
            <div class="row panel panel-primary">

                {{-- student payment process --}}
                <form class="form-horizontal" id="registration-form">
                    @csrf
                    <input id="role_id" name="role_id" value="6" type="hidden">
           {{-- //// --}}
           <fieldset id="account">
            <div class="panel-body mt-5 text-center">
                <h2 class=" fs-1" id="text-color"><strong>Reduced Online Tutoring Rates For Organisations</strong>
                </h2><br>
            </div>
            <div class="d-flex flex-column flex-md-row ">
                <div class="col-md-12 col-12 ">
                    <div class="row mt-4 justify-content-center gap-5 ">
                        <div class="col-11 col-md-5 col-lg-3 rounded-3" style="background-color: #ABFF00">
                            <div class="px-2">
                                <div class="text-center">
                                    <img src="{{ asset('assets/images/Student_and_Pupil@2x.png.webp') }}" width="70%"
                                        class=" py-3" alt="">
                                </div>
                                <div class=" py-1 ">
                                    <h3  class="text-center fw-bold" id="text-color">247Tutors Core</h3>
                                    <h5 style="color:#363636;">Our foundational programme, designed to deliver consistent, weekly tutoring to pupils across subjects and Key Stages. 55-minute lessons, once a week, for 12 weeks.</h5>
                                </div>
                            </div>
                        </div>

                        <div class="col-11 col-md-5 col-lg-3 rounded-3" style="background-color: #ABFF00">
                            <div class="px-2">
                                <div class="text-center">
                                    <img src="{{ asset('assets/images/Lesson_space@2x.png.webp') }}" width="70%" class=" py-3"
                                        alt="">
                                </div>
                                <div class=" py-1 ">
                                    <h3 class="text-center fw-bold " id="text-color">247Tutors Boost</h3>
                                    <h5 style="color:#363636;">Need high impact in less time? 247Tutors Boost delivers a term's worth of personalised tutoring in just 6 weeks. 55-minute lessons, twice a week.</h5>
                                </div>
                            </div>
                        </div>

                        <div class="col-11 col-md-5 col-lg-3 rounded-3" style="background-color: #ABFF00" >
                            <div class="px-2">
                                <div class="text-center">
                                    <img src="{{ asset('assets/images/Science@2x.png.webp') }}" width="70%" class=" py-3"

                                        alt="">
                                </div>
                                <div class=" py-1  ">
                                    <h3 class="text-center fw-bold" id="text-color">247Tutors Superboost</h3>
                                    <h5 class=" py-1" style="color:#363636;">High-intensity lessons with great results, outside of term time. 247Tutors Superboost delivers 12 55-minute lessons in just 1-2 weeks - perfect for exam prep during half terms, Easter, or summer holidays.</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <hr class="w-75 m-auto mt-5" />
            <div class="d-flex col-12 justify-content-center m-auto my-5 gap-2">
                <a href="#" class="link-dark previous btn " id="previous2"><i
                    class="fa fa-light fa-arrow-left"></i>
                Back</a>
                <a href="#toplinkup" class="text-decoration-none">
            <input type="button" required name="password" class=" next btn btn-primary px-5"
                value="Next" id="next1" />
                </a>
            </div>
        </fieldset>

           {{-- /// --}}
                    <fieldset id="account">
                        <div class="panel-body mt-5 text-center">
                            <h2 class="text-center fs-1" id="text-color"><strong>Your Organization Information?</strong>
                            </h2><br>
                        </div>
                        <div class="d-flex flex-column flex-md-row ">
                            <div class="col-md-12 col-12 ">
                                <div class="row mt-4 justify-content-center">
                                    <div class="col-md-5">
                                        <label class="text-secondary">Organization Name</label><br>
                                        <input type="text" id="parentfname" placeholder="Enter Organization Name" name="name"
                                            class="w-100 p-2">
                                    </div>
                                </div>
                                {{-- <div class="row mt-4 justify-content-center">
                                    <div class="col-md-6">
                                        <label class="text-secondary">Organization Last Name</label><br>
                                        <input type="text" id="parentlname" placeholder="Enter Last Name" name="lname"
                                            class="w-100 p-3">
                                    </div>
                                </div> --}}
                                <div class="row mt-4 justify-content-center">
                                    <div class="col-md-5">
                                        <label class="text-secondary">Organization Email</label><br>
                                        <input type="email" id="parentemail" name="email"
                                            placeholder="Enter Email Address" class="w-100 p-2">
                                        <span id="email-validation-message" style="color: red;"></span>
                                    </div>
                                </div>

                                <div class="row mt-4 justify-content-center">
                                    <div class="col-md-5">
                                        <label class="text-secondary">Organization Phone</label><br>
                                        <span class="d-flex">
                                            <select class="w-10 p-2" name="code">
                                                <option value="+1">+1</option>
                                                <option value="+20">+20</option>
                                                <option value="+33">+33</option>
                                                <option value="+34">+34</option>
                                                <option value="+44" selected>+44</option>
                                                <option value="+44">+44</option>
                                                <option value="+52">+52</option>
                                                <option value="+55">+55</option>
                                                <option value="+56">+56</option>
                                                <option value="+57">+57</option>
                                                <option value="+61">+61</option>
                                                <option value="+62">+62</option>
                                                <option value="+63">+63</option>
                                                <option value="+64">+64</option>
                                                <option value="+65">+65</option>
                                                <option value="+65">+65</option>
                                                <option value="+82">+82</option>
                                                <option value="+82">+82</option>
                                                <option value="+86">+86</option>
                                                <option value="+86">+86</option>
                                                <option value="+91">+91</option>
                                                <option value="+92">+92</option>
                                                <option value="+98">+98</option>
                                                <option value="+971">+971</option>
                                                <option value="+971">+971</option>
                                                <option value="+971">+971</option>
                                                <option value="+972">+972</option>
                                                <option value="+972">+972</option>
                                                <option value="+972">+972</option>
                                                <option value="+972">+972</option>
                                                <option value="+972">+972</option>
                                                <option value="+977">+977</option>
                                                <option value="+972">+972</option>
                                                <option value="+995">+995</option>
                                                <option value="+996">+996</option>
                                            </select>
                                            <input type="text" id="parentphone" name="phone"
                                                placeholder="Enter Phone Number" class="w-100 p-2">

                                        </span>
                                    </div>
                                </div>

                                <div class="row mt-4 justify-content-center">
                                    <div class="col-md-5">
                                        <label class="text-secondary">Organization Address</label><br>
                                        <input type="email" id="address" name="address"
                                            placeholder="Enter Organization Address" class="w-100 p-2">
                                        <span id="email-validation-message" style="color: red;"></span>
                                    </div>
                                </div>

                                <div class="row mt-4 justify-content-center">
                                    <div class="col-md-5">
                                        <label class="text-secondary">Organization Postcode </label><br>
                                        <input type="email" id="zipcode" name="zipcode"
                                            placeholder="Enter Organization Postcode" class="w-100 p-2">
                                        <span id="email-validation-message" style="color: red;"></span>
                                    </div>
                                </div>

                            </div>

                        </div>
                        <hr class="w-75 m-auto mt-5" />
                        <div class="d-flex col-12 justify-content-center m-auto my-5 gap-2">
                            <a href="#" class="link-dark previous btn " id="previous2"><i
                                class="fa fa-light fa-arrow-left"></i>
                            Back</a>
                            <a href="#toplinkup" class="text-decoration-none">
                        <input type="button" required name="password" class=" next btn btn-primary px-5"
                            value="Next" id="next1" /></a>
                        </div>
                    </fieldset>
                    <fieldset id="personal">
                        <div class="panel-body mt-5">
                            <h2 class="text-center fs-1" id="text-color"><strong>Contact Personal Information</strong></h2><br>
                            <div class="d-flex flex-column flex-md-row ">
                                <div class="col-md-12 col-12 ">

                                    <div class="row mt-4 justify-content-center">
                                        <div class="col-md-5">
                                            <label class="text-secondary">Contact Person First Name</label><br>
                                                <input type="text" id="cpfname" name="cpfname"
                                                    placeholder="Enter First Name" class="w-100 p-2">
                                        </div>
                                    </div>

                                    <div class="row mt-4 justify-content-center">
                                        <div class="col-md-5">
                                            <label class="text-secondary">Contact Person Last Name</label><br>
                                                <input type="text" id="cplname" name="cplname"
                                                    placeholder="Enter Last Name" class="w-100 p-2">
                                        </div>
                                    </div>

                                    <div class="row mt-4 justify-content-center">
                                        <div class="col-md-5">
                                            <label class="text-secondary">Contact Person Email</label><br>
                                                <input type="text" id="cpemail" name="cpemail"
                                                    placeholder="Enter Email" class="w-100 p-2">
                                                    <span id="cpemail-validation-message" style="color: red;"></span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="d-flex col-12 justify-content-center m-auto my-5 gap-2">
                            <a href="#" class="link-dark previous btn " id="previous3"><i
                                    class="fa fa-light fa-arrow-left"></i>
                                Back</a>
                            <button type="button" class="next btn btn-primary px-5 submit-button" id="register">Submit</button>
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
    <script>
        $(document).ready(function() {
            $('#parentemail').on('keyup', function() {
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
                            $('#next1').prop('disabled', true);
                        } else {
                            $('#email-validation-message').text('');
                            $('#next1').prop('disabled', false);
                        }
                    }
                });
            });
        });
    </script>

<script>
    $(document).ready(function() {
        $('#cpemail').on('keyup', function() {
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
                        $('#cpemail-validation-message').text(
                            'This email is already registered.');
                        $('#register').prop('disabled', true);
                    } else {
                        $('#cpemail-validation-message').text('');
                        $('#register').prop('disabled', false);
                    }
                }
            });
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
                if (step === 2) {
                    if ($('#parentfname').val() === '' || $('#parentlname').val() === '' || $('#parentemail').val() === '' || $('#parentphone').val() === '' || $('#address').val() === '' || $('#zipcode').val() === '') {
                        isValid = false;
                    }
                }else if (step === 3) {
                    if ($('#cpfname').val() === '' || $('#cplname').val() === '' || $('#cpemail').val() === '') {
                        isValid = false;
                    }
                }
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
    </script>

<script>
    $(document).ready(function() {
        $('#register').click(function() {
            var formData = $('#registration-form').serialize();
            $.ajax({
                url: '/register',
                method: 'POST',
                data: formData,
                beforeSend:function(){
                    $('.submit-button').addClass('d-none');
                    $('.spiner').removeClass('d-none');
                },
                success: function(response) {
                    if(response.status == 200){
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Registration Successful.Please check your email and verify your account to login.',
                            showConfirmButton: false,
                            timer: 5000,
                            showCloseButton: true
                        });
                        window.setTimeout(function(){

                            // Move to a new location or you can do something else
                            window.location.href = 'login';

                        }, 5000);

                    }else{
                        Swal.fire({
                            position: 'center',
                            icon: 'error',
                            title: 'Something went wrong!',
                            showConfirmButton: false,
                            timer: 2000,
                            showCloseButton: true
                        });
                    }
                },
            });
        });
    });
</script>
@endsection
