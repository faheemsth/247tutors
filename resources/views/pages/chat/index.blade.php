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
        .msg {
            font-size: 2.9rem;
        }
        .leftpadd{
            list-style: none;padding-left: 10px;
        }
        @media only screen and (max-width:330px){
  
     .leftpadd{
        padding-left:0px;
       
    }
}
    </style>
    <div id="topmsg" class="container py-5">
       <div class="row">
        @include('include.message')
       </div>
        <div class="row my-4">
            <div class="col-3 ">
                <h1 class="msg" id="text-color">Message's</h1>
            </div>
        </div>
        <div class="row mb-5 px-md-2 mx-1 mx-md-0" style="border: 1px solid rgb(199, 199, 199);">
            <div class="col-12 my-4 px-1 px-md-2">
                <div class="w-100 h-100">
                    <!-- Tabs navs -->
                    <ul class="nav nav-tabs mb-3" id="ex1" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a href="#topmsg" class="nav-link mb-1 active" id="ex1-tab-1" data-mdb-toggle="tab" href="#ex1-tabs-1"
                                role="tab" aria-controls="ex1-tabs-1" aria-selected="true"
                                style="border: 0px 0px 2px 0px solid rgb(199, 199, 199); ">Active Chat's</a>
                        </li>

                    </ul>
                    <div class="tab-content " id="ex1-content">
                        <div class="tab-pane fade show active" id="ex1-tabs-1" role="tabpanel" aria-labelledby="ex1-tab-1">
                            <ul class="leftpadd">

                                @if (!empty($tutors))
                                    @foreach ($tutors as $tutor)
                                
                                        <li class="d-flex align-items-end align-items-md-center justify-content-between py-2 mb-2"
                                            style="border-bottom: 1px solid #e3e3e3;">
                                            <div class="d-flex gap-2 align-items-md-center align-items-end">
                                               {{-- reciver --}}

                                                {{-- sender --}}
                                                    @if (
                                                        !empty($tutor['image']) &&
                                                            file_exists(public_path(!empty($tutor['image']) ? $tutor['image'] : '')))
                                                        <img src="{{ asset($tutor['image']) }}" style="width: 60px;height: 60px;border-radius: 50%;"
                                                             alt="" srcset="">
                                                    @else
                                                        <img src="{{ asset('assets/images/default.png') }}"
                                                           style="width: 60px;height: 60px;border-radius: 50%;" alt=""
                                                            srcset="">
                                                    @endif
                                                <div class=" d-flex flex-column">

                                                    <h5 class="mb-0 text-capitalize">
                                                        {{ $tutor['username'] }}
                                                    </h5>
                                                    <p class="mb-0">{{$tutor['facebook_link'] ?? ''}}</p>
                                                </div>
                                            </div>
                                            <div>

                                                <a href="{{ url('chat') . '/' . $tutor['id'] }}"
                                                    class="btn px-2 px-md-3 py-1 bg-primary text-white text-decoration-none">Let's
                                                    Chat</a>


                                            </div>
                                        </li>
                                    @endforeach
                                @endif


                            </ul>
                        </div>

                    </div>
                    <!-- Tabs content -->
                </div>

            </div>
        </div>
    </div>


@endsection
