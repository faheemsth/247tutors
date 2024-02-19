@extends('pages.dashboard.appstudent')
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
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/appointment-slot-picker@1.2.8/css/appointment-picker.css">

    <script src="{{ asset('js/jsdelivrcore.js') }}"></script>
    <script src="{{ asset('js/jsdelivr.js') }}"></script>
    <style>
    .btnpay:hover{
    color:white !important;
    }
        .btnpay{
           background: linear-gradient(93.86deg, #87c607 9.41%, #0096ff 98.3%);
    font-size: 18px;
    color: white;
    border: none;
        }
        .labpay{
            font-size:20px;
            font-weight:600;
            
        }
    </style>
    
    <div class="container-fluid">
        <div class="container">
            <div class="row">
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
            </div>
            <div class="row my-5">

                <div class="col-12 col-md-7 col-lg-8 arman-d">

                    <div class="mt-3 arman">

                        <div class="row">

                            <div class="col-12 col-lg-4 profile-img d-flex justify-content-lg-center  ">
                                @if (!empty($tutor->image) && file_exists(public_path(!empty($tutor) ? $tutor->image : '')))
                                    <img src="{{ asset($tutor->image) }}" alt=""
                                        style="height:180px;width:180px;" class="rounded-3">
                                @else
                                    @if ($tutor->gender == 'Male')
                                        <img src="{{ asset('assets/images/male.jpg') }}"
                                            style="height:180px;width:180px;" alt=""
                                            class="rounded-3">
                                    @elseif($tutor->gender == 'Female')
                                        <img src="{{ asset('assets/images/female.jpg') }}"
                                            style="height:180px;width:180px;" alt=""
                                            class="rounded-3">
                                    @else
                                        <img src="{{ asset('assets/images/default.png') }}"
                                            style="height:180px;width:180px;" alt=""
                                            class="rounded-3">
                                    @endif
                                @endif
                            </div>
                            <div class="col-12 col-lg-8 ps-lg-0 mt-1 ms-2 ms-md-0">
                                <div class="d-flex justify-content-between mt-lg-4 hr align-items-center">

                                    <h4 class="text-capitalize">{{ $tutor->username }}<img
                                            src="{{ asset('assets/images/Verified-p.png') }}" alt=""></h4>
                                </div>
                                <div class="Spreading">
                                    <h6 style="font-weight: 500;color:#3d3d3d;">{{ $tutor->facebook_link }}</h6>

                                </div>

                                @php
                                    $updateType = App\Models\TutorApplication::where('tutor_id', $tutor->id)->first();
                                @endphp
                                <div class="mt-md-3 mt-lg-5">
                                    <a class="one alert alert-{{ $tutor->status == 'Active' ? 'success' : 'danger' }}"
                                        href="">{{ $tutor->status }}</a>
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
                            <div class="row justify-content-lg-end">
                                <div class="col-md-4 d-none d-lg-inline-block"></div>
                                <div class="mx-md-3 col-md-8 d-flex gap-1 justify-content-xl-end  align-items-center book mt-3  px-md-0">
                                    <div class="col-xl-2 col-lg-2 col-auto">
                                        <a class=" d-none d-md-block" href="{{ url('likeDislike?tutor=') . $tutor->id }}"
                                            style="text-decoration: none;color: inherit;">
                                            @php
                                                $action = App\Models\LikeDislike::where('to_user_id', $tutor->id)
                                                    ->where('from_user_id', Auth::id())
                                                    ->first();
                                            @endphp
                                            @if (!empty($action) && $action->action == '1')
                                                <span class="text-danger">❤</span>
                                            @else
                                                <span class="text-default">❤</span>
                                            @endif
                                            Saved
                                        </a>
                                    </div>
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    <div class="col-xl-4 col-lg-5 col-auto">

                                        @if (Auth::check())


                                            @php
                                                $check = App\Models\Booking::where('lessons_schedule', 'Demo Lesson')
                                                    ->where('tutor_id', $tutor->id)
                                                    ->first();
                                            @endphp

                                            @if (empty($check))
                                                @if (CheckAgeUnder16() && Auth::user()->role_id == 4)
                                                    <a onclick="freeMeetmodal()"
                                                        style="text-decoration: none;color: black;cursor:pointer">
                                                        <h5>Book free meeting</h5>
                                                    </a>
                                                @elseif(Auth::user()->role_id == 5)
                                                    <a onclick="freeMeetmodal()"
                                                        style="text-decoration: none;color: black;cursor:pointer">
                                                        <h5>Book free meeting</h5>
                                                    </a>
                                                @endif
                                            @else
                                            <a style="text-decoration: none;color:#000000b8;">
                                                        <h5 style="background-color:#abff00a3">Book free meeting</h5>
                                            </a>
                                            @endif
                                        @else
                                            <a href="{{ url('login') }}"
                                                style="text-decoration: none;color: black;cursor:pointer">
                                                <h5>Book free meeting</h5>
                                            </a>
                                        @endif
                                    </div>
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    <!--<div class="col-xl-4 col-lg-4 col-auto ">-->
                                    <!--    @if (Auth::check())-->
                                    <!--        @if (CheckAgeUnder16() && Auth::user()->role_id == 4)-->
                                    <!--            <a href="{{ url('tutor/book') . '/' . $tutor->id }}"-->
                                    <!--                style="text-decoration: none;color: black;">-->
                                    <!--                <h5>Book lessons</h5>-->
                                    <!--            </a>-->
                                    <!--        @elseif(Auth::user()->role_id == 5)-->
                                    <!--            <a href="{{ url('tutor/book') . '/' . $tutor->id }}"-->
                                    <!--                style="text-decoration: none;color: black;">-->
                                    <!--                <h5>Book lessons</h5>-->
                                    <!--            </a>-->
                                    <!--        @endif-->
                                    <!--    @endif-->
                                    <!--</div>-->
                                    
                                    
                                    
                                    
                                    <div class="col-xl-4 col-lg-4 col-auto ">
                                        @if (Auth::check())
                                            @if (CheckAgeUnder16() && Auth::user()->role_id == 4)
                                                <a href="javascript::void(0)" onclick="BooTypemodal('{{ $tutor->id}}')"
                                                    style="text-decoration: none;color: black;">
                                                    <h5>Book lessons</h5>
                                                </a>
                                            @elseif(Auth::user()->role_id == 5)
                                                <a href="javascript::void(0)" onclick="BooTypemodal('{{ $tutor->id}}')"
                                                    style="text-decoration: none;color: black;">
                                                    <h5>Book lessons</h5>
                                                </a>
                                            @endif
                                        @endif
                                    </div>
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                </div>
                            </div>
                        </div>
                        <div class="mt-5 ">
                            <h3 style="color:#4FB5FF" class="headline">About</h3>
                            {{-- <p>Hi! My name is {{ $tutor->first_name . ' ' . $tutor->last_name }} and I'm
                                currently a pre-medical student.</p>
                            <p> --}}

                            {{ $tutor->profile_description }}
                            </p>
                        </div>
                        
                        @if($tutor->complaint_stage == 'Personal inform' && $tutor->id == Auth::id())
                        <div class="personally py-4 mb-3 bg-warning">
                            <h3 class="mx-5">Warning by 24/7 Tutor</h3>
                            <h6 class="mx-5">{{$tutor->complaint_stage}}</h6>
                            <p class="mx-5">{{$tutor->complaint_message}}</p>
                            
                            <p class="mx-5">{{Carbon\Carbon::parse($tutor->updated_at)->diffForHumans()}}</p>

                        </div>
                        @endif
                        
                        
                        @if($tutor->complaint_stage == 'Disclaimer')
                        <div class="personally py-4 mb-3 bg-warning">
                            <h3 class="mx-5">Warning by 24/7 Tutor</h3>
                            <h6 class="mx-5">{{$tutor->complaint_stage}}</h6>
                            <p class="mx-5">{{$tutor->complaint_message}}</p>
                            
                            <p class="mx-5">{{Carbon\Carbon::parse($tutor->updated_at)->diffForHumans()}}</p>

                        </div>
                        @endif
                        
                        
                        @if($tutor->complaint_stage == 'Blocked')
                        <div class="personally py-4 mb-3 bg-warning">
                            <h3 class="mx-5">Warning by 24/7 Tutor</h3>
                            <h6 class="mx-5">{{$tutor->complaint_stage}}</h6>
                            <p class="mx-5">{{$tutor->complaint_message}}</p>
                            
                            <p class="mx-5">{{Carbon\Carbon::parse($tutor->updated_at)->diffForHumans()}}</p>

                        </div>
                        @endif
                        
                        
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


                        <div class="container-fluid py-5 px-1">
                            <div class="row py-3 justify-content-center">
                                <div class="col-xl-12 col-md-10 col-12 text-center">
                                    <?php 
                                    $StuReviews=App\Models\Booking::with('student')->where('tutor_id',$tutor->id)->whereNotNull('student_rating')->get();
                                    $parentReviews=App\Models\Booking::with('parent')->where('tutor_id',$tutor->id)->whereNotNull('parent_rating')->get();
                                    ?>

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
                        <!-- Review Section end  -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-md-6 quali">
                                        <h3 class="headline">Qualification</h3>
                                    </div>
                                    <div class="row pe-0">
                                        <div class="col-md-12  pe-0" style="overflow:scroll;">
                                            <table class="table table-bordered border-dark mt-4" >
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
                                                    @if ($TutorQualifications->count() > 0)
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
                                                         @else 
                                    <tr>
                                        <td colspan="5">No Record Found</td>
                                    </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class=" col-12 gen">
                                <h3 class="headline">General Availability</h3>
                                <div class="overflow-scroll">
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
                                            @if ($availabilitys->count() > 0)
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
                                                 @else 
                                    <tr>
                                        <td colspan="9">No Record Found</td>
                                    </tr>
                                            @endif
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            
                                <div class="col-md-6 quali">
                                        <h3 class="headline">Subject Offered</h3>
                                    </div>
                               <div class="row">
                                 <div class="col-md-12 " style="overflow:scroll;">
                           
                                <table class="table table-bordered border-dark mt-4">
                                    <thead class="qualification">
                                        <tr>
                                            <th scope="col">Subject</th>
                                            <th scope="col">Qualification</th>
                                            <th scope="col">Fee Per Hour</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($tutorsubjectoffers->count() > 0)
                                            @foreach ($tutorsubjectoffers as $tutorsubjectoffer)
                                                <tr>
                                                    <td>{{ optional($tutorsubjectoffer->subject)->name }}</td>

                                                    <td>{{ $tutorsubjectoffer->levelstring }}</td>
                                                    <td>£{{ $tutorsubjectoffer->fee }}/hr</td>
                                                </tr>
                                            @endforeach
                                             @else 
                                    <tr>
                                        <td colspan="3">No Record Found</td>
                                    </tr>
                                        @endif
                                    </tbody>

                                </table>
                            </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-md-5 col-lg-4 mt-5 mt-md-0">

                    <div class="row">
                        <div
                            class="col-md-12 chat justify-content-center text-center d-flex align-items-center flex-column">

                            <img src="/assets/images/chat 1.png" alt="">
                            <h5>Let’s Chat with 247tutor</h5>
                            <p>Have a Chat with 247tutor and see how (and when!) they can Help</p>
                            <a
                                href="mailto:@isset($web_settings['topbaremail']) {{ $web_settings['topbaremail'] ?? '' }} @endisset">Let's
                                Chat</a>

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






















    <div class="modal fade zoomIn" id="demo_meeting_modal" tabindex="-1" aria-labelledby="update_doc_modal"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0">
                <div class="modal-header p-3 bg-info-subtle">
                    <h5 class="modal-title" id="update_doc_modal_title"> Book free meeting</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        id="close-modal"></button>
                </div>
                <form class="tablelist-form" id="free_meet_form" enctype="multipart/form-data" autocomplete="off"
                    method="post" action="{{ route('book.free.lesson') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-lg-12">
                                <div>
                                    <label>Subject & Level</label><br>
                                    <select name="subject_id" id="subject_id" class="w-100 p-2">
                                        @if (!empty($tutorsubjectoffers))
                                            @foreach ($tutorsubjectoffers as $offersubject)
                                                <option value="{{ $offersubject->subject_id }}"
                                                    {{ $tutor->subject_id == $offersubject->subject_id ? 'selected' : '' }}
                                                    data-fee="{{ $offersubject->fee }}">
                                                    {{ optional($offersubject->subject)->name }}
                                                    - {{ $offersubject->levelstring }} - £{{ $offersubject->fee }}/hr
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div>
                                    <label>Who is the free meeting for?</label><br>
                                    <select name="student_id" id="student_id" class="w-100 p-2">
                                        @if (!empty($students))
                                            @foreach ($students as $student)
                                                <option value="{{ $student->id }}">
                                                    {{ $student->first_name . ' ' . $student->last_name }}</option>
                                            @endforeach
                                        @else
                                            @if (Auth::check())
                                                <option value="{{ Auth::user()->id }}">
                                                    {{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}</option>
                                            @endif
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <label class="text-secondary">Date</label><br>
                                <input type="date" name="date" id="date" class="w-100 p-2" required max="9999-12-31">
                            </div>
                            <input type="text" hidden name="tutor_id" value="{{ $tutor->id }}" class="w-100 p-2">

                            <div class="col-md-6">
                                <label class="text-secondary">Time</label><br>
                                <input type="text" id="time-1" name="time" class="w-100 p-2" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="hstack gap-2 justify-content-end">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success" id="add-btn">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    
    
    
        <div class="modal fade zoomIn" id="BooTypemodal" tabindex="-1" aria-labelledby="update_doc_modal"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0">
                <div class="modal-header p-3 bg-info-subtle"  id="text-color">
                    <h4 class="modal-title fw-bold" id="update_doc_modal_title">Choose Your Payment Gateway</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        id="close-modal"></button>
                </div>
                <div class="tablelist-form">
                    <div class="modal-body">
                        <div class="row justify-content-center">
                            <div class="col-10">
                                <img src="{{asset('assets/images/payment-methods-illustration-set-characters-260nw-2112350300.jpg')}}" class="img-fluid">
                            </div>
                        </div>
                        <div class="row mt-4  justify-content-around">
                            <div class="col-auto">
                                <label class="text-secondary d-flex gap-1 align-items-center labpay">
                                Credit  Card : 
                                    <div class="d-flex ms-1 gap-2 align-items-center">
              <i class="fa-brands fa-cc-visa" style="color:navy;"></i>
              <i class="fa-brands fa-cc-amex" style="color:blue;"></i>
              <i class="fa-brands  fa-cc-mastercard" style="color:red;"></i>
              <i class="fa-brands fa-cc-discover" style="color:orange;"></i>
            </div>
                                </label>
                                <div id="stripe" class="mt-1"></div>
                            </div>
                            <div class="col-auto">
                                <label class="text-secondary labpay">Our Wallet :</label>
                                <div id="wallet" class="mt-1"></div>
                            </div>
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
    <script src="{{ asset('js/timeslot.min.js') }}"></script>
    <script>
        let id = {!! json_encode($tutor->id) !!};

        var picker = '';
        let slots = '';
        $(document).ready(function() {

            var date = new Date().toISOString().slice(0, 10);
            $('#date').attr('min', date);

            $("#date").on("change", function() {
                var date = $(this).val();

                $.ajax({
                    url: '{{ url('get-slots') }}',
                    type: 'POST',
                    data: {
                        date: date,
                        id: id,
                    },
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    success: function(data) {
                        console.log(data)
                        slots = data.slots;

                        if (slots.length > 0) {
                            if (picker != '') {
                                picker.destroy();
                            }

                            let $interval = '';
                            for (let i = 0; i < slots.length; i++) {
                                // if (slots[i].schedule_time == '12am-5am') {
                                //     $interval +=
                                //         `<button id="option1" onclick="optionsClick(0,5,1)" style="width:auto !important;margin-right: 5px;" type="button">12am - 5am</button>`;
                                // } else
                                if (slots[i].schedule_time == 'Morning') {
                                    $interval +=
                                        `<button id="option2" onclick="optionsClick(6,12,2)" style="width:auto !important;margin-right: 5px;" type="button">Morning</button>`;
                                } else if (slots[i].schedule_time == 'Afternoon') {
                                    $interval +=
                                        `<button id="option2" onclick="optionsClick(12,18,3)" style="width:auto !important;margin-right: 5px;" type="button">Afternoon</button>`;
                                } else if (slots[i].schedule_time == 'Evening') {
                                    $interval +=
                                        `<button id="option2" onclick="optionsClick(18,24,4)" style="width:auto !important;margin-right: 5px;" type="button">Evening</button>`;
                                }

                            }
                            picker = new AppointmentSlotPicker(document.getElementById(
                                'time-1'), {
                                interval: 60,
                                mode: '12h',
                                minTime: 0,
                                maxTime: 5,
                                startTime: 0,
                                endTime: 5,
                                large: true,
                                title: $interval,
                                disabled: data.disabled_slots
                            });

                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            for (var key in errors) {
                                $('#errormsg').append('<p>' + errors[key][0] + '</p>');
                            }
                        }
                    }
                });

            });
        });

        function freeMeetmodal() {
            $('#demo_meeting_modal').modal('show')
        }

        function optionsClick(strt, end, btn) {

            picker.destroy();

            let $interval = '';
            for (let i = 0; i < slots.length; i++) {
                // if (slots[i].schedule_time == '12am-5am') {
                //     $interval +=
                //         `<button id="option1" onclick="optionsClick(0,5,1)" style="width:auto !important;margin-right: 5px;" type="button">12am - 5am</button>`;
                // } else

                if (slots[i].schedule_time == 'Morning') {
                    $interval +=
                        `<button id="option2" onclick="optionsClick(6,12,2)" style="width:auto !important;margin-right: 5px;" type="button">Morning</button>`;
                } else if (slots[i].schedule_time == 'Afternoon') {
                    $interval +=
                        `<button id="option2" onclick="optionsClick(12,18,3)" style="width:auto !important;margin-right: 5px;" type="button">Afternoon</button>`;
                } else if (slots[i].schedule_time == 'Evening') {
                    $interval +=
                        `<button id="option2" onclick="optionsClick(18,24,4)" style="width:auto !important;margin-right: 5px;" type="button">Evening</button>`;
                }

            }

            picker = new AppointmentSlotPicker(document.getElementById('time-1'), {
                interval: 60,
                mode: '12h',
                minTime: strt,
                maxTime: end,
                startTime: strt,
                endTime: end,
                large: true,
                title: $interval
                // disabled: ['1:30 pm', '2:00 pm', '7:30 pm', '9:30 pm']
            });
            picker.open();
        }
        
        
        function BooTypemodal(BooTypemodal) {
            var stripe = '<a  class=" btn px-5 py-2 text-decoration-none btnpay" href="{{ url('tutor/book') }}/' + BooTypemodal + '">Stripe<i class="ms-3 fa-solid fa-chevron-right"></i></a>';
            var wallet = '<a  class="btn px-5 py-2 text-decoration-none btnpay"  href="{{ url('tutor/wallet/book') }}/' + BooTypemodal + '">Wallet<i class="ms-3 fa-solid fa-chevron-right"></i></a>';
        
            $('#stripe').html(stripe);
            $('#wallet').html(wallet);
            $('#BooTypemodal').modal('show');
        }

        
    </script>


@endsection
