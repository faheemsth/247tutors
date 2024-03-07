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
    <script src="{{ asset('js/jsdelivrcore.js') }}"></script>
    <script src="{{ asset('js/jsdelivr.js') }}"></script>
    <style>
        .bgpro{
            background-color: #f2f2f2;
            border: 1px solid #c1c1c1;
        }
        .bgpro:focus{
            color: white;
    background-color: rgba(59, 59, 59, 0.267);
    border-color: rgba(180, 178, 178, 0.267);
    outline: 0;
    box-shadow: 0 0 0 0;
        }
        .profileeditdiv{
            opacity: 0;
        }
        .profileeditdiv:hover{
            opacity: 0.8;
        }

    </style>
    <div class="container-fluid">
        <div class="container">
            @if (session('success'))
                <div class="alert alert-success mt-4">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('failed'))
                <div class="alert alert-danger mt-4">
                    {{ session('failed') }}
                </div>
            @endif

            <div class="row mt-5 mb-5">
                <div class="col-12 col-lg-2 image1 d-flex justify-content-lg-center position-relative">
                    <div  class="profileeditdiv d-flex justify-content-center align-items-center" style="width: 180px;height: 180px;background-color: #cfcfcf;border-radius: 50%; position: absolute;top:0px;">
                        <button type="button" data-bs-toggle="modal" data-bs-target="#staticBackdrop" class="btn px-4" style="background-color: #080808;
                        color: white;">Edit</button>
                    </div>
                    @if (!empty(Auth::user()->image) && file_exists(public_path(Auth::user()->image)))
                        <img src="{{ asset(Auth::user()->image) }}" alt="" style="width: 180px;height: 180px;
                        border-radius: 50%;">
                    @else
                        <img src="{{ asset('assets/images/default.png') }}" alt="" style="    width: 180px;
                        height: 180px;
                        border-radius: 50%;">
                    @endif
                </div>
                <!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Upload Profile</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="form1" runat="server" action="{{ url('/Upload/Profile') }}" method="post" enctype="multipart/form-data">
            @csrf
                <div class="modal-body">
                <div class="row gap-4">

                    <div class="col-12 my-3" style="position: relative;">
                        <div class="btn text-center btn-primary w-100 p-1">
                            <h5>Upload Image</h5>
                        </div>
                        <div class="btn btn-primary w-100 p-1" style="position: absolute;top:0px;left:0px;opacity: 0;">
                            <input  id="imgInp"  type="file" name="image"
                            placeholder="Select Your picture"class="w-100" >
                        </div>
                    </div>
                    <div class="col-12 text-center d-none">
                        <img id="blah" alt="your image" src="#"  style="width: 80px;height: 80px;
                        border-radius: 50%;">
                    </div>
                </div>
                </div>

                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Upload</button>
                </div>
         </form>
      </div>
    </div>
</div>

                <div class="col-12 col-lg-8  mt-1 ms-2 ms-md-0">
                    <div class="d-flex justify-content-between mt-lg-4 hr align-items-center">

                        <h4>{{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}
                        @if (Auth::user()->status == "Active")
                        <img src="{{asset('assets/images/Verified-p.png')}}" >
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

            </div>

            <div class="mt-5 about">
                <h4>About me:</h4>
                {{-- <p>Hi! My name is {{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}.</p> --}}
                <p>{{ Auth::user()->profile_description }}</p>
            </div>

            <!-- Arman D end -->

            <!-- General Detail start -->
            <div class="row gende">
                <div class="col-md-12 general mt-5 mb-5">
                    <h2>General Detail</h2>
                </div>
                <div class="row general-detail mb-5">
                    {{-- start --}}
                    <div class="col-md-12">
                        <form action="{{ url('update_tutor_post') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row mt-2">
                                <div class="col-md-6">

                                    <label for="exampleFormControlInput1" class="form-label">First Name</label>
                                    <input type="text" name="first_name" value="{{ Auth::user()->first_name }}"
                                        class="form-control" id="" required placeholder="Type Your First Name">

                                </div>
                                <div class="col-md-6 ">
                                    <label for="exampleFormControlInput1" class="form-label">Last Name</label>
                                    <input type="text" name="last_name" value="{{ Auth::user()->last_name }}"
                                        class="form-control" id="" required placeholder="Type Your Last Name">

                                </div>
                            </div>

                            <div class="row mt-5">
                                <div class="col-md-6 ">
                                    <label for="exampleFormControlInput1" class="form-label">Email</label>
                                    <input type="email" name="email" value="{{ Auth::user()->email }}"
                                        class="form-control" id="" required placeholder="Type Your Email Address">
                                </div>
                                <!-- <div class="col-md-6">
                                    <label for="exampleFormControlInput1" class="form-label">Password</label>
                                    <input type="password" name="password" value="" class="form-control"
                                        id="" required placeholder="Type Your Password">
                                </div> -->
                                <div class="col-md-6">
                                    <label for="exampleFormControlInput1" class="form-label">Tagline</label>
                                    <input type="text" name="facebook_link" value="{{ Auth::user()->facebook_link }}"
                                        class="form-control" id=""
                                        placeholder="Type Your Tag Line For Profile">

                                </div>
                            </div>

                            <div class="row mt-5 mb-2">
                                <div class="col-md-6">
                                    <label for="exampleFormControlInput1" class="form-label">Phone</label>
                                    <input type="text" name="phone" value="{{ Auth::user()->phone }}"
                                        class="form-control" id="" required placeholder="Type Your Phone">
                                </div>
                                <div class="col-md-6">
                                    <label for="exampleFormControlInput1" class="form-label">Gender</label>
                                    <select class="form-control bgpro" name="gender" required>
                                        <option value="Male" {{ Auth::user()->gender == 'Male' ? 'selected' : '' }}>Male
                                        </option>
                                        <option value="Female" {{ Auth::user()->gender == 'Female' ? 'selected' : '' }}>
                                            Female
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mt-5 mb-2">

                                <div class="col-md-6">
                                    <label for="exampleFormControlInput1" class="form-label">DOB</label>
                                    <input type="date" name="dob" value="{{ Auth::user()->dob }}"
                                        class="form-control" id="" required placeholder="yyyy-mm-dd" max="9999-12-31">
                                </div>
                                <div class="col-md-6">
                                    <label for="exampleFormControlInput1" class="form-label">Postcode</label>
                                    <input type="text" name="zipcode" class="form-control" id="" required
                                        placeholder="Type Your Postcode" value="{{ Auth::user()->zipcode }}">
                                </div>
                            </div>


                            <div class="row mt-5 mb-2">

                                <div class="col-md-6">
                                    <label for="exampleFormControlInput1" class="form-label">Address</label>
                                    <textarea type="text" name="address" class="form-control bgpro"  id="address" cols="30" rows="5">{{ Auth::user()->address }}</textarea>
                                </div>
                                <div class="col-md-6">
                                    <label for="exampleFormControlInput1"  class="form-label">Biography</label>
                                    <textarea type="text" name="profile_description" class="form-control bgpro"  id="profile_description" cols="30" rows="5">{{ Auth::user()->profile_description }}</textarea>

                                </div>
                            </div>
                            <div class="row mt-5 mb-2">

                                @php
                                    $updateType=App\Models\TutorApplication::where('tutor_id',Auth::id())->first();
                                @endphp
                                <div class="col-md-6">
                                    <label for="exampleFormControlInput1" class="form-label">Choose</label>
                                    <select class="form-control bgpro" name="tutor_type" required>
                                        <option value="1" {{ !empty($updateType) && $updateType->tutor_type == 1 ? 'selected' : '' }}>Online
                                        </option>
                                        <option value="2" {{ !empty($updateType) && $updateType->tutor_type == 2 ? 'selected' : '' }}>In Person
                                        </option>
                                        <option value="3" {{ !empty($updateType) && $updateType->tutor_type == 3 ? 'selected' : '' }}>
                                            Both
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-6 d-none">
                                    <label for="exampleFormControlInput1" class="form-label">Linkedin Link</label>
                                    <input type="text" name="linkedin_link" value="{{ Auth::user()->linkedin_link }}"
                                        class="form-control" id=""
                                        placeholder="Type Your Linkedin Link">
                                </div>
                            </div>
                            <div class="row mt-5 mb-2 d-none">
                                <div class="col-md-6">
                                    <label for="exampleFormControlInput1" class="form-label">Twitter Link</label>
                                    <input type="text" name="twitter_link" value="{{ Auth::user()->twitter_link }}"
                                        class="form-control" id=""
                                        placeholder="Type Your twitter link">

                                </div>
                            </div>



                            <div class="row mt-5 mb-5 justify-content-center">
                                <div class="col-md-2 text-center">
                                    <button type="submit" class="btn btn-primary px-3 py-2">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    {{-- end --}}


                </div>

            </div>

            <!-- General Deatil end -->

            <!-- Qualification Srat -->

            <div class="row ">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6 quali">
                            <h3>Qualification</h3>
                        </div>
                        <div class="col-md-6"> </div>
                        <div class="row quion pe-0">
                            <div class="col-md-12 pe-0" style="display:scroll;">
                                {{-- <a href="" class="btn qualification float-end mb-3 me-2" data-bs-toggle="modal"
                                    data-bs-target="#addSubjectModal">Add subject</a> --}}
                                <table class="table table-bordered border-dark mt-4">
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

            <!-- Qualification end -->

            <!-- General Availability start -->

            <div class="row ">
                <div class="col-md-12 col-12 gen">
                    <h3>General Availability</h3>
                    <!-- <a href="" class="btn qualification float-end mb-3 me-2" data-bs-toggle="modal"
                        data-bs-target="#addavailabilityModal">Add General Availability</a> -->
                    <div class="genav">
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
                                    <th scope="col">Action</th>
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

                                            <td class="text-center">
                                                <a href="{{ url('availability/delete') . '/' . $availability->id }}"
                                                    class="btn qualification"><i class="fa-solid fa-trash"></i></a>
                                                <a class="btn qualification"
                                                    onclick="UpdateAvailability('{{ $availability->id }}','{{ $availability->day_of_the_week }}','{{ $availability->schedule_time }}')"><i
                                                        class="fa-solid fa-edit"></i></a>
                                            </td>
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

            <!-- General Availability end -->

            <!-- Subject Offered start -->

            <div class="row">
                <div class="col-md-12 suboff">
                    <h3>Subject Offered</h3>
                    <a href="" class="btn qualification float-end mb-3 me-2" data-bs-toggle="modal"
                        data-bs-target="#addSubjectofferModal">Add subject</a>
                    <table class="table table-bordered border-dark mt-4">
                        <thead class="qualification">
                            <tr>
                                <th scope="col">Subject</th>
                                <th scope="col">Level</th>
                                <th scope="col">Fee Per Hour</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($tutorsubjectoffers->count() > 0)
                                @foreach ($tutorsubjectoffers as $tutorsubjectoffer)
                                    <tr>

                                        <td>{{ !empty($tutorsubjectoffer->subject) ? $tutorsubjectoffer->subject->name : '' }}
                                        </td>
                                        <td>{{ $tutorsubjectoffer->levelstring }}</td>
                                        <td>£{{ $tutorsubjectoffer->fee }}/hr</td>
                                        <td class="text-center">
                                            <a href="{{ url('subject/offer/delete') . '/' . $tutorsubjectoffer->id }}"
                                                class="btn qualification"><i class="fa-solid fa-trash"></i></a>
                                            <a class="btn qualification"
                                                onclick="UpdateSubjectOffer('{{ $tutorsubjectoffer->id }}','{{ $tutorsubjectoffer->subject_id }}','{{ $tutorsubjectoffer->levelstring }}','{{ $tutorsubjectoffer->fee }}')"><i
                                                    class="fa-solid fa-edit"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                                @else 
                                    <tr>
                                        <td colspan="4">No Record Found</td>
                                    </tr>
                            @endif
                        </tbody>

                    </table>
                </div>
            </div>

            <!-- Subject Offered end -->

            <!-- Billing Start -->
            {{-- <div class="row mt-3 mb-5">
                <div class="col-12 billing">
                    <h3>Billing Address</h3>
                </div>
                <div class="row mb-5 billing1 w-100">
                    <div class="col-md-6 col-12 mt-3 ">
                        <label for="" class="form-label">Name on Card</label>
                        <input type="" class="form-control" id="" aria-describedby="">
                    </div>
                    <div class="col-md-6 col-12 "></div>
                    <div class="row mt-3">
                        <div class="col-md-6 col-12">
                            <label for="exampleFormControlInput1" class="form-label">Card Number</label>
                            <input type="email" class="form-control" id="" required
                                placeholder="xxxx xxxx xxxx xxxx">

                        </div>
                        <div class="col-md-6 ">
                            <div class="input-group">

                                <input type="text" required placeholder="Enter Card Number First" class="form-control"
                                    aria-label="Text input with dropdown button">
                                <button class="btn btn-secondary dropdown-toggle" type="button"
                                    data-bs-toggle="dropdown" aria-expanded="false"></button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="#">Action</a></li>
                                    <li><a class="dropdown-item" href="#">Another action</a></li>
                                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item" href="#">Separated link</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3 mb-5">
                        <div class="col-md-6"><label for="exampleFormControlInput1" class="form-label">Expiray Date
                                (MM/YY)</label>
                            <input type="email" class="form-control" id="" required placeholder="MM/YY">
                        </div>
                        <div class="col-md-6"><label for="exampleFormControlInput1" class="form-label">CVC
                                Number</label>
                            <input type="email" class="form-control" id="" required placeholder="xxx">
                        </div>
                    </div>
                    <div class="row mt-5 mb-5 justify-content-center">
                        <div class="col-md-2 text-center">
                            <button type="submit" class="btn btn-primary px-3 py-2">Save</button>
                        </div>
                    </div>

                </div>


            </div> --}}
            <!-- <div class="row my-4">
                <form action="{{ url('user-card-create') }}" method="post">
                    @csrf
                    <div class="panel-body mt-5 billing">
                        <h2 class="text-left fs-1" style="color: #4fb5ff;"><strong>Configure your paypal account</strong></h2><br>
                        <div class="d-flex col-lg-7 col-md-6 justify-content-between">
                            <h4 class="text-left text-secondary fs-3"><strong>We will use this paypal account to send you money when you initiate withdrawl.</strong></h4>
                            <br>
                            <img src="{{ asset('assets/images/card visa.svg') }}" alt="visa cards" width="100"
                                height="auto">
                        </div>

                        <div class="d-flex flex-column flex-md-row justify-content-between">
                            <div class="col-lg-7 col-md-6 col-12">
                                <div class="row col-md-12">
                                    <div class="col-md-6">
                                        <div class='col-xs-12 form-group required'>
                                            <label class='control-label'>Paypal account</label> <input class=" w-100 p-3"
                                                size='4' type='text' required name="account_holder_name">
                                        </div>
                                    </div>

                                </div>
                                <div class="mt-5 row col-md-12">
                                    <div class="col-md-12">
                                        <label class="text-secondary">Card Number</label><br>
                                        <input autocomplete='off' required name="card_number"
                                            class='card-number w-100 p-3' size='20' type='text' id='cardInput'>
                                    </div>
                                </div>
                                <div class="mt-5 row col-md-12">

                                    <div class="col-md-4">
                                        <label class="text-secondary">CVC Number</label><br>
                                        <input type="text" required name="cvc" placeholder='ex. 311'
                                            class="w-100 p-3 card-cvc" id="cvcInput">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="text-secondary">Expiration Month</label><br>
                                        <input type="text" required name="exp_month" placeholder="MM"
                                            class="w-100 p-3 card-expiry-month">
                                    </div>

                                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                                    <script>
                                        $(document).ready(function() {
                                            $(".card-expiry-month").on("input", function() {
                                                var inputValue = $(this).val();
                                                inputValue = inputValue.replace(/\D/g, "");
                                                if (inputValue === '' || parseInt(inputValue) > 12) {
                                                    $(this).val('');
                                                } else {
                                                    $(this).val(inputValue);
                                                }
                                            });
                                        });
                                    </script>

                                    <div class="col-md-4">
                                        <label class="text-secondary">Expiration Year</label><br>
                                        <input type="text" required name="exp_year" placeholder="YY"
                                            class="w-100 p-3 card-expiry-year" id="exp_year_input">
                                    </div>
                                </div>
                                <div class="row my-5">
                                    <div class="col-2">
                                        <button class="btn bg-primary  px-5 py-3 text-white">Save</button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <input type="hidden" class="w-100 p-3" required name="amount" id="amount2" value="">
                    <input type="hidden" class="w-100 p-3" required name="copounid" id="copounid" value="">


                </form>

            </div> -->

            <div class="row my-4">
                <form action="{{ url('user-card-create') }}" method="post">
                    @csrf
                    <div class="panel-body mt-5 billing">
                        <h2 class="text-left fs-2" style="color: #4fb5ff;"><strong>Configure your paypal account</strong></h2><br>
                        <div class="d-flex col-lg-7 col-md-6 justify-content-between">
                            <h4 class="text-left text-secondary fs-4"><strong>We will use this paypal account to send you money <br> when you initiate withdrawl.</strong></h4>
                            <br>
                            <img src="{{ asset('assets/images/paypal.png') }}" alt="visa cards" width="100px"
                                height="38px">
                        </div>

                        <div class="d-flex flex-column flex-md-row justify-content-between my-4">
                            <div class="col-lg-7 col-md-6 col-12">
                                <div class="row col-md-12 mb-3">
                                    <div class="col-md-6">
                                        <div class='col-xs-12 form-group required'>
                                            <label class='control-label'>Paypal account email</label>
                                            <input class=" w-100 p-2" type='email' value="{{\Auth::user()->paypal_email}}" required name="paypal_email">
                                        </div>
                                    </div>

                                </div>

                                <div class="row col-md-12 mb-3">
                                    <div class="col-md-6">
                                        <div class='col-xs-12 form-group required'>
                                            <label class='control-label'>Confirm email</label>
                                            <input class=" w-100 p-2" type='email' required name="paypal_email_confirm">
                                        </div>
                                    </div>

                                </div>

                                <div class="row my-3">
                                    <div class="col-2">
                                        <button class="btn bg-primary  px-3 py-2 text-white">Save</button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>

            </div>





            <!-- Billing end -->

        </div>
    </div>
    {{-- addSubjectModal --}}
    <div class="modal" id="addSubjectModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ url('subject/store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title">Create Subject</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                        </button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="name" id="floatingInput"
                                placeholder="Name">
                            <label for="floatingInput">Name</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="grade" id="floatingInput"
                                placeholder="Name">
                            <label for="floatingTextarea2">Grade</label>
                        </div>
                        <div class="form-floating mb-3">
                            <select class="form-select" id="floatingSelectGrid" name="level_id"
                                aria-label="Floating label select example">
                                <option selected>Select Level</option>
                                @if ($levels)
                                    @foreach ($levels as $level)
                                        <option value="{{ $level->id }}">{{ $level->level }}</option>
                                    @endforeach
                                @endif
                            </select>
                            <label for="floatingSelectGrid">Levels</label>
                        </div>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" data-bs-dismiss="modal">Create</button>
                    </div>
                </form>


            </div>
        </div>
    </div>
    {{-- addSubjectofferModal --}}
    <div class="modal" id="addSubjectofferModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ url('subject/offer/store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title">Create Subject Offer</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                        </button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="form-floating mb-3">
                            <select class="form-select" id="floatingSelectGrid" required name="subject_id"
                                aria-label="Floating label select example">
                                <option value="" selected>Select Subject</option>
                                @if ($subjects)
                                    @foreach ($subjects as $subject)
                                        <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                            <label for="floatingSelectGrid">Subjects</label>
                        </div>
                        <div class="form-floating mb-3">
                            <select class="form-select" id="floatingSelectGrid" name="level_id" required
                                aria-label="Floating label select example">
                                <option value="">Select Level</option>
                                <option value="KS1 (Primary)" data-level="KS1 (Primary)">KS1 (Primary)</option>
                                <option value="KS2 (Primary)" data-level="KS2 (Primary)">KS2 (Primary)</option>
                                <option value="KS3 (GCSE)" data-level="KS3 (GCSE)">KS3 (GCSE)</option>
                                <option value="KS4 (A Level)" data-level="KS4 (A Level)">KS4 (A Level)</option>
                                <option value="University" data-level="University">University</option>
                            </select>
                            <label for="floatingSelectGrid">Levels</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="fee" required
                                oninput="this.value = this.value.replace(/[^0-9]/g, '');" id="floatingInput"
                                placeholder="Name">
                            <label for="floatingInput">Fee</label>
                        </div>

                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" >Create</button>
                    </div>
                </form>


            </div>
        </div>
    </div>

    {{-- UpdateModal --}}
    <div class="modal" id="updateSubjectModal">
        <div class="modal-dialog">
            <div class="modal-content" id="subjectmodalget">
            </div>
        </div>
    </div>



    {{-- addavailabilityModal --}}
    <div class="modal" id="addavailabilityModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ url('availability/store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title">Create Availability</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                        </button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="form-floating mb-3">
                            <select class="form-select" id="floatingSelectGrid" name="schedule_time"
                                aria-label="Floating label select example">
                                <option value="12am-5am">12am-5am</option>
                                <option value="6am-11am">6am-11am</option>
                                <option value="12pm-5pm">12pm-5pm</option>
                                <option value="6pm-11pm">6pm-11pm</option>

                            </select>
                            <label for="floatingSelectGrid">Availability</label>
                        </div>
                        <span class="d-flex">

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="day_of_the_week[]" value="1"
                                    id="flexCheckChecked">
                                <label class="form-check-label px-2" for="flexCheckChecked">
                                    Mon
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="day_of_the_week[]" value="2"
                                    id="flexCheckChecked">
                                <label class="form-check-label px-2" for="flexCheckChecked">
                                    Tue
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="day_of_the_week[]" value="3"
                                    id="flexCheckChecked">
                                <label class="form-check-label px-2" for="flexCheckChecked">
                                    Wed
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="day_of_the_week[]" value="4"
                                    id="flexCheckChecked">
                                <label class="form-check-label px-2" for="flexCheckChecked">
                                    Thu
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="day_of_the_week[]" value="5"
                                    id="flexCheckChecked">
                                <label class="form-check-label px-2" for="flexCheckChecked">
                                    Fri
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="day_of_the_week[]" value="6"
                                    id="flexCheckChecked">
                                <label class="form-check-label px-2" for="flexCheckChecked">
                                    Sat
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="day_of_the_week[]" value="7"
                                    id="flexCheckChecked">
                                <label class="form-check-label px-2" for="flexCheckChecked">
                                    Sun
                                </label>
                            </div>
                        </span>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" data-bs-dismiss="modal">Create</button>
                    </div>
                </form>


            </div>
        </div>
    </div>
    <script>
        function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#blah').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

$("#imgInp").change(function(){
    alert(1);
    readURL(this);
});


        function UpdateAvailability(id, days, schedule_time) {

            $('#subjectmodalget').html('');
            const modal = document.getElementById("updateSubjectModal");
            const url = `{{ url('availability/update?id=') }}${id}`;
            const getday = days.split(',').map(Number);

            const daysOfWeek = ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"];

            const html = `
    <form action="${url}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="modal-header">
            <h4 class="modal-title">Update Availability</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
            <span class="d-flex">
                ${daysOfWeek.map((day, index) => `
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="day_of_the_week[]" value="${index + 1}" id="flexCheckChecked${index + 1}" ${getday.includes(index + 1) ? 'checked' : ''}>
                            <label class="form-check-label px-2" for="flexCheckChecked${index + 1}">
                                ${day}
                            </label>
                        </div>
                    `).join('')}
            </span>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-success">Update</button>
        </div>
    </form>`;

            $('#subjectmodalget').append(html);
            new bootstrap.Modal(modal).show();
        }

        function UpdateSubject(id, name, level, grade) {
            $('#subjectmodalget').html('');
            const modal = document.getElementById("updateSubjectModal");
            const url = `{{ url('/subject/update') }}/${id}`;
            let selectOptions = @json($levels);

            const html = `
            <form action="${url}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title">Update Subject</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="name" value="${name}" id="floatingInput" placeholder="Name">
                        <label for="floatingInput">Name</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="grade" value="${grade}" id="floatingInput" placeholder="Grade">
                        <label for "floatingInput">Grade</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select" id="floatingSelectGrid" name="level_id" aria-label="Floating label select example">
                            <option>Select Level</option>
                            <option value="KS1 (Primary)" data-level="KS1 (Primary)">KS1 (Primary)</option>
                            <option value="KS2 (Primary)" data-level="KS2 (Primary)">KS2 (Primary)</option>
                            <option value="KS3 (GCSE)" data-level="KS3 (GCSE)">KS3 (GCSE)</option>
                            <option value="KS4 (A Level)" data-level="KS4 (A Level)">KS4 (A Level)</option>
                            <option value="University" data-level="University">University</option>
                        </select>
                        <label for="floatingSelectGrid">Levels</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" >Update</button>
                </div>
            </form>`;

            $('#subjectmodalget').append(html);

            new bootstrap.Modal(modal).show();
        }

        function UpdateSubjectOffer(id, subject_id, level_id, fee) {
            $('#subjectmodalget').html('');
            const modal = document.getElementById("updateSubjectModal");
            const url = `{{ url('/subject/offer/update') }}/${id}`;
            let selectOptions = @json($levels);
            let selectOptions2 = @json($subjects);

            const html = `
            <form action="${url}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title">Update Subject Offer</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">


                    <div class="form-floating mb-3">
                        <select class="form-select" id="floatingSelectGrid" name="subject_id" aria-label="Floating label select example">
                            <option>Select Level</option>
                            ${selectOptions2.map(l => `<option value="${l.id}" ${subject_id == l.id ? 'selected' : ''}>${l.name}</option>`).join('')}
                        </select>
                        <label for="floatingSelectGrid">Subjects</label>
                    </div>


                    <div class="form-floating mb-3">
                        <select class="form-select" id="up_level_id" name="level_id" aria-label="Floating label select example">
                            <option>Select Level</option>
                            <option value="KS1 (Primary)" data-level="KS1 (Primary)">KS1 (Primary)</option>
                            <option value="KS2 (Primary)" data-level="KS2 (Primary)">KS2 (Primary)</option>
                            <option value="KS3 (GCSE)" data-level="KS3 (GCSE)">KS3 (GCSE)</option>
                            <option value="KS4 (A Level)" data-level="KS4 (A Level)">KS4 (A Level)</option>
                            <option value="University" data-level="University">University</option>
                        </select>
                        <label for="floatingSelectGrid">Levels</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="fee" oninput="this.value = this.value.replace(/[^0-9]/g, '');" value="${fee}" id="floatingInput" placeholder="Name">
                        <label for="floatingInput">Fee</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Update</button>
                </div>
            </form>`;

            $('#subjectmodalget').append(html);

            new bootstrap.Modal(modal).show();
            $('#up_level_id').val(level_id);
        }
    </script>

    <script>
        $('#cvcInput').on('input', function() {
            const cvcInput = $(this).val().replace(/\D/g, '').substring(0, 3);
            const formattedDisplay = cvcInput.replace(/(\d{4})(?=\d)/g, '$1 ');
            $(this).val(formattedDisplay);
        });

        $('#cardInput').on('input', function() {
            const cardInput = $(this).val().replace(/\D/g, '').substring(0, 16);
            const formattedDisplay = cardInput.replace(/(\d{4})(?=\d)/g, '$1 ');
            $(this).val(formattedDisplay);
        });
        const currentYear = new Date().getFullYear();
        const expYearInput = document.getElementById("exp_year_input");

        expYearInput.addEventListener("input", () => {
            expYearInput.value = expYearInput.value.replace(/\D/g, '');
            expYearInput.value = expYearInput.value.slice(0, 2);

            const inputValue = expYearInput.value;

            if (/^\d{2}$/.test(inputValue)) {
                if (inputValue < currentYear % 100) {
                    expYearInput.setCustomValidity("Expiration year should be this year or later.");
                } else {
                    expYearInput.setCustomValidity("");
                }
            } else {
                expYearInput.setCustomValidity("Please enter a valid 2-digit year.");
            }
        });
    </script>
    <script>
    </script>

@endsection
