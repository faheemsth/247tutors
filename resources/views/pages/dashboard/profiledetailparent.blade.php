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
<script src="{{ asset('js/jsdelivrcore.js') }}"></script>
<script src="{{ asset('js/jsdelivr.js') }}"></script>
<style>
      .profileeditdiv{
            opacity: 0;
        }
        .profileeditdiv:hover{
            opacity: 0.8;
        }
</style>
    <div class="container-fluid">
        <div class="container">
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
                     <div class="row mt-5 mb-5">

                        <div class="col-12 col-lg-2 image1 d-flex justify-content-lg-center position-relative">
                            <div  class="profileeditdiv d-flex justify-content-center align-items-center" style="width: 180px;height: 180px;background-color: #cfcfcf;border-radius: 50%; position: absolute;top:0px;">
                                <button type="button" data-bs-toggle="modal" data-bs-target="#staticBackdrop" class="btn px-4" style="background-color: #080808;
                                color: white;">Edit</button>
                            </div>
                            @if (!empty(Auth::user()->image) && file_exists(public_path(Auth::user()->image)))
                                <img src="{{ asset(Auth::user()->image) }}" alt="" style="width: 180px;height: 180px;
                                border-radius: 50%;">
                            @else
                                <img src="{{ asset('assets/images/default.png') }}" alt="" style="    width: 180px;
                                height: 180px;
                                border-radius: 50%;">
                            @endif
                        </div>
                                            <!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Upload Profile</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="form1" runat="server" action="{{ url('/Upload/Profile') }}" method="post" enctype="multipart/form-data">
            @csrf
                <div class="modal-body">
                <div class="row gap-4">

                    <div class="col-12 my-3" style="position: relative;">
                        <div class="btn text-center btn-primary w-100 p-1">
                            <h5>Upload Image</h5>
                        </div>
                        <div class="btn btn-primary w-100 p-1" style="position: absolute;top:0px;left:0px;opacity: 0;">
                            <input  id="imgInp"  type="file" name="image"
                            placeholder="Select Your picture"class="w-100" >
                        </div>
                    </div>
                    
                </div>
                </div>

                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Upload</button>
                </div>
         </form>
      </div>
    </div>
</div>
                            <div class="col-12 col-md-8 ps-lg-0 mt-1 ms-2 ms-md-0">
                                <div class="d-flex justify-content-between mt-lg-4 hr align-items-center">
                                    <h4 class="text-capitalize">{{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}
                                    @if (Auth::user()->status == "Active")
                                    <img src="{{ asset('assets/images/Verified-p.png') }}" alt="">
                                    @endif

                                    </h4>
                                    <!--<h5>£25 /hr</h5>-->
                                </div>
                                <div class="Spreading">
                                    <h6 style="font-weight: 500;color:#3d3d3d;">{{ Auth::user()->facebook_link }}</h6>
                                </div>
                                <div class="mt-md-3 mt-lg-5">
                                    <a class="one" href="">Parent's home</a>
                                   <a class="mb-0 one alert alert-{{ Auth::user()->status == 'Active' ? 'success' : 'danger' }}"
                            href="">{{ Auth::user()->status }}</a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4"></div>
                                <div class="col-md-8 d-flex justify-content-between align-items-center book mt-3">
                                   
                                </div>
                            </div>
                        </div>




            <div class="mt-5">
                <h3>About me:</h3>
                {{-- <p>Hi! My name is {{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}.
                   </p> --}}
                <p>

                    {{ Auth::user()->profile_description }}
                </p>
            </div>

            <!-- Arman D end -->

            <!-- General Detail start -->
            <div class="row gende">
                <div class="col-md-12 general mt-5 mb-5">
                    <h2>General Detail</h2>
                </div>
                <div class="row general-detail mb-5">
                    {{-- start --}}
                    <div class="col-md-12">
                        <form action="{{ url('profile-setting') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row mt-5">
                                <div class="col-md-6">

                                    <label for="exampleFormControlInput1" class="form-label">First Name</label>
                                    <input type="text" name="first_name" value="{{ Auth::user()->first_name }}"
                                        class="form-control" id="" required placeholder="Type Your First Name">

                                </div>
                                <div class="col-md-6 ">
                                    <label for="exampleFormControlInput1" class="form-label">Last Name</label>
                                    <input type="text" name="last_name" value="{{ Auth::user()->last_name }}"
                                        class="form-control" id="" required placeholder="Type Your Last Name">

                                </div>
                            </div>

                            <div class="row mt-5">
                                {{-- <div class="col-md-6">
                                    this div is pending
                                </div> --}}
                                <div class="col-md-6 ">
                                    <label for="exampleFormControlInput1" class="form-label">Email</label>
                                    <input type="email" name="email" value="{{ Auth::user()->email }}"
                                        class="form-control" id="" required
                                        placeholder="Type Your Email Address">
                                </div>

                                <div class="col-md-6">
                                    <label for="exampleFormControlInput1" class="form-label">Phone</label>
                                    <input type="text" name="phone" value="{{ Auth::user()->phone }}"
                                        class="form-control" id="" required placeholder="Type Your Phone">
                                </div>
                            </div>
                            <div class="row mt-5 mb-5">
                                <div class="col-md-6">
                                    <label for="exampleFormControlInput1" class="form-label">Gender</label>
                                    <input type="text" name="gender" value="{{ Auth::user()->gender }}"
                                        class="form-control" id="" required placeholder="Type Your gender">

                                </div>
                                <div class="col-md-6">
                                    <label for="exampleFormControlInput1" class="form-label">DOB</label>
                                    <input type="date" name="dob" value="{{ Auth::user()->dob }}"
                                        class="form-control" id="" required placeholder="Type Your dob">
                                </div>
                            </div>
                            <div class="row mt-5 mb-5">
                                <div class="col-md-6">
                                    <label for="exampleFormControlInput1" class="form-label">Tagline</label>
                                    <input type="text" name="facebook_link" value="{{ Auth::user()->facebook_link }}"
                                        class="form-control" id=""
                                        placeholder="Type Your Tag Line For Profile">
                                </div>
                                <div class="col-md-6">
                                    <label for="exampleFormControlInput1" class="form-label">Postcode</label>
                                    <input type="text" name="zipcode" class="form-control" id="zipcode " value="{{ Auth::user()->zipcode  }}">
                                </div>
                               
                               
                            </div>
                           

                            <div class="row mt-5 mb-5">


                                <div class="col-md-6">
                                    <label for="exampleFormControlInput1" class="form-label">Address</label>
                                    <textarea name="address" class="form-control" id="address" cols="30" rows="3">{{ Auth::user()->address }}</textarea>
                                </div>
                                 <div class="col-md-6">
                                    <label for="exampleFormControlInput1" class="form-label">Biography</label>
                                    <textarea name="profile_description" class="form-control" id="profile_description" cols="30" rows="3">{{ Auth::user()->profile_description }}</textarea>
                                </div>

                                
                            </div>
                            <div class="row mt-5 mb-5 justify-content-center">
                                <div class="col-2 text-center">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    {{-- end --}}
                </div>
                <div class="row my-4">
                   <form action="{{ url('user-card-create') }}" method="post" class="ps-0">
                    @csrf
                    <div class="col-12 col-md-7 col-lg-6 col-xl-5 mt-2 billing about">
                        <h2 class="mb-1">Configure Your Paypal Account</h2>
                        <div>
                            <h4 class="text-left text-secondary fs-4 my-3">We will use this paypal account to send you money when you initiate withdrawl.</h4>
                            
                        </div>
                    </div>    

                        <div class="col-12">
                            
                                <div class="row mb-3">
                                    <div class="col-md-5 col-11 col-lg-4">
                                        <div class='form-group required'>
                                            <label class='control-label'>Paypal account email</label>
                                            <input class=" w-100 p-2 mt-1" type='email' value="{{\Auth::user()->paypal_email}}" required name="paypal_email">
                                        </div>
                                    </div>

                                </div>

                                <div class="row  mb-3">
                                    <div class="col-md-5 col-11 col-lg-4">
                                        <div class='form-group required'>
                                            <label class='control-label'>Confirm email</label><br>
                                            <input class=" w-100 p-2 mt-1" type='email' required name="paypal_email_confirm">
                                        </div>
                                    </div>

                                </div>

                                <div class="row my-3">
                                    <div class="col-2">
                                        <button class="btn bg-primary  px-4 py-2 text-white">Save</button>
                                    </div>
                                </div>
                           

                        </div>
                    
                </form>

                </div>
            </div>
        </div>
    </div>
    
        <script src="./assets/js/main.js"></script>
    <!-- jquery file -->
    <script src="{{ asset('vendor/jquery/jquery3.7.0.js') }}"></script>
    <!-- Bootstrap js file -->
    <script src="./vendor/bootstrap/js/bootstrap.bundle.js"></script>
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
    @endsection
