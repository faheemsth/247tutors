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
    <div class="container-fluid">
        <div class="container">
            <div class="row my-5">
                <div class="col-12 col-md-7 col-lg-8 arman-d">

                    <div class="mt-3 arman">

                        <div class="row">

                            <div class="col-12 col-md-4 profile-img">
                                <img src="{{ asset(Auth::user()->image?? 'assets\images\default.png') }}" alt="" class="img-fluid">
                            </div>
                            <div class="col-12 col-md-8 ps-lg-0 mt-1 ms-2 ms-md-0">
                                <div class="d-flex justify-content-between mt-lg-4 hr align-items-center">

                                    <h4>{{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}<img
                                            src="./assets/images/Verified-p.png" alt=""></h4>

                                </div>
                                <div class="Spreading">
                                    <p class="">Spreading knowledge everywhere that's all I do</p>
                                </div>

                                <div class="mt-md-3 mt-lg-5">
                                    <a class="one" href="">Student's home</a>
                                    <a class="two" href="">Online</a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4"></div>
                                <div class="col-md-8 d-flex justify-content-between align-items-center book mt-3 ms-3 ms-md-0">
                                    <p><img src="./assets/images/heart.png" alt=""> Saved</p>

                                </div>

                            </div>
                        </div>


                        <div class="mt-5">
                            <h3>About me:</h3>
                            {{-- <p class="mb-1">Hi! My name is {{ Auth::user()->first_name . ' ' . Auth::user()->last_name }} and I'm
                                currently a pre-medical student.</p>
                            <p> --}}
                                {{ Auth::user()->profile_description }}
                            </p>
                        </div>

                        <div class="personally py-4 mb-3">
                            <h3 class="mx-5">Personally interviewed by 24/7 Tutor</h3>
                            <p class="mx-5">Lorem ipsum dolor sit amet. Est magni cupiditate ad laboriosam vitae a
                                dicta nisi qui
                                corrupti laborum non repellat molestiae. Sit eaque quam cum itaque dolores vel culpa
                                maiores. Aut
                                architecto earum ut quidem assumenda ad dicta harum aut voluptatem iure qui consequuntur
                                nihil et
                                internos rerum eum velit eaque.</p>

                        </div>
                    </div>
                </div>
                <div class="col-md-5 col-lg-4 mt-5 mt-md-0">

                    <div class="row">
                        <div class="col-md-12 chat justify-content-center text-center d-flex align-items-center flex-column">

                            <img src="/assets/images/chat 1.png" alt="">
                            <h5>Let’s Chat with Arman</h5>
                            <p>Have a Chat with Arman and see how ( and when!) they can Help</p>
                            <a href="">Let's Chat</a>

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 more mt-2 ">
                            <ul class="ps-0 ps-md-5">
                                <li>
                                    <a href="">More Biology Tutor</a>
                                </li>

                                <li> <a href="">More Chemistry Tutor</a></li>
                                <li> <a href="">More English Language Tutor</a></li>
                                <li> <a href="">More Mathmatics Tutor</a></li>
                                <li> <a href="">More Physics Tutor</a></li>
                                <li> <a href="">More Biology GCSE Tutor</a></li>
                                <li> <a href="">More Chemistry GCSE Tutor</a></li>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
