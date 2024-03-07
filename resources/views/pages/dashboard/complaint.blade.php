@php
    function generateTicketId() {
        $uniqueId = uniqid();
        $ticketId = substr($uniqueId, -6);
        return $ticketId;
    }
@endphp
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
        @elseif (Auth::user()->role_id == '6')
            @include('layouts.orgnav')
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
    <style>
        .complainttext {
            font-size: 2.6rem;
            font-weight: bold;
        }

        .complaintp {
            font-size: 1.5rem;
            font-weight: 600;
        }

        .fa-file-lines,
        .fa-volcano,
        .fa-sitemap {
            font-size: 6rem;
        }

        .tickettext {
            font-size: 2rem;
            font-weight: 700;
        }

        .btnhov:hover {
            background-color: rgba(0, 150, 255, 1);

        }
        @media only screen and (max-width:425px){
            table tr th{
                min-width:110px;
            }
             table tr td{
                min-width:120px;
            }
        }

    </style>
    <div class="container-fluid">
        @include('include.message')
        <div class="row my-5">
            <div class="col-12 text-center">
                <h4 class="complainttext" id="text-color">Complaint System</h4>
                <h6 class="complaintp">How To Works</h6>
            </div>
            <div class="col-12 my-3">
                <div class="row justify-content-center my-3">
                    <div class="col-md-3 col-12 text-center">
                        <i class="fa-solid fa-sitemap"></i>
                        <p class="mt-3">
                            Get to know the status
                            of your complaint or add a
                            new complaint
                        </p>
                    </div>
                    <div class="col-md-3 col-12 text-center">
                        <i class="fa-solid fa-volcano"></i>
                        <p class="mt-3">Track your complaint
                            (Track your complaint using
                            Ticket number)</p>
                    </div>
                    <div class="col-md-3 col-12 text-center">
                        <i class="fa-regular fa-file-lines"></i>
                        <p class="mt-3">
                            Add a complaint
                            (Add a complaint against an Tutor
                            service provided)
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-12 my-4">
                <div class="row justify-content-center">
                    <div class="col-auto">
                        <button class="btn me-lg-3 btnhov" style="border: 1px solid rgba(0, 150, 255, 1);"
                            onclick="toggleDiv()">
                            <i class="fa fa-solid fa-plus me-2" style="color:rgba(171, 255, 0, 1)"></i>
                            Add Complaint</button>
                        <a href="{{ url('/faq') }}" class="btn btnhov"
                            style="border: 1px solid rgba(0, 150, 255, 1)">FAQ's</a>
                    </div>
                </div>
            </div>
        </div>


        <div class="row mx-md-5 mx-2 mb-5" id="complaintDiv">
            <form method="get" class="col-12 d-flex flex-column flex-md-row justify-content-md-between align-items-baseline"
            style="border-bottom: 1px solid gray;" onsubmit="return submitForm()">
            <h5 class="tickettext mb-0 pb-0" id="text-color">Track Ticket</h5>
            <div class="mb-1">
                <label for="formGroupExampleInput" class="form-label">Search:</label>
                <input type="text" class="form-control" id="formGroupExampleInput" value="{{ $_GET['search'] ?? '' }}" name="search" placeholder="Ticket No"
                    onkeydown="if(event.keyCode==13) return submitForm()">
            </div>
        </form>
            <div class="col-12 mt-5 mt-md-1">
                <div class="row mb-4 justify-content-md-center text-center">
                    <div class="col-lg-11 col-12 px-0 ">
                        <div class="container mt-2 mt-md-5 custom-table px-1">
                            <table class="table table-bordered custom-table">
                                <thead class="student-table-details">
                                    <tr>
                                        <th>#Ticket No</th>
                                        <th>Subject</th>
                                        <th>Bookind Id</th>
                                        <th>Issue Details</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($Complaints->count() > 0)
                                        @foreach ($Complaints as $Complaint)
                                        <tr>
                                            <td>{{ $Complaint->TicketID }}</td>
                                            <td>{{ $Complaint->subject }}</td>
                                            <td>{{ $Complaint->booking_id }}</td>
                                            <td>{{ $Complaint->issues_detail }}</td>
                                            <td>
                                                <!--<span class="badge badge-danger" style="background-color: green">{{ $Complaint->status }}</span>-->

                                                 @if($Complaint->status == 'Pending')
                                                    <span class="badge bg-warning" >{{ $Complaint->status }}</span>
                                                    @elseif($Complaint->status == 'Processing')
                                                    <span class="badge bg-danger">{{ $Complaint->status }}</span>
                                                    @else
                                                    <span class="badge bg-success">{{ $Complaint->status }}</span>
                                                    @endif
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($Complaint->created_at)->format('F j, Y \a\t g:i A'); }}</td>
                                        </tr>
                                        @endforeach
                                        @else
                                        <tr>
                                            <td colspan="6">Not Record Found </td>
                                        </tr>
                                    @endif
                                </tbody>

                            </table>
                            <div class="d-flex justify-center">{{ $Complaints->links() }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="row mx-lg-5 mx-md-2 my-5 " style="display:none" id="complaintDiv2">
            <div class="col-12 mt-5" style="border-bottom: 1px solid gray;">
                <h5 class="tickettext mb-2 pb-0" id="text-color">Create Ticket</h5>
            </div>
            <div class="col-md-6 col-12 my-5 py-2 mx-lg-5">
                <form action="{{ url('Submit/Comptaint') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-lg-8 col-12">
                            <label for="inputticket" class="form-label">Ticket No</label>
                            <input type="text" class="form-control" name="TicketID" id="inputticket" placeholder="Ticket No" value="{{ generateTicketId() }}" readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-lg-8 col-12">
                            <label for="inputsubject" class="form-label">Subject <span style="color:red">*</span></label>
                            <input type="text" class="form-control" name="subject" id="inputsubject" required placeholder="Select Subject">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-lg-8 col-12" >
                            <label for="inputbooking" class="form-label">Booking Id <span style="color:red"></span></label>
                            <input type="text" class="form-control" name="booking_id" id="inputbooking"  placeholder="123plm">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-lg-8 col-12">
                            <label for="inputissues" class="form-label">Issues Details</label>
                            <textarea type="text" class="form-control" name="issues_detail" id="inputissues" required placeholder="Description"></textarea>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-lg-8 col-12">
                            <label for="inputissuesfile" class="form-label">Upload File <span class="mx-2"
                                    style="color:gray;font-size:14px;">Optional</span></label>
                            <input type="file" class="form-control" name="file" id="inputissuesfile">
                        </div>
                    </div>
                    <div class="row py-3">
                        <div class="col-lg-8 col-12">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-lg-4 col-md-6 col-12 pt-5 d-none d-md-inline-block">
                <img src="{{ asset('assets/images/complaint.jpg') }}" alt="" class="img-fluid mt-2">
            </div>
        </div>
    </div>
    <script>
        function toggleDiv() {
            var complaintDiv = document.getElementById("complaintDiv");
            if (complaintDiv.style.display === "none") {
                complaintDiv.style.display = "flex";
                complaintDiv2.style.display = "none";

            } else {
                complaintDiv.style.display = "none";
                complaintDiv2.style.display = "flex";

            }
        }
    </script>
@endsection
