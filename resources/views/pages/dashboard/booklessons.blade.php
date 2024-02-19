@extends('pages.dashboard.appstudent')
@section('content')
    @if (Auth::check())
        @if (Auth::user()->role_id == '4')
            @include('layouts.studentnav')
        @elseif (Auth::user()->role_id == '3')
            @include('layouts.tutornav')
        @elseif (Auth::user()->role_id == '5' ||Auth::user()->role_id == '6')
            @include('layouts.parentnav')
        @elseif (Auth::user()->role_id == '1' || Auth::user()->role_id == '2')
            @include('layouts.navbar')
        @endif
    @else
        @include('layouts.navbar')
    @endif
    <script src="{{ asset('js/jsdelivrcore.js') }}"></script>
    <script src="{{ asset('js/jsdelivr.js') }}"></script>
    <script src="{{ asset('vendor/jquery/jquery3.7.0.js') }}"></script>
    <style type="text/css">
        #changesubject option::after {
            content: ' $' attr(data-fee) '/hr';
            float: right;
            color: #777;
        }

        #multistep_form fieldset:not(:first-of-type) {
            display: none;
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
            left: 533px
        }

        .flag-3 {
            left: 1064px;
        }

        .flag-4 {
            left: 920px;
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

    <div class="container mt-3">
        <div class="d-flex justify-content-center align-items-center">
            <div class=" col-8 col-md-10">
                <div class="progress" style="position: relative; overflow: visible;">
                    <div class="progress-bar active" role="progressbar" style="background: #ABFF00;"></div>
                    <span class="flag flag-1">1</span>
                    <span class="flag flag-2">2</span>
                    <span class="flag flag-3">3</span>
                </div>
            </div>

        </div>
    </div>


    <!-- End prograss bar -->
    <div class="container">
        <div class="panel-group">
            <div class="row panel panel-primary">
                <form role="form" action="{{ route('stripe.post') }}" method="post" class="require-validation"
                    data-cc-on-file="false" data-stripe-publishable-key="{{ env('STRIPE_KEY') }}" id="payment-form">
                    @csrf
                    <span id="hiddeninput"></span>
                    <fieldset id="account">
                        <div class="panel-body mt-5">
                            <h2 class="text-left fs-1"><strong>Book Lessons</strong></h2><br>
                        </div>
                        <div class="d-flex flex-column flex-md-row justify-content-between">
                            <div class="col-md-12 col-12">
                                <label>Tutor</label><br>
                                <select name="tutor_id" id="tutorsubject" class="w-100 p-3">
                                    @if (!empty($tutors))
                                        @foreach ($tutors as $tutor)
                                            <option value="{{ $tutor->tutor_id }}">
                                                {{ $tutor->tutor->first_name . ' ' . $tutor->tutor->last_name }}</option>
                                        @endforeach
                                    @endif
                                </select><br><br>
                                <label>Subject & Level</label><br>
                                <select name="subject" id="changesubject" class="w-100 p-3">

                                </select>
                                <br><br>
                                <label>Student</label><br>
                                <select name="user_id" id="changesubject2" class="w-100 p-3">
                                    @if (!empty($students))
                                        @foreach ($students as $student)
                                            <option value="{{ $student->id }}">
                                                {{ $student->first_name . ' ' . $student->last_name }}</option>
                                        @endforeach
                                    @endif
                                </select><br><br>
                                <div class="row mt-1">
                                    <div class="col-md-6">
                                        <label>Date</label><br>
                                        <input type="date" name="date" class="w-100 p-3" max="9999-12-31">
                                    </div>

                                    <div class="col-md-6">
                                        <label>Time</label><br>
                                        <input type="time" name="time" class="w-100 p-3">
                                    </div>

                                </div>
                            </div>

                        </div>
                        <hr class="w-75 m-auto mt-5" />
                        <div class="d-flex col-2 col-md-3 justify-content-center m-auto my-5 gap-2">
                            <a href="#" class="link-dark previous btn " id="previous1"><i
                                    class="fa fa-light fa-arrow-left"></i>
                                Back</a>
                            <input type="button" name="password" class=" next btn btn-primary px-5" value="Next"
                                id="next1" />
                        </div>
                    </fieldset>
                    <fieldset id="personal">
                        <div class="panel-body mt-5">
                            <div class="container">
                                <h2 class="text-left text-primary fs-1"><strong>Booking do you Want?</strong></h2><br>
                                <div class="d-flex flex-column flex-md-row justify-content-between">
                                    <div class="col-md-7">
                                        <div class="col-lg-9 col-md-11 rounded-0 card p-md-5 p-3 shadow"
                                            style=" background: #ABFF00;">
                                            <div class="card-inner-img m-auto">
                                                <img src="{{ asset('assets/images/teacher.svg') }}" alt="Teacher"
                                                    width="80" height="auto">
                                                <p class="mt-3"><strong>Regular Lessons</strong></p>
                                            </div>
                                            <div class="mt-3 ms-3">
                                                <ul>
                                                    <li>Lorem ipsum dolor sit amet.</li>
                                                    <li>Est magni cupiditate ad laboriosam vitae a Dicta nisi qui
                                                        corruption laborum non repellat
                                                        molestiae. </li>
                                                    <li>Lorem ipsum dolor sit amet laboriosam vitae a.</li>
                                                </ul>
                                            </div>
                                            <div class="m-auto mt-md-5 mt-3">
                                                <a href="#"
                                                    class="text-primary fw-bold fs-4 border p-1 px-md-5 py-md-3"
                                                    style=" background: #ffffff;">25% off your First Two Lessons</a>
                                            </div>
                                        </div>
                                        <div class="row col-lg-10 col-md-12 p-3 border mt-5 shadow"
                                            style=" background: rgba(13, 153, 255, 0.3);">
                                            <div class="card-item-image col-md-2 m-auto text-center text-md-left pe-0">
                                                <img src="assets/images/teacher.svg" alt="Teacher" width="50"
                                                    height="auto">
                                            </div>
                                            <div class="col-md-10 ps-0">
                                                <ul>
                                                    <li>Lorem ipsum dolor sit amet.</li>
                                                    <li>Est magni cupiditate ad laboriosam vitae</li>
                                                    <li>Lorem ipsum dolor sit amet laboriosam vitae a.</li>
                                                </ul>
                                            </div>
                                        </div>
                                        <h2 class="text-left mt-5 fs-2 text-primary"><strong>How Often do you want
                                                Lessons?</strong></h2>
                                        <br>
                                        <div class="d-flex flex-column flex-md-row gap-3">
                                            <a href="#" class="px-3 py-2 fs-5 bg-primary text-center"
                                                style="color: #ffffff;">
                                                <input type="radio" value="once-a-week" name="duration">
                                                <!-- Checkbox for "ONCE A WEEK" -->
                                                ONCE A WEEK
                                            </a>
                                            <a href="#" class="px-3 py-2 fs-5 bg-primary text-center"
                                                style="color: #ffffff;">
                                                <input type="radio" value="twice-a-week" name="duration">
                                                <!-- Checkbox for "TWICE A WEEK" -->
                                                TWICE A WEEK
                                            </a>
                                            <a href="#" class="px-3 py-2 fs-5 bg-primary text-center"
                                                style="color: #ffffff;">
                                                <input type="radio" value="fortnightly" name="duration">
                                                <!-- Checkbox for "FORTNIGHTLY" -->
                                                FORTNIGHTLY
                                            </a>

                                        </div>

                                    </div>
                                    <div class="form-1 col-md-4 col-12 d-flex p-3 h-25 me-5 mt-4 shadow"
                                        style=" background: #ABFF00; border-radius: 10px;">
                                        <img src="{{ asset('assets/images/image 1.png') }}" width="70"
                                            height="70">
                                        <div class="text p-3 d-flex flex-column">
                                            <span>Armon D</span>
                                            <span class="fw-bold">Chemistry GSSE</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex col-2 col-md-3 justify-content-center m-auto my-5 gap-2">
                            <a href="#" class="link-dark previous btn " id="previous2"><i
                                    class="fa fa-light fa-arrow-left"></i>
                                Back</a>
                            <input type="button" name="password" class=" next btn btn-primary px-5" value="Next"
                                id="next2" />
                        </div>
                    </fieldset>
                    <fieldset id="personal">
                        <div class="panel-body mt-5">
                            <h2 class="text-left text-primary fs-1"><strong>Confirm your Booking</strong></h2><br>
                            <div class="d-flex col-lg-7 col-md-6 justify-content-between">
                                <h2 class="text-left text-secondary fs-3"><strong>Credit or Debit Card</strong></h2>
                                <br>
                                <img src="{{ asset('assets/images/card visa.svg') }}" alt="visa cards" width="100"
                                    height="auto">
                            </div>
                            <div class="d-flex flex-column flex-md-row justify-content-between">
                                <div class="col-lg-7 col-md-6 col-12">
                                    <div class="row col-md-12">
                                        <div class="col-md-6">
                                            <div class='col-xs-12 form-group required'>
                                                <label class='control-label'>Name on Card</label> <input
                                                    class=" w-100 p-3" size='4' type='text'
                                                    name="account_holder_name">
                                            </div>
                                        </div>

                                    </div>
                                    <div class="mt-5 row col-md-12">
                                        <div class="col-md-12">
                                            <label class="text-secondary">Card Number</label><br>
                                            <input autocomplete='off' name="card_number" class='card-number w-100 p-3'
                                                size='20' type='text'>
                                        </div>
                                    </div>
                                    <div class="mt-5 row col-md-12">

                                        <div class="col-md-4">
                                            <label class="text-secondary">CVC Number</label><br>
                                            <input type="text" name="cvc" placeholder='ex. 311'
                                                class="w-100 p-3 card-cvc">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="text-secondary">Expiration Month</label><br>
                                            <input type="text" name="exp_month" placeholder="MM/YY"
                                                class=" w-100 p-3 card-expiry-month">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="text-secondary">Expiration Year</label><br>
                                            <input type="text" name="exp_year" placeholder="MM/YY"
                                                class=" w-100 p-3 card-expiry-year">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-5 col-12 p-3 h-25 mt-4 mt-md-0 me-5">
                                    <div class="alert-danger p-2 mb-2 rounded-3">
                                        <h5 class="m-0 ps-3 text-black-50">Check your email for coupon</h5>
                                        <div class="summary px-3 mt-3 d-flex justify-content-between">
                                            <input type="hidden" name="amount" id="amount"
                                                value="{{ $tutor->fee }}">
                                            <input type="text" class="w-95 p-2 mb-1" name="Coupon"
                                                id="coupon" placeholder="Enter Coupon Code"
                                                style="border:1px solid #ABFF00;border-radius: 10px;" value="">
                                            <input type="button" class="w-95 p-2 mb-1" value="Confirm"
                                                id="confirm" style="border:1px solid #ABFF00;border-radius: 10px;">

                                        </div>
                                        <div class="summary px-3 d-flex justify-content-between">
                                            <p id="errormsg" style="color: red"></p>
                                        </div>
                                    </div>
                                <div class="form-1 p-2 shadow"
                                    style=" background: #ABFF00; border-radius: 12px;">
                                    <div class="d-flex">
                                        <img src="{{ url('') . '/' . $tutor->tutor->image }}" width="70"
                                            height="70">
                                        <div class="text p-3 d-flex flex-column">
                                            <span>{{ $tutor->tutor->first_name . ' ' . $tutor->tutor->last_name }}</span>
                                            <span class="fw-bold">Chemistry GSSE</span>
                                        </div>
                                    </div>
                                    <div class="summary-item mt-2" style="line-height: 0.7;">

                                        <div class="summary px-3 d-flex justify-content-between">
                                            <p>Saturdays at 13:30-14:25</p>
                                            <p id="feeId"></p>
                                        </div>
                                        <div class="summary px-3 d-flex justify-content-between">
                                            <p>Discount</p>
                                            <p id="dicountId">0%</p>
                                        </div>
                                        <div class="summary px-3 d-flex justify-content-between">
                                            <p>Total to Pay</p>
                                            <p class="total"></p>
                                        </div>
                                        <div class="summary px-3 d-flex justify-content-between">
                                            <p>Next lesson: Saturday 28 Aug</p>
                                            <p class="total"></p>
                                        </div>
                                    </div>
                                    <div class="summary-text mt-1">
                                        <p class="text-center">
                                            We'll take payment 24hrs before each lesson
                                            Make changes before then free of charge.
                                            See terms and conditions lahore
                                        </p>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="d-flex col-2 col-md-3 justify-content-center m-auto my-5 gap-2"
                            style="margin-top: 80px !important;">
                            <a href="#" class="link-dark previous btn " id="previous4"><i
                                    class="fa fa-light fa-arrow-left"></i>
                                Back</a>
                            <input type="submit" class=" next btn btn-primary px-5" value="Submit" id="next3" />
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>





    <script>
        $(document).ready(function() {
            var form_count = 1;
            var total_forms = $("fieldset").length;

            // Hide all fieldsets except the first one
            $("fieldset:not(:first)").hide();

            // Function to set the progress bar
            function setProgressBar(curStep) {
                var percent = (curStep - 1) / (total_forms - 1) * 100;
                $(".progress-bar")
                    .css("width", percent + "%")
                // .html(percent.toFixed(0) + "%");
            }

            // Function to show the next step and hide the current step
            function showNextStep() {
                var currentFieldset = $("fieldset:visible");
                var nextFieldset = currentFieldset.next("fieldset");

                if (nextFieldset.length > 0) {
                    currentFieldset.hide();
                    nextFieldset.show();
                    form_count++;
                    setProgressBar(form_count);
                }
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
            $('.input-phone').intlInputPhone();
        })
    </script>
    <script type="text/javascript">
        var _gaq = _gaq || [];
        _gaq.push(['_setAccount', 'UA-36251023-1']);
        _gaq.push(['_setDomainName', 'jqueryscript.net']);
        _gaq.push(['_trackPageview']);

        (function() {
            var ga = document.createElement('script');
            ga.type = 'text/javascript';
            ga.async = true;
            ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') +
                '.google-analytics.com/ga.js';
            var s = document.getElementsByTagName('script')[0];
            s.parentNode.insertBefore(ga, s);
        })();
    </script>

    <script>
        $(document).ready(function() {
            var tutor = $(this).find('option:selected').val();
            $.ajax({
                url: '{{ url('get-subject') }}',
                type: 'GET',
                data: {
                    tutor_id: tutor,
                },
                success: function(data) {
                    $('#changesubject').append(data.html);
                    $('#hiddeninput').append(data.input);
                    $('#feeId').text('$' + data.fee);
                    $('.total').text('$' + data.fee);

                }
            });
            $('#tutorsubject').on('change', function() {
                var tutor = $(this).val();
                $('#changesubject').html('');
                $('#hiddeninput').html('');
                $('#amount').val('');


                $.ajax({
                    url: '{{ url('get-subject') }}',
                    type: 'GET',
                    data: {
                        tutor_id: tutor,
                    },
                    success: function(data) {
                        $('#changesubject').append(data.html);
                        $('#hiddeninput').append(data.input);
                        var fee = $('#amount').val();
                        $('.total').text('$' + fee);
                    }
                });
            });
        });
    </script>
    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>

    <script type="text/javascript">
        $(function() {
            var $form = $(".require-validation");

            $('form.require-validation').bind('submit', function(e) {
                var $form = $(".require-validation"),
                    inputSelector = ['input[type=email]', 'input[type=password]',
                        'input[type=text]', 'input[type=file]',
                        'textarea'
                    ].join(', '),
                    $inputs = $form.find('.required').find(inputSelector),
                    $errorMessage = $form.find('div.error'),
                    valid = true;
                $errorMessage.addClass('hide');

                $('.has-error').removeClass('has-error');
                $inputs.each(function(i, el) {
                    var $input = $(el);
                    if ($input.val() === '') {
                        $input.parent().addClass('has-error');
                        $errorMessage.removeClass('hide');
                        e.preventDefault();
                    }
                });

                if (!$form.data('cc-on-file')) {
                    e.preventDefault();
                    Stripe.setPublishableKey($form.data('stripe-publishable-key'));
                    Stripe.createToken({
                        number: $('.card-number').val(),
                        cvc: $('.card-cvc').val(),
                        exp_month: $('.card-expiry-month').val(),
                        exp_year: $('.card-expiry-year').val()
                    }, stripeResponseHandler);
                }

            });
            function stripeResponseHandler(status, response) {
                if (response.error) {
                    $('.error')
                        .removeClass('hide')
                        .find('.alert')
                        .text(response.error.message);
                } else {
                    var token = response['id'];
                    $form.find('input[type=text]').empty();
                    $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
                    $form.get(0).submit();
                }
            }

        });
    </script>

    <script>
        $(document).ready(function() {
            $('#changesubject').on('change', function() {
                var selectedOption = $(this).find('option:selected');
                var fee = selectedOption.data('fee');
                $('#amount').val(fee);
                $('#amount2').val(fee);
                $('#feeId').text('$' + fee);
                $('.total').text('$' + fee);
            });
            $('#confirm').on('click', function() {
                var coupon = $('#coupon').val();
                var fee = $('#amount').val();
                var selectedOption = $('#changesubject2').find('option:selected');
                var userid = selectedOption.val();
                var fetchfee = 0;
                $('#errormsg').text('');
                $.ajax({
                    url: '{{ url('get-coupon') }}',
                    type: 'POST',
                    data: {
                        coupon: coupon,
                        userid: userid,
                    },
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    success: function(data) {
                        fetchfee = 0;
                        if (data.price !== undefined) {
                            fetchfee = data.price;

                        }

                        if (data.id !== undefined) {
                            id = data.id;
                        }
                        $('#copounid').val(id);
                        $('#dicountId').text('$' + fetchfee + '%');
                        $('.total').text('$' + (fee - fetchfee));


                        $('#amount').hide();
                        $('#amount2').val((fee - fetchfee));
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            for (var key in errors) {
                                $('#errormsg').append('<p>' + errors[key][0] + '</p>');
                            }
                        }
                    }
                });

            });
        });
    </script>
@endsection
