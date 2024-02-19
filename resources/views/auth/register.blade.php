@extends('layouts.app')

@section('content')
    <script src="{{ URL::asset('assets/sweetalert2/sweetalert2.min.js') }}"></script>
    <link href="{{ URL::asset('assets/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />

    @include('layouts/navbar')
    <style type="text/css">
        #multistep_form fieldset:not(:first-of-type) {
            display: none;
        }

        .text-left-1 {
            text-align: left !important;
        }

        .form-1-bottom {
            bottom: 4%;
        }

        .form-3-bottom {
            top: 30%;
            z-index: -99;
        }

        .form-end-1 {
            top: 36%;
            right: 0px;
        }

        .form-end-2 {
            top: 49%;
        }

        @media screen and (max-width:1025px) {
            .form-end-1 {
                top: 34%;
                right: 0px;
            }

            .form-end-2 {
                top: 46%;
            }
        }

        @media screen and (max-width:770px) {
            .form-end-1 {
                top: 29%;
                right: 0px;
            }

            .form-end-2 {
                top: 42%;
            }
        }
    </style>

    <!-- logo -->
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12 d-flex justify-content-center mt-5">
                <img src="./assets/images/247 NEW Logo 1.png" alt="Logo" width="250" height="auto">
            </div>
        </div>
    </div>

    <!-- logo end -->

    <!-- prograss bar -->

    <div class="container mt-3">
        <div class="d-flex justify-content-between align-items-center">
            <div class="col-md-1 text-center">
                <a href="#" class="link-dark previous" id="previous1" id="previous2" id="previous3"><i
                        class="fa fa-light fa-arrow-left fa-2x"></i></a>
            </div>
            <div class=" col-8 col-md-10">
                <div class="progress">
                    <div class="progress-bar active" role="progressbar" aria-valuemin="0" aria-valuemax="100"
                        style="background-color: rgba(171, 254, 16, 1);"></div>
                </div>
            </div>
            <div class="col-md-1 text-center">
                <a href="{{ url('/') }}" class="link-dark"><i class="fa-solid fa-xmark fa-2x"></i></a>
            </div>
        </div>
    </div>

    <!-- End prograss bar -->

    <!-- select type -->

    <div class="container mb-5 pb-5 pb-md-0 mb-md-0">
        <div class="panel-group">
            <div class="panel panel-primary">
                <form class="form-horizontal" action="{{ route('register') }}" id="multistep_form" method="POST">
                    @csrf
                    <input id="role_id" name="role_id" type="hidden">
                    <fieldset id="account">
                        <div class="panel-body mt-5">
                            {{-- <h2 class="text-center fs-1" id="text-color"><strong>Apply as...</strong></h2><br> --}}
                            <div class="container">
                                <div class="apply-as">
                                    <div class="d-flex flex-column flex-md-row justify-content-center gap-3">
                                        <a href="javascript:void(0)" data-role-id="4"
                                            class="btn col-md-4 col-lg-3 col-12 text-left-1 text-dark fs-4 fw-bold next user-role"
                                            style="background-color: rgba(171, 254, 16, 1);" id="next1"> <img
                                                src="assets/images/graduated.svg" alt="student icon" class="px-3 next"
                                                width="60" height="auto"> Student</a>
                                        <a href="javascript:void(0)" data-role-id="3"
                                            class="btn col-md-4 col-lg-3 text-left-1 text-dark fs-4 fw-bold next user-role"
                                            id="next2" style="background-color: rgba(171, 254, 16, 1);"> <img
                                                src="assets/images/tutor.svg" alt="tutor icon" class="px-3" width="60"
                                                height="auto">Tutor</a>
                                    </div>
                                    <div class="d-flex flex-column flex-md-row justify-content-center gap-3 mt-3">
                                        <a href="javascript:void(0)" data-role-id="5"
                                            class="btn col-md-4 col-lg-3 text-left-1 text-dark fs-4 fw-bold next user-role"
                                            id="next3" style="background-color: rgba(171, 254, 16, 1);"> <img
                                                src="assets/images/fathers-day.svg" alt="Parent icon" class="px-3"
                                                width="60" height="auto"> Parent</a>
                                        <a href="javascript:void(0)" data-role-id="6"
                                            class="btn col-md-4 col-lg-3 text-left-1 text-dark fs-4 fw-bold next d-flex user-role"
                                            id="next4" style="background-color: rgba(171, 254, 16, 1);"> <img
                                                src="assets/images/school.svg" alt="School icon" class="px-3"
                                                width="60" height="auto">Organization</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-md-flex justify-content-between position-relative d-none  mb-5">
                            <div class="d-flex align-items-end">
                                <img src="assets/images/tree 1.svg" alt="" width="30%" height="auto">
                                <img src="assets/images/tree 2.svg" alt="" width="30%" height="auto">
                            </div>
                            <div>
                                <img src="assets/images/tree 3.svg" alt="" width="60%" height="auto">
                            </div>
                            <div class="form-1-bottom position-absolute d-none d-md-inline-block">
                                <img src="assets/images/form1 bottom.svg" alt="" width="100%" height="auto">
                            </div>
                        </div>

                        <input type="hidden" role_id="" name="role_id" class="role_id">
                    </fieldset>

                    <fieldset id="personal">
                        <div class="panel-body mt-5">
                            <h2 class="text-center fs-1" id="text-color"><strong>Your First Name and Last Name?</strong>
                            </h2><br>
                            <div class="form-group">
                                <div class="col-10 col-md-5 row m-auto">
                                    <input type="text" class="form-control m-auto" id="fname" name="fname"
                                        placeholder="Type Your First Name">
                                    <span class="invalid-error fname-error text-danger d-none">Please enter first
                                        name</span>

                                    <input type="text" class="form-control m-auto mt-3" id="lname" name="lname"
                                        placeholder="Type Your Last Name">
                                    <span class="invalid-error fname-error text-danger d-none">Please enter last
                                        name</span>
                                </div>
                            </div>
                            <div class="row col-2 col-md-1 m-auto">
                                <input type="button" name="password" style="background-color: rgba(0, 150, 255, 1);"
                                    class="next btn mt-5" value="Next" id="next2" />
                            </div>
                        </div>
                        <div class="form-1-bottom d-none d-md-block mb-5">
                            <img src="assets/images/form1 bottom.svg" alt="" width="100%" height="auto">
                        </div>
                    </fieldset>

                    <fieldset id="contact">
                        <div class="panel-body mt-5">
                            <h2 class="text-center fs-1" id="text-color"><strong>Add your Phone Number or Email?</strong>
                            </h2><br>
                            <div class="form-group">
                                <div class="col-12 col-md-6 col-lg-5 row m-auto mb-3">
                                    <div class="form-group d-flex">
                                        <select name="code" id="">
                                            <option value="+1">+1</option>
                                            <option value="+44"  selected>+44</option>
                                            <option value="+33">+33</option>
                                            <option value="+49">+49</option>
                                            <option value="+91">+91</option>
                                            <option value="+86">+86</option>
                                            <option value="+81">+81</option>
                                            <option value="+7">+7</option>
                                            <option value="+92">+92</option>
                                            <option value="+34">+34</option>
                                            <option value="+61">+61</option>
                                            <option value="+52">+52</option>
                                            <option value="+39">+39</option>
                                            <option value="+1">+1</option>
                                            <option value="+91">+91</option>
                                            <option value="+82">+82</option>
                                            <option value="+234">+234</option>
                                            <option value="+351">+351</option>
                                            <option value="+64">+64</option>
                                            <option value="+86">+86</option>
                                            <option value="+972">+972</option>
                                            <option value="+65">+65</option>
                                            <option value="+20">+20</option>
                                            <option value="+46">+46</option>
                                            <option value="+82">+82</option>
                                            <option value="+63">+63</option>
                                            <option value="+55">+55</option>
                                            <option value="+971">+971</option>
                                            <option value="+44">+44</option>
                                            <option value="+62">+62</option>
                                            <option value="+41">+41</option>
                                            <option value="+49">+49</option>
                                            <option value="+7">+7</option>
                                            <option value="+380">+380</option>
                                            <option value="+965">+965</option>
                                            <option value="+972">+972</option>
                                            <option value="+961">+961</option>
                                            <option value="+977">+977</option>
                                            <option value="+971">+971</option>
                                            <option value="+967">+967</option>
                                            <option value="+971">+971</option>
                                            <option value="+41">+41</option>
                                            <option value="+65">+65</option>
                                            <option value="+852">+852</option>
                                            <option value="+420">+420</option>
                                            <option value="+63">+63</option>
                                            <option value="+358">+358</option>
                                            <option value="+47">+47</option>
                                            <option value="+46">+46</option>
                                            <option value="+354">+354</option>
                                            <option value="+48">+48</option>
                                            <option value="+7">+7</option>
                                            <option value="+995">+995</option>
                                            <option value="+961">+961</option>
                                            <option value="+66">+66</option>
                                            <option value="+84">+84</option>
                                            <option value="+82">+82</option>
                                            <option value="+93">+93</option>
                                            <option value="+355">+355</option>
                                            <option value="+213">+213</option>
                                            <option value="+244">+244</option>
                                            <option value="+297">+297</option>
                                            <option value="+43">+43</option>
                                            <option value="+32">+32</option>
                                            <option value="+375">+375</option>
                                            <option value="+591">+591</option>
                                            <option value="+387">+387</option>
                                            <option value="+673">+673</option>
                                            <option value="+359">+359</option>
                                            <option value="+855">+855</option>
                                            <option value="+56">+56</option>
                                            <option value="+57">+57</option>
                                            <option value="+506">+506</option>
                                            <option value="+385">+385</option>
                                            <option value="+53">+53</option>
                                            <option value="+357">+357</option>
                                            <option value="+420">+420</option>
                                            <option value="+45">+45</option>
                                            <option value="+593">+593</option>
                                            <option value="+503">+503</option>
                                            <option value="+372">+372</option>
                                            <option value="+251">+251</option>
                                            <option value="+358">+358</option>
                                            <option value="+995">+995</option>
                                            <option value="+30">+30</option>
                                            <option value="+502">+502</option>
                                            <option value="+504">+504</option>
                                            <option value="+36">+36</option>
                                            <option value="+354">+354</option>
                                            <option value="+62">+62</option>
                                            <option value="+98">+98</option>
                                            <option value="+964">+964</option>
                                            <option value="+353">+353</option>
                                            <option value="+972">+972</option>
                                            <option value="+39">+39</option>
                                            <option value="+81">+81</option>
                                            <option value="+962">+962</option>
                                            <option value="+254">+254</option>
                                            <option value="+965">+965</option>
                                            <option value="+961">+961</option>
                                            <option value="+961">+961</option>
                                        </select>

                                        <input type="text" class="form-control phone-signup" value=""
                                            name="phone">
                                    </div>
                                    <span class="invalid-error text-danger d-none phone-error">Please enter phone
                                        number.</span>

                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12 col-md-6 col-lg-5 m-auto">
                                    <input type="email" class="form-control m-auto email-signup" name="email"
                                        placeholder="Type Your Email">
                                    <span class="invalid-error text-danger d-none email-signup-error">Please enter your
                                        email.</span>


                                    <div class="form-check mt-3 ms-2">
                                        <input class="form-check-input me-1" type="checkbox" value=""
                                            id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            <strong>I would like to Receive, Tips, and offers by Email</strong>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row col-lg-2 col-3  col-md-3 m-auto" style="margin-bottom: 100px !important;">
                                <input type="button" style="background-color: rgba(0, 150, 255, 1);" name="password"
                                    class="next btn mt-5 text-white" value="Next" id="next3" />
                            </div>
                            <div class="form-3-bottom position-absolute text-center d-none d-md-block">
                                <img src="assets/images/form3 bottom.svg" alt="" width="90%" height="auto">
                            </div>
                        </div>

                    </fieldset>

                    <fieldset id="password">
                        <div class="panel-body mt-5">
                            <h2 class="text-center fs-1" id="text-color"><strong>Your Password?</strong></h2><br>
                            <div class="form-group">
                                <div class="col-10 col-md-5 row m-auto">
                                    <input type="password" class="form-control m-auto" id="password" name="password"
                                        placeholder="Type Your Password">
                                    <span class="invalid-error password-error text-danger d-none">Please enter
                                        password.</span>

                                    <input type="text" class="form-control m-auto mt-3" id="confirm-password"
                                        name="confirm-password" placeholder="Type Your Confirm Password">

                                    <span class="invalid-error cpassword-error text-danger d-none">Please enter confirm
                                        password.</span>
                                </div>
                            </div>
                            <div class="row col-2 col-md-1 m-auto">
                                <input type="button" name="password" style="background-color: rgba(0, 150, 255, 1);"
                                    class="next btn mt-5" value="Next" id="next5" />
                            </div>
                        </div>
                        <div class="form-1-bottom d-none d-md-block mb-5">
                            <img src="assets/images/form1 bottom.svg" alt="" width="100%" height="auto">
                        </div>
                    </fieldset>

                    <fieldset id="subjects">
                        <div class="panel-body mt-5">
                            <h2 class="text-center fs-1" id="text-color"><strong>Which Subject would you Like Help
                                    with?</strong></h2><br>
                            <div class="container">
                                <div class="d-flex flex-wrap justify-content-center">
                                    <a href="javascript:void(0)" data-subject-id="1" class="next" id="next6"
                                        style="text-decoration: none">
                                        <div class="card text-center py-4  px-3 m-3"
                                            style="border-radius: 15px; width: 135px; background-color: rgba(171, 254, 16, 1);">
                                            <img src="assets/images/mathematics.svg" alt="Math" width="50"
                                                class="m-auto">
                                            <span class="fw-bolder text-dark">Mathematics</span>
                                        </div>
                                    </a>
                                    <a href="javascript:void(0)" data-subject-id="1" class="next" id="next6"
                                        style="text-decoration: none">
                                        <div class="card text-center p-4 m-3"
                                            style="border-radius: 15px; width: 135px;background-color: rgba(171, 254, 16, 1);">
                                            <img src="assets/images/english.svg" alt="Math" width="50"
                                                class="m-auto">
                                            <span class="fw-bolder text-dark">English</span>
                                        </div>
                                    </a>
                                    <a href="javascript:void(0)" data-subject-id="1" class="next" id="next6"
                                        style="text-decoration: none">
                                        <div class="card text-center p-4 m-3"
                                            style="border-radius: 15px; width: 135px;
                                                  background-color: rgba(171, 254, 16, 1);">
                                            <img src="assets/images/Chemistry.svg" alt="Math" width="50"
                                                class="m-auto">
                                            <span class="fw-bolder text-dark">Chemistry</span>
                                        </div>
                                    </a>
                                    <a href="javascript:void(0)" data-subject-id="1" class="next" id="next6"
                                        style="text-decoration: none">
                                        <div class="card text-center p-4 m-3"
                                            style="border-radius: 15px; width: 135px;background-color: rgba(171, 254, 16, 1);">
                                            <img src="assets/images/Biology.svg" alt="Math" width="50"
                                                class="m-auto">
                                            <span class="fw-bolder text-dark">Biology</span>
                                        </div>
                                    </a>
                                    <a href="javascript:void(0)" data-subject-id="1" class="next" id="next6"
                                        style="text-decoration: none">
                                        <div class="card text-center p-4 m-3"
                                            style="border-radius: 15px; width: 135px;
                                             background-color: rgba(171, 254, 16, 1);">
                                            <img src="assets/images/physics.svg" alt="Math" width="50"
                                                class="m-auto">
                                            <span class="fw-bolder text-dark">Physics</span>
                                        </div>
                                    </a>

                                </div>
                            </div>

                            <input type="hidden" value="" name="subject_id" class="subject-id">
                            <div class="row col-7 col-md-4 col-lg-3 col-xl-2 m-auto">
                                <a href="#" class="btn mt-5 py-2 px-4 text-white"
                                    style="background-color: rgba(0, 150, 255, 1);font-size:20px;">More Subjects</a>
                            </div>
                            <p style="font-size:20px;font-style:italic"
                                class="text-center my-5 text-secondary text-italic">We’ll Select Tutors who Specialise in
                                your Chosen Subject (with A/A*’s to Show for it)!.
                            </p>
                        </div>
                    </fieldset>

                    <fieldset id="final">
                        <div class="panel-body mt-5">
                            <h3 class="text-center text-secondary"><strong>You’re all Set up, Name</strong></h3><br>
                            <h2 class="text-center fs-1" id="text-color"><strong>Now Let’s find you a Great Tutor</strong>
                            </h2><br>
                            <div class="card text-center col-md-6 col-10 col-xl-3 col-lg-4 py-5  m-auto"
                                style="border-radius: 10px;background-color: rgba(171, 254, 16, 1); margin-bottom: 120px !important;">
                                <img src="assets/images/Group 1122.png" alt="" width="200" class="m-auto">
                                <p class="m-auto pt-4 col-md-10">We Interview all our Tutors
                                    and only 1 in 8 Candidates
                                    make the out.</p>

                                <div class="dropdown mt-2">
                                    <input type="submit" class="btn btn-light justify-content-center" value="Submit">
                                </div>
                            </div>
                        </div>
                        <div class="form-end-1 d-none d-md-block position-absolute">
                            <img src="assets/images/Plant.svg" alt="" width="65%" height="auto">
                        </div>
                        <div class="form-end-2 position-absolute d-none d-md-block">
                            <img src="assets/images/form1 bottom.svg" alt="" width="90%" height="auto">
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.getElementById("next1").addEventListener("click", function() {

            var roleId = this.getAttribute("data-role-id");
            document.getElementById("role_id").value = roleId;
        });
        document.getElementById("next2").addEventListener("click", function() {
            var roleId = this.getAttribute("data-role-id");
            document.getElementById("role_id").value = roleId;
        });
        document.getElementById("next3").addEventListener("click", function() {
            var roleId = this.getAttribute("data-role-id");
            document.getElementById("role_id").value = roleId;
        });
        document.getElementById("next4").addEventListener("click", function() {
            var roleId = this.getAttribute("data-role-id");
            document.getElementById("role_id").value = roleId;
        });
    </script>
@endsection
