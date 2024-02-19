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
    <link rel="stylesheet" href="{{ asset('assets/css/parentdashboard.css') }}">
    <script src="{{ asset('js/jsdelivrcore.js') }}"></script>
    <script src="{{ asset('js/jsdelivr.js') }}"></script>
    <div class="container mt-5">
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
        <div class="row my-4">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <!-- Tutor Card -->
                <div class="row ">
                    <div class="col-md-2">
                        @if (!empty(Auth::user()->image) && file_exists(public_path(Auth::user()->image)))
                        <img src="{{ Auth::user()->image }}" alt="" class="img-fluid tutor-profile">
                    @else
                        
                            @if(Auth::user()->gender == 'Male')
                                <img src="{{ asset('assets/images/male.jpg') }}" class="img-fluid tutor-profile" alt="" width="25">
                            @elseif(Auth::user()->gender == 'Female')
                                <img src="{{ asset('assets/images/female.jpg') }}" class="img-fluid tutor-profile" alt="" width="25">
                            @else
                                <img src="{{ asset('assets/images/default.png') }}" class="img-fluid tutor-profile" alt="" width="25">
                            @endif
                    @endif
                    </div>
                    <div class="col-md-10">
                        <div class="d-block d-md-flex justify-content-between">
                            <div class="d-flex justify-content-between">
                                <div class="d-flex">
                                    <div class="content">
                                        <h3 class="my-0">{{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}
                                        </h3>
                                        <small><b>5.0</b></small>
                                        <i class="fa-solid fa-star ms-2" style="color: #FFD101;"></i>
                                        <small class="ms-2">(4,448)</small>
                                    </div>
                                    <img src="{{ asset('assets/images/verified.png') }}" class="correctiocn my-2 mx-1"
                                        alt="">
                                </div>
                                <div class="saved-div my-auto d-block d-md-none">
                                    <span class="text-danger my-auto">❤</span> <b>Saved</b>
                                </div>
                            </div>
                            <div class="my-3 my-md-0 text-secondary">

                            </div>
                        </div>
                    </div>
                    <div class="saved-div d-none d-md-block col-md-2 text-center">
                    </div>
                    <div class="btns d-flex justify-content-end col-md-10">
                        <a href="{{ url('chat_with_students') }}">
                            <button class="btn button1 text-center border-1"><b>Let’s chat</b></button>
                        </a>
                        <a href="{{ url('parent_profile') }}"><button class="btn button2 mx-1 "><b>View full
                                    profile</b></button></a>
                    </div>
                </div>
                <!-- Tutor Card End -->

                <!-- Welcome Start -->
                <div class="welcome2 mt-5 mb-4">
                    <h1><b>Welcome, Dear Parent</b></h1>
                </div>
                <!-- Welcome End -->
                <!-- Box Contant Start -->
                <div class="row d-flex justify-content-center mb-5">
                    <div class="col-sm-6 col-md-4 " onclick="toggle('student')">
                        <div class="welcome hoverstu">
                            <div class="text-center">
                                <img src="{{ asset('assets/images/graduating-student 1.png') }}" width="155"
                                    class="cardimg py-3" alt="">
                            </div>
                            <div class="cardimg py-1">
                                <h1><b>{{ !empty($students) ? $students->count() : '0' }}</b></h1>
                                <h2 class="text-center"><b>Students</b></h2>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-4">
                        <div class="welcome hoverstu">
                            <div class="text-center">
                                <img src="{{ asset('assets/images/wall-clock 1.png') }}" class="cardimg py-3"
                                    alt="">
                            </div>
                            <div class="cardimg py-1">
                                <h1><b>5</b></h1>
                                <h2 class="text-center"><b>Hours</b></h2>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-4" onclick="toggle('tutor')">
                        <div class="welcome hoverstu">
                            <div class="text-center">
                                <img src="{{ asset('assets/images/lec.png') }}" width="210" class="cardimg py-3"
                                    alt="">
                            </div>
                            <div class="cardimg py-1">
                                <h1><b>{{ !empty($tutors) ? $tutors->count() : '0' }}</b></h1>
                                <h2 class="welcome3 text-center py-1"><b>Hired Tutors</b></h2>
                            </div>
                        </div>
                    </div>

                    <!-- Box Contant End -->
                    <div id="studentDIV" style="display: none">
                        <div class="row p-5">
                            <h2>Students</h2>
                        </div>
                        @if (!empty($students))
                            @foreach ($students as $student)
                                <div class="row m-5">
                                    <div class="col-md-2">
                                        <img src="{{ asset($student->image) }}" alt=""
                                            class="img-fluid tutor-profile">
                                    </div>
                                    <div class="col-md-10">
                                        <div class="d-block d-md-flex justify-content-between">

                                            <div class="d-flex justify-content-between">

                                                <div class="d-flex">

                                                    <div class="content">
                                                        <h3 class="my-0">
                                                            {{ $student->first_name . ' ' . $student->last_name }}
                                                        </h3>

                                                        <small><b>5.0</b></small>
                                                        <i class="fa-solid fa-star ms-2" style="color: #FFD101;"></i>
                                                        <small class="ms-2">(4,448)</small>
                                                    </div>

                                                    <img src="{{ asset('assets/images/verified.png') }}"
                                                        class="correctiocn my-2 mx-1" alt="">
                                                </div>



                                                <div class="saved-div my-auto d-block d-md-none">
                                                    <span class="text-danger my-auto">❤</span> <b>Saved</b>
                                                </div>


                                            </div>


                                            <div class="my-3 my-md-0 text-secondary">

                                            </div>
                                        </div>
                                    </div>

                                    <div class="saved-div d-none d-md-block col-md-2 text-center">
                                        <a  href="{{ url('likeDislike?tutor=').$student->id }}" style="text-decoration: none;color: inherit;">
                                            @php
                                            $action=App\Models\LikeDislike::where('to_user_id', $student->id)->where('from_user_id', Auth::id())->first();
                                            @endphp
                                            @if (!empty($action) && $action->action == '1')
                                            <span class="text-danger">❤</span>
                                            @else
                                            <span class="text-default">❤</span>
                                            @endif
                                            <b>Saved</b>
                                        </a>
                                    </div>

                                    <div class="btns d-flex justify-content-end col-md-10">
                                        <a href="{{ url('chats') . '/' . $student->id }}">
                                            <button class="btn button1 text-center border-1"><b>Let’s chat</b></button>
                                        </a>
                                        <a href="{{ url('student_profile') . '/' . $student->id }}">
                                            <button class="btn button2 mx-1 "><b>View full profile</b></button>
                                        </a>
                                    </div>
                                    <div class="col-6 mt-2" id="img-border"></div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    {{-- tutor --}}
                    <div id="tutorDIV" style="display: none">
                        <div class="row p-5">
                            <h2>Tutor</h2>
                        </div>
                        @if (!empty($tutors))
                            @foreach ($tutors as $tutor)
                                <div class="row m-5">
                                    <div class="col-md-2">
                                        <img src="{{ asset($tutor->tutor->image) }}" alt=""
                                            class="img-fluid tutor-profile">
                                    </div>
                                    <div class="col-md-10">
                                        <div class="d-block d-md-flex justify-content-between">

                                            <div class="d-flex justify-content-between">

                                                <div class="d-flex">

                                                    <div class="content">
                                                        <h3 class="my-0">
                                                            {{ $tutor->tutor->first_name . ' ' . $tutor->tutor->last_name }}
                                                        </h3>

                                                        <small><b>5.0</b></small>
                                                        <i class="fa-solid fa-star ms-2" style="color: #FFD101;"></i>
                                                        <small class="ms-2">(4,448)</small>
                                                    </div>

                                                    <img src="{{ asset('assets/images/verified.png') }}"
                                                        class="correctiocn my-2 mx-1" alt="">
                                                </div>



                                                <div class="saved-div my-auto d-block d-md-none">
                                                    <span class="text-danger my-auto">❤</span> <b>Saved</b>
                                                </div>


                                            </div>


                                            <div class="my-3 my-md-0 text-secondary">
                                                <span>Starting from:</span>

                                                <div class="dollor">
                                                    <span><b>£{{ $tutor->amount }}/hr</b></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="saved-div d-none d-md-block col-md-2 text-center">
                                        <a  href="{{ url('likeDislike?tutor=').$tutor->tutor->id }}" style="text-decoration: none;color: inherit;">
                                            @php
                                            $action=App\Models\LikeDislike::where('to_user_id', $tutor->tutor->id)->where('from_user_id', Auth::id())->first();
                                            @endphp
                                            @if (!empty($action) && $action->action == '1')
                                            <span class="text-danger">❤</span>
                                            @else
                                            <span class="text-default">❤</span>
                                            @endif
                                            <b>Saved</b>
                                        </a>
                                    </div>

                                    <div class="btns d-flex justify-content-end col-md-10">
                                        <a href="{{ url('chats') . '/' . $tutor->tutor->id }}">
                                            <button class="btn button1 text-center border-1"><b>Let’s chat</b></button>
                                        </a>
                                        <a href="{{ url('student_profile') . '/' . $tutor->tutor->id }}">
                                            <button class="btn button2 mx-1 "><b>View full profile</b></button>
                                        </a>
                                    </div>
                                    <div class="col-6 mt-2" id="img-border"></div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <script>
        function toggle(value) {
            var student = document.getElementById("studentDIV");
            var tutor = document.getElementById("tutorDIV");
            if (value === 'student') {
                if (student.style.display === "none") {
                    student.style.display = "block";
                    tutor.style.display = "none";

                } else {
                    student.style.display = "none";
                    tutor.style.display = "block";
                }
            }
            if (value === 'tutor') {
                if (tutor.style.display === "none") {
                    tutor.style.display = "block";
                    student.style.display = "none";

                } else {
                    tutor.style.display = "none";
                    student.style.display = "block";
                }
            }

        }
    </script>
@endsection
