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


    <link href="{{ URL::asset('assets/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    <style>
        .select2-container {
            width: 100% !important;
        }
    </style>
    <script src="{{ asset('vendor/jquery/jquery3.7.0.js') }}"></script>

    <script src="{{ asset('js/jsdelivrcore.js') }}"></script>
    <script src="{{ URL::asset('assets/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('js/jsdelivr.js') }}"></script>


    <style type="text/css">
        body {
            font-family: "Inter", sans-serif;
        }

        .formbold-mb-5 {
            margin-bottom: 20px;
        }

        .formbold-pt-3 {
            padding-top: 12px;
        }

        .formbold-main-wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 48px;
        }

        .formbold-form-wrapper {
            margin: 0 auto;
            max-width: 550px;
            width: 100%;
            background: white;
        }

        .formbold-form-label {
            display: block;
            font-weight: 500;
            font-size: 16px;
            color: #07074d;
            margin-bottom: 12px;
        }

        .formbold-form-label-2 {
            font-weight: 600;
            font-size: 20px;
            margin-bottom: 20px;
        }

        .formbold-form-input {
            width: 100%;
            padding: 12px 24px;
            border-radius: 6px;
            border: 1px solid #e0e0e0;
            background: white;
            font-weight: 500;
            font-size: 16px;
            color: #6b7280;
            outline: none;
            resize: none;
        }

        .formbold-form-input:focus {
            border-color: #6a64f1;
            box-shadow: 0px 3px 8px rgba(0, 0, 0, 0.05);
        }

        .formbold-btn {
            text-align: center;
            font-size: 16px;
            border-radius: 6px;
            padding: 14px 32px;
            border: none;
            font-weight: 600;
            background-color: black;
            color: white;
            cursor: pointer;
        }

        .formbold-btn:hover {
            box-shadow: 0px 3px 8px rgba(0, 0, 0, 0.05);
        }

        .formbold--mx-3 {
            margin-left: -12px;
            margin-right: -12px;
        }

        .formbold-px-3 {
            padding-left: 12px;
            padding-right: 12px;
        }

        .flex {
            display: flex;
        }

        .flex-wrap {
            flex-wrap: wrap;
        }

        .w-full {
            width: 100%;
        }

        .formbold-file-input input {
            opacity: 0;
            position: absolute;
            /* width: 100%; */
            /* height: 100%; */
        }

        .formbold-file-input label {
            position: relative;
            border: 1px dashed #e0e0e0;
            border-radius: 6px;
            min-height: 200px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 48px;
            text-align: center;
        }

        .formbold-drop-file {
            display: block;
            font-weight: 600;
            color: #07074d;
            font-size: 20px;
            margin-bottom: 8px;
        }

        .formbold-or {
            font-weight: 500;
            font-size: 16px;
            color: #6b7280;
            display: block;
            margin-bottom: 8px;
        }

        .formbold-browse {
            font-weight: 500;
            font-size: 16px;
            color: #07074d;
            display: inline-block;
            padding: 8px 28px;
            border: 1px solid #e0e0e0;
            border-radius: 4px;
        }

        .formbold-file-list {
            border-radius: 6px;
            background: #f5f7fb;
            padding: 16px 32px;
        }

        .formbold-file-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .formbold-file-item button {
            color: #07074d;
            border: none;
            background: transparent;
            cursor: pointer;
        }

        .formbold-file-name {
            font-weight: 500;
            font-size: 16px;
            color: #07074d;
            padding-right: 12px;
        }

        .formbold-progress-bar {
            margin-top: 20px;
            position: relative;
            width: 100%;
            height: 6px;
            border-radius: 8px;
            background: #e2e5ef;
        }

        .formbold-progress {
            position: absolute;
            width: 75%;
            height: 100%;
            left: 0;
            top: 0;
            background: #6a64f1;
            border-radius: 8px;
        }

        @media (min-width: 540px) {
            .sm\:w-half {
                width: 50%;
            }
        }

        /* //// */
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
            left: 354px;
        }

        .flag-3 {
            left: 710px;
        }

        .flag-4 {
            left: 1068px;
        }

        @media only screen and (max-width: 1240px) {
            .flag-2 {
                left: 250px;
            }

            .flag-3 {
                left: 512px;
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
                left: 185px;
            }

            .flag-3 {
                left: 380px;
            }

            .flag-4 {
                left: 580px;
            }
        }

        @media only screen and (max-width: 425px) {
            .flag-2 {
                left: 85px;
            }

            .flag-3 {
                left: 175px;
            }

            .flag-4 {
                left: 265px;
            }
        }

        @media only screen and (max-width: 375px) {
            .flag-2 {
                left: 70px;
            }

            .flag-3 {
                left: 145px;
            }

            .flag-4 {
                left: 225px;
            }
        }

        @media only screen and (max-width: 320px) {
            .flag-2 {
                left: 57px;
            }

            .flag-3 {
                left: 130px;
            }

            .flag-4 {
                left: 200px;
            }
        }

        .card-content {
            /* border: 2px solid black; */
            width: 400px;
            height: auto;
            margin: auto;
            box-shadow: 0px 0px 4px 3px rgb(234, 228, 228);
        }

        .card-lists i {
            padding-right: 10px;
            color: rgb(139, 233, 139);


        }

        .box {
            text-align: center;
            padding: 20px;
            width: auto;
            border: 1px solid #ffffff;
            background-color: #eeeeee;
        }

        .cen {
            text-align: center;
        }
    </style>

    <!-- End prograss bar -->
    <div class="container">
        <div class="panel-group">
            <div class="row panel panel-primary justify-content-center">
                <form class="form-horizontal" id="registration-form">
                <fieldset id="personal">
                        <div class="panel-body mt-5">
                            <div class="container px-0">
                                <div class="col-12 col-md-8 col-lg-5 center-box m-auto ">
                                    <div class="box py-5">
                                        <i style="font-size: 3.2rem">"&#128077"</i>
                                        <h4 class="fw-bold my-4" style="color: rgba(0, 150, 255, 1)">Thanks for taking ur time to contact us we will be in touch shortly.</h4>
                                        <p>We are currently reviewing your application and will be in touch by email within
                                            7 working days to let you know about next steps. If you need any help,just get
                                            in touch.</p>
                                    </div>
                                    <div class="mt-1 mb-5">
                                        <p class="cen">Need help? Call us <a href="tel:@isset($web_settings['Ph_num']) {{$web_settings['Ph_num'] ?? '' }} @endisset" class="text-decoration-none"><span style="color: rgb(162, 244, 10)">@isset($web_settings['Ph_num']) {{$web_settings['Ph_num'] ?? '' }} @endisset</span></a> or
                                          <a href="mailto:@isset($web_settings['topbaremail']) {{$web_settings['topbaremail'] ?? '' }} @endisset"  class="text-decoration-none"><span style="color: rgb(162, 244, 10)">email us</span></a>. </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>



    <script src="{{ asset('js/timeslot.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#register').click(function() {
                var formData = $('#registration-form').serialize();
                $.ajax({
                    url: '/register',
                    method: 'POST',
                    data: formData,
                    // beforeSend:function(){
                    //     $('.submit-button').addClass('d-none');
                    //     $('.spiner').removeClass('d-none');
                    // },
                    success: function(response) {
                        window.location.reload();
                    },
                });
            });
        });
    </script>
@endsection
