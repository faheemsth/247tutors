@extends('layouts.main')
@section('title', 'Activity Logs')
@section('content')
    <!-- push external head elements to head -->
    @push('head')
        <link rel="stylesheet" href="{{ asset('plugins/DataTables/datatables.min.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/bootstrap/css/bootstrap.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/webicons/css/all.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    @endpush
    <style>
        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked+.slider {
            background-color: #2196F3;
        }

        input:focus+.slider {
            box-shadow: 0 0 1px #2196F3;
        }

        input:checked+.slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }
    </style>
    <style>
        /* Add your custom styles here */
        .card-header {
            background-color: #007bff; /* Bootstrap primary color */
            color: #fff; /* Text color */
            padding: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .select2 {
            /* Add your custom styles for the select element */
            padding: 0.5rem;
            border: 1px solid #ced4da; /* Bootstrap default border color */
            border-radius: 0.25rem;
        }

        /* Add any other custom styles as needed */
    </style>

    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8 col-md-6 col-12">
                    <div class="page-header-title">
                        <i class="fa fa-file-shield bg-blue" style="margin-right:10px;"></i>
                        <div class="d-inline">
                            <h5>{{ __('Activity Logs') }}</h5>
                            <span>{{ __('List of Activity Logs') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-12 mt-3 mt-md-0">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#">{{ __('Activity Logs') }}</a>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- start message area-->
            @include('include.message')
            <!-- end message area-->
             <div class="col-md-12  user-table-data col-12 pe-0 pe-md-2">
                <div class="card p-md-3 p-2">
                    

                    <!--<div class="card-header d-flex justify-content-between">-->
                    <!--    <h3 class="col-auto">{{ __('') }}</h3>-->
                    <!--    <form method="GET" action="" class="col-12 col-md-5  col-xl-3 d-flex justify-content-between align-items-center gap-2">-->
                    <!--        <input type="text" name="search" value="{{ $_GET['search'] ?? '' }}" class="form-control" placeholder="Search">-->
                    <!--        <button type="submit" class="btn btn-primary">Search</button>-->
                    <!--    </form>-->
                    <!--</div>-->
                    <div class="card-header justify-content-between">
                        <h3>{{ __('Activity Logs') }}</h3>
                    </div>

                    <div class="card-body" style="overflow: scroll;">
                        <table id="reviewStudents" class="table table-bordered">
                   
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>User</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tbody id="ajaxbody">
                                 @foreach($ActivityLogs as $key => $booking)
                                 @if(!empty($booking->user) && !empty($booking->title) && !empty($booking->description))
                                    <tr>
                                        {{-- @dd($booking) --}}
                                        <td style="border-bottom: .5px solid black;">{{ $booking->id }}</td>
                                        <td style="border-bottom: .5px solid black;">{{ optional($booking->user)->first_name.' '.optional($booking->user)->last_name }}</td>
                                        <td class="fw-bold" style="border-bottom: .5px solid black;">{{ $booking->title }}</td>
                                        <td style="border-bottom: .5px solid black;">{{ $booking->description }}</td>
                                    </tr>
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('script')
        <script src="{{ asset('plugins/select2/dist/js/select2.min.js') }}"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css"/>
                        <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.11.5/datatables.min.js"></script>
                        <script>
                            $(document).ready(function(){
                                $('#reviewStudents').DataTable();
                            });
                        </script>
    @endpush
@endsection
