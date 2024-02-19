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
                <img src="./assets/images/247 NEW Logo 1.png" alt="Logo" width="255px" height="auto">
            </div>
        </div>
    </div>

    <!-- logo end -->

    <!-- prograss bar -->
    <div class="container mb-5 pb-5 pb-md-0 mb-md-0">
        <div class="panel-group">
            <div class="panel panel-primary">
                <fieldset id="account">
                    <div class="panel-body mt-5">
                        {{-- <h2 class="text-center fs-1" id="text-color"><strong>Apply as...</strong></h2><br> --}}
                        <div class="container">
                            <div class="apply-as">
                                <div class="d-flex flex-column flex-md-row justify-content-center gap-3">
                                    <a href="{{ url('student-signup?role=4') }}" data-role-id="4"
                                        class="btn col-md-4 col-lg-3 col-12 text-left-1 text-dark fs-4 fw-bold next user-role"
                                        style="background-color: rgba(171, 254, 16, 1);" id="next1"> <img
                                            src="assets/images/graduated.svg" alt="student icon" class="px-3 next"
                                            width="60" height="auto"> Student</a>
                                    <a href="{{ url('tutor-signup?role=3') }}" data-role-id="3"
                                        class="btn col-md-4 col-lg-3 text-left-1 text-dark fs-4 fw-bold next user-role"
                                        id="next2" style="background-color: rgba(171, 254, 16, 1);"> <img
                                            src="assets/images/tutor.svg" alt="tutor icon" class="px-3" width="60"
                                            height="auto">Tutor</a>
                                </div>
                                <div class="d-flex flex-column flex-md-row justify-content-center gap-3 mt-3">
                                    <a href="{{ url('parent-signup?role=5') }}" data-role-id="5"
                                        class="btn col-md-4 col-lg-3 text-left-1 text-dark fs-4 fw-bold next user-role"
                                        id="next3" style="background-color: rgba(171, 254, 16, 1);"> <img
                                            src="assets/images/fathers-day.svg" alt="Parent icon" class="px-3"
                                            width="60" height="auto"> Parent</a>
                                    <a href="{{ url('organization-signup?role=6') }}" data-role-id="6"
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
            </div>
        </div>
    </div>
@endsection
