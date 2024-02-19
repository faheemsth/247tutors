@extends('layouts.app')
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
<style>
  @media only screen and (max-width:430px){
.hero-section-title h1{
  font-size: 2rem !important;
}
  }
</style>
<div class="container">

    <div class="row mt-5 justify-content-center">
      <div class="hero-section-title col-12 col-md-7 col-lg-7  mt-5">
        <h1 class="hero-heading"><b>@isset($web_settings['pricing_title']) {{ $web_settings['pricing_title'] ?? '' }} @endisset</b></h1>
        <p>@isset($web_settings['pricing_desc']) {{ $web_settings['pricing_desc'] ?? '' }} @endisset</p>
        <img src="./assets/images/Icon.png" alt="">
        <span>@isset($web_settings['pricing_short_desc']) {{ $web_settings['pricing_short_desc'] ?? '' }} @endisset</span>
      </div>
      <div class="col-12 col-lg-4 col-md-5 p-3 d-none d-md-flex align-items-end">
        <div class="first-header-model pt-5 pt-md-0">
          <img src="./assets/images/Image.png" alt="" class="header-shape">
        </div>
      </div>
    </div>

    <div class="container">


      <div class="boxes-center">
        <div class="price-boxes row d-flex justify-content-center mt-5">
          <a href="{{ url('find-tutor?min_price=20&max_price=29') }}" class="text-decoration-none p-box col-sm-6 col-md-4 col-lg-3" id="box1">
            <h2><b>£20 - £29</b></h2>
            <p>@isset($web_settings['pricecard1_desc']) {{$web_settings['pricecard1_desc'] ?? '' }} @endisset</p>
          </a>
          <a href="{{ url('find-tutor?min_price=40&max_price=87') }}" class="text-decoration-none p-box col-sm-6 col-md-4 col-lg-3" id="box2">
            <h2><b>£40 - £87</b></h2>
            <p>@isset($web_settings['pricecard2_desc']) {{$web_settings['pricecard2_desc'] ?? '' }} @endisset</p>
          </a>
          <a href="{{ url('find-tutor?min_price=90&max_price=119') }}" class="text-decoration-none p-box col-sm-6 col-md-4 col-lg-3" id="box3">
            <h2><b>£90 - £119</b></h2>
            <p>@isset($web_settings['pricecard3_desc']) {{$web_settings['pricecard3_desc'] ?? '' }} @endisset</p>
          </a>
        </div>
      </div>


    </div>


    <div class="boxcontent container w-75 mt-4">
      <p> @isset($web_settings['price_desc']) {{$web_settings['price_desc'] ?? '' }} @endisset</p>
    </div>
    <div class="find-tutor-budget mt-5 mb-4 py-3">
      <h1><b> Find a Tutor for your Budget </b></h1>
    </div>
    <div class="find-1-content d-flex justify-content-center mb-5">
      <a href="{{ url('find-tutor?min_price=20&max_price=29') }}" class="text-decoration-none find-1-text">
        <h5><b> Find £20 - £29 Tutors </b></h5>
      </a>
      <a href="{{ url('find-tutor?min_price=40&max_price=89') }}" class="text-decoration-none find-1-text ms-3">
        <h5><b> Find £40 - £89 Tutors </b></h5>
      </a>
      <a href="{{ url('find-tutor?min_price=90&max_price=119') }}" class="text-decoration-none find-1-text ms-3">
        <h5><b> Find £90 - £119 Tutors </b></h5>
      </a>
    </div>

  </div>

  <div class="container mt-5">
    <div class="row  pt-5 justify-content-xl-center align-items-center mb-5">
      <div class="mid-content1 col-12 col-lg-6 col-md-offset-1 mt-5">
        <h1>@isset($web_settings['card5_title']) {{ $web_settings['card5_title'] ?? '' }} @endisset</h1>
        <p>@isset($web_settings['card5_desc']) {{ $web_settings['card5_desc'] ?? '' }} @endisset
        </p>
      </div>
      <div class="col-12 col-lg-5 d-flex justify-content-center justify-content-lg-start">
        <img src="./assets/images/Frame@2x.png" alt="" class="mid-content1-img img-fluid">
      </div>
    </div>
    <div class="row justify-content-lg-center">
      <div class="col-12 col-lg-5 mt-4 order-2 order-lg-1 d-flex justify-content-center justify-content-lg-start">
        <img src="./assets/images/Character.png" alt="" width="100%" class="mid-content2-img img-fluid">
      </div>
      <div class="mid-content2 col-12 col-lg-6 col-md-offset-1 mt-4 order-1 order-lg-2 d-flex flex-column ">
        <h1 class="mt-2">@isset($web_settings['card6_title']) {{ $web_settings['card6_title'] ?? '' }} @endisset</h1>
        <p> @isset($web_settings['card6_desc']) {{$web_settings['card6_desc'] ?? '' }} @endisset</p>
      </div>
    </div>
  </div>
  <!-- Review Section  -->
  <div class="container-fluid py-5">
    <div class="row py-md-5" id="review-section-head">
      <div class="review-trustpilot col-12 text-center">
        <h1><text>4.5/5 Review <a href="#">on Trustpilot</a></text></h1>
      </div>
    </div>
    <div class="row py-3 justify-content-center mt-5">
      <div class="col-12 col-md-10 text-center">

        <div class="card-center">
          <div>
            <div class="card text-center review-card mx-auto">
              <div class="card-img-top px-4 pt-3 review-card mx-auto">
                <p>The institute boasts an impressive roster of tutors who are not only experts
                  in
                  their respective fields but also skilled in online teaching methods.
                </p>
                <div class="card-img-div">
                  <img src="./assets/images/imgpsh_fullsize_anim.png" class="mx-auto" alt="...">
                </div>
              </div>
              <div class="card-body">
                <img src="./assets/images/stars-steps.svg" alt="" srcset="" class="mx-auto">
                <p class="mb-0 mt-2">Mr John </p>
              </div>
            </div>
          </div>

          <div>
            <div class="card text-center review-card mx-auto ">
              <div class="card-img-top px-4 pt-3 review-card mx-auto">
                <p>Flexible Scheduling: As a student with a busy schedule, I appreciate the flexibility [ Tutor 24/7 ]
                  provides when it comes to scheduling sessions.
                </p>
                <div class="card-img-div pt-4">
                  <img src="./assets/images/imgpsh_fullsize_anim.png" class="mx-auto" alt="...">
                </div>
              </div>
              <div class="card-body ">
                <img src="./assets/images/stars-steps.svg" alt="" srcset="" class="mx-auto">
                <p class="mb-0 mt-2">Miss Wick </p>
              </div>
            </div>
          </div>

          <div>
            <div class="card text-center review-card mx-auto">
              <div class="card-img-top px-4 pt-3 review-card mx-auto">
                <p>The institute boasts an impressive roster of tutors who are not only experts
                  in
                  their respective fields but also skilled in online teaching methods.
                </p>
                <div class="card-img-div">
                  <img src="./assets/images/imgpsh_fullsize_anim.png" class="mx-auto" alt="...">
                </div>
              </div>
              <div class="card-body">
                <img src="./assets/images/stars-steps.svg" alt="" srcset="" class="mx-auto">
                <p class="mb-0 mt-2">Jae Hopkins</p>
              </div>
            </div>
          </div>

          <div>
            <div class="card text-center review-card mx-auto">
              <div class="card-img-top  px-4 pt-3 review-card mx-auto">
                <p>Flexible Scheduling: As a student with a busy schedule, I appreciate the flexibility [ Tutor 24/7 ]
                  provides when it comes to scheduling sessions.
                </p>
                <div class="card-img-div pt-4">
                  <img src="./assets/images/imgpsh_fullsize_anim.png" class="mx-auto" alt="...">
                </div>
              </div>
              <div class="card-body">
                <img src="./assets/images/stars-steps.svg" alt="" srcset="" class="mx-auto">
                <p class="mb-0 mt-2">Mick Dobins</p>
              </div>
            </div>
          </div>
          <div>
            <div class="card text-center review-card mx-auto">
              <div class="card-img-top px-4 pt-3 review-card mx-auto">
                <p>Flexible Scheduling: As a student with a busy schedule, I appreciate the flexibility [ Tutor 24/7 ]
                  provides when it comes to scheduling sessions.
                </p>
                <div class="card-img-div pt-4">
                  <img src="./assets/images/imgpsh_fullsize_anim.png" class="mx-auto" alt="...">
                </div>
              </div>
              <div class="card-body">
                <img src="./assets/images/stars-steps.svg" alt="" srcset="" class="mx-auto">
                <p class="mb-0 mt-2">Mick Dobins</p>
              </div>
            </div>
          </div>
          <div>
            <div class="card text-center review-card mx-auto">
              <div class="card-img-top px-4 pt-3 review-card mx-auto">
                <p>Flexible Scheduling: As a student with a busy schedule, I appreciate the flexibility [ Tutor 24/7 ]
                  provides when it comes to scheduling sessions.
                </p>
                <div class="card-img-div pt-4">
                  <img src="./assets/images/imgpsh_fullsize_anim.png" class="mx-auto" alt="...">
                </div>
              </div>
              <div class="card-body">
                <img src="./assets/images/stars-steps.svg" alt="" srcset="" class="mx-auto">
                <p class="mb-0 mt-2">Mick Dobins</p>
              </div>
            </div>
          </div>
          <div>
            <div class="card text-center review-card mx-auto">
              <div class="card-img-top px-4 pt-3 review-card mx-auto">
                <p>Flexible Scheduling: As a student with a busy schedule, I appreciate the flexibility [ Tutor 24/7 ]
                  provides when it comes to scheduling sessions.
                </p>
                <div class="card-img-div pt-4">
                  <img src="./assets/images/imgpsh_fullsize_anim.png" class="mx-auto" alt="...">
                </div>
              </div>
              <div class="card-body">
                <img src="./assets/images/stars-steps.svg" alt="" srcset="" class="mx-auto">
                <p class="mb-0 mt-2">Mick Dobins</p>
              </div>
            </div>
          </div>


        </div>
      </div>
    </div>
  </div>
  <!-- Review Section end  -->
  <div class="container my-5">
    <div class="speak-tutor d-flex justify-content-center mt-3">
      <h1>Speak to a Tutor and get Tuition Sorted Today</h1>
    </div>

    <div class="findtutor d-flex justify-content-center mt-5">
      <a href="{{url('/find-tutor')}}"><b>
          <h1>Find a Tutor</h1>
        </b></a>
    </div>
  </div>
  <script>
    var botmanWidget = {
        aboutText: '247Tutors',
        title:'Chat Support',
        mainColor:'#0096FF',
        bubbleBackground:'#0096FF',
        introMessage: "✋ Hi! I'm from 247tutors.com"
    };
   </script>

   <script src='https://cdn.jsdelivr.net/npm/botman-web-widget@0/build/js/widget.js'></script>


@endsection
