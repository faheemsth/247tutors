@extends('pages.dashboard.appstudent')
<!-- Slick slider CSS  -->
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

    <div class="container-fluid">
        <div class="container">
            <div class="row my-5">
                <div class="col-12 col-md-7 col-lg-8 arman-d">

                    <div class="mt-3 arman">

                        <div class="row">

                            <div class="col-12 col-md-4 profile-img d-flex justify-content-lg-center">
                                @if (!empty(Auth::user()->image) && file_exists(public_path(Auth::user()->image)))
                                    <img src="{{ asset(Auth::user()->image) }}" alt="" style="    width: 180px;
    height: 180px;
    border-radius: 50%;" >
                                @else
                                    @if(Auth::user()->gender == 'Male')
                                        <img src="{{ asset('assets/images/male.jpg') }}" style="    width: 180px;
    height: 180px;
    border-radius: 50%;">
                                    @elseif(Auth::user()->gender == 'Female')
                                        <img src="{{ asset('assets/images/female.jpg') }}" style="    width: 180px;
    height: 180px;
    border-radius: 50%;">
                                    @else
                                        <img src="{{ asset('assets/images/default.png') }}" style="    width: 180px;
    height: 180px;
    border-radius: 50%;">
                                    @endif
                                @endif
                            </div>
                            <div class="col-12 col-lg-8 ps-lg-0 mt-1 ms-2 ms-md-0">
                                <div class="d-flex justify-content-between mt-lg-4 hr align-items-center">

                                    <h4>{{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}
                                    @if (Auth::user()->status == "Active")
                                    <img src="./assets/images/Verified-p.png" alt="">
                                    @endif

                                    </h4>

                                    <!--<h5>£25 /hr</h5>-->

                                </div>
                                <div class="Spreading">
                                    <h6 style="font-weight: 500;color:#3d3d3d;">{{ Auth::user()->facebook_link }}</h6>
                                </div>

                            @php
                                $updateType=App\Models\TutorApplication::where('tutor_id',Auth::id())->first();
                            @endphp
                            <div class="mt-md-3 mt-lg-5">
                                <a class="one alert alert-{{ Auth::user()->status == 'Active' ? 'success' : 'danger' }}"
                                    href="">{{ Auth::user()->status }}</a>
                                <a class="two" href="">
                                    @if (!empty($updateType) && $updateType->tutor_type == 1)
                                     Online
                                    @elseif (!empty($updateType) && $updateType->tutor_type == 2)
                                    In Person
                                    @else
                                    Both
                                    @endif
                                </a>
                            </div>
                            </div>





                            <div class="row">
                                <div class="col-md-4 d-none d-lg-inline-block"></div>
                                <div class="col-md-8 d-flex justify-content-between align-items-center book mt-3 ms-3 ms-md-0">
                                    <p><img src="./assets/images/heart.png" alt=""> Saved</p>
                                    {{-- <a href="" style="text-decoration: none;color: black;"><h5>Book a Tutor</h5></a> --}}
                                </div>

                            </div>




                        </div>


                        <div class="mt-2 mb-5">
                            <h3>About me:</h3>
                            {{-- <p>Hi! My name is {{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}.
                               </p> --}}
                            <p>

                                {{ Auth::user()->profile_description }}
                            </p>
                        </div>
                        
                        
                        
                        
                        
                        @if(Auth::user()->complaint_stage == 'Personal inform' && Auth::user()->id == Auth::id())
                        <div class=" py-3 mb-3  alert-danger">
                            <h3 class="mx-md-5 mx-2 fw-bold text-dark">Warning by 24/7 Tutor</h3>
                            <h6 class="mx-md-5 mx-2">{{Auth::user()->complaint_stage}}</h6>
                            <p class="mx-md-5 mb-0 mx-2">{{Auth::user()->complaint_message}}</p>
                            
                            <p class="mx-md-5 mb-0 mx-2">{{Carbon\Carbon::parse(Auth::user()->updated_at)->diffForHumans()}}</p>

                        </div>
                        @endif
                        
                        
                        @if(Auth::user()->complaint_stage == 'Disclaimer')
                        <div class="personally py-3 mb-3 alert alert-danger">
                            <h3 class="mx-md-4 mx-2">Warning by 24/7 Tutor</h3>
                            <h6 class="mx-md-5 mx-2">{{Auth::user()->complaint_stage}}</h6>
                            <p class="mx-md-5 mb-0 mx-2">{{Auth::user()->complaint_message}}</p>
                            
                            <p class="mx-md-5 mb-0 mx-2">{{Carbon\Carbon::parse(Auth::user()->updated_at)->diffForHumans()}}</p>

                        </div>
                        @endif
                        
                        
                        @if(Auth::user()->complaint_stage == 'Blocked')
                        <div class="personally py-3 mb-3 bg-danger">
                            <h3 class="mx-5 mx-2">Warning by 24/7 Tutor</h3>
                            <h6 class="mx-md-5 mx-2">{{Auth::user()->complaint_stage}}</h6>
                            <p class="mx-md-5 mb-0 mx-2">{{Auth::user()->complaint_message}}</p>
                            
                            <p class="mx-md-5 mb-0 mx-2">{{Carbon\Carbon::parse(Auth::user()->updated_at)->diffForHumans()}}</p>

                        </div>
                        @endif
                        

                        <div class="personally py-4">


                            <h3 class="mx-md-5 mx-2">Personally interviewed by 24/7 Tutor</h3>
                            <p class="mx-md-5 mx-2 mb-0">Lorem ipsum dolor sit amet. Est magni cupiditate ad laboriosam vitae a dicta
                                nisi qui
                                corrupti laborum non repellat molestiae. Sit eaque quam cum itaque dolores vel culpa
                                maiores. Aut
                                architecto earum ut quidem assumenda ad dicta harum aut voluptatem iure qui consequuntur
                                nihil et
                                internos rerum eum velit eaque.</p>

                        </div>

                        <!-- Review Section  -->

                                    <?php 
                                    $StuReviews=App\Models\Booking::with('student')->where('tutor_id',Auth::id())->whereNotNull('student_rating')->get();
                                    $parentReviews=App\Models\Booking::with('parent')->where('tutor_id',Auth::id())->whereNotNull('parent_rating')->get();
                                    ?>
                                    
                    @if(!empty($StuReviews) && !empty($parentReviews))
                        <div class="container-fluid py-5 px-1">
                            <div class="row py-3 justify-content-center">
                                <div class="col-xl-12 col-md-10 col-12 text-center">
                                <!--student_rating-->
                                    <div class="card-center">
                                     @if(!empty($StuReviews))
                                      @foreach($StuReviews as $Review)
                                      @if(!empty(App\Models\User::find($Review->student_id)))
                                        <div>
                                            <div class="card text-center review-card mx-auto" style="width: 16rem;">
                                                <div class="card-img-top px-4 pt-3 review-card mx-auto">
                                                    <p style="font-size: 15px;">
                                                        {{$Review->student_feedback}}
                                                        </p>
                                                    <div class="card-img-div text-center">
                                                @if (!empty(App\Models\User::find($Review->student_id)->image) && file_exists(public_path(!empty(App\Models\User::find($Review->student_id)->image) ? App\Models\User::find($Review->student_id)->image : '')))
                                                    <img src="{{ $Review->image }}" alt=""
                                                        class="mx-auto">
                                                @else
                                                    @if ($Review->gender == 'Male')
                                                        <img src="{{ asset('assets/images/male.jpg') }}" alt=""
                                                            class="mx-auto">
                                                    @elseif($Review->gender == 'Female')
                                                        <img src="{{ asset('assets/images/female.jpg') }}" alt=""
                                                            class="mx-auto">
                                                    @else
                                                        <img src="{{ asset('assets/images/default.png') }}"
                                                            alt=""
                                                            class="mx-auto">
                                                    @endif
                                                @endif
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                   @for ($i=0;$i < $Review->tutor_rating ;$i++)
                                                    <i class="fa fa-star" style="color: yellow"></i>
                                                   @endfor
                                                    <p class="mb-0 mt-2">{{ optional(App\Models\User::find($Review->student_id))->first_name . ' '.optional(App\Models\User::find($Review->student_id))->last_name }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                       @endforeach
                                      @endif
                                      
                                      @if(!empty($parentReviews))
                                      @foreach($parentReviews as $Review)
                                       @if(!empty(App\Models\User::find($Review->parent_id)))
                                        <div>
                                            <div class="card text-center review-card mx-auto" style="width: 16rem;">
                                                <div class="card-img-top px-4 pt-3 review-card mx-auto">
                                                    <p style="font-size: 15px;">
                                                        {{$Review->parent_feedback}}
                                                        </p>
                                                    <div class="card-img-div text-center">
                                                @if (!empty(App\Models\User::find($Review->parent_id)->image) && file_exists(public_path(!empty(App\Models\User::find($Review->parent_id)->image) ? App\Models\User::find($Review->parent_id)->image : '')))
                                                    <img src="{{ $Review->mage }}" alt=""
                                                        class="mx-auto">
                                                @else
                                                    @if ($Review->gender == 'Male')
                                                        <img src="{{ asset('assets/images/male.jpg') }}" alt=""
                                                            class="mx-auto">
                                                    @elseif($Review->gender == 'Female')
                                                        <img src="{{ asset('assets/images/female.jpg') }}" alt=""
                                                            class="mx-auto">
                                                    @else
                                                        <img src="{{ asset('assets/images/default.png') }}"
                                                            alt=""
                                                            class="mx-auto">
                                                    @endif
                                                @endif
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                   @for ($i=0;$i < $Review->parent_rating ;$i++)
                                                    <i class="fa fa-star" style="color: yellow"></i>
                                                   @endfor
                                                    <p class="mb-0 mt-2">{{ optional(App\Models\User::find($Review->parent_id))->first_name . ' '.optional(App\Models\User::find($Review->parent_id))->last_name }}</p>
                                                </div>
                                            </div>
                                        </div>
                                         @endif
                                       @endforeach
                                      @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                     @endif








                        {{-- <link rel="stylesheet" href="{{ asset('vendor/slick/slick-style.css') }}">
                        <script src="{{ asset('vendor/jquery/jquery3.7.0.js') }}"></script>
                        <script src="{{ asset('vendor/slick/slick-slide.js') }}"></script> --}}


                        <!-- Review Section end  -->

                        <div class=" mt-5">
                            <h3>Qualifications</h3>

                            <div class="custom-table">
                                <table class="table table-bordered border-dark mt-4 custom-table">
                                <thead class="qualification">
                                    <tr>

                                        <th scope="col">Degree Title</th>
                                        <th scope="col">Institute</th>
                                        <th scope="col">Grade</th>
                                        <th scope="col">Type</th>
                                        <th scope="col">Completed Date</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @if (!empty($TutorQualifications))
                                        @foreach ($TutorQualifications as $subject)
                                            <tr>
                                                <td>{{ $subject->degree_title }}</td>
                                                <td>{{ $subject->institute }}</td>

                                                @php
                                                    $grade = '--';
                                                    if ($subject->grade) {
                                                        if ($subject->grade == 1) {
                                                            $grade = 'A+';
                                                        } elseif ($subject->grade == 2) {
                                                            $grade = 'B+';
                                                        } else {
                                                            $grade = 'C+';
                                                        }
                                                    }
                                                @endphp
                                                <td>{{ $grade }}</td>
                                                <td>{{ $subject->type }}</td>
                                                <td>{{ $subject->degree_completed }}</td>


                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                            </div>
                        </div>

                        <div class="avail">
                            <h3>General Availability</h3>
                            <table class="table table-bordered border-dark mt-4 ">
                                <thead class="qualification">
                                    <tr class="thh">

                                        <th class="col" scope="col"></th>
                                        <th scope="col">Mon</th>
                                        <th scope="col">Tue</th>
                                        <th scope="col">Wed</th>
                                        <th scope="col">Thu</th>
                                        <th scope="col">Fri</th>
                                        <th scope="col">Sat</th>
                                        <th scope="col">Sun</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($availabilitys)
                                        @foreach ($availabilitys as $availability)
                                            @php $days = explode(',', $availability->day_of_the_week); @endphp
                                            <tr>
                                                <td class="tdd">
                                                    @if ($availability->schedule_time == 'Morning')
                                                        <img src="/assets/images/11111.png" alt="Morning">Morning
                                                    @elseif ($availability->schedule_time == 'Afternoon')
                                                        <img src="/assets/images/sunny 1.png" alt="Afternoon">Afternoon
                                                    @elseif ($availability->schedule_time == 'Evening')
                                                        <img src="/assets/images/sunrise 1.png" alt="Evening">Evening
                                                    @endif
                                                </td>

                                                @for ($i = 1; $i <= 7; $i++)
                                                    <td class="text-end">
                                                        @if (in_array($i, $days))
                                                            <img src="{{ asset('assets/images/Vector (3).png') }}"
                                                                alt="" data-days="{{ $i }}">
                                                        @endif
                                                    </td>
                                                @endfor
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>

                        <div>
                            <h3>Subject Offered</h3>

                            <table class="table table-bordered border-dark mt-4">
                                <thead class="qualification">
                                    <tr>
                                        <th scope="col">Subject</th>
                                        <th scope="col">Qualification</th>
                                        <th scope="col">Fee Per Hour</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (!empty($tutorsubjectoffers))
                                        @foreach ($tutorsubjectoffers as $tutorsubjectoffer)
                                            <tr>
                                                <td>{{ !empty($tutorsubjectoffer->subject) ? $tutorsubjectoffer->subject->name : '' }}
                                                </td>
                                                <td>{{ !empty($tutorsubjectoffer->levelstring) ? $tutorsubjectoffer->levelstring : $tutorsubjectoffer->levelstring }}
                                                </td>
                                                <td>£{{ $tutorsubjectoffer->fee }}/hr</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>

                            </table>
                        </div>

                    </div>





                </div>
                <div class="col-md-5 col-lg-4 mt-5 mt-md-0">

                    <div class="row">
                        <div
                            class="col-md-12 chat justify-content-center text-center d-flex align-items-center flex-column">

                            <img src="/assets/images/chat 1.png" alt="">
                            <h5>Let’s Chat with Admin</h5>
                            <p>Have a Chat with Admin and see how ( and when!) they can Help</p>
                            <a href="mailto:hello@247tutors.co.uk">Let's Chat</a>

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 more mt-2 ">
                            <ul class="ps-0 ps-md-5">
                                @if(!empty($AllSubjects))
                                   @foreach($AllSubjects as $AllSubject)
                                   <li><a href="{{ url('find-tutor?subject=') . $AllSubject }}">More {{$AllSubject}} Tutor</a></li>
                                   @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('vendor/jquery/jquery3.7.0.js') }}"></script>



    <script>
        $(document).ready(function() {

            $('.card-center').slick({
                infinite: true,
                slidesToShow: 2,
                slidesToScroll: 1,
                autoplay: true,
                arrows: false,
                responsive: [{
                        breakpoint: 825,
                        settings: {
                            infinite: true,
                            slidesToShow: 1,
                            slidesToScroll: 1,
                            autoplay: true,
                            arrows: false,
                        }
                    },
                    {
                        breakpoint: 1026,
                        settings: {
                            infinite: true,
                            slidesToShow: 1,
                            slidesToScroll: 1,
                            autoplay: true,
                            arrows: false,
                        }
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            infinite: true,
                            slidesToShow: 1,
                            slidesToScroll: 1,
                            autoplay: true,
                            arrows: false,
                        }
                    }
                ]
            });
        })
    </script>
@endsection
