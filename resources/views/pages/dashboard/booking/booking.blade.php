@extends('layouts.main')
@section('title', 'Bookings')
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
                <div class="col-lg-8 col-md-6 col-7">
                    <div class="page-header-title">
                        <i class="fa fa-atom bg-blue"></i>
                        <div class="d-inline">
                            <h5>{{ __('Bookings') }}</h5>
                            <span>{{ __('List of Bookings') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-5">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}">
                                    <i class="ik ik-home "></i>
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#">{{ __('Bookings') }}</a>
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

            <div class="col-md-12 user-table-data  col-12 pe-0 pe-md-2">
                <div class="card p-md-3 p-2">
                    <div class="card-header justify-content-between">
                        <h3>{{ __('Booking') }}</h3>
                    </div>
                     <div class=" mt-4  px-0 pe-md-4 d-flex justify-content-between">
                        <h3 class="col-auto  d-none d-md-inline-block">{{ __('') }}</h3>
                            <form method="GET" action="" class="col-12 col-md-6 col-lg-6 col-xl-5 d-flex px-0 justify-content-between align-items-center gap-2">
                              
                             <select name="status" id="status" class="col-md-6 select2 form-select">
                                <option value="">All Search</option>
                                <option value="Pending" {{ !empty($_GET['status']) && $_GET['status'] == 'Pending'? 'selected':"" }}>Pending</option>
                                <option value="Scheduled" {{ !empty($_GET['status']) && $_GET['status'] == 'Scheduled'? 'selected':"" }}>Scheduled</option>
                                <option value="Completed" {{ !empty($_GET['status']) && $_GET['status'] == 'Completed'? 'selected':"" }}>Completed</option>
                                <option value="Cancelled" {{ !empty($_GET['status']) && $_GET['status'] == 'Pending'? 'Cancelled':"" }}>Cancelled</option>
                                <option value="Cancelled By User" {{ !empty($_GET['status']) && $_GET['status'] == 'Cancelled By User'? 'selected':"" }}>Cancelled By User</option>
                                <option value="Cancelled By Tutor" {{ !empty($_GET['status']) && $_GET['status'] == 'Cancelled By Tutor'? 'selected':"" }}>Cancelled By Tutor</option>
                            </select>
                            <input type="text" name="search" value="{{ $_GET['search'] ?? '' }}" class="form-control " placeholder="Search">
                            <button type="submit" class="btn btn-primary">Search</button>
                        </form>
                    </div>
                    <div class="card-body" style="overflow: scroll;">
                        <table id="user_table" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Student</th>
                                    <th>Tutor</th>
                                    <th>Subject</th>
                                    <th>Duration</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Download</th>

                                </tr>
                            </thead>
                            <tbody id="ajaxbody">
                                @forelse($bookings as $key => $booking)
                                    <tr>
                                        <td>{{ optional($booking->student)->first_name . ' ' . optional($booking->student)->last_name }}</td>
                                        <td>{{ optional($booking->tutor)->first_name . ' ' . optional($booking->tutor)->last_name }}</td>
                                        <th>{{ optional($booking->subjects)->name }}</th>
                                        <td>{{ $booking->duration }} minute</td>
                                        <td>
                                            
                                            @if ((int) $booking->amount == $booking->amount)
                                                    £{{ $booking->amount }}.00/hr
                                            @else
                                                    £{{ $booking->amount }}/hr
                                            @endif

                                            
                                        </td>

                                        <td>
                                            @if ($booking->request_refound != 1)
                                                <span
                                                    class="badge
                                                @if ($booking->status == 'Completed') bg-success
                                                @elseif($booking->status == 'Scheduled')
                                                bg-info
                                                @elseif($booking->status == 'Cancelled By Tutor' || $booking->status == 'Cancelled By User')
                                                bg-danger
                                                @elseif($booking->status == 'Cancelled')
                                                bg-danger
                                                @elseif($booking->status == 'Pending')
                                                bg-warning @endif
                                                ">
                                                    {{ $booking->status }}
                                                </span>
                                            @else
                                                <span class="badge bg-secondary">
                                                    {{ 'Request Refound' }}
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                           <a class="btn btn-success" href="{{ asset('videos/'.$booking->uuid.'/blob.mp4') }}" download>Lecture Download</a>
                                        </td>
                                    </tr>

                                @empty
                                    <tr >
                                        <td class="text-center" colspan="7">Record not found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                            
                        </table>
                        {{ $bookings->links() }}

                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('script')
        <script src="{{ asset('plugins/select2/dist/js/select2.min.js') }}"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        // <script>
        //     $(document).ready(function() {
        //         $('#status').on('change', function() {
        //             var status = $('#status').val();
        //             $.ajax({
        //                 url: '{{ url('admin/bookings') }}',
        //                 type: 'GET',
        //                 data: { status: status },
        //                 success: function(data) {
        //                     $('#ajaxbody').html(data);
        //                 }
        //             });
        //         });

        //         $(document).on('click', '.pagination a', function(e) {
        //             e.preventDefault();
        //             var page = $(this).attr('href').split('page=')[1];
        //             var status = $('#status').val();
        //             getPaginatedData(status,page);
        //         });

        //         function getPaginatedData(status,page) {
        //             $.ajax({
        //                 url: '{{ url('admin/bookings') }}?page=' + page,
        //                 type: 'GET',
        //                 data: { status: status },
        //                 success: function(data) {
        //                     $('#ajaxbody').html(data);
        //                 }
        //             });
        //         }

        //     });
        // </script>
    @endpush
@endsection
