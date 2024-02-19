@php
    $Subjects = App\Models\Subject::distinct('name')->pluck('name');
@endphp
<div class="footer-wrapper container-fluid pt-4">
    <!-- Top-Footer -->
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-7 pb-3">
                <a href='{{ route('index') }}'> <img src="{{ asset('assets/images/247 NEW Logo 2.png') }}" alt=""
                        srcset="" width="250px"></a>
                <p class="py-3">
                    Accusamus etidio dignissimos ducimus blanditiis praesentium volupta eleniti atquete corrupti
                    quolores
                    etmquasa molestias epturi sinteam occaecati cupiditate non providente mikume molareshe.
                </p>
                <div>
                    <a href="@isset($web_settings['fblink']) {{ $web_settings['fblink'] ?? '' }} @endisset"
                        target="_blank"><img src="{{ asset('assets/images/01.png') }}" alt=""
                            srcset=""></a>
                    {{-- <a href="https://www.instagram.com/" target="_blank"><img src="./assets/images/" alt=""
                            srcset=""></a> --}}
                    <a href="@isset($web_settings['inlink']) {{ $web_settings['inlink'] ?? '' }} @endisset"
                        target="_blank"><img src="{{ asset('assets/images/03.png') }}" alt=""
                            srcset=""></a>
                    <a href="@isset($web_settings['instlink']) {{ $web_settings['instlink'] ?? '' }} @endisset"
                        target="_blank">
                        <img src="{{ asset('assets/images/instagram.svg') }}"
                            style="width: 44px; height: 44px; gap: 10px; padding: 14px; border-radius: 30px;";
                            id="bg-color" srcset="">
                    </a>
                    <a href="@isset($web_settings['xlink']) {{ $web_settings['xlink'] ?? '' }} @endisset"
                        target="_blank">
                        <img src="{{ asset('assets/images/Twitter-Logо.png') }}"
                            style="width: 43px;
    height: 41px;
    padding: 6px;
    border-radius: 50%;";
                            id="bg-color" srcset="">

                    </a>
                    <!--<a href="https://discord.com/" target="_blank"><img src="{{ asset('assets/images/05.png') }}"-->
                    <!--        alt="" srcset=""></a>-->
                </div>
            </div>
            <div class="col-12 col-md-5">
                <h5 class="text-white">Contact Us <span
                        style="color: rgba(180, 178, 178, 0.267);
                    font-size: 18px; margin-left: 5px;">(Expect
                        Response in 24 Working Hours)</span></h5>
                <div class="contact-info pt-3 ">
                    <p> <a href="tel:@isset($web_settings['Ph_num']) {{ $web_settings['Ph_num'] ?? '' }} @endisset"
                            class="text-decoration-none">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                                fill="none">
                                <g clip-path="url(#clip0_11_13513)">
                                    <path
                                        d="M16.7004 19.1C16.6004 19.1 16.5004 19.1 16.5004 19.1C13.8004 18.8 11.2004 17.9 8.90044 16.4C6.80044 15.1 5.00044 13.3 3.70044 11.1C2.20044 8.9 1.20044 6.3 0.90044 3.6C0.80044 2.2 1.80044 1 3.20044 0.8C3.30044 0.8 3.30044 0.8 3.40044 0.8H5.90044C7.10044 0.8 8.20044 1.7 8.40044 3C8.50044 3.7 8.70044 4.5 9.00044 5.2C9.30044 6.1 9.10044 7.1 8.40044 7.8L7.80044 8.4C8.80044 9.9 10.1004 11.2 11.6004 12.2L12.2004 11.6C12.9004 10.9 13.9004 10.7 14.8004 11C15.5004 11.3 16.2004 11.4 17.0004 11.5C18.3004 11.7 19.2004 12.8 19.2004 14V16.5C19.2004 18 18.1004 19.1 16.7004 19.1ZM5.90044 2.5H3.40044C2.90044 2.5 2.60044 3 2.60044 3.4C2.90044 5.8 3.70044 8.2 5.00044 10.3C6.20044 12.2 7.90044 13.8 9.70044 15C11.8004 16.3 14.1004 17.2 16.5004 17.4C17.0004 17.4 17.4004 17 17.4004 16.6V14.1C17.4004 13.7 17.1004 13.3 16.7004 13.3C15.8004 13.2 15.0004 13 14.2004 12.7C13.9004 12.6 13.5004 12.7 13.3004 12.9L12.2004 14C11.9004 14.3 11.5004 14.3 11.2004 14.1C9.10044 12.7 7.30044 10.9 6.00044 8.7C5.80044 8.4 5.90044 8 6.10044 7.7L7.20044 6.6C7.40044 6.4 7.50044 6 7.40044 5.7C7.10044 4.9 6.90044 4.1 6.80044 3.2C6.70044 2.8 6.40044 2.5 5.90044 2.5ZM15.8004 8.3C15.4004 8.3 15.1004 8 15.0004 7.6C14.7004 6.3 13.7004 5.2 12.4004 5C11.9004 4.9 11.7004 4.5 11.7004 4C11.8004 3.5 12.2004 3.3 12.7004 3.3C14.7004 3.7 16.3004 5.2 16.6004 7.3C16.7004 7.8 16.4004 8.2 15.9004 8.3C15.9004 8.3 15.9004 8.3 15.8004 8.3ZM19.2004 8.3C18.8004 8.3 18.4004 8 18.4004 7.6C18.0004 4.4 15.6004 2 12.5004 1.7C12.0004 1.6 11.7004 1.2 11.8004 0.8C11.9004 0.4 12.2004 0 12.6004 0C16.5004 0.4 19.5004 3.5 20.0004 7.4C20.0004 7.8 19.7004 8.2 19.2004 8.3Z"
                                        fill="#DDDDDD" />
                                </g>
                                <defs>
                                    <clipPath id="clip0_11_13513">
                                        <rect width="20" height="20" fill="white" />
                                    </clipPath>
                                </defs>
                            </svg>
                            @isset($web_settings['Ph_num'])
                                {{ $web_settings['Ph_num'] ?? '' }}
                            @endisset
                            <span>(Mon to Sun 9am - 11pm GMT)</span>
                        </a>
                    </p>
                    <p><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"
                            fill="none">
                            <path
                                d="M13.3596 2H2.63965C1.59965 2 0.639648 2.88 0.639648 4V12C0.639648 13.12 1.51965 14 2.63965 14H13.2796C14.3996 14 15.2796 13.12 15.2796 12V4C15.3596 2.88 14.3996 2 13.3596 2ZM2.63965 3.36H13.2796C13.5196 3.36 13.7596 3.52 13.8396 3.76L7.99965 7.84L2.07965 3.68C2.15965 3.52 2.39965 3.36 2.63965 3.36ZM13.9996 12C13.9996 12.4 13.6796 12.64 13.3596 12.64H2.63965C2.23965 12.64 1.99965 12.32 1.99965 12V5.28L7.59965 9.2C7.67965 9.28 7.83965 9.28 7.99965 9.28C8.15965 9.28 8.23965 9.28 8.39965 9.2L13.9996 5.28V12Z"
                                fill="#DDDDDD" />
                        </svg>
                        <a href="tel:@isset($web_settings['Maintopbaremail']) {{ $web_settings['Maintopbaremail'] ?? '' }} @endisset"
                            mailto:class="text-primary">
                            @isset($web_settings['Maintopbaremail'])
                                {{ $web_settings['Maintopbaremail'] ?? '' }}
                            @endisset
                        </a>
                    </p>
                    {{-- <p>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"
                            fill="none">
                            <g clip-path="url(#clip0_11_13520)">
                                <path
                                    d="M13.3596 5.36021H12.7196V1.36021C12.7196 0.960215 12.3996 0.720215 12.0796 0.720215H3.99965C3.59965 0.720215 3.35965 1.04021 3.35965 1.36021V5.36021H2.63965C1.59965 5.36021 0.639648 6.24021 0.639648 7.36021V10.7202C0.639648 11.8402 1.51965 12.7202 2.63965 12.7202H3.27965V14.7202C3.27965 15.1202 3.59965 15.3602 3.91965 15.3602H11.9196C12.3196 15.3602 12.5596 15.0402 12.5596 14.7202V12.7202H13.1996C14.3196 12.7202 15.1996 11.8402 15.1996 10.7202V7.36021C15.3596 6.24021 14.3996 5.36021 13.3596 5.36021ZM4.63965 2.00021H11.2796V5.36021H4.63965V2.00021ZM11.3596 14.0002H4.63965V10.0002H11.2796V14.0002H11.3596ZM13.9996 10.6402C13.9996 11.0402 13.6796 11.2802 13.3596 11.2802H12.7196V9.28022C12.7196 8.88021 12.3996 8.64021 12.0796 8.64021H3.99965C3.59965 8.64021 3.35965 8.96021 3.35965 9.28022V11.2802H2.63965C2.23965 11.2802 1.99965 10.9602 1.99965 10.6402V7.36021C1.99965 6.96021 2.31965 6.72021 2.63965 6.72021H13.2796C13.6796 6.72021 13.9196 7.04021 13.9196 7.36021V10.6402H13.9996Z"
                                    fill="#DDDDDD" />
                            </g>
                            <defs>
                                <clipPath id="clip0_11_13520">
                                    <rect width="16" height="16" fill="white" />
                                </clipPath>
                            </defs>
                        </svg>
                        +62 811 09998263
                    </p> --}}
                    <p><a href="https://api.whatsapp.com/send?phone=@isset($web_settings['MainPh_num']){{$web_settings['MainPh_num']??'' }} @endisset"

                            class="text-decoration-none d-flex align-items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"
                                fill="none">
                                <path
                                    d="M12.9031 3.03437C11.5938 1.72187 9.85 1 7.99687 1C4.17187 1 1.05937 4.1125 1.05937 7.9375C1.05937 9.15938 1.37813 10.3531 1.98438 11.4062L1 15L4.67812 14.0344C5.69063 14.5875 6.83125 14.8781 7.99375 14.8781H7.99687C11.8188 14.8781 15 11.7656 15 7.94063C15 6.0875 14.2125 4.34687 12.9031 3.03437ZM7.99687 13.7094C6.95937 13.7094 5.94375 13.4312 5.05937 12.9062L4.85 12.7812L2.66875 13.3531L3.25 11.225L3.1125 11.0063C2.53437 10.0875 2.23125 9.02812 2.23125 7.9375C2.23125 4.75938 4.81875 2.17188 8 2.17188C9.54062 2.17188 10.9875 2.77187 12.075 3.8625C13.1625 4.95312 13.8313 6.4 13.8281 7.94063C13.8281 11.1219 11.175 13.7094 7.99687 13.7094ZM11.1594 9.39062C10.9875 9.30313 10.1344 8.88438 9.975 8.82812C9.81563 8.76875 9.7 8.74062 9.58438 8.91562C9.46875 9.09062 9.1375 9.47813 9.03438 9.59688C8.93438 9.7125 8.83125 9.72812 8.65938 9.64062C7.64062 9.13125 6.97188 8.73125 6.3 7.57812C6.12188 7.27187 6.47812 7.29375 6.80937 6.63125C6.86562 6.51562 6.8375 6.41563 6.79375 6.32812C6.75 6.24062 6.40313 5.3875 6.25938 5.04063C6.11875 4.70312 5.975 4.75 5.86875 4.74375C5.76875 4.7375 5.65312 4.7375 5.5375 4.7375C5.42188 4.7375 5.23438 4.78125 5.075 4.95312C4.91562 5.12813 4.46875 5.54688 4.46875 6.4C4.46875 7.25313 5.09063 8.07813 5.175 8.19375C5.2625 8.30938 6.39687 10.0594 8.1375 10.8125C9.2375 11.2875 9.66875 11.3281 10.2188 11.2469C10.5531 11.1969 11.2437 10.8281 11.3875 10.4219C11.5312 10.0156 11.5312 9.66875 11.4875 9.59688C11.4469 9.51875 11.3313 9.475 11.1594 9.39062Z"
                                    fill="#DDDDDD" />
                            </svg>
                            @isset($web_settings['MainPh_num'])
                            {{ $web_settings['MainPh_num'] ?? '' }}
                        @endisset
                            <span>(Mon to Sun 9am - 11pm GMT)</span>
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <!-- Middle-Footer -->
    <div class="container border-top p-md-3 py-3">
        <div class="row">
            <div class="col col-md-7">
                <h5>Tutor by subjects</h5>
                @if (!empty($Subjects))
                    <div class="row">
                        <div class="col col-md-3">
                            <ul>
                                @php
                                    $subjectCount = 0;
                                @endphp
                                @foreach ($Subjects as $Subject)
                                    <li class="text-capitalize"><a
                                            href="{{ url('find-tutor?subject=') . $Subject }}">{{ $Subject }}</a>
                                    </li>
                                    @php $subjectCount++; @endphp
                                    @if ($subjectCount == 5)
                                    @break
                                @endif
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-12 col-md-4">
                        <ul>
                            @php
                                $extraSubjects = $subjectCount - 5;
                                $subjectCount = 0;
                            @endphp
                            @foreach ($Subjects as $Subject)
                                @if ($subjectCount >= 5)
                                    <!-- Limit to 15 records -->
                                    @if ($subjectCount == 5)
                                        <li><a
                                                href="{{ url('find-tutor?subject=') . $Subject }}">{{ $Subject }}</a>
                                        </li>
                                    @else
                                        <li>{{ $Subject }}</li>
                                    @endif
                                @endif
                                @php $subjectCount++; @endphp
                            @endforeach
                            <a href="{{ url('find-tutor') }}" class="text-primary d-inline-block py-2">Explore
                                all</a>
                        </ul>
                    </div>
                </div>
            @endif
        </div>
        <div class="col-12 col-md-5">
            <h5>Online classes</h5>
            @if (!empty($Subjects))
                <div class="row">
                    <div class="col col-md-6">
                        <ul>
                            @php
                                $subjectCount = 0;
                            @endphp
                            @foreach ($Subjects as $Subject)
                                <li><a href="{{ url('find-tutor?subject=') . $Subject }}">Online
                                        {{ $Subject }} classes</a>
                                </li>
                                @php $subjectCount++; @endphp
                                @if ($subjectCount == 5)
                                @break
                            @endif
                        @endforeach
                    </ul>
                </div>
                <div class="col">
                    <ul>
                        @php
                            $extraSubjects = $subjectCount - 5;
                            $subjectCount = 0;
                        @endphp
                        @foreach ($Subjects as $Subject)
                            @if ($subjectCount >= 5)
                                <!-- Limit to 15 records -->
                                @if ($subjectCount == 5)
                                    <li><a href="{{ url('find-tutor?subject=') . $Subject }}">Online
                                            {{ $Subject }} classes</a></li>
                                @else
                                    <li>Online {{ $Subject }} classes</li>
                                @endif
                            @endif
                            @php $subjectCount++; @endphp
                        @endforeach
                        <a href="{{ url('find-tutor') }}" class="text-primary d-inline-block py-2">Explore
                            all</a>
                    </ul>
                </div>
            </div>
        @endif
    </div>
</div>
</div>
<!-- last footer section -->
<div class="container border-top p-md-3 pt-4">
<div class="row justify-content-beetween">
    <div class="col-12 col-md-7 col-xl-6">
        <h5>Useful links</h5>
        <div class="row">
            <div class="col-6">
                <ul>
                    <li><a href="">Careers</a></li>
                    <li><a href="{{ url('blogs') }}">Blog</a></li>
                    <li><a href="">Subject answers</a></li>
                    <li><a href="{{ url('/privacypolicy') }}">Safegeuarding policy</a></li>
                </ul>
            </div>
            <div class="col-6">
                <ul>
                    <li><a href="{{ url('tutor-apply-steps') }}">Become a tutor</a></li>
                    <li><a href="">Testimonials & press</a></li>
                    <li><a href="{{ url('/videos-guides') }}">Using the Online Lesson Space</a></li>
                    <li><a href="{{ route('faq') }}">F.A.Q</a></li>
                    <li><a href="{{ url('/sitemap') }}">Sitemap</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-4 col-xl-3 py-3 d-none">
        <h5>Get mobile app</h5>
        <p>Take education on the go. Get our mobile app for FREE! on your Apple and android devices</p>
        <div>
            <a href="">
                <img src="./assets/images/iOS.png" alt="">
            </a>
            <a href="">
                <img src="./assets/images/Android.png" alt="" srcset="">
            </a>
        </div>
    </div>
    <form id="newsletterForm" action="{{ url('send/newsletter') }}" method="POST"
        style="display: contents;">
        @csrf
        <div class="col-12 col-md-5 col-xl-5 py-4 py-md-0">
            <h5>Signup for newsletter</h5>
            <p>Corrupti quolores etmquasa molestias epturite sinteam occaecati amet cupiditate mikume molareshe.
            </p>
            <div class="input-group input-group-lg">
                <input type="text" class="form-control email-input" name="email"
                    placeholder="Enter email address">
                <span class="input-group-text input-group-sm border-0 px-2" style="cursor: pointer"
                    id="bg-color">
                    <button class="btn bg-transparent px-2" type="submit">
                        <img src="{{ asset('assets/images/Icon (1).png') }}" alt="" srcset="">
                    </button>
                </span>
            </div>
        </div>
    </form>

</div>
</div>
<!-- bottom footer -->
<div class="container-fluid">

<div class="row py-2 text-center align-items-lg-center" style="background-color: rgba(0, 0, 0, 0.2);">
    <div class="col-12 col-lg-6 col-md-5">
        <h6>© 2023 All Rights Reserved.</h6>
    </div>
    <div class="col-12 col-md-7 col-lg-6 d-flex gap-3 bottom-footer-menu justify-content-center">
        <h6><a href="">Careers</a></h6>
        <h6><a href="{{ url('/testimonials') }}" class="text-primary">Terms of use</a></h6>
        <h6><a href="{{ url('/privacypolicy') }}">Privacy policy</a></h6>
    </div>
</div>
</div>
</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
@if (Auth::check() && Auth::user()->role_id == 3 && App\Models\TutorSubjectOffer::where('tutor_id', Auth::id())->where('fee', 0)->count() > 0)
    <script>
        $(document).ready(function() {
            toastr.error('Dear Tutor', 'Complete your profile and Your {{ App\Models\TutorSubjectOffer::where('tutor_id', Auth::id())->where('fee', 0)->count() }} Subjects Have zero Fee');
        });
    </script>
@endif

<audio id="bellSound">
  <source src="{{ asset('assets/bicycle-bell-155622.mp3')}}" type="audio/mpeg">
  Your browser does not support the audio element.
</audio>

<script>

    $(document).ready(function() {


        $('#newsletterForm').submit(function(event) {
            event.preventDefault();

            // AJAX request to submit the form
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        // Show success toaster notification
                        toastr.success(response.message);

                        // Reset the form
                        $('#newsletterForm')[0].reset();
                    } else {
                        // Show email validation error or general error
                        toastr.error(response.message);
                    }
                },
                error: function(error) {
                    // Show error toaster notification
                    toastr.error('Please Enter Only Email Or Already Email Used .');
                },
            });
        });
    });
</script>

@if (Auth::check())
    <script>

        setInterval(function() {
        $.ajax({
            url: "{{ url('CounterShow') }}",
            type: 'GET',
            success: function(response) {
                 var bellAudio = $('#bellSound')[0];
                $('.messgcount').text('');
                $('.countBooking').text('');
                $('.messgcount').hide();
                $('.countBooking').hide();
                 var bellSoundPlayed = false;
                if(response.countmessg != 0){
                    // bellAudio.play();
                    // bellSoundPlayed = true;

                $('.messgcount').text(response.countmessg);
                $('.messgcount').show();
                }

                if(response.countBooking != 0){
                $('.countBooking').text(response.countBooking);
                $('.countBooking').show();
                }

            }
        });
    }, 1000);
    </script>

    <script>
    var instance = $("[name=sheraz]")
    instance.intlTelInput();

    $("[name=sheraz]").on("blur", function() {
      console.log($(this).val())
      console.log(instance.intlTelInput('getSelectedCountryData').dialCode) //get counrty code
    })
</script>
@endif
