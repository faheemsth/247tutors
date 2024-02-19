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
    <script src="{{ URL::asset('assets/sweetalert2/sweetalert2.min.js') }}"></script>
    <link href="{{ URL::asset('assets/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />

    <script src="{{ asset('js/jsdelivr.js') }}"></script>
    <script src="{{ asset('vendor/jquery/jquery3.7.0.js') }}"></script>

    <style type="text/css">
        #multistep_form fieldset:not(:first-of-type) {
            display: none;
        }

        .appo-picker.is-large {
            max-width: 500px !important;
        }

        .appo-picker.is-large .appo-picker-list {
            max-width: 340px;
            padding-top: 10px !important;
        }

        .text-left-1 {
            text-align: left !important;
        }

        .flag {
            display: inline-block;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            text-align: center;
            border: 1px solid #0D99FF;
            position: absolute;
            top: -5px;
            background: #0D99FF;
            z-index: 10;
            font-size: 12px;
            color: #ffffff;
        }

        .flag-1 {
            left: -12px;
        }

        .flag-2 {
            left: 450px;
        }

        .flag-3 {
            left: 920px;
        }

        .flag-4 {
            left: 920px;
        }

        @media only screen and (max-width: 1240px) {
            .flag-2 {
                left: 378px;
            }

            .flag-3 {
                left: 764px;
            }

            .flag-4 {
                left: 772px;
            }
        }

        @media only screen and (max-width: 999px) {
            .flag-2 {
                left: 190px;
            }

            .flag-3 {
                left: 390px;
            }

            .flag-4 {
                left: 575px;
            }
        }

        @media only screen and (max-width: 768px) {
            .flag-2 {
                left: 281px;
            }

            .flag-3 {
                left: 568px;
            }

            .flag-4 {
                left: 580px;
            }
        }

        @media only screen and (max-width: 425px) {
            .flag-2 {
                left: 124px;
            }

            .flag-3 {
                left: 254px;
            }

            .flag-4 {
                left: 265px;
            }
        }

        @media only screen and (max-width: 375px) {
            .flag-2 {
                left: 106px;
            }

            .flag-3 {
                left: 223px;
            }

            .flag-4 {
                left: 225px;
            }
        }

        @media only screen and (max-width: 320px) {
            .flag-2 {
                left: 87px;
            }

            .flag-3 {
                left: 184px;
            }

            .flag-4 {
                left: 200px;
            }
        }
    </style>
    <div class="container">
        <div class="row">
            <div class="col-md-12 d-flex justify-content-between mt-5 mb-4">
                <img src="{{ asset('assets/images/247 NEW Logo 2.png') }}" alt="Logo" width="150px" class="img-fluid">
                <div class="col-md-1 text-center">
                    <a href="{{ url('') }}" class="link-dark"><i class="fa-solid fa-xmark fa-2x"></i></a>
                </div>
            </div>
        </div>
    </div>

    <!-- logo end -->

    <!-- prograss bar -->

    <div class="container mt-3">
        <div class="d-flex justify-content-center align-items-center">
            <div class=" col-8 col-md-10">
                <div class="progress" style="position: relative; overflow: visible;">
                    <div class="progress-bar active" role="progressbar" style="background: #ABFF00;"></div>
                    <span class="flag flag-1">1</span>
                    <span class="flag flag-2">2</span>
                    <span class="flag flag-3">3</span>
                    {{-- <span class="flag flag-4">4</span> --}}
                </div>
            </div>

        </div>
    </div>

    <!-- End prograss bar -->
    <div class="container">
        <div class="panel-group">
            <div class="row panel panel-primary">

                {{-- student payment process --}}
                {{-- @if (Auth::user()->role_id == '4') --}}
                <form role="form" action="{{ route('stripe.post') }}" method="post" class="require-validation"
                    data-cc-on-file="false"
                    data-stripe-publishable-key="pk_test_51O4cl2Iml1HP3wz7XFNa5N0OGpZyMTKiCgTyM1yO6ZZRL36cI9faSLn7Ahee5BAMbX2G5yEBnAIWoPbwRQTngD3D00zEJ71Ubv"
                    id="payment-form">
                    @csrf
                    <input type="hidden" required name="tutor_id" value="{{ $tutor->id }}">
                    <fieldset id="account">
                        <div class="panel-body mt-5">
                            <h2 class="text-left fs-1" id="text-color"><strong>Who Would You Like A Lesson With?</strong></h2><br>
                        </div>
                        <div class="d-flex flex-column flex-md-row justify-content-between">
                            <div class="col-md-7 col-12">
                                <label>Subject & Level</label><br>
                                <select required name="subject" id="changesubject" class="w-100 p-2">
                                    @if (!empty($offersubjects))
                                        @foreach ($offersubjects as $offersubject)
                                            <option value="{{ $offersubject->subject_id }}"
                                                {{ $tutor->subject_id == $offersubject->subject_id ? 'selected' : '' }}
                                                data-fee="{{ $offersubject->fee }}">
                                                {{ !empty($offersubject->subject) ? $offersubject->subject->name : '' }}
                                                -
                                                {{ !empty($offersubject->levelstring) ? $offersubject->levelstring : '' }}
                                                -
                                                £{{ $offersubject->fee }}/hr
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                @if (Auth::user()->role_id == '5' && !empty($students))
                                    <label>Students</label>
                                    <select required name="user_id" id="changesubject" class="w-100 p-2">
                                        @foreach ($students as $student)
                                            <option value="{{ $student->id }}">
                                                {{ $student->first_name . ' ' . $student->last_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                @endif
                                <div class="row ">
                                    <div class="col-md-6 my-3">
                                        <label class="text-secondary">Date</label><br>
                                        <input type="date" id="date" required name="date" minDate="0"
                                            class="w-100 p-2" max="9999-12-31">
                                    </div>

                                    <div class="col-md-6 my-3">
                                        <label class="text-secondary">Time</label><br>
                                        {{-- <input type="time" required name="time" class="w-100 p-3"> --}}
                                        <input id="time-1" required name="time" readonly type="text" class="w-100 p-2">
                                        <span id="time-1122" style="color: red"></span>

                                    </div>
                                </div>
                            </div>
                            <div class="form-1 col-md-4 col-12 d-flex p-2 h-25 me-5 mt-4 shadow"
                                style=" background: #ABFF00; border-radius: 10px;">
                                @if (!empty($tutor->image) && file_exists(public_path(!empty($tutor->image) ? $tutor->image : '')))
                                    <img src="{{ asset($tutor->image ?? 'assets\images\default.png') }}" alt=""
                                        style="height:50px;width:50px;border-radius:50%;">
                                @else
                                    @if ($tutor->gender == 'Male')
                                        <img src="{{ asset('assets/images/male.jpg') }}" style="height:50px;width:50px;border-radius:50%;">
                                    @elseif($tutor->gender == 'Female')
                                        <img src="{{ asset('assets/images/female.jpg') }}" style="height:50px;width:50px;border-radius:50%;">
                                    @else
                                        <img src="{{ asset('assets/images/default.png') }}" style="height:50px;width:50px;border-radius:50%;">
                                    @endif
                                @endif
                                <div class="text px-3 d-flex flex-column">
                                    <span class="fw-bold">{{ $tutor->username }}</span>
                                     <span>{{ $tutor->facebook_link }}</span> 
                                </div>
                            </div>
                        </div>
                        <hr class="w-75 m-auto mt-5" />
                        <div class="d-flex  col-12 justify-content-center m-auto my-5 gap-2">
                            <a href="#" class="link-dark previous btn " id="previous1"><i
                                    class="fa fa-light fa-arrow-left"></i>
                                Back</a>
                            <input type="button" required name="password" class=" next btn btn-primary px-5" value="Next"
                                id="next1" />
                        </div>
                    </fieldset>
                    <fieldset id="contact">
                        <div class="panel-body mt-5">
                            <h2 class="text-left text-primary fs-2"><strong>What's Your Billing Address?</strong></h2>
                            <br>
                            <div class="d-flex flex-column flex-md-row justify-content-between">
                                <div class="col-lg-7 col-md-6 col-12">
                                    <div class="">
                                        <label class="text-secondary">Country</label><br>
                                        <select required name="country" id="country" class="w-100 p-2">
                                            <option value="Afghanistan">Afghanistan</option>
                                            <option value="Albania">Albania</option>
                                            <option value="Algeria">Algeria</option>
                                            <option value="Andorra">Andorra</option>
                                            <option value="Angola">Angola</option>
                                            <option value="Antigua and Barbuda">Antigua and Barbuda</option>
                                            <option value="Argentina">Argentina</option>
                                            <option value="Armenia">Armenia</option>
                                            <option value="Australia">Australia</option>
                                            <option value="Austria">Austria</option>
                                            <option value="Azerbaijan">Azerbaijan</option>
                                            <option value="Bahamas">Bahamas</option>
                                            <option value="Bahrain">Bahrain</option>
                                            <option value="Bangladesh">Bangladesh</option>
                                            <option value="Barbados">Barbados</option>
                                            <option value="Belarus">Belarus</option>
                                            <option value="Belgium">Belgium</option>
                                            <option value="Belize">Belize</option>
                                            <option value="Benin">Benin</option>
                                            <option value="Bhutan">Bhutan</option>
                                            <option value="Bolivia">Bolivia</option>
                                            <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
                                            <option value="Botswana">Botswana</option>
                                            <option value="Brazil">Brazil</option>
                                            <option value="Brunei">Brunei</option>
                                            <option value="Bulgaria">Bulgaria</option>
                                            <option value="Burkina Faso">Burkina Faso</option>
                                            <option value="Burundi">Burundi</option>
                                            <option value="Cabo Verde">Cabo Verde</option>
                                            <option value="Cambodia">Cambodia</option>
                                            <option value="Cameroon">Cameroon</option>
                                            <option value="Canada">Canada</option>
                                            <option value="Central African Republic">Central African Republic</option>
                                            <option value="Chad">Chad</option>
                                            <option value="Chile">Chile</option>
                                            <option value="China">China</option>
                                            <option value="Colombia">Colombia</option>
                                            <option value="Comoros">Comoros</option>
                                            <option value="Congo">Congo</option>
                                            <option value="Costa Rica">Costa Rica</option>
                                            <option value="Croatia">Croatia</option>
                                            <option value="Cuba">Cuba</option>
                                            <option value="Cyprus">Cyprus</option>
                                            <option value="Czech Republic">Czech Republic</option>
                                            <option value="Denmark">Denmark</option>
                                            <option value="Djibouti">Djibouti</option>
                                            <option value="Dominica">Dominica</option>
                                            <option value="Dominican Republic">Dominican Republic</option>
                                            <option value="Ecuador">Ecuador</option>
                                            <option value="Egypt">Egypt</option>
                                            <option value="El Salvador">El Salvador</option>
                                            <option value="Equatorial Guinea">Equatorial Guinea</option>
                                            <option value="Eritrea">Eritrea</option>
                                            <option value="Estonia">Estonia</option>
                                            <option value="Eswatini">Eswatini</option>
                                            <option value="Ethiopia">Ethiopia</option>
                                            <option value="Fiji">Fiji</option>
                                            <option value="Finland">Finland</option>
                                            <option value="France">France</option>
                                            <option value="Gabon">Gabon</option>
                                            <option value="Gambia">Gambia</option>
                                            <option value="Georgia">Georgia</option>
                                            <option value="Germany">Germany</option>
                                            <option value="Ghana">Ghana</option>
                                            <option value="Greece">Greece</option>
                                            <option value="Grenada">Grenada</option>
                                            <option value="Guatemala">Guatemala</option>
                                            <option value="Guinea">Guinea</option>
                                            <option value="Guinea-Bissau">Guinea-Bissau</option>
                                            <option value="Guyana">Guyana</option>
                                            <option value="Haiti">Haiti</option>
                                            <option value="Honduras">Honduras</option>
                                            <option value="Hungary">Hungary</option>
                                            <option value="Iceland">Iceland</option>
                                            <option value="India">India</option>
                                            <option value="Indonesia">Indonesia</option>
                                            <option value="Iran">Iran</option>
                                            <option value="Iraq">Iraq</option>
                                            <option value="Ireland">Ireland</option>
                                            <option value="Israel">Israel</option>
                                            <option value="Italy">Italy</option>
                                            <option value="Jamaica">Jamaica</option>
                                            <option value="Japan">Japan</option>
                                            <option value="Jordan">Jordan</option>
                                            <option value="Kazakhstan">Kazakhstan</option>
                                            <option value="Kenya">Kenya</option>
                                            <option value="Kiribati">Kiribati</option>
                                            <option value="Korea, North">Korea, North</option>
                                            <option value="Korea, South">Korea, South</option>
                                            <option value="Kosovo">Kosovo</option>
                                            <option value="Kuwait">Kuwait</option>
                                            <option value="Kyrgyzstan">Kyrgyzstan</option>
                                            <option value="Laos">Laos</option>
                                            <option value="Latvia">Latvia</option>
                                            <option value="Lebanon">Lebanon</option>
                                            <option value="Lesotho">Lesotho</option>
                                            <option value="Liberia">Liberia</option>
                                            <option value="Libya">Libya</option>
                                            <option value="Liechtenstein">Liechtenstein</option>
                                            <option value="Lithuania">Lithuania</option>
                                            <option value="Luxembourg">Luxembourg</option>
                                            <option value="Madagascar">Madagascar</option>
                                            <option value="Malawi">Malawi</option>
                                            <option value="Malaysia">Malaysia</option>
                                            <option value="Maldives">Maldives</option>
                                            <option value="Mali">Mali</option>
                                            <option value="Malta">Malta</option>
                                            <option value="Marshall Islands">Marshall Islands</option>
                                            <option value="Mauritania">Mauritania</option>
                                            <option value="Mauritius">Mauritius</option>
                                            <option value="Mexico">Mexico</option>
                                            <option value="Micronesia">Micronesia</option>
                                            <option value="Moldova">Moldova</option>
                                            <option value="Monaco">Monaco</option>
                                            <option value="Mongolia">Mongolia</option>
                                            <option value="Montenegro">Montenegro</option>
                                            <option value="Morocco">Morocco</option>
                                            <option value="Mozambique">Mozambique</option>
                                            <option value="Myanmar">Myanmar</option>
                                            <option value="Namibia">Namibia</option>
                                            <option value="Nauru">Nauru</option>
                                            <option value="Nepal">Nepal</option>
                                            <option value="Netherlands">Netherlands</option>
                                            <option value="New Zealand">New Zealand</option>
                                            <option value="Nicaragua">Nicaragua</option>
                                            <option value="Niger">Niger</option>
                                            <option value="Nigeria">Nigeria</option>
                                            <option value="North Macedonia">North Macedonia</option>
                                            <option value="Norway">Norway</option>
                                            <option value="Oman">Oman</option>
                                            <option value="Pakistan">Pakistan</option>
                                            <option value="Palau">Palau</option>
                                            <option value="Panama">Panama</option>
                                            <option value="Papua New Guinea">Papua New Guinea</option>
                                            <option value="Paraguay">Paraguay</option>
                                            <option value="Peru">Peru</option>
                                            <option value="Philippines">Philippines</option>
                                            <option value="Poland">Poland</option>
                                            <option value="Portugal">Portugal</option>
                                            <option value="Qatar">Qatar</option>
                                            <option value="Romania">Romania</option>
                                            <option value="Russia">Russia</option>
                                            <option value="Rwanda">Rwanda</option>
                                            <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
                                            <option value="Saint Lucia">Saint Lucia</option>
                                            <option value="Saint Vincent and the Grenadines">Saint Vincent and the Grenadines</option>
                                            <option value="Samoa">Samoa</option>
                                            <option value="San Marino">San Marino</option>
                                            <option value="Sao Tome and Principe">Sao Tome and Principe</option>
                                            <option value="Saudi Arabia">Saudi Arabia</option>
                                            <option value="Senegal">Senegal</option>
                                            <option value="Serbia">Serbia</option>
                                            <option value="Seychelles">Seychelles</option>
                                            <option value="Sierra Leone">Sierra Leone</option>
                                            <option value="Singapore">Singapore</option>
                                            <option value="Slovakia">Slovakia</option>
                                            <option value="Slovenia">Slovenia</option>
                                            <option value="Solomon Islands">Solomon Islands</option>
                                            <option value="Somalia">Somalia</option>
                                            <option value="South Africa">South Africa</option>
                                            <option value="South Sudan">South Sudan</option>
                                            <option value="Spain">Spain</option>
                                            <option value="Sri Lanka">Sri Lanka</option>
                                            <option value="Sudan">Sudan</option>
                                            <option value="Suriname">Suriname</option>
                                            <option value="Sweden">Sweden</option>
                                            <option value="Switzerland">Switzerland</option>
                                            <option value="Syria">Syria</option>
                                            <option value="Taiwan">Taiwan</option>
                                            <option value="Tajikistan">Tajikistan</option>
                                            <option value="Tanzania">Tanzania</option>
                                            <option value="Thailand">Thailand</option>
                                            <option value="Timor-Leste">Timor-Leste</option>
                                            <option value="Togo">Togo</option>
                                            <option value="Tonga">Tonga</option>
                                            <option value="Trinidad and Tobago">Trinidad and Tobago</option>
                                            <option value="Tunisia">Tunisia</option>
                                            <option value="Turkey">Turkey</option>
                                            <option value="Turkmenistan">Turkmenistan</option>
                                            <option value="Tuvalu">Tuvalu</option>
                                            <option value="Uganda">Uganda</option>
                                            <option value="Ukraine">Ukraine</option>
                                            <option value="United Arab Emirates">United Arab Emirates</option>
                                            <option value="United Kingdom">United Kingdom</option>
                                            <option value="United States">United States</option>
                                            <option value="Uruguay">Uruguay</option>
                                            <option value="Uzbekistan">Uzbekistan</option>
                                            <option value="Vanuatu">Vanuatu</option>
                                            <option value="Vatican City">Vatican City</option>
                                            <option value="Venezuela">Venezuela</option>
                                            <option value="Vietnam">Vietnam</option>
                                            <option value="Yemen">Yemen</option>
                                            <option value="Zambia">Zambia</option>
                                            <option value="Zimbabwe">Zimbabwe</option>
                                        </select>

                                    </div>
                                    <div class="mt-2 mt-md-3">
                                        <label class="text-secondary">Address 1</label><br>
                                        <input type="text" required name="address1" id="address1" class="w-100 p-2">
                                    </div>
                                    <div class="mt-2 mt-md-3">
                                        <label class="text-secondary">Address 2</label><br>
                                        <input type="text" required name="address2" id="address2" class="w-100 p-2">
                                    </div>
                                    <div class="mt-2 mt-md-3">
                                        <label class="text-secondary">Town/City</label><br>
                                        <input type="text" required name="city" id="city"
                                            placeholder="Cambridge" class="w-100 p-2">
                                    </div>
                                    <div class="mt-2 mt-md-3">
                                        <label class="text-secondary">Postcode</label><br>
                                        <input type="text" required name="postcode" id="postcode"
                                            placeholder="CB1 0GN" class="w-100 p-2">
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-5 col-12 p-3 h-25 mt-4 mt-md-0 me-5">


                                    <div class="form-1  shadow pb-3 p-2" style=" background: #ABFF00; border-radius: 12px;">

                                        <div class="d-flex">
                                            @if (!empty($tutor->image) && file_exists(public_path(!empty($tutor->image) ? $tutor->image : '')))
                                                <!-- <img src="{{ $tutor->image }}" alt="" width="70"
                                                        height="70"> -->
                                                <img src="{{ asset($tutor->image ?? 'assets\images\default.png') }}"
                                                    alt="" style="height:50px;width:50px;border-radius:50%;">
                                            @else
                                                @if ($tutor->gender == 'Male')
                                                    <img src="{{ asset('assets/images/male.jpg') }}"
                                                       style="height:50px;width:50px;border-radius:50%;">
                                                @elseif($tutor->gender == 'Female')
                                                    <img src="{{ asset('assets/images/female.jpg') }}"
                                                        style="height:50px;width:50px;border-radius:50%;">
                                                @else
                                                    <img src="{{ asset('assets/images/default.png') }}"
                                                        style="height:50px;width:50px;border-radius:50%;">
                                                @endif
                                            @endif
                                            <div class="text p-3 d-flex flex-column">
                                                <span  class="fw-bold">{{ $tutor->username }}</span>
                                                 <span>{{ $tutor->facebook_link }}</span> 
                                            </div>
                                        </div>
                                        <div class="summary-item mt-3" style="line-height: 0.7;">

                                            <!-- <div class="summary px-3 d-flex justify-content-between">
                                                    <p>Saturdays at 13:30-14:25</p>
                                                    <p id="feeId">£{{ $tutor->fee }}</p>
                                                </div> -->
                                            <div class="summary px-3 d-flex justify-content-between">
                                                <p>Discount</p>
                                                <p id="discountId">0%</p>
                                            </div>
                                            <div class="summary px-3 d-flex justify-content-between">
                                                <p>Total to Pay</p>
                                                <p class="total">£{{ $tutor->fee }}</p>
                                            </div>
                                            <!-- <div class="summary px-3 d-flex justify-content-between">
                                                    <p>Next lesson: Saturday 28 Aug</p>
                                                    <p class="total">£{{ $tutor->fee }}</p>
                                                </div> -->
                                        </div>
                                        <div class="summary-text mt-3">
                                            <p class="text-center">
                                                We'll take payment 24hrs before each lesson
                                                Make changes before then free of charge.
                                                See terms and conditions lahore
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex  col-12 justify-content-center m-auto my-5 gap-2">
                            <a href="#" class="link-dark previous btn " id="previous3"><i
                                    class="fa fa-light fa-arrow-left"></i>
                                Back</a>
                            <input type="button" required name="password" class="next btn btn-primary px-5"
                                value="Next" id="next3" />
                        </div>
                    </fieldset>

                    <fieldset id="personal">
                        <div class="panel-body mt-5">
                            <h2 class="text-left text-primary fs-2"><strong>Confirm your Booking</strong></h2><br>
                            <div class="d-flex col-lg-7 col-md-6 justify-content-between align-items-center">
                                <h2 class="text-left text-secondary fs-4"><strong>Credit or Debit Card</strong></h2>
                                <br>

                                <h2 class="text-left text-secondary fs-4"><strong id="walletText"></strong></h2>
                                <img src="{{ asset('assets/images/mastercard.png') }}" alt="visa cards" width="100"
                                    height="auto">
                            </div>

                            <div class="d-flex flex-column flex-md-row justify-content-between">
                                <div class="col-lg-7 col-md-6 col-12">
                                    <div class="row col-md-12">
                                        <div class="col-md-6">
                                            <div class='col-xs-12 form-group required'>
                                                <label class='control-label'>Name on Card</label> <input
                                                    class=" w-100 p-2" size='4' type='text' required
                                                    name="account_holder_name">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class='col-xs-12 form-group required'>
                                                <label class='control-label'>Payed Amount</label> <input
                                                    class=" w-100 p-2" size='4' type='text' readonly
                                                    name="amount" id="amount2">
                                            </div>
                                        </div>

                                        <input type="hidden" class="w-100 p-2" required name="wallet" id="wallet"
                                            value="">


                                    </div>
                                    <div class="mt-5 row col-md-12">
                                        <div class="col-md-12">
                                            <label class="text-secondary">Card Number</label><br>
                                            <input autocomplete='off' required name="card_number"
                                                class='card-number w-100 p-2' size='20' type='text'
                                                id='cardInput'>
                                        </div>
                                    </div>
                                    <div class="mt-5 row col-md-12">

                                        <div class="col-md-4">
                                            <label class="text-secondary">CVC Number</label><br>
                                            <input type="text" required name="cvc" placeholder='ex. 311'
                                                class="w-100 p-2 card-cvc" id="cvcInput">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="text-secondary">Expiration Month</label><br>
                                            <input type="text" required name="exp_month" placeholder="MM"
                                                class="w-100 p-2 card-expiry-month">
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
                                                class="w-100 p-2 card-expiry-year" id="exp_year_input">
                                        </div>
                                    </div>


                                    <div class="mt-5 row col-md-12">
                                        <div class="col-md-6 d-flex">
                                            <input type="checkbox" required name="card_number"
                                                class='card-number mb-4 mx-2'>
                                            <label class="text-secondary">I can confirm legellay authorised to use this
                                                details for payments</label><br>

                                        </div>
                                        <div class="col-md-6 d-flex">
                                            <input type="checkbox" name="cardSaveCheck" id="cardSaveCheck"
                                                value="1" class='card-number mb-4 mx-2'>
                                            <label class="text-secondary">Save card details for future
                                                transactions</label><br>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-lg-4 col-md-5 col-12 p-3 h-25 mt-4 mt-md-0 me-5">

                                    <div class="bg-primary p-2 mb-2 rounded-3">
                                        <h5 class="m-0 ps-3 text-dark">Check your email for coupon</h5>
                                        <div class="summary gap-1 mt-3 d-flex justify-content-between">
                                            <input type="hidden" required name="amount" id="amount"
                                                value="{{ $tutor->fee }}">
                                            <input type="text" class="w-100 p-1 mb-1" name="Coupon" id="coupon"
                                                placeholder="Enter Coupon Code"
                                                style="border:1px solid #ABFF00;border-radius: 10px;" value="">
                                            <input type="button" class="w-95 p-1 mb-1" value="Confirm" id="confirm"
                                                style="border:1px solid #ABFF00;border-radius: 10px;">

                                        </div>
                                        <div class="summary px-3 d-flex justify-content-between">
                                            <p id="errormsg" style="color: red"></p>
                                        </div>
                                    </div>
                                    <div class="form-1  shadow p-2" style=" background: #ABFF00; border-radius: 12px;">

                                        <div class="d-flex">
                                            @if (!empty($tutor->image) && file_exists(public_path(!empty($tutor->image) ? $tutor->image : '')))
                                                <!-- <img src="{{ $tutor->image }}" alt="" width="70"
                                                        height="70"> -->
                                                <img src="{{ asset($tutor->image ?? 'assets\images\default.png') }}"
                                                    alt="" style="height:70px;width:70px;border-radius:50%;">
                                            @else
                                                @if ($tutor->gender == 'Male')
                                                    <img src="{{ asset('assets/images/male.jpg') }}"
                                                        height="70"style="height:70px;width:70px;border-radius:50%;">
                                                @elseif($tutor->gender == 'Female')
                                                    <img src="{{ asset('assets/images/female.jpg') }}"
                                                        style="height:70px;width:70px;border-radius:50%;">
                                                @else
                                                    <img src="{{ asset('assets/images/default.png') }}"
                                                        style="height:70px;width:70px;border-radius:50%;">
                                                @endif
                                            @endif
                                            <div class="text p-3 d-flex flex-column">
                                                <span>{{ $tutor->username }}</span>
                                                <!-- <span class="fw-bold">Chemistry GSSE</span> -->
                                            </div>
                                        </div>
                                        <div class="summary-item mt-2" style="line-height: 0.7;">

                                            <!-- <div class="summary px-3 d-flex justify-content-between">
                                                    <p>Saturdays at 13:30-14:25</p>
                                                    <p id="feeId">£{{ $tutor->fee }}</p>
                                                </div> -->
                                            <div class="summary px-3 d-flex justify-content-between">
                                                <p>Discount</p>
                                                <p id="dicountId">0%</p>
                                            </div>
                                            <div class="summary px-3 d-flex justify-content-between">
                                                <p>Total to Pay</p>
                                                <p class="total">£{{ $tutor->fee }}</p>
                                            </div>
                                            <!-- <div class="summary px-3 d-flex justify-content-between">
                                                    <p>Next lesson: Saturday 28 Aug</p>
                                                    <p class="total">£{{ $tutor->fee }}</p>
                                                </div> -->
                                        </div>
                                        <div class="summary-text mt-3">
                                            <p class="text-center">
                                                We'll take payment 24hrs before each lesson
                                                Make changes before then free of charge.
                                                See terms and conditions lahore
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" class="w-100 p-3" required name="copounid" id="copounid" value="">

                        <div class="d-flex  col-12 justify-content-center m-auto my-5 gap-2"
                            style="margin-top: 80px !important;">
                            <a href="#" class="link-dark previous btn " id="previous4"><i
                                    class="fa fa-light fa-arrow-left"></i>
                                Back</a>
                            <input type="submit" class=" next btn btn-primary px-5" value="Pay" id="next3" />
                        </div>
                    </fieldset>

                </form>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/timeslot.min.js') }}"></script>
    <script>
        let id = {!! json_encode($tutor->id) !!};

        var picker = '';
        let slots = '';
        let message = '';

        $(document).ready(function() {


            var form_count = 1;
            var total_forms = $("fieldset").length;

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
                            var timeInput = document.getElementById("time-1");
                            if (data.disabled_slots.length === 5) {

                                timeInput.removeAttribute("readonly");
                            }else{
                            var timeInput = document.getElementById("time-1");
                            var time1122 = document.getElementById("time-1122");
                            time1122.innerText = '';
                            }

                        }else{
                            var timeInput = document.getElementById("time-1");
                            var time1122 = document.getElementById("time-1122");
                            time1122.innerText = 'At This Day This Tutor Not available';
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

            $('#time-1').keydown(function(e) {
                e.preventDefault();
                return false;
            });

            // Hide all fieldsets except the first one
            $("fieldset:not(:first)").hide();

            // Function to set the progress bar
            function setProgressBar(curStep) {
                var percent = (curStep - 1) / (total_forms - 1) * 100;
                $(".progress-bar")
                    .css("width", percent + "%")
                // .html(percent.toFixed(0) + "%");
            }

            // Function to show the next step and hide the current step
            function showNextStep() {
                if (validateStep(form_count)) {
                    var currentFieldset = $("fieldset:visible");
                    var nextFieldset = currentFieldset.next("fieldset");
                    if (nextFieldset.length > 0) {
                        currentFieldset.hide();
                        nextFieldset.show();
                        form_count++;
                        setProgressBar(form_count);
                    }
                } else {
                    if (messsage != '') {
                        Swal.fire({
                            position: 'center',
                            icon: 'error',
                            title: message,
                            showConfirmButton: false,
                            timer: 2000,
                            showCloseButton: true
                        });
                    } else {
                        Swal.fire({
                            position: 'center',
                            icon: 'error',
                            title: 'Please fill in all required fields.',
                            showConfirmButton: false,
                            timer: 2000,
                            showCloseButton: true
                        });
                    }

                }
            }

            function validateStep(step) {
                var isValid = true;
                // You can add your validation logic here for the fields in the current step
                // Example:
                if (step === 1) {
                    if ($('#changesubject').val() === '' || $('#date').val() === '' || $('#time-1').val() === '') {
                        isValid = false;
                    } else {

                        let date = $('#date').val();
                        let slot = $('#time-1').val();
                        let tr = id;

                        $.ajax({
                            url: '{{ url('check-slot') }}',
                            type: 'POST',
                            data: {
                                date: date,
                                slot: slot,
                                tr: id,
                            },
                            async: false,
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            },
                            success: function(data) {
                                console.log(data)
                                if (data.success == false) {
                                    isValid = false;
                                    message = 'Slot is already reserved please choose another';
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

                    }
                } else if (step === 2) {
                    if ($('#country').val() === '' || $('#address1').val() === '' || $('#address2').val() === '' ||
                        $('#city').val() === '' || $('#postcode').val() === '') {
                        isValid = false;
                    }
                }
                return isValid;
            }

            // Function to show the previous step and hide the current step
            function showPreviousStep() {
                var currentFieldset = $("fieldset:visible");
                var previousFieldset = currentFieldset.prev("fieldset");

                if (previousFieldset.length > 0) {
                    currentFieldset.hide();
                    previousFieldset.show();
                    form_count--;
                    setProgressBar(form_count);
                }
            }

            // Handle the "Next" button click
            $(".next").click(function() {
                showNextStep();
            });

            // Handle the "Previous" button click
            $(".previous").click(function() {
                showPreviousStep();
            });

            // Handle the "Submit" button click (you can adjust this as needed)
            $(".submit").click(function() {
                // You can add your form submission logic here
                // alert("Form submitted!");
            });


        });

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
    </script>
    <script>
        $(document).ready(function() {
            // $('.input-phone').intlInputPhone();
        })
    </script>
    <script type="text/javascript">
        var _gaq = _gaq || [];
        _gaq.push(['_setAccount', 'UA-36251023-1']);
        _gaq.push(['_setDomainName', 'jqueryscript.net']);
        _gaq.push(['_trackPageview']);

        (function() {
            var ga = document.createElement('script');
            ga.type = 'text/javascript';
            ga.async = true;
            ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') +
                '.google-analytics.com/ga.js';
            var s = document.getElementsByTagName('script')[0];
            s.parentNode.insertBefore(ga, s);
        })();
    </script>
    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
    <script type="text/javascript">
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

        $(function() {
            var $form = $(".require-validation");

            $('form.require-validation').bind('submit', function(e) {
                var $form = $(".require-validation"),
                    inputSelector = ['input[type=email]', 'input[type=password]',
                        'input[type=text]', 'input[type=file]',
                        'textarea'
                    ].join(', '),
                    $inputs = $form.find('.required').find(inputSelector),
                    $errorMessage = $form.find('div.error'),
                    valid = true;
                $errorMessage.addClass('hide');

                $('.has-error').removeClass('has-error');
                $inputs.each(function(i, el) {
                    var $input = $(el);
                    if ($input.val() === '') {
                        $input.parent().addClass('has-error');
                        $errorMessage.removeClass('hide');
                        e.preventDefault();
                    }
                });

                if (!$form.data('cc-on-file')) {
                    e.preventDefault();
                    Stripe.setPublishableKey($form.data('stripe-publishable-key'));
                    Stripe.createToken({
                        number: $('.card-number').val(),
                        cvc: $('.card-cvc').val(),
                        exp_month: $('.card-expiry-month').val(),
                        exp_year: $('.card-expiry-year').val()
                    }, stripeResponseHandler);
                }

            });

            /*------------------------------------------
            --------------------------------------------
            Stripe Response Handler
            --------------------------------------------
            --------------------------------------------*/
            function stripeResponseHandler(status, response) {
                if (response.error) {
                    $('.error')
                        .removeClass('hide')
                        .find('.alert')
                        .text(response.error.message);
                } else {
                    /* token contains id, last4, and card type */
                    var token = response['id'];

                    $form.find('input[type=text]').empty();
                    $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
                    $form.get(0).submit();
                }
            }

        });
    </script>
    <div id="walletBalance" data-balance="{{ $Wallet->balance?? '0' }}"></div>
    <script>
        $(document).ready(function() {
            // get subject fee
            var selectedOption = $(this).find('option:selected');
            var fee = selectedOption.data('fee') - $('#walletBalance').data('balance');
            var wallet = $('#walletBalance').data('balance') - selectedOption.data('fee');

            if (fee < 0) {
                fee = 0;
            }
            if (wallet < 0) {
                wallet = 0;
            }

            $('#wallet').val(wallet);
            $('#walletText').text('Wallet Have Amount :' + wallet);

            $('#amount').val(fee);
            $('#amount2').val(fee);
            $('#feeId').text('$' + fee);
            $('.total').text('$' + fee);
            
            $('#feeId').text('$' + fee);
            $('.total').text('$' + selectedOption.data('fee'));
            
            
            $('#changesubject').on('change', function() {
                var selectedOption = $(this).find('option:selected');
                var fee = selectedOption.data('fee') - $('#walletBalance').data('balance');
                var wallet = $('#walletBalance').data('balance') - selectedOption.data('fee');

                if (fee < 0) {
                    fee = 0;
                }
                if (wallet < 0) {
                    wallet = 0;
                }

                $('#wallet').val(wallet);
                $('#walletText').text('Wallet Have Amount :' + wallet);

                $('#amount').val(fee);
                $('#amount2').val(fee);
                $('#feeId').text('$' + fee);
                $('.total').text('$' + fee);
                // alert(selectedOption.data('fee'));
            });
            // get coupon
            $('#confirm').on('click', function() {
                var coupon = $('#coupon').val();
                var fee = $('#amount').val();
                var fetchfee = 0;
                $('#errormsg').text('');
                $.ajax({
                    url: '{{ url('get-coupon') }}',
                    type: 'POST',
                    data: {
                        coupon: coupon,
                    },
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    success: function(data) {
                        $('#dicountId').text('');
                        fetchfee = 0;
                        if (data.price !== undefined) {
                            fetchfee = data.price;
                        }

                        if (data.id !== undefined) {
                            id = data.id;
                        }
                        $('#copounid').val(id);
                        $('#dicountId').text('$' + fetchfee + '%');

                        if(data.discount_type === 'percentage')
                        {
                            calculate = (fee / 100) * fetchfee;
                            discount = Math.max(calculate, 0);
                        }else{
                            discount = Math.max(fetchfee, 0);
                        }
                        
                        
                        var walletCheck=$('#wallet').val();
                        if(walletCheck > 0){
                         var TotalWallet = discount + parseFloat(walletCheck);
                        $('.total').text('$' + Math.max((fee - TotalWallet), 0));
                        $('#amount').hide();
                        $('#amount2').val(Math.max((fee  - fetchfee), 0));
                        $('#amount').val(Math.max((fee  - fetchfee), 0));
                        $('#wallet').val(TotalWallet);
                        $('#walletText').text('Wallet Have Amount :' + TotalWallet);
                        $('#feeId').text('$' + fee);
                        $('.total').text('$' + (selectedOption.data('fee') - fetchfee));
                        
                        
                        }else{
                        $('.total').text('$' + Math.max((fee - discount), 0));
                        $('#amount').hide();
                        $('#amount').val(Math.max((fee  - fetchfee), 0));
                        $('#amount2').val(Math.max((fee - discount), 0));
                        }
                        $('#coupon').val('');
                        $('#discountId').text('$' + fetchfee);
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
    </script>
    <script>
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
@endsection
