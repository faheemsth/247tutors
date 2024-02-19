<style>

        .active {
            color: rgba(0, 150, 255, 1) !important;
            }

</style>



<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid logo-img">
        <a class="navbar-brand logo-247" href='{{ route('index') }}'><img
                src="{{ asset('assets/images/247 NEW Logo 1.png') }}" alt="" srcset="" class="img-fluid"></a>
        <div class="d-flex align-items-center gap-md-4">
            <div class="dropdown d-none d-md-inline-block d-lg-none btn" style="border: 1px solid gray">
                <a class="dropdown-toggle me-2 text-dark text-decoration-none" href="#" role="button"
                    id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                    {{-- <img src="{{ asset('assets/images/translation.svg') }}" alt="Translation" width="20"
                        height="auto"> --}}
                        Translate
                </a>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink" style=" top: 35px !important;">
                    <li><a class="dropdown-item" href="{{ route('locale', ['locale' => 'en']) }}" {{ Session::get('locale') == 'en' ? 'active' : ''}}>English</a></li>
                    <li><a class="dropdown-item" href="{{ route('locale', ['locale' => 'urd']) }}" {{ Session::get('locale') == 'urd' ? 'active' : ''}}>Urdu</a></li>
                    <li><a class="dropdown-item" href="{{ route('locale', ['locale' => 'chi']) }}" {{ Session::get('locale') == 'chi' ? 'active' : ''}}>Chinese</a></li>

                </ul>
            </div>
            <button class="navbar-toggler buger-btn" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav m-auto mb-2 mb-lg-0 fw-bold">
                <li class="nav-item ">
                    <a class="nav-link {{ request()->routeIs('index') ? 'active' : '' }}" aria-current="page" href='{{ route('index') }}'>Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('findTutor') ? 'active' : '' }}" href='{{ route('findTutor') }}'>Find a Tutor</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">How it's Work</a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href='{{ route('studentApplySteps') }}'>Become a Student</a></li>
                        <li><a class="dropdown-item" href='{{ route('tutorApplySteps') }}'>Become a Tutor</a></li>
                        <li><a class="dropdown-item" href='{{ route('organizationApplySteps') }}'>For Organization</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('prices') ? 'active' : '' }}" href='{{ route('prices') }}' tabindex="-1" aria-disabled="true">Prices</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('blogs') ? 'active' : '' }}" href='{{ route('blogs') }}' tabindex="-1" aria-disabled="true">Resources</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('faq') ? 'active' : '' }}"  href='{{ route('faq') }}' tabindex="-1" aria-disabled="true">FAQs</a>
                </li>
            </ul>

            @if (Auth::check())
                @if (Auth::user()->role_id != '1' && Auth::user()->role_id != '2' && Auth::check())
                    <div class="col-md-2 d-flex justify-content-end align-items-center header-btn gap-1"
                        style="max-width: max-content;">
                        <div class="dropdown d-none d-lg-inline-block btn" style="border: 1px solid gray">
                            <a class="dropdown-toggle me-2 text-dark text-decoration-none" href="#" role="button"
                                id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                {{-- <img src="{{ asset('assets/images/translation.svg') }}" alt="Translation" width="20"
                                    height="auto"> --}}
                                    Translate
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink" style=" top: 35px !important;">
                                <li><a class="dropdown-item" href="{{ route('locale', ['locale' => 'en']) }}" {{ Session::get('locale') == 'en' ? 'active' : ''}}>English</a></li>
                                <li><a class="dropdown-item" href="{{ route('locale', ['locale' => 'urd']) }}" {{ Session::get('locale') == 'urd' ? 'active' : ''}}>Urdu</a></li>
                                <li><a class="dropdown-item" href="{{ route('locale', ['locale' => 'chi']) }}" {{ Session::get('locale') == 'chi' ? 'active' : ''}}>Chinese</a></li>
                            </ul>
                        </div>
                        <a href='{{ route('login-roles') }}' class="header-login px-2 py-1 mx-1 btn fw-bold"
                            id="btn-bg" type="submit">Login</a>
                        <div class="dropdown">
                            <a class="btn px-3 py-2 fw-bold" href="{{ route('showRegisterForm') }}" role="button"
                                id="dropdownMenuLink"
                                style="  background-color: rgba(6, 59, 0, 1);color: rgba(255, 255, 255, 1);">
                                Registration
                            </a>
                            {{-- <a class="btn px-3 py-2 fw-bold dropdown-toggle" href="#" role="button"
                                id="dropdownMenuLink"
                                style="  background-color: rgba(6, 59, 0, 1);color: rgba(255, 255, 255, 1);"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Registration
                            </a> --}}
                            {{-- <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <li><a class="dropdown-item" href='{{ route('showRegisterForm') }}'>Join as Tutor</a>
                                </li>
                                <li><a class="dropdown-item" href='{{ route('showRegisterForm') }}'>Join as
                                        Student</a></li>
                                <li><a class="dropdown-item" href='{{ route('showRegisterForm') }}'>Join as
                                        Organization</a>
                                </li>
                                <li><a class="dropdown-item" href='{{ route('showRegisterForm') }}'>Join as
                                        Parents</a></li>
                            </ul> --}}
                        </div>
                    </div>
                @else
                <div class="col-md-2 d-flex justify-content-end align-items-center header-btn gap-1"
                style="max-width: max-content;">
                <div class="dropdown d-none d-lg-inline-block btn" style="border: 1px solid gray">
                    <a class="dropdown-toggle me-2 text-dark text-decoration-none" href="#" role="button"
                        id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                        {{-- <img src="{{ asset('assets/images/translation.svg') }}" alt="Translation" width="20"
                            height="auto"> --}}
                            Translate
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink" style=" top: 35px !important;">
                        <li><a class="dropdown-item" href="{{ route('locale', ['locale' => 'en']) }}" {{ Session::get('locale') == 'en' ? 'active' : ''}}>English</a></li>
                        <li><a class="dropdown-item" href="{{ route('locale', ['locale' => 'urd']) }}" {{ Session::get('locale') == 'urd' ? 'active' : ''}}>Urdu</a></li>
                        <li><a class="dropdown-item" href="{{ route('locale', ['locale' => 'chi']) }}" {{ Session::get('locale') == 'chi' ? 'active' : ''}}>Chinese</a></li>
                    </ul>
                </div>
                <div class="dropdown  d-none d-lg-flex ">
                    <a class="btn   fw-bold dropdown dropdown-second " href="#" role="button"
                        id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false"
                        style="border: none;outline: 0; box-shadow: 0px 0px 0;">
                        <span class="name-logo px-2 fw-bold" style="color: rgba(13, 153, 255, 1);">
                            {{ Auth::user()->role->name }}
                        </span>
                        @if (!empty(Auth::user()->image) && file_exists(public_path(!empty(Auth::user()->image) ? Auth::user()->image : '')))
                        <img src="{{ asset(Auth::user()->image) }}" alt=""
                        width="25">
                        @else
                            @if(Auth::user()->gender == 'Male')
                                <img src="{{ asset('assets/images/male.jpg') }}"  alt="" width="25">
                            @elseif(Auth::user()->gender == 'Female')
                                <img src="{{ asset('assets/images/female.jpg') }}"  alt="" width="25">
                            @else
                                <img src="{{ asset('assets/images/default.png') }}"  alt="" width="25">
                            @endif
                        @endif
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink">
                        <li>
                            <a class="dropdown-item" href="{{ Auth::user()->role_id==2?url('admin_dashboard'):url('dashboard') }}"><img
                                    src="{{ asset('assets/images/user 1.png') }}" alt=""> Dashboard</a>
                        </li>
                        <li><a class="dropdown-item" href="{{ url('logout') }}"><img
                                    src="{{ asset('assets/images/logout 1.png') }}" alt="" srcset=""> Logout</a></li>
                    </ul>
                </div>
            </div>
                @endif
            @else
                <div class="col-md-2 d-flex justify-content-end align-items-center header-btn gap-1"
                    style="max-width: max-content;">
                    <div class=" d-none d-xl-inline-block btn">
                        <!--<a class="dropdown-toggle me-2 text-dark text-decoration-none" href="#" role="button"-->
                        <!--    id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">-->
                        <!--    {{-- <img src="{{ asset('assets/images/translation.svg') }}" alt="Translation" width="20"-->
                        <!--        height="auto"> --}}-->
                        <!--        Translate-->
                        <!--</a>-->
                        <!--<ul class="dropdown-menu" aria-labelledby="dropdownMenuLink" style=" top: 35px !important;">-->
                        <!--    <li><a class="dropdown-item" href="{{ route('locale', ['locale' => 'en']) }}" {{ Session::get('locale') == 'en' ? 'active' : ''}}>English</a></li>-->
                        <!--    <li><a class="dropdown-item" href="{{ route('locale', ['locale' => 'urd']) }}" {{ Session::get('locale') == 'urd' ? 'active' : ''}}>Urdu</a></li>-->
                        <!--    <li><a class="dropdown-item" href="{{ route('locale', ['locale' => 'chi']) }}" {{ Session::get('locale') == 'chi' ? 'active' : ''}}>Chinese</a></li>-->
                        <!--</ul>-->
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                         <div id="google_element"></div>
                         
                         
                         
                         
                         
                    </div>
                    <a href='{{ route('login-roles') }}' class="header-login px-3 py-2 mx-1 btn fw-bold"
                        id="btn-bg" type="submit">Login</a>
                    <div class="dropdown">
                        <a class="btn px-3 py-2 fw-bold" href="{{ route('select-user-type') }}" role="button"
                            id="dropdownMenuLink"
                            style="  background-color: rgba(6, 59, 0, 1);color: rgba(255, 255, 255, 1);">
                            Registration
                        </a>
                        {{-- <a class="btn px-3 py-2 fw-bold dropdown-toggle" href="#" role="button"
                            id="dropdownMenuLink"
                            style="  background-color: rgba(6, 59, 0, 1);color: rgba(255, 255, 255, 1);"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Registration
                        </a> --}}
                        {{-- <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink">
                            <li><a class="dropdown-item" href='{{ route('showRegisterForm') }}'>Join as Tutor</a>
                            </li>
                            <li><a class="dropdown-item" href='{{ route('showRegisterForm') }}'>Join as
                                    Student</a></li>
                            <li><a class="dropdown-item" href='{{ route('showRegisterForm') }}'>Join as
                                    Organization</a>
                            </li>
                            <li><a class="dropdown-item" href='{{ route('showRegisterForm') }}'>Join as
                                    Parents</a></li>
                        </ul> --}}
                    </div>
                </div>
            @endif
        </div>
    </div>
</nav>
