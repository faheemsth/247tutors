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

    <style>
        .msg{
            font-size: 3.4rem;
        }
    </style>
    <div class="container py-5">
        <div class="row my-4">
            <div class="col-3">
                <h1 class="msg">Message's</h1>
            </div>
        </div>
        <div class="row mb-5 px-2" style="border: 1px solid rgb(199, 199, 199);">
            <div class="col-12 my-4">
                <div class="w-100 h-100">
                    <!-- Tabs navs -->
                    <ul class="nav nav-tabs mb-3" id="ex1" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link mb-1 active" id="ex1-tab-1" data-mdb-toggle="tab" href="#ex1-tabs-1"
                                role="tab" aria-controls="ex1-tabs-1" aria-selected="true" style="border: 0px 0px 2px 0px solid rgb(199, 199, 199); ">Active Chat's</a>
                        </li>

                    </ul>
                    <!-- Tabs navs -->

                    <!-- Tabs content -->
                    <div class="tab-content " id="ex1-content">
                        <div class="tab-pane fade show active" id="ex1-tabs-1" role="tabpanel" aria-labelledby="ex1-tab-1">

                           {{-- <div class= row class="align-items-center">
                            <div class="col-auto">
                                <img src="./assets/images/img1.png"   class="rounded-circle" alt="" srcset="">
                            </div>
                            <div class="col-4 d-flex flex-column">
                                <h5>Ahsan Shoukat</h5>
                                <p class="mb-0">Graduate in BEng. Biomedical engineering. Medical engineer at NHS</p>
                            </div>
                            <div class="col-2" style="">
                                <button class="btn px-4 py-2 bg-primary">Let's Chat</button>
                            </div>
                           </div> --}}
                           <ul style="list-style: none;padding-left: 10px;">
                            <li class="d-flex align-items-center justify-content-between py-2 mb-2" style="border-bottom: 1px solid #e3e3e3;">
                                <div class="d-flex gap-2 align-items-center">
                                    <img src="./assets/images/img1.png"   class="rounded-circle" width="60px" alt="" srcset="">
                                    <div class=" d-flex flex-column">
                                        <h5 class="mb-0">Ahsan Shoukat</h5>
                                        <p class="mb-0">Graduate in BEng. Biomedical engineering. Medical engineer at NHS</p>
                                    </div>
                                </div>
                                <div >
                                    <a href="{{ url('/single_chat') }}" class="btn px-3 py-1 bg-primary text-white text-decoration-none">Let's Chat</a>
                                </div>
                            </li>
                            <li class="d-flex align-items-center justify-content-between py-2 mb-2" style="border-bottom: 1px solid #e3e3e3;">
                                <div class="d-flex gap-2 align-items-center">
                                    <img src="./assets/images/img1.png"   class="rounded-circle" width="60px" alt="" srcset="">
                                    <div class=" d-flex flex-column">
                                        <h5 class="mb-0">Ahsan Shoukat</h5>
                                        <p class="mb-0">Graduate in BEng. Biomedical engineering. Medical engineer at NHS</p>
                                    </div>
                                </div>
                                <div >
                                    <a href="{{ url('/single_chat') }}" class="btn px-3 py-1 bg-primary text-white text-decoration-none">Let's Chat</a>
                                </div>
                            </li>
                           </ul>
                        </div>

                    </div>
                    <!-- Tabs content -->
                </div>

            </div>
        </div>
    </div>


@endsection
