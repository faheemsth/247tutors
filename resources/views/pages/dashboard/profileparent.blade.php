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
<style>
    .profileeditdiv{
          opacity: 0;
      }
      .profileeditdiv:hover{
          opacity: 0.8;
      }
</style>
<script src="{{ asset('js/jsdelivrcore.js') }}"></script>
<script src="{{ asset('js/jsdelivr.js') }}"></script>
    <div class="container-fluid">
        <div class="container">
            <div class="row my-5">
                <div class="col-12 col-md-7 col-lg-8 arman-d">

                    <div class="mt-3 arman">

                        <div class="row">


                            <div class="col-12 col-md-3 profile-img image1 d-flex justify-content-lg-center position-relative">
                                <div  class="profileeditdiv d-flex justify-content-center align-items-center" style="width: 150px;height: 150px;background-color: #cfcfcf;border-radius: 50%; position: absolute;top:0px;">
                                    <button type="button" data-bs-toggle="modal" data-bs-target="#staticBackdrop" class="btn px-4" style="background-color: #080808;
                                    color: white;">Edit</button>
                                </div>
                                @if (!empty(Auth::user()->image) && file_exists(public_path(Auth::user()->image)))
                                    <img src="{{ asset(Auth::user()->image) }}" alt="" style="width: 150px;height: 150px;
                                    border-radius: 50%;">
                                @else
                                    <img src="{{ asset('assets/images/default.png') }}" alt="" style="    width: 150px;
                                    height: 150px;
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
                            <div class="col-12 col-md-8 ps-lg-0 mt-1 ms-2 ms-md-0">
                                <div class="d-flex justify-content-between mt-lg-4 hr align-items-center">

                                    <h4 class="text-capitalize">{{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}<img
                                            src="./assets/images/Verified-p.png" alt=""></h4>



                                </div>
                                <div class="Spreading">
                                    <p class="">Spreading knowledge everywhere that's all I do</p>
                                </div>

                                <div class="mt-md-3 mt-lg-5">
                                    <a class="one" href="">Student's home</a>
                                    <a class="two" href="">Online</a>
                                </div>
                            </div>





                            <div class="row">
                                <div class="col-md-4"></div>
                                <div class="col-md-8 d-flex justify-content-between align-items-center book mt-3">
                                    <p><img src="./assets/images/heart.png" alt=""> Saved</p>
                                    {{-- <a href="" style="text-decoration: none;color: black;">
                                        <h5>Book a Tutor</h5>
                                    </a> --}}
                                </div>

                            </div>




                        </div>


                        <div class="mt-5">
                            <h3>About me:</h3>
                            {{-- <p>Hi! My name is {{ Auth::user()->first_name . ' ' . Auth::user()->last_name }} and I'm
                                currently a pre-medical student.</p>
                            <p> --}}

                                {{ Auth::user()->profile_description }}
                            </p>
                        </div>

                        <div class="personally py-4">


                            <h3 class="mx-5">Personally interviewed by 24/7 Tutor</h3>
                            <p class="mx-5">Lorem ipsum dolor sit amet. Est magni cupiditate ad laboriosam vitae a
                                dicta nisi qui
                                corrupti laborum non repellat molestiae. Sit eaque quam cum itaque dolores vel culpa
                                maiores. Aut
                                architecto earum ut quidem assumenda ad dicta harum aut voluptatem iure qui consequuntur
                                nihil et
                                internos rerum eum velit eaque.</p>

                        </div>
                        <!-- Review Section end  -->



                    </div>





                </div>
                <div class="col-md-5 col-lg-4 mt-5 mt-md-0">

                    <div class="row">
                        <div
                            class="col-md-12 chat justify-content-center text-center d-flex align-items-center flex-column">

                            <img src="/assets/images/chat 1.png" alt="">
                            <h5>Let’s Chat with Arman</h5>
                            <p>Have a Chat with Arman and see how ( and when!) they can Help</p>
                            <a href="">Let's Chat</a>

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 more mt-2 ">
                            <ul class="ps-0 ps-md-5">
                                <li>
                                    <a href="">More Biology Tutor</a>
                                </li>

                                <li> <a href="">More Chemistry Tutor</a></li>
                                <li> <a href="">More English Language Tutor</a></li>
                                <li> <a href="">More Mathmatics Tutor</a></li>
                                <li> <a href="">More Physics Tutor</a></li>
                                <li> <a href="">More Biology GCSE Tutor</a></li>
                                <li> <a href="">More Chemistry GCSE Tutor</a></li>

                            </ul>
                        </div>
                    </div>





                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {

            $('.card-center').slick({
                infinite: true,
                slidesToShow: 3,
                slidesToScroll: 1,
                autoplay: true,
                arrows: false,
                responsive: [{
                        breakpoint: 1030,
                        settings: {
                            infinite: true,
                            slidesToShow: 2,
                            slidesToScroll: 1,
                            autoplay: true,
                            arrows: false,
                        }
                    },
                    {
                        breakpoint: 770,
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
