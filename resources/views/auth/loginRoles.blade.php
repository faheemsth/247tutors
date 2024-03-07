@extends('layouts.app')

@section('content')
    @include('layouts/navbar')
<div class="container mt-5 ">
    <div class="row align-items-center">
        <div class=" login col-6  ">
            <h3 class="fs-1 fw-bold co" >Log in</h3>
        </div>
        <!--<div class="col-6 fs-4 mt-2  text-end"><a href="{{ url('/') }}" class="text-dark"><i class="fa-solid fa-xmark" style="font-size: 28px;margin-right: 20px"></i></a></div>-->
    </div>
    <!-- card1 -->
    <div class="row col-md-12 mt-5 gap-4 justify-content-center  text-center">
        <div class="card col-md-3" style="width: 16rem;background-color: rgba(171, 254, 16, 1);">
            <img src="./assets/images/1.png" class=" img-one card-img-top img-one img-fluid w-75 mx-auto" alt="...">
            <div class="card-body">
                <h4 class="card-title fw-bold">I am a Parent</h4>
                <p class="card-text">Manage Payments or Lessons for your Child</p>
                <a href="javascript:void(0)" onclick="roleget('5')" class="btn d-grid gap-2 btn-light">Parent Log in</a>
            </div>
        </div>
        <!-- card2 -->
        <div class="card col-md-3" style="width: 16rem;background-color: rgba(171, 254, 16, 1);">
            <img src="./assets/images/2.png" class=" img-two card-img-top img-fluid w-75 mx-auto" alt="...">
            <img src="./assets/images/Group.png" alt="" srcset="" id="shape-mail">
            <img src="./assets/images/Pencil.png" alt="" srcset="" id="shape-pencil">
            <div class="card-body">
                <h4 class="card-title fw-bold">I am a Student</h4>
                <p class="card-text">Manage Payments or Lessons for your Child</p>
                <a href='javascript:void(0)' onclick="roleget('4')" class="btn  d-grid gap-2 " style="background-color: #0096FF;">Student Log in</a>
            </div>
        </div>
        <!-- card3 -->
        <div class="card col-md-3" style=" width: 16rem;background-color: rgba(171, 254, 16, 1); ">
            <img src="./assets/images/3.png" class=" img-three card-img-top img-fluid w-75 mx-auto" alt="...">
            <img src="./assets/images/Layer_1 (2).png" alt="" srcset="" id="bg-shape-1">
            <img src="./assets/images/Speech Bubble (2).png" alt="" srcset="" id="bg-shape-2">
            <div class="card-body">
                <h4 class="card-title fw-bold">I am a Tutor</h4>
                <p class="card-text mb-4">Manage Payments or Lessons for your Child</p>
                <a href='javascript:void(0)' onclick="roleget('3')" class="btn d-grid gap-2 btn-light">Tutor Log in</a>
            </div>
        </div>
        <!-- card4 -->
        <div class="card col-md-3" style="width: 16rem;background-color: rgba(171, 254, 16, 1);">
            <img src="./assets/images/4.png" class="card-img-top img-fluid  w-100 mx-auto" alt="...">
            <div class="card-body">
                <br>
                <h4 class="card-title fw-bold">I am a Organization</h4>
                <p class="card-text">Manage Payments or Lessons for your Child</p>
                <a href='javascript:void(0)' onclick="roleget('6')" class="btn d-grid gap-2 btn-light">Organization Log in</a>
            </div>
        </div>
    </div>

</div>
<div class="container my-5">
    <div class="row justify-content-between align-items-center bottom mx-xl-5">
        <div class="mt-2  col-md-7 d-flex justify-content-around flex-wrap">
            <div class="col-12 col-xl-4 "><a href="tel:@isset($web_settings['Ph_num']) {{$web_settings['Ph_num'] ?? '' }} @endisset" class="text-dark  text-decoration-none">Need help? Call us on
                   <br><b>@isset($web_settings['Ph_num']) {{$web_settings['Ph_num'] ?? '' }} @endisset</b></a> or <a
                   href="mailto:@isset($web_settings['Maintopbaremail']) {{$web_settings['Maintopbaremail'] ?? '' }} @endisset" class="text-decoration-none text-dark"><b> Email</b></a></div>
            <div class="col-12 col-xl-4"><a href="{{url('/student-apply-steps')}}" class="text-dark  text-decoration-none">Help! I'm an <b> Adult
                    Learn</b></a></div>
            <div class="col-12 col-xl-4"><a href="{{url('/login')}}" class="text-dark  text-decoration-none">Log in as a <b>Tutor
                    </b></a></div>
        </div>
        <div class="mt-3 mt-md-0 col-lg-4 d-flex justify-content-center justify-content-md-end gap-3">
            <div><a href="{{ url('admin/login') }}" class="btn" style="background-color:  #063B00;color: white;">Login as Super Admin</a>
            </div>
            <div class="d-none"><a href="{{ url('register') }}" class="btn" style="background-color:  #063B00;color: white;">Sign up</a></div>
        </div>
    </div>
</div>

<script>
function roleget(role) {
    var message = "";
    var id = "";

    if (role === '3') {
        message = 'Tutor Log In';
        message1 = 'I am a Tutor';
        id = 3;

    } else if (role === '4') {
        message = 'Student Log In';
        message1 = 'I am a Student';
        id = 4;

    } else if (role === '5') {
        message = 'Parent Log In';
        message1 = 'I am a Parent';
        id = 5;

    } else if (role === '6') {
        message = 'Organization Log In';
        message1 = 'I am an Organization';
        id = 6;

    }
    document.cookie = "message="+message;
    document.cookie = "id="+id;

    localStorage.setItem('message', message);
    localStorage.setItem('id', id);

    $.ajax({
        url: 'roleget',
        data: { message: message ,message1:message1},
        type: 'GET',
        success: function (response) {
            window.location.href = "{{ url('/login') }}";
        }
    });
}

</script>
@endsection
