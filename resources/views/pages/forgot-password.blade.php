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
   <div class="container">
    <div class="row justify-content-center mt-5">
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
        <div class="col-12 text-center">
            <h1 style="font-size: 3.2rem;color:#0D99FF;font-weight: bold">Forget Password</h1>
        </div>
    </div>

   </div>
    <div class="container mb-3  d-flex justify-content-center ">

        <div class=" mt-5 mb-3 shadow-lg p-3 mb-5 rounded "
            style="background-color:  rgba(171, 255, 0, 1);width:750px; ">
            <div class="row g-0 align-items-center justify-content-center py-3">

                <div class="col-md-6 col-border text-center">


                    <img src="{{ asset('assets/images/Group.png') }}" alt="" id="bg-shape-box">
                    <img src="{{ asset('assets/images/student-char.png') }}" class="img-fluid rounded-start " style="height:200px"
                        alt="...">
                    <img src="{{ asset('assets/images/pencil.png') }}" alt="" id="bg-shape-pancil" >
                    <h5 class="card-title" style="line-height: 2;">
                        @if (session('login_message'))
                            {{ session('login_message1') }}
                        @else
                            I am a User
                        @endif
                    </h5>
                    <p class="card-text" style="line-height: 0.3rem;">Enter your email address for forget </p>
                    <p class="card-text" style="line-height: 0.3rem;">your account passsword</p>

                </div>
                <!-- card body details -->
                <div class="col-md-6 text-center">
                    <div class="card-body d-flex flex-column justify-content-center align-items-center">
                        <form action="{{ route('password.email') }}" method="POST">
                            @csrf
                            <div class="form-group mb-3">
                                <input type="email" class="form-control" style="border: 1px solid white" id="email" placeholder="Enter email"
                                    name="email">
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
