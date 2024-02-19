@extends('pages.dashboard.appstudent')

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
    <script src="{{ asset('js/jsdelivrcore.js') }}"></script>
    <script src="{{ asset('js/jsdelivr.js') }}"></script>
    <style>
        .chat-sec{
            height: 100vh;
        }
        .cont-text {
          border: 1px solid rgb(249, 248, 248);
          padding: 5px 5px;
          /* font-size: 12px; */
          /* font-weight: bold; */
          background-color: rgb(243, 240, 232);
        }
      </style>
    <div class="container mt-3 chat-sec">
        <div class="row   " style="height: 90vh;">
          <div class="col-md-9 border border-secondary border-opacity-10">
            <button type="button" class="btn btn-outline-success mt-3 btn-sm"><i class="fa-solid fa-arrow-left"
                style="padding-right: 5px;"></i>Back</button>

            <div class="cont-parts mt-3 " style="height: 85%; float: right;">
              <span>Tue,7 Nov 20:07</span>
              <h6 class="mt-2 cont-text text-center">JGHJ</h6>
              <span>FRI,10 Nov 12:00</span>
              <h6 class="mt-2 cont-text text-center">YYYY</h5>
            </div>

            <div class="input-group " style="border-top:1px solid gainsboro  ;">


              <input type="text" class="form-control my-3" placeholder="" aria-label="Recipient's username"
                aria-describedby="button-addon2">

              <button class="btn btn-outline-success my-3 mx-2" type="button" id="button-addon2">Send</button>
            </div>


          </div>
          <!-- second card body -->
          <div class="col-md-3 border border-secondary border-opacity-10 text-center ">
            <img src="{{ asset('assets/images/profile.png') }}" alt="" class="rounded-circle mt-4"
              style="width: 80px; border: 1px solid rgb(233, 226, 226); ">

            <h5 class="img-name mt-2" style="color: rgb(104, 224, 164);">Jonathan K.</h5>

            <p class="img-price fw-bold">&#163;37-&#163;39/hr</p>
            <div class="d-grid gap-2 my-5">
              <button class="btn btn-success" type="button">Book free meeting </button>
              <button class="btn btn-secondary" type="button">Book lesson</button>
              <h6 class="mt-3" style="color:rgb(104, 224, 164);">See all bookings</h6>
            </div>



          </div>
        </div>
      </div>



@endsection
