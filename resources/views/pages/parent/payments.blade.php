@extends('layouts.app')
@section('content')
    <link href="{{ URL::asset('assets/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    @include('layouts.allnav')
    <div class="container  py-3">
        <div class="row mt-2">
            @if (session('failed'))
                <div class="alert alert-danger">
                    {{ session('failed') }}
                </div>
            @endif
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
        </div>
        <style>
            .billtext {
                font-size: 3rem !important;
            }

            @media only screen and (max-width : 1024px) {
                .billtext {
                    font-size: 2.3rem !important;
                }
            }

            @media only screen and (max-width : 768px) {
                .billtext {
                    font-size: 2.3rem !important;
                }
            }

            @media only screen and (max-width : 425px) {
                table tr th {
                    min-width: 130px;
                }

                table tr td {
                    min-width: 130px;
                }

                .billtext {
                    font-size: 1.8rem !important;
                }
            }
        </style>
        <style>
            /* Optional: Add some styling to the button */
            .paypal-button {
                background-color: #003087;
                color: #ffffff;
                padding: 10px 20px;
                border: none;
                border-radius: 4px;
                cursor: pointer;
                display: flex;
                align-items: center;
            }

            /* Optional: Adjust the icon size */
            .paypal-icon {
                width: 30px;
                height: 30px;
                margin-right: 10px;
            }

            .texttitle {
                font-size: 3rem !important;
            }

            @media screen and (max-width: 425px) {
                .texttitle {
                    font-size: 1.4rem !important;
                }
            }
        </style>
        <div class="container">
            <div class="row mt-4 mb-3 mx-lg-5 justify-content-between">
                <div class="col-auto">
                    <h1 class="fw-bold mb-0" id="text-color">Wallet</h1>
                </div>

                <div class="col-6">
                    <div class="row align-items-center justify-content-end">

                        @if (optional(App\Models\Wallet::where('user_id', Auth::id())->first())->net_income > 0)
                            <div class="col-auto">


                                <button class="paypal-button mx-1 py-1" onclick="withdraw()">

                                    Withdrawn <i class="fa-brands fa-cc-paypal"
                                        style="font-size:34px;margin-left:10px;"></i>
                                </button>

                            </div>
                        @endif
                        <div class="col-auto">
                            <button class="btn  py-2 " onclick="freeMeetmodal()"
                                style="background-color:rgba(171, 254, 16, 1);color:#0D99FF;font-weight:500;">Add Wallet
                                Amount</button>

                        </div>
                    </div>
                </div>
            </div>
            <div class="row py-1 align-items-center mx-lg-5"
                style="border: 1px solid gray;box-shadow: 1px 1px 3px #9b9b9b;">
                <div class=" col-lg-6 text-center col-6" style="border-right: 1px solid gray;">
                    <h5 class="fw-bold">Balance</h5>
                    <h4>
                        @if(!empty(App\Models\Wallet::where('user_id', Auth::id())->first()))

                            @if ((int) App\Models\Wallet::where('user_id', Auth::id())->first()->net_income == App\Models\Wallet::where('user_id', Auth::id())->first()->net_income)
                                £{{ App\Models\Wallet::where('user_id', Auth::id())->first()->net_income }}.00
                            @else
                                £{{ App\Models\Wallet::where('user_id', Auth::id())->first()->net_income }}
                            @endif
                        @else
                        £ 0.00
                        @endif
                    </h4>
                </div>

                <div class="col-lg-6 text-center col-6">
                    <h5 class="fw-bold">Withdrawn</h5>
                    <h4>
                        @if(!empty(App\Models\Wallet::where('user_id', Auth::id())->first()))

                            @if ((int) App\Models\Wallet::where('user_id', Auth::id())->first()->withdrawn == App\Models\Wallet::where('user_id', Auth::id())->first()->withdrawn)
                                £{{ App\Models\Wallet::where('user_id', Auth::id())->first()->withdrawn }}.00
                            @else
                                £{{ App\Models\Wallet::where('user_id', Auth::id())->first()->withdrawn }}
                            @endif
                        @else
                              £ 0.00
                        @endif
                    </h4>
                </div>

            </div>

        </div>


        <!-- Filter section  -->
        <div class="container">
            <div class="row mt-4 mb-3 mx-lg-5">
                <div class="col-12 booking-table-details">
                    <h1 class="texttitle">Billing & Payments</h1>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-12 col-12 col-lg-10 booking-filter">
                    <div class="row flex-wrap justify-content-center align-content-end">
                    </div>
                </div>
            </div>
        </div>
        <!-- Booking details table  -->
        <div class="row mb-4 d-flex justify-content-md-center text-center">
            <div class="col-12 col-lg-10 px-0 ">
                <div class="container mt-2 mt-md-5 custom-table px-1 ">
                    <table class="table table-bordered custom-table ">

                        <thead class="student-table-details">
                            <tr>
                                <th>Student</th>
                                <th>Tutor</th>
                                <th>Subject</th>
                                <th>Amount</th>
                                <th>Duration</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody id="ajaxbody">
                            @if (!empty($bookings))
                                @foreach ($bookings as $booking)
                                    @php
                                        $date = date('Y-m-d', strtotime($booking->booking_date . ' +7 days'));
                                    @endphp
                                    <tr>
                                        <th class="text-capitalize">{{ optional($booking->student)->username }}
                                        </th>
                                        <th class="text-capitalize">{{ optional($booking->tutor)->username }}</th>
                                        <th class="text-capitalize">{{ optional($booking->subjects)->name }}</th>
                                        <td>
                                            @if ($booking->booking_fee !== 'Free')
                                                @if ((int) $booking->booking_fee == $booking->booking_fee)
                                                    £{{ $booking->booking_fee }}.00/hr
                                                @else
                                                    £{{ $booking->booking_fee }}/hr
                                                @endif
                                            @else
                                                {{ $booking->booking_fee }}
                                            @endif
                                        </td>
                                        <td>{{ $booking->duration }} minutes</td>
                                        <td>
                                            @if ($booking->request_refound != 1 && $booking->request_refound != '2')
                                                <span
                                                    class="badge
                                                @if ($booking->status == 'Completed') bg-success
                                                @elseif($booking->status == 'Scheduled')
                                                bg-info
                                                @elseif($booking->status == 'Cancelled By Tutor' || $booking->status == 'Cancelled By User')
                                                bg-danger
                                                @elseif($booking->status == 'Cancelled')
                                                bg-danger
                                                @elseif($booking->status == 'Pending')
                                                bg-warning @endif
                                                ">
                                                    {{ $booking->status }}
                                                </span>
                                            @else
                                                <span class="badge bg-secondary">
                                                     @if($booking->request_refound == '2')
                                                     {{ 'Paid Refund To User' }}
                                                    @else
                                                     {{ 'Request Refund' }}
                                                    @endif
                                                </span>
                                            @endif
                                        </td>
                                        <td>{{ $booking->booking_date . ' ' . $booking->booking_time }}</td>

                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" id="updateSubjectModal">
        <div class="modal-dialog">
            <div class="modal-content" id="subjectmodalget">
            </div>
        </div>
    </div>





    <div class="modal fade zoomIn" id="demo_meeting_modal" tabindex="-1" aria-labelledby="update_doc_modal"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0">
                <div class="modal-header p-3 bg-info-subtle">
                    <h5 class="modal-title" id="update_doc_modal_title"> Add Amount In Wallet</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        id="close-modal"></button>
                </div>
                <form role="form" action="{{ route('stripe.post.wallet') }}" method="post" class="require-validation"
                    data-cc-on-file="false"
                    data-stripe-publishable-key="pk_test_51O4cl2Iml1HP3wz7XFNa5N0OGpZyMTKiCgTyM1yO6ZZRL36cI9faSLn7Ahee5BAMbX2G5yEBnAIWoPbwRQTngD3D00zEJ71Ubv"
                    id="payment-form">
                    @csrf
                    @csrf
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-lg-12">

                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="d-flex flex-column flex-md-row justify-content-between">
                                <div class="col-lg-8 col-xl-7 col-md-6 col-12">
                                    <div class="row col-md-12">
                                        <div class="col-md-6">
                                            <div class=' form-group required'>
                                                <label class='control-label text-secondary'>Name On Card</label> <input class=" w-100 p-2"
                                                    size='4' type='text' required name="account_holder_name">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class=' form-group required'>
                                                <label class='control-label text-secondary'>Amount </label> <input class=" w-100 p-2"
                                                    size='4' type='text' name="amount" id="amount2" required placeholder="£">
                                            </div>
                                        </div>

                                        <input type="hidden" class="w-100 p-2" required name="wallet" id="wallet"
                                            value="">


                                    </div>
                                    <div class="mt-3 row col-md-12">
                                        <div class="col-md-12">
                                            <label class="text-secondary">Card Number</label><br>
                                            <input autocomplete='off' required name="card_number"
                                                class='card-number w-100 p-2' size='20' type='text'
                                                id='cardInput'>
                                        </div>
                                    </div>
                                    <div class="mt-3 row col-md-12">

                                        <div class="col-md-4 pe-1">
                                            <label class="text-secondary">CVC Number</label><br>
                                            <input type="text" required name="cvc" placeholder='ex. 311'
                                                class="w-100 p-2 card-cvc" id="cvcInput">
                                        </div>
                                        <div class="col-md-4 px-1">
                                            <label class="text-secondary">Expiration Month</label><br>
                                            <input type="text" required name="exp_month" placeholder="MM"
                                                class="w-100 p-2 card-expiry-month">
                                        </div>

                                        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                                        <script>
                                            $(document).ready(function() {
                                                $(".card-expiry-month").on("input", function() {
                                                    var inputValue = $(this).val();
                                                    inputValue = inputValue.replace(/\D/g, "");
                                                    if (inputValue === '' || parseInt(inputValue) > 12) {
                                                        $(this).val('');
                                                    } else {
                                                        $(this).val(inputValue);
                                                    }
                                                });
                                            });
                                        </script>

                                        <div class="col-md-4 ps-1">
                                            <label class="text-secondary">Expiration Year</label><br>
                                            <input type="text" required name="exp_year" placeholder="YY"
                                                class="w-100 p-2 card-expiry-year" id="exp_year_input">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-xl-5 col-md-5 col-12 p-2 h-25 mt-4 mt-md-0 me-5">
                                    <div class="form-1  shadow p-2" style=" background: #ABFF00; border-radius: 12px;">

                                        <div class="d-flex">
                                            @if (!empty(Auth::user()->image) && file_exists(public_path(!empty(Auth::user()->image) ? Auth::user()->image : '')))
                                                <img src="{{ asset(Auth::user()->image ?? 'assets\images\default.png') }}"
                                                    alt="" style="height:70px;width:70px;border-radius:50%;">
                                            @else
                                                @if (Auth::user()->gender == 'Male')
                                                    <img src="{{ asset('assets/images/male.jpg') }}"
                                                        height="70"style="height:70px;width:70px;border-radius:50%;">
                                                @elseif(Auth::user()->gender == 'Female')
                                                    <img src="{{ asset('assets/images/female.jpg') }}"
                                                        style="height:70px;width:70px;border-radius:50%;">
                                                @else
                                                    <img src="{{ asset('assets/images/default.png') }}"
                                                        style="height:70px;width:70px;border-radius:50%;">
                                                @endif
                                            @endif
                                            <div class="text p-3 d-flex flex-column">
                                                <span class="fw-bold" id="text-color">{{ Auth::user()->username }}</span>
                                                 <span>{{ Auth::user()->facebook_link }}</span>
                                            </div>
                                        </div>

                                        <div class="summary-text mt-3">
                                            <p class="text-center">
                                               Thank you for adding funds to your 247Tutors wallet! Your action ensures smooth transactions and uninterrupted learning experiences with our tutors. 🌟
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="hstack gap-2 justify-content-end">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success" id="add-btn">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <script>
        function freeMeetmodal() {
            $('#demo_meeting_modal').modal('show')
        }
    </script>


    <script src="{{ asset('js/timeslot.min.js') }}"></script>
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
    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
    <script type="text/javascript">
        $('#cvcInput').on('input', function() {
            const cvcInput = $(this).val().replace(/\D/g, '').substring(0, 3);
            const formattedDisplay = cvcInput.replace(/(\d{4})(?=\d)/g, '$1 ');
            $(this).val(formattedDisplay);
        });

        $('#cardInput').on('input', function() {
            const cardInput = $(this).val().replace(/\D/g, '').substring(0, 16);
            const formattedDisplay = cardInput.replace(/(\d{4})(?=\d)/g, '$1 ');
            $(this).val(formattedDisplay);
        });

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

            /*------------------------------------------
            --------------------------------------------
            Stripe Response Handler
            --------------------------------------------
            --------------------------------------------*/
            function stripeResponseHandler(status, response) {
                if (response.error) {
                    $('.error')
                        .removeClass('hide')
                        .find('.alert')
                        .text(response.error.message);
                } else {
                    /* token contains id, last4, and card type */
                    var token = response['id'];

                    $form.find('input[type=text]').empty();
                    $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
                    $form.get(0).submit();
                }
            }

        });
    </script>
    <script>
        const currentYear = new Date().getFullYear();
        const expYearInput = document.getElementById("exp_year_input");

        expYearInput.addEventListener("input", () => {
            expYearInput.value = expYearInput.value.replace(/\D/g, '');
            expYearInput.value = expYearInput.value.slice(0, 2);

            const inputValue = expYearInput.value;

            if (/^\d{2}$/.test(inputValue)) {
                if (inputValue < currentYear % 100) {
                    expYearInput.setCustomValidity("Expiration year should be this year or later.");
                } else {
                    expYearInput.setCustomValidity("");
                }
            } else {
                expYearInput.setCustomValidity("Please enter a valid 2-digit year.");
            }
        });
    </script>

    <script src="{{ URL::asset('assets/sweetalert2/sweetalert2.min.js') }}"></script>

    <script>
        function withdraw() {
            $.ajax({
                url: '{{ url('tutor/payout') }}',
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    console.log(data)
                    if (data.status_code == 401) {
                        Swal.fire({
                            position: 'center',
                            icon: 'warning',
                            title: data.message,
                            showConfirmButton: false,
                            timer: 2000,
                            showCloseButton: true
                        });
                    } else if (data.status_code == 501) {
                        Swal.fire({
                            position: 'center',
                            icon: 'error',
                            title: data.message,
                            showConfirmButton: false,
                            timer: 2000,
                            showCloseButton: true
                        });
                    } else if (data.status_code == 200) {
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: data.message,
                            showConfirmButton: false,
                            timer: 2000,
                            showCloseButton: true
                        }).then(function() {
                            window.location.reload();
                        });
                    }
                }
            });
        }
    </script>
@endsection
