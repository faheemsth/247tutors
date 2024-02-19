@extends('layouts.app')

@section('content')
    @include('layouts/navbar')
    <div class="container">
        <div class="row">
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
    </div>
    <div class="container-fluid student-login-title text-center  mt-5">
        <div class="row align-items-center">
            <div class="col">
                <a href="{{ url('/') }}" style="text-decoration: none;"><i class="fa-solid fa-arrow-left "
                        style="font-size: 23px;"></i> </a>
            </div>
            <div class="col-5">
                <h1 class="student-login-title" style="color: rgba(0, 150, 255, 1); font-weight:bold">
                    @if (session('login_message'))
                        {{ session('login_message') }}
                    @else
                        User Log In
                    @endif
                </h1>
            </div>
            <div class="col">
                <a href="{{ url('/') }}"><i class="fa-solid fa-xmark" style="font-size: 23px;"></i></a>

            </div>

        </div>
        <!-- card details -->
        <div class="container my-3  d-flex justify-content-center ">
            <div class=" mt-5 mb-3 shadow-lg p-3 mb-5 rounded "
                style="background-color:  rgba(171, 255, 0, 1);width:750px; ">
                <div class="row g-0 align-items-center pb-2">

                    <div class="col-md-6 col-border ">


                        <img src="./assets/images/Group.png" alt="" id="bg-shape-box">
                        <img src="./assets/images/student-char.png" class="img-fluid rounded-start " style="height:200px"
                            alt="...">
                        <img src="./assets/images/pencil.png" alt="" id="bg-shape-pancil">
                        <h5 class="card-title" style="line-height: 2;">
                            @if (session('login_message'))
                                {{ session('login_message1') }}
                            @else
                                I am a User
                            @endif
                        </h5>
                        <p class="card-text" style="line-height: 0.3rem;">Have Lesson, Message Your Tutor </p>
                        <p class="card-text" style="line-height: 0.3rem;">or Watch Your Lesson Back </p>

                    </div>
                    <!-- card body details -->
                    <div class="col-md-6">
                        <div class="card-body d-flex flex-column justify-content-center align-items-center">
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="py-2">
                                    <label for="myeamil"></label>
                                    <input type="email" name="email" id="email" value="" required
                                        autocomplete="email" autofocus placeholder="Type your Email Address"
                                        class="px-2 py-1 text-center @error('email') is-invalid @enderror"
                                        style="background: none; ">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <span class="ErrorMessage" style="color:red">

                                </span>
                                <span class="append">

                                </span>
                                <div class="d-grid gap-2 col-12 mx-auto pb-1 ">
                                    <span id="append33">
                                        <a class="btn btn-light px-4" id="submit1" type="submit">Log in with Password</a>
                                    </span>

                                    <a  class="btn " id="magickEmail"
                                        style="background-color: rgba(0, 150, 255, 1); color: white;margin:0px 21px;" type="button">Log in
                                        with Magic</i></a>

                                    <a href="{{ url('auth/google') }}" class="btn bg-transparent px-4" type="button"><img
                                            src="https://developers.google.com/identity/images/btn_google_signin_dark_normal_web.png"
                                            class="img-fluid"></a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- footer tags -->

        <div class="container-fluid" id="col-text">
            <div class="row justify-content-xl-center align-items-center mt-5 pt-5 mb-5">
                <div class="col-md-4 col-lg-3">
                    <a href="tel:+447851012039> Need help call us on <strong>+447851012039</strong> or <strong>Email us</strong></a>
                </div>
                <div class="col-md-4 col-lg-2 ">
                    <a href="{{url('/student-apply-steps')}}">Help! I'm an <strong>Adult Learn</strong></a>
                </div>
                <div class="col-md-4 col-lg-2">
                    <a href="{{url('/tutor-signup')}}">Log in as <strong>Register as Tutor</strong></a>
                </div>
                <div class="col-12 col-lg-5 col-xl-3 mt-4 mt-lg-0">
                    <div class="row">
                        <div class="">
                            <a href="{{ url('login') }}" type="button" class="btn btn-success "
                                style="background-color:  #063B00;color: white;">Log
                                in as Super Admin</a>
                            <a href="{{ url('register') }}" type="button" class="btn btn-success col-sm d-none"
                                style="background-color:  #063B00;color: white;">Sign Up</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#submit1').click(function() {
                if ($('#email').val() !== '') {
                    $('.append').append(`<div class="py-3">
                                    <label for="myeamil"></label>
                                    <input type="password" name="password" value="" required
                                        placeholder="Enter Your Password"
                                        class="px-2 py-1 text-center @error('password') is-invalid @enderror"
                                        style="background: none; ">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <a href="{{ url('password/forget') }}" style="color:#0d6efd;">
                                    Forgot Password!
                                </a>`);

                    $('#append33').html(
                        `<button class="btn btn-light px-4" type="submit">Log in with Password</button>`
                    );

                }

            });


            $('#email').keyup(function() {
                var email = $('#email').val();
                var url = "{{ url('auth/magiclink') }}" +'/'+ email;
                $('#magickEmail').attr('href', url);
            });

            $('#magickEmail').click(function() {
    if ($('#email').val() === '') {
        // Append error message
        $('.ErrorMessage').text('Please fill in your email');
    } else {
        // Remove error message if it exists
        $('.ErrorMessage').text('');
        // Your further logic for handling a non-empty email, if needed
    }
});


        });


    </script>
@endsection
