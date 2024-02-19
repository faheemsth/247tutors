<?php
$tutors = App\Models\Chat::where('reciver_id', Auth::id())
    ->select('sender_id')
    ->groupBy('sender_id')
    ->with('sender')
    ->get();
$countmessg = App\Models\Chat::where('reciver_id', Auth::id())
    ->where('status', 0)
    ->select('sender_id')
    ->groupBy('sender_id')
    ->with('sender')
    ->get();
$groups = App\Models\Group::All();
?>
<style>
    #msgcount {
        background-color: red;
        padding: 0px 5px 0px 5px;
        border-radius: 42px;
        position: sticky;
        color: white;
        font-weight: bold;
        font-size: 13px;
        padding-top: 0px;
    }
     @media screen and (max-width: 425px){
    .name-logo {
        display:none !important;
    }
    }
</style>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid logo-img">
        <button class="navbar-toggler btn" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"
            style="background-color: #0D99FF;;color: white;border: none;outline: 0; box-shadow: 0px 0px 0;font-size:15px;">
            <span class="span-name">Menu</span>
        </button>
        <a class="navbar-brand m-0" href="{{ url('/') }}" class="logo">
            <img src="{{ asset('assets/images/247 NEW Logo 2.png') }}" alt="Header-Logo" class="logo img-fluid"
                width="130" height="auto">
        </a>
        <div class="dropdown dropdown-toggle d-lg-none">
            <a class="btn fw-bold dropdown dropdown-first p-1" href="#" role="button" id="dropdownMenuLink"
                data-bs-toggle="dropdown" aria-expanded="false" style="border: none;outline: 0; box-shadow: 0px 0px 0;">
                <span class="name-logo px-2 fw-bold"
                    style="color: rgba(13, 153, 255, 1);">{{ Auth::user()->username }}
                    </span>
                <img src="{{ asset(Auth::user()->image ?? 'assets\images\default.png') }}" alt="" style="width: 30px;height: 30px; border-radius: 50%;">
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink">
                @if (Auth::user()->role_id === 6 && Auth::user()->status === 'Pending')
                            <li><a class="dropdown-item" href="{{ url('logout') }}"><img
                                        src="{{ asset('assets/images/logout 1.png') }}" alt=""
                                        srcset=""> Logout</a></li>
                        @else
                            <li><a class="dropdown-item"
                                    href="{{ Auth::user()->role_id == '5' ? url('parent/profile') : url('organization/home') }}">
                                    <img src="{{ asset('assets/images/user 1.png') }}" alt=""> Your
                                    Profile</a></li>
                            <li><a class="dropdown-item" href="{{ url('parent/students') }}">
                                <img
                        src="{{ asset('assets/images/student 1.png') }}" alt="" srcset="">
                                Your Students</a></li>
                                    <li><a class="dropdown-item" href="{{ url('/parent/payments') }}">
                                        <i class="fa-solid fa-file-invoice-dollar me-2"></i>
                                         Billing & Payments</a></li>
                            {{-- <li><a class="dropdown-item" href="{{ url('profile-setting') }}"><img
                                    src="{{ asset('assets/images/student 1.png') }}" alt="" srcset="">
                                Setting</a></li> --}}
                                <li><a class="dropdown-item" href="{{ url('complaint') }}"><i class="fa-solid fa-headset me-2"></i>
                                    Support</a></li>
                            <li><a class="dropdown-item" href="{{ url('logout') }}"><img
                                        src="{{ asset('assets/images/logout 1.png') }}" alt=""
                                        srcset=""> Logout</a></li>
                        @endif
            </ul>
        </div>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav m-auto mb-2 mb-lg-0 fw-bold">
                <li class="nav-item active">
                    <a class="nav-link active" aria-current="page" href="{{ url('parent/home') }}">Home</a>
                </li>
                @if(\Auth::user()->role_id != 6)
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('find-tutor') }}">Find a Tutor</a>
                </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/parent/payments') }}">Balance over view Report</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('findTutor') ? 'active' : '' }}"
                        href="{{ url('parent/messages') }}">Messages <span id="msgcount" class="messgcount" style="display: none"></a>
                </li>
                {{-- <div class="dropdown  d-none d-lg-flex ">
                    <a class="nav-link dropdown dropdown-second" href="#" tabindex="-1" id="dropdownMenuLink"
                        data-bs-toggle="dropdown" aria-expanded="false" aria-disabled="true">Messages
                        {!! $countmessg->count() > 0 ? '<span id="msgcount">' . $countmessg->count() . '</span>' : '' !!}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink">
                        <li>
                            @if (!empty($tutors))
                                @foreach ($tutors as $tutor)
                                    <a class="dropdown-item" href="{{ url('chats') . '/' . $tutor->sender->id }}">
                                        <img src="{{ url('') . '/' . $tutor->sender->image }}" alt=""
                                            width="40" height="40" style="border-radius: 73px;">
                                        {{ $tutor->sender->first_name . ' ' . $tutor->sender->last_name }}
                                    </a>
                                @endforeach
                            @endif
                        </li>
                        @if (!empty($groups))
                            @foreach ($groups as $key => $group)
                                @if ($key === 0)
                                    @if (Auth::id() == $group->user_id || Auth::user()->parent_id == $group->user_id)
                                        <li>
                                            <a class="dropdown-item" href="{{ url('chat_with_students') }}">
                                                <i class="fa-solid fa-user-group"
                                                    style="font-size: 19px;margin-left: 8px;"></i>
                                                <span style="margin-left: 8px">Group Chats</span>
                                            </a>
                                        </li>
                                    @endif
                                @endif
                            @endforeach
                        @endif
                    </ul>
                </div> --}}
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('findTutor') ? 'active' : '' }}"
                        href="{{ url('bookings') }}" tabindex="-1" aria-disabled="true">Bookings
                        <span id="msgcount" class="countBooking" style="display: none"></span>
                    </a>
                </li>
            </ul>


            <div class="col-md-2 d-flex justify-content-end align-items-center header-btn gap-1"
                style="max-width: max-content;">

                <div class="dropdown  d-none d-lg-flex ">
                    <a class="btn   fw-bold dropdown dropdown-second " href="#" role="button"
                        id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false"
                        style="border: none;outline: 0; box-shadow: 0px 0px 0;">
                        @if(\Auth::user()->role_id != 6)
                        <span class="name-logo px-2 fw-bold text-capitalize"
                            style="color: rgba(13, 153, 255, 1);">{{ Auth::user()->username }}
                        </span>
                        @else
                        <span class="name-logo px-2 fw-bold text-capitalize"
                            style="color: rgba(13, 153, 255, 1);">{{ Auth::user()->first_name }}
                        </span>
                        @endif
                            @if (!empty(Auth::user()->image) && file_exists(public_path(!empty(Auth::user()->image) ? Auth::user()->image : '')))
                            <img src="{{ asset(Auth::user()->image) }}" alt=""
                            style="width: 32px;height: 32px; border-radius: 50%;">
                            @else
                                @if(Auth::user()->gender == 'Male')
                                    <img src="{{ asset('assets/images/male.jpg') }}"  alt="" style="width: 32px;height: 32px; border-radius: 50%;">
                                @elseif(Auth::user()->gender == 'Female')
                                    <img src="{{ asset('assets/images/female.jpg') }}"  alt="" style="width: 32px;height: 32px; border-radius: 50%;">
                                @else
                                    <img src="{{ asset('assets/images/default.png') }}"  alt="" style="width: 32px;height: 32px; border-radius: 50%;">
                                @endif
                            @endif
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink">
                        @if (Auth::user()->role_id === 6 && Auth::user()->status === 'Pending')
                        <li><a class="dropdown-item" href="{{ url('logout') }}"><img
                                    src="{{ asset('assets/images/logout 1.png') }}" alt=""
                                    srcset=""> Logout</a></li>
                    @else
                        <li><a class="dropdown-item"
                                href="{{ Auth::user()->role_id == '5' ? url('parent/profile') : url('organization/home') }}">
                                <img src="{{ asset('assets/images/user 1.png') }}" alt=""> Your
                                Profile</a></li>
                        <li><a class="dropdown-item" href="{{ url('parent/students') }}">
                            <img
                    src="{{ asset('assets/images/student 1.png') }}" alt="" srcset="">
                            Your Students</a></li>
                                <li><a class="dropdown-item" href="{{ url('/parent/payments') }}">
                                    <i class="fa-solid fa-file-invoice-dollar me-2"></i>
                                     Billing & Payments</a></li>
                        {{-- <li><a class="dropdown-item" href="{{ url('profile-setting') }}"><img
                                src="{{ asset('assets/images/student 1.png') }}" alt="" srcset="">
                            Setting</a></li> --}}
                            <li><a class="dropdown-item" href="{{ url('complaint') }}"><i class="fa-solid fa-headset me-2"></i>
                                Support</a></li>
                        <li><a class="dropdown-item" href="{{ url('logout') }}"><img
                                    src="{{ asset('assets/images/logout 1.png') }}" alt=""
                                    srcset=""> Logout</a></li>
                    @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>


    </div>
</nav>
