@extends('layouts.app')

@php
    $Page = \App\Models\Page::where('page_name', 'home')->first();
@endphp
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
<style>
#subject a:hover{
    color: rgba(0, 150, 255, 1) !important;
}

.hero-focus-btn{
    font-size: 2em;
}
.subject-title{
    font-size: 4rem;
}
@media only screen
and (max-width : 1024px){
    .hero-section-heading{
        font-size: 2.8rem !important;
    }
    .hero-focus-btn{
        font-size: 1.6em;
    }
    .subject-title{
        font-size: 3.2rem !important;
    }

}
@media only screen
and (max-width : 768px){
    .hero-section-heading{
        font-size: 2.4rem !important;
        padding-right: 15rem;
    }
    .hero-focus-btn{
        font-size: 1.4em;
    }
    .subject-title{
        font-size: 3rem !important;
    }
}

@media only screen
and (max-width : 430px){
   
.padd{
    padding:8px 41px !important;
}
.padd1{
    padding:8px 21px !important;
}
.padd3{
    padding:8px 45px !important;
}
.hero-section-heading{
        font-size: 1.7rem !important;
        padding-right: 0rem !important;
    }
    .hero-focus-btn{
        font-size: 1.3em;
    }
    .subject-title{
        font-size: 2.8rem !important;
    }


}
 #subjectcard{
        border: 2px solid rgb(226, 226, 226); 
    border-radius: 35px; 
    max-height: 100%;
    /*min-height: 255px; */
    
    color: white;
  }


@media screen and (max-width: 320px) {
  #subjectcard{
    max-height: 100%;
    min-height: 170px; 
  }
}
@media screen and (max-width: 425px) {
  #subjectcard{
    max-height: 100%;
    min-height: 202px; 
  }
}
@media screen and (max-width: 1024px) {
  #subjectcard{
    max-height: 100%;
    min-height: 205px; 
  }
}
@media screen and (max-width: 1440px) {
  #subjectcard{
    max-height: 100%;
    min-height: 245px; 
  }
}
@media screen and (min-width: 1440px) {
  #subjectcard{
    max-height: 100%;
    min-height: 283px; 
  }
}
@media screen and (min-width: 2560px) {
  #subjectcard{
    max-height: 100%;
    min-height: 339px; 
  }
}
</style>
    <!-- hero section  -->
    <section class="homePage mt-5">

        <div class="container-fluid">
            <div class="container">
                <!-- first row -->
                <div class="row hero-section">
                    <div class="col-12 mt-5 col-lg-6 col-xl-6 hero-text-section" id="text-color">
                        <h1 class="hero-section-heading">@isset($web_settings['hero_title']) {{ $web_settings['hero_title'] ?? '' }} @endisset</h1>

                        <div id="hero-focus">
                            <p class="px-2  fw-bold  hero-focus-btn">@isset($web_settings['highlight_text']) {{ $web_settings['highlight_text'] ?? '' }} @endisset</p>
                        </div>
                        <p class="py-2">@isset($web_settings['hero_desc']) {{$web_settings['hero_desc'] ?? '' }} @endisset</p>

                        <div class="mb-5 pt-2 pb-4">
                            <a type="button" href='{{ route('studentApplySteps') }}' class="padd btn px-4 py-2 mb-2"
                                style="background:linear-gradient(93.86deg, #063B00 9.41%, #000000 98.3%);
                                ;
                                font-size: 16px;color: white; border: none;">Become
                                a Student <i class="fa-solid fa-chevron-right"></i></a>
                                <a type="button" href='{{ route('tutorApplySteps') }}' class="padd2 btn px-5 py-2 mb-2"
                                style="border: 1px solid lightgray;
                          font-size: 16px;font-family:'Outfit', sans-serif;">Become
                                a Tutor
                                {{-- <span style="color:rgba(29, 161, 242, 1);">It’s Free <i class="fa-solid fa-exclamation"></i>
                                </span> --}}
                                <i class="fa-solid fa-chevron-right"></i>
                            </a><br>
                            <a type="button" href='{{ route('organizationApplySteps') }}' class="padd1 btn px-4 py-2 mb-2"
                                style="border: 1px solid lightgray;
                          font-size: 16px;font-family:'Outfit', sans-serif;">Become
                                a Organization
                                {{-- <span style="color:rgba(29, 161, 242, 1);">It’s Free <i class="fa-solid fa-exclamation"></i>
                                </span> --}}
                                <i class="fa-solid fa-chevron-right"></i>
                            </a>
                                <a type="button" href='{{ route('organizationApplySteps') }}' class="padd3 btn px-4 py-2 mb-2"
                                style="background:linear-gradient(93.86deg, #063B00 9.41%, #000000 98.3%);
                                ;
                                font-size: 16px;color: white; border: none;">Become
                                a Parent  <i class="fa-solid fa-chevron-right"></i></a>

                            <p class="">
                                <img src="{{ asset('assets/images/Icon.png') }}" alt="" srcset="">
                                @isset($web_settings['hero_short_desc']) {{$web_settings['hero_short_desc'] ?? '' }} @endisset </span>
                            </p>
                        </div>
                        {{-- {!! $Page->home_hero_section !!} --}}
                    </div>
                    <div class="col-md-6 d-none d-lg-flex justify-content-center">

                        <div class="shapes-parent py-5">
                            <div class="shapes">
                                <img src="{{ asset('assets/images/Ellipse 40.png') }}" alt="" srcset="" class="shape">
                            </div>
                            <img src="{{ asset('assets/images/Mask group.png') }}" alt="" srcset="" class="model-header">
                            <!-- <img src="assets/images/brand-image-for-hero.png" alt="" class="w-50 img-card" id="img"> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- hero Sec end  -->



    <!-- Banner section  -->
    {{-- <div class="container-fluid py-3" style="background-color: rgba(0, 150, 255, 0.1);">
        <div class="row justify-content-lg-center gap-lg-5 py-3 banner-sec-home">
            <div class="col-lg-2 col-md-3 col-6 banner-border-first py-2">
                <div class="card text-center border-0 bg-transparent py-2 align-items-center">
                    <div class="mb-2" id="banner-icon">
                        <img src="{{ asset('assets/images/books-stack-of-three 1.png" alt="" srcset="">
                    </div>
                    <h4>{{ count($subjectCounts) }}</h4>
                    <small>Subjects available for verified
                        and top tutors</small>
                </div>
            </div>
            <div class="col-lg-2 col-md-3 col-6 py-2">
                <div class="card text-center bg-transparent border-0 py-2 align-items-center">
                    <div class="mb-2" id="banner-icon">
                        <img src="{{ asset('assets/images/portfolio 1.png" alt="" srcset="">
                    </div>
                    <h4>{{ $TutorSubjectOffers->count() }}</h4>
                    <small>Total tuition job posted on the
                        platform till date</small>
                </div>
            </div>
            <div class="col-lg-2 col-md-3 col-6 banner-border-second py-2">
                <div class="card text-center border-0 bg-transparent py-2 align-items-center">
                    <div class="mb-2" id="banner-icon">
                        <img src="./assets/images/clock 1.png" alt="" srcset="">
                    </div>
                    <h4>14+ Hours </h4>
                    <small>User daily average time spent
                        on the platform</small>
                </div>
            </div>
            <div class="col-lg-2 col-md-3 col-6 banner-border-third py-2">
                <div class="card text-center border-0 bg-transparent py-2 align-items-center">
                    <div class="mb-2" id="banner-icon">
                        <img src="./assets/images/icons8-training-30 1.png" alt="" srcset="">
                    </div>
                    <h4>{{ $stu_tutor_count }}</h4>
                    <small>Active instructor and students
                        available on the platform</small>
                </div>
            </div>
        </div>
    </div> --}}
    {{-- slider --}}
    {{-- <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"
                aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
                aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
                aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="{{ asset('assets/images/13763344_5317197.jpg') }}" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('assets/images/13763344_5317197.jpg') }}" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('assets/images/13763344_5317197.jpg') }}" class="d-block w-100" alt="...">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
            data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
            data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div> --}}
    {{-- div  --}}
    <div class="container-fluid px-0">
        <div class="row h-75 px-0 mx-0">
            <div class="col-12 h-75">
                <img src="{{ asset('assets/images/13763344_5317197.jpg') }}" class="d-block w-100 h-75" alt="...">
            </div>
        </div>
    </div>
    <!-- Banner section end  -->



    <!-- Subject & Lang -->
    <div class="container-fluid lan-sec my-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8  py-5">
                <div class="row mb-5">
                    <div class="col-12 text-center">
                        <h1 class="fw-bold subject-title"  id="text-color">Subjects</h1>
                    </div>
                </div>
                <div class="row  mb-3 subject-card">

                    @if (!empty($subjectCounts) && is_array($subjectCounts))
                        @php $count = 0; @endphp
                        @foreach ($subjectCounts as $subject => $counts)
                        @php
                        $color = '#3c90f0';
                        $icons = asset('assets/images/englishliterature.svg');
                        if ($subject == 'Math') {
                            $color = 'rgba(171, 255, 0, 1)';
                            $icons = asset('assets/images/maths.svg');
                        }
                        elseif ($subject == 'English') {
                            $color = '#3c90f0';
                            $icons = asset('assets/images/englishliterature.svg');
                        }

                        elseif ($subject == 'physics') {
                            $color = 'rgba(171, 255, 0, 1)';
                            $icons = asset('assets/images/physics (1).svg');
                        }
                        elseif ($subject == 'Data Structures') {
                            $color = '#3c90f0';
                            $icons = asset('assets/images/subicon3.png');
                        }
                        elseif ($subject == 'Biology') {
                            $color = 'rgba(171, 255, 0, 1)';
                            $icons = asset('assets/images/chemistry (1).svg');
                        }
                        elseif ($subject == 'Statistics') {
                            $color = '#3c90f0';
                            $icons = asset('assets/images/subicon5.png');
                        }
                        elseif ($subject == 'Chemistry') {
                            $color = 'rgba(171, 255, 0, 1)';
                            $icons = asset('assets/images/geography.svg');
                        }
                        elseif ($subject == 'History') {
                            $color = 'rgba(171, 255, 0, 1)';
                            $icons = asset('assets/images/geography.svg');
                        }
                        elseif ($subject == 'Psychology') {
                            $color = '#3c90f0';
                            $icons = asset('assets/images/subicon2.png');
                        }
                    @endphp

                            @if ($count++ <= 8)
                               <a href="{{ url('find-tutor').'?subject='.$subject }}" class="col-6 col-lg-4 mb-3 px-1 px-md-3 text-decoration-none">
                                    <div class=" card subj-card text-center py-3 d-flex flex-column justify-content-center gap-3"
                                        style="border: 2px solid rgb(226, 226, 226); border-radius: 35px; max-height: 100%;min-height: 238px; background-color: {{ $color }};color: white">
                                        <div class="subj-card-icon">
                                            <img src="{{ $icons }}" style="width: 80px; height:80px;" alt="">
                                        </div>
                                       <div>
                                        <h4 class="card-title">{{ $subject }}</h4>
                                        <p class="mb-0 card-text ">{{ $counts['tutors'] }} Tutors Available</p>
                                        <!--<p class="mb-0 card-text">{{ $counts['students'] }} Students</p>-->
                                       </div>
                                    </div>
                                </a>
                                {{-- @elseif($count > 8)
                        <div class="col-6 col-lg-3 mb-3 px-1 px-md-3" id="hidden-content" style="display: none;">
                            <div class="subj-card text-center py-3"
                            style="border: 2px solid rgb(226, 226, 226); border-radius: 35px;">
                            <div class="subj-card-icon">
                                @if ($subject == 'Math')
                                    <img src="./assets/images/mathematics 1.svg" alt="" srcset="">
                                @elseif ($subject == 'English')
                                    <img src="./assets/images/mathematics 1.svg" alt="" srcset="">
                                @elseif ($subject == 'Math')
                                    <img src="./assets/images/mathematics 1.svg" alt="" srcset="">
                                @else
                                    <img src="./assets/images/mathematics 1.svg" alt="" srcset="">
                                @endif
                            </div>
                            <h4>{{ $subject }}</h4>
                            <p class="mb-0">{{ $counts['tutors'] }} Tutors Available</p>
                            <!--<p class="mb-0">{{ $counts['students'] }} Students</p>-->
                        </div>
                        </div> --}}
                            @endif
                        @endforeach
                    @endif
                </div>
                {{-- <div class="row mt-3">
                    <div class="col-12 text-center">
                        <a href="javascript:void(0);" id="find-tutor" onclick="showMoreSubjects()">More Subjects</a>
                    </div>
                </div> --}}
            </div>
        </div>
            <div class="row justify-content-center">
            <div class="col-12 col-md-10 ">
                <div class="row mb-5">
                    <div class="col-12 text-center">
                        <h1 class="fa-3x fw-bold subject-title" id="text-color">Languages</h1>
                    </div>
                </div>
                <div class="row justify-content--md-center mb-3 subject-card">
                    <div class="col-6 col-lg-3 mb-3 px-1 px-md-3">
                        <div class="card subj-card text-center py-3 "
                            style="border: 2px solid rgb(226, 226, 226); border-radius: 35px; max-height: 100%;background-color:#3c90f0 ;color: white;">
                            <div class="subj-card-icon">
                                <img src="{{ asset('assets/images/german.svg') }}" style="width: 100px; height:100px;" alt="" srcset="">
                            </div>
                            <h4 class="card-title">German</h4>
                            <p class="mb-0 card-text"> Tutors Available</p>
                            <p class="mb-0 card-text"> Students</p>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3 mb-3 px-1 px-md-3">
                        <div class=" card subj-card text-center py-3 "
                            style="border: 2px solid rgb(226, 226, 226); border-radius: 35px; max-height: 100%;background-color: rgba(171, 255, 0, 1);color: white;">
                            <div class="subj-card-icon">
                                <img src="{{ asset('assets/images/subicon4.png') }}" style="width: 100px; height:100px;" alt="" srcset="">
                            </div>
                            <h4 class="card-title">Spanish</h4>
                            <p class="mb-0 card-text"> Tutors Available</p>
                            <p class="mb-0 card-text"> Students</p>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3 mb-3 px-1 px-md-3">
                        <div class="card subj-card text-center py-3 "
                            style="border: 2px solid rgb(226, 226, 226); border-radius: 35px; max-height: 100%;background-color: #3c90f0;color: white;">
                            <div class="subj-card-icon">
                                <img src="{{ asset('assets/images/french.svg') }}" style="width: 100px; height:100px;" alt="" srcset="">
                            </div>
                            <h4 class="card-title">French</h4>
                            <p class="mb-0 card-text"> Tutors Available</p>
                            <p class="mb-0 card-text"> Students</p>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3 mb-3 px-1 px-md-3">
                        <div class="card subj-card text-center py-3 "
                            style="border: 2px solid rgb(226, 226, 226); border-radius: 35px; max-height: 100%;background-color: rgba(171, 255, 0, 1);color: white;">
                            <div class="subj-card-icon">
                                <img src="{{ asset('assets/images/subicon1.png') }}" style="width: 100px; height:100px;" alt="" srcset="">
                            </div>
                            <h4 class="card-title">Arabic</h4>
                            <p class="mb-0 card-text"> Tutors Available</p>
                            <p class="mb-0 card-text"> Students</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Subject & Lang end  -->

    <!-- Why choose us start  -->
    <div class="container-fluid choose-us">
        <div class=" circle-box circle-box-1 d-none d-md-block"></div>
        <div class=" circle-box circle-box-2 d-none d-md-block"></div>
        <div class=" circle-box circle-box-3 d-none d-md-block"></div>
        <div class="container">
            <div class="row choose-title my-4">
                <div class="col-12 text-center">
                    <h1 id="text-color">Why Choose Us?</h2>
                </div>
            </div>
            <!-- choose us card  -->
            <div class="row choose-card-sec">
                <div class="col-12 col-md-6 col-lg-3 my-3 d-flex justify-content-center">
                    <div
                        class="card choose-card-blue p-3 d-flex flex-column align-items-center text-center justify-content-center" style="width:20rem;">
                        <img src="{{ asset('assets/images/Layer_1.png') }}" alt="" style="width: 150px;height:120px;">
                        <h1 class="mb-0 pb-0 card-title">@isset($web_settings['card1_title']) {{ $web_settings['card1_title'] ?? '' }} @endisset</h1>
                        <hr class="w-75">
                        <div class=>
                            <p class="mb-0 card-text">@isset($web_settings['card1_desc']) {{$web_settings['card1_desc'] ?? '' }} @endisset  </p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3 my-3 d-flex justify-content-center">
                    <div
                        class="card  choose-card-green p-3 d-flex flex-column align-items-center text-center justify-content-center"style="width:20rem;">
                        <img src="{{ asset('assets/images/verified 1.png') }}" alt="" style="width: 120px;height:120px;">
                        <h1 class="mb-0 pb-0 card-title">@isset($web_settings['card2_title']) {{ $web_settings['card2_title'] ?? '' }} @endisset</h1>
                        <hr class="w-75">
                        <div class=>
                            <p class="mb-0 card-text">@isset($web_settings['card2_desc']) {{$web_settings['card2_desc'] ?? '' }} @endisset</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3 my-3 d-flex justify-content-center">
                    <div
                        class="card  choose-card-blue p-3 d-flex flex-column align-items-center text-center justify-content-center"style="width:20rem;">
                        <img src="{{ asset('assets/images/Layer_1 (1).png') }}" alt="" style="width: 120px;height:120px;">
                        <h1 class="mb-0 pb-0 card-title">@isset($web_settings['card3_title']) {{ $web_settings['card3_title'] ?? '' }} @endisset</h1>
                        <hr class="w-75">
                        <div class=>
                            <p class="mb-0 card-text">@isset($web_settings['card3_desc']) {{$web_settings['card3_desc'] ?? '' }} @endisset </p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3 my-3 d-flex justify-content-center">
                    <div
                        class="card choose-card-green p-3 d-flex flex-column align-items-center text-center justify-content-center"style="width:20rem;">
                        <img src="{{ asset('assets/images/online-learning 2.png') }}" alt="" style="width: 120px;height:120px;">
                        <h1 class="mb-0 pb-0 card-title">@isset($web_settings['card4_title']) {{ $web_settings['card4_title'] ?? '' }} @endisset <br>
                            </h1>
                        <hr class="w-75 ">
                        <div class=>
                            <p class="mb-0 card-text">@isset($web_settings['card4_desc']) {{$web_settings['card4_desc'] ?? '' }} @endisset </p>
                        </div>
                    </div>
                </div>
                {{-- {!! $Page->home_why_choose !!} --}}
            </div>
        </div>
    </div>
    <!-- Why choose us end  -->

    <!-- Review Section  -->
    <div class="container-fluid py-5">
        <div class="row mb-2 py-md-5" id="review-section-head">
            <div class="col-12 text-center">
                <h1 class="review-link" id="text-color">4.5/5 Review
                    <a href=""><img src="{{ asset ('assets/images/Vector-1.png') }}"
                            style="margin-top: -10px; margin-right: 5px;" alt="" srcset=""
                            width="35px">Trustpilot</a>
                </h1>

            </div>
        </div>
        <div class="row py-3 justify-content-center">
            <div class="col-xl-8 col-md-10 col-12 text-center ">

                <div class="card-center">
                    <div>
                        <div class="card text-center review-card mx-auto" style="width: 16rem;">
                            <div class="card-img-top px-4 pt-3 review-card mx-auto">
                                <p style="font-size: 15px;">The institute boasts an impressive roster of tutors who are not
                                    only experts
                                    in
                                    their respective fields but also skilled in online.
                                </p>
                                <div class="card-img-div">
                                    <img src="{{ asset('assets/images/Vector-1.png') }}" class="mx-auto" alt="...">
                                </div>
                            </div>
                            <div class="card-body">
                                <img src="{{ asset('assets/images/stars-steps.svg') }}" alt="" srcset=""
                                    class="mx-auto">
                                <p class="mb-0 mt-2">Mr John </p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="card text-center review-card mx-auto" style="width: 16rem;">
                            <div class="card-img-top px-4 pt-3 review-card mx-auto">
                                <p style="font-size: 15px;">Flexible Scheduling: As a student with a busy schedule, I
                                    appreciate the flexibility [ Tutor 24/7 ] provides when it comes to scheduling sessions.
                                </p>
                                <div class="card-img-div">
                                    <img src="{{ asset('assets/images/Vector-1.png') }}" class="mx-auto" alt="...">
                                </div>
                            </div>
                            <div class="card-body ">
                                <img src="{{ asset('assets/images/stars-steps.svg') }}" alt="" srcset="" class="mx-auto">
                                <p class="mb-0 mt-2">Miss Wick </p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="card text-center review-card mx-auto" style="width: 16rem;">
                            <div class="card-img-top px-4 pt-3 review-card mx-auto">
                                <p style="font-size: 15px;">Lorem ipsum dolor sit amet. Est magni cupiditate ad laboriosam
                                    vitae a dicta nisi qui corrupti laborum non repellat molestiae.
                                </p>
                                <div class="card-img-div">
                                    <img src="{{ asset('assets/images/Vector-1.png') }}" class="mx-auto" alt="...">
                                </div>
                            </div>
                            <div class="card-body">
                                <img src="{{ asset('assets/images/stars-steps.svg') }}" alt="" srcset=""
                                    class="mx-auto">
                                <p class="mb-0 mt-2">Jae Hopkins</p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="card text-center review-card mx-auto" style="width: 16rem;">
                            <div class="card-img-top px-4 pt-3 review-card mx-auto">
                                <p style="font-size: 15px;">Lorem ipsum dolor sit amet. Est magni cupiditate ad laboriosam
                                    vitae a dicta nisi qui corrupti laborum non repellat molestiae.
                                </p>
                                <div class="card-img-div">
                                    <img src="{{ asset('assets/images/Vector-1.png') }}" class="mx-auto" alt="...">
                                </div>
                            </div>
                            <div class="card-body">
                                <img src="{{ asset('assets/images/stars-steps.svg')}}" alt="" srcset=""
                                    class="mx-auto">
                                <p class="mb-0 mt-2">Mick Dobins</p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="card text-center review-card mx-auto" style="width: 16rem;">
                            <div class="card-img-top px-4 pt-3 review-card mx-auto">
                                <p style="font-size: 15px;">The institute boasts an impressive roster of tutors who are not
                                    only experts
                                    in
                                    their respective fields but also skilled in online.
                                </p>
                                <div class="card-img-div">
                                    <img src="{{ asset('assets/images/Vector-1.png') }}" class="mx-auto" alt="...">
                                </div>
                            </div>
                            <div class="card-body ">
                                <img src="{{ asset('assets/images/stars-steps.svg')}}" alt="" srcset=""
                                    class="mx-auto">
                                <p class="mb-0 mt-2">Mr John </p>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="card text-center review-card mx-auto" style="width: 16rem;">
                            <div class="card-img-top px-4 pt-3 review-card mx-auto">
                                <p style="font-size: 15px;">The institute boasts an impressive roster of tutors who are not
                                    only experts
                                    in
                                    their respective fields but also skilled in online.
                                </p>
                                <div class="card-img-div">
                                    <img src="{{ asset('assets/images/Vector-1.png') }}" class="mx-auto" alt="...">
                                </div>
                            </div>
                            <div class="card-body">
                                <img src="{{ asset('assets/images/stars-steps.svg')}}" alt="" srcset=""
                                    class="mx-auto">
                                <p class="mb-0 mt-2">Mr John </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Review Section end  -->

    <!-- Find tutor section -->
    <div class="container-fluid px-0" style="position: relative;overflow: hidden;">
        <div class="ellipse"></div>
        <div class="container text-center py-5 mb-5">
            <h3 class="fa-2x fw-bold pb-4" id="text-color">Book a free meeting with a tutor today</h3>
            <a href="{{ route ('findTutor') }}" id="find-tutor">Find a Tutor</a>
        </div>
        <div class="pt-4 mt-5">
            <nav class="navbar navbar-expand" id="btn-bg">
                <div class="container-fluid">
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav w-100 justify-content-around flex-wrap " id="subject">
                            @if (!empty($Subjects))
                                @foreach ($Subjects as $Subject)
                                        <li class="nav-item text-capitalize subhover">
                                            <a class="nav-link" aria-current="page"
                                                href="{{ url('find-tutor').'?subject='.$Subject }}">{{ $Subject }}</a>
                                        </li>
                                @endforeach
                            @endif

                        </ul>
                    </div>
                </div>
            </nav>

        </div>
    </div>
    <!-- Find tutor section end-->
    <script>
        function showMoreSubjects() {
            var hiddenContent = document.getElementById("hidden-content");
            var findTutorLink = document.getElementById("find-tutor");

            if (hiddenContent.style.display === "none") {
                hiddenContent.style.display = "block";
                findTutorLink.innerText = "Show Less";
            } else {
                hiddenContent.style.display = "none";
                findTutorLink.innerText = "More Subjects";
            }
        }
    </script>

            {{-- <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/botman-web-widget@0/build/assets/css/chat.min.css"> --}}
            <script>
                var botmanWidget = {
                    aboutText: '247Tutors',
                    title:'Chat Support',
                    icon: 'd',
                    mainColor:'#0096FF',
                    bubbleBackground:'#0096FF',
                    introMessage: "✋ Hi! I'm from 247tutors.com"
                };
                setTimeout(function() {
        document.getElementById('avatar').classList.add('tilt-animation');
    }, 120000); // 120,000 milliseconds = 120 seconds = 1 minute
               </script>

               <script src='https://cdn.jsdelivr.net/npm/botman-web-widget@0/build/js/widget.js'></script>


@endsection
