@extends('pages.dashboard.appstudent')
@section('content')
    @include('layouts.allnav')
    <link href="{{ URL::asset('assets/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    <script src="{{ URL::asset('assets/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('vendor/jquery/jquery3.7.0.js') }}"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/appointment-slot-picker@1.2.8/css/appointment-picker.css">
    <script src="{{ asset('js/timeslot.min.js') }}"></script>
    <script src="{{ asset('js/jsdelivr.js') }}"></script>
    <script src="{{ asset('js/jsdelivrcore.js') }}"></script>
    <style>

    .bookingdetail{
        font-size:2.5rem;
    }
        .success-box {
            margin: 50px 0;
            padding: 10px 10px;
            border: 1px solid #eee;
            background: #f9f9f9;
        }

        .success-box img {
            margin-right: 10px;
            display: inline-block;
            vertical-align: top;
        }

        .success-box>div {
            vertical-align: top;
            display: inline-block;
            color: #888;
        }



        /* Rating Star Widgets Style */
        .rating-stars ul {
            list-style-type: none;
            padding: 0;

            -moz-user-select: none;
            -webkit-user-select: none;
        }

        .rating-stars ul>li.star {
            display: inline-block;

        }

        /* Idle State of the stars */
        .rating-stars ul>li.star>i.fa {
            font-size: 2.5em;
            /* Change the size of the stars */
            color: #ccc;
            /* Color on idle state */
        }

        /* Hover state of the stars */
        .rating-stars ul>li.star.hover>i.fa {
            color: #FFCC36;
        }

        /* Selected state of the stars */
        .rating-stars ul>li.star.selected>i.fa {
            color: #FF912C;
        }
             @media only screen and (max-width : 1025px) {

           table tr th{
        min-width:100px !important;
    }
    table tr td{
        min-width:90px !important;
    }
             }

        @media only screen and (max-width : 768px) {
          /*.bookingdetail{*/
          /*    font-size:2.4rem;*/
          /*}*/
           table tr th{
        min-width:150px !important;
    }
    table tr td{
        min-width:110px !important;
    }
            .custom-table {
                overflow: scroll !important;
            }
        }
         @media only screen and (max-width : 330px) {
          .bookingdetail{
              font-size:2.1rem;
          }
         }
    </style>
    <div class="container  py-3">
        <div class="row mt-2">
            @if (session('failed'))
                <div class="alert alert-danger">
                    {{ session('failed') }}
                </div>
            @endif
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
        </div>
        <!-- Filter section  -->
        <div class="container">
            <div class="row justify-content-center">
                <div class="row mt-5">
                    <div class="col-12 booking-table-details text-center">
                        <h2 class="bookingdetail fw-bold" id="text-color">Bookings Detail</h2>
                    </div>
                </div>
                <div class="col-10 booking-filter">
                    <div class="row flex-wrap justify-content-center align-content-end">
                        <div class="col-12 col-md-4 col-lg-3 my-1">
                            <div class="mb-md-3 row">
                                <label for="inputSubject" class="col-12 col-form-label">Subject </label>
                                <div class="col-12">
                                    <select class="form-select  text-capitalize" aria-label="Default select example"
                                        name="subject" id="subject">
                                        <option value="">Select Option</option>
                                        @if (!empty($Subjects1))
                                            @foreach ($Subjects1 as $Subject)
                                                <?php $Subject_id = App\Models\Subject::where('id', $Subject->subject_id)
                                                    ->with(['level'])
                                                    ->first();
                                                ?>
                                                @if ($Subject_id)
                                                    <option value="{{ $Subject_id->id }}">{{ $Subject_id->name }}</option>
                                                @endif
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 col-lg-3 my-1">
                            <div class="mb-md-3 row">
                                <label for="inputDate" class="col-12 col-form-label">Date</label>
                                <div class="col-12">
                                    <input type="date" class="form form-control" style="box-shadow: none;" name="date"
                                        id="date1" max="9999-12-31">
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 col-lg-3 my-1 d-none">
                            <div class="mb-3 row">
                                <label for="inputStatus" class="col-12 col-form-label">Level</label>
                                <div class="col-12">
                                    <select class="form-select" aria-label="Default select example" name="level"
                                        id="level">
                                        <option value="">Select Option</option>
                                        @if (!empty($levels))
                                            @foreach ($levels as $level)
                                                <option value="{{ $level->id }}">
                                                    {{ $level->level }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div
                            class="col-lg-3 col-12 col-md-4 my-2 d-flex align-items-end justify-content-center justify-content-md-start">
                            <div class="mb-3 row  w-100">
                                <label class="col-12 col-form-label"></label>
                                <div class="col-12 px-0">
                                    <input type="submit" id="search" class="btn px-5 filter-btn" value="Filter">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-4 d-flex justify-content-md-center text-center">
            <div class="col-lg-11 col-12 px-0 ">
                <div class="container mt-2 mt-md-5 custom-table px-3 px-lg-0">
                    <table class="table table-bordered custom-table">
                        <thead class="student-table-details">
                            <tr>
                                <th># Booking Id</th>
                                <th>Student</th>
                                <th>Tutor</th>
                                <th>Subject</th>
                                <th>Amount</th>
                                <th>Duration</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="ajaxbody">
                            @forelse ($bookings as $booking)
                                @php
                                    $tutorsubjectoffers = App\Models\TutorSubjectOffer::where('tutor_id', $booking->tutor_id)
                                        ->with(['level', 'tutor', 'subject'])
                                        ->get();
                                @endphp
                                @if (!empty(optional($booking->student)->role_id == '4' || optional($booking->student)->role_id == '6'))
                                    <tr>
                                        <th>{{ $booking->uuid }}</th>
                                        <th>{{ optional($booking->student)->username }}</th>
                                        <th class="text-capitalize">
                                            <a href="{{url('tutor/profile').'/'.optional($booking->tutor)->id}}" class="text-decoration-none text-dark">
                                                {{ optional($booking->tutor)->username }}
                                            </a>
                                        </th>
                                        <th class="text-capitalize">{{ optional($booking->subjects)->name }}</th>
                                        <td>
                                            @if ($booking->booking_fee !== 'Free')
                                                @if ((int) $booking->booking_fee == $booking->booking_fee)
                                                    £{{ $booking->booking_fee }}.00/hr
                                                @else
                                                    £{{ $booking->booking_fee }}/hr
                                                @endif
                                            @else
                                                {{ $booking->booking_fee }}
                                            @endif
                                        </td>
                                        <td>{{ $booking->duration }} minutes</td>
                                        <td>
                                            @if ($booking->request_refound != 1 && $booking->request_refound != '2')
                                                <span
                                                    class="badge
                                @if ($booking->status == 'Completed') bg-success
                                @elseif($booking->status == 'Scheduled') bg-info
                                @elseif($booking->status == 'Cancelled By Tutor' || $booking->status == 'Cancelled By User') bg-danger
                                @elseif($booking->status == 'Cancelled') bg-danger
                                @elseif($booking->status == 'Pending') bg-warning @endif
                            ">
                                                    {{ $booking->status }}
                                                </span>
                                            @else
                                                <span class="badge bg-secondary">
                                                    @if($booking->request_refound == '2')
                                                     {{ 'Paid Refund To User' }}
                                                    @else
                                                     {{ 'Request Refund' }}
                                                    @endif
                                                </span>
                                            @endif
                                        </td>
                                        <td>{!! $booking->booking_date . '<br>' . $booking->booking_time !!}</td>
                                        <th class="dropdown">






                                            @if ($booking->request_refound == '2' || $booking->request_refound == '1' || $booking->status == 'Cancelled' || $booking->status == 'Cancelled By User' || $booking->status == 'Cancelled By Tutor')
                                            <button class="btn student-table-details dropdown-toggle" type="button"
                                                id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false" disabled>
                                                Actions
                                            </button>
                                            @else
                                            <button class="btn student-table-details dropdown-toggle" type="button"
                                                id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                                Actions
                                            </button>
                                            @endif

                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1" >
                                                @if (Auth::user()->role_id == 5 || Auth::user()->role_id == 6)
                                                    <li>
                                                        <a href="{{ url('chat') . '/' . $booking->tutor->id }}"
                                                            class="dropdown-item">Let’s
                                                            chat with Tutor</a>
                                                        <a href="{{ url('chat') . '/' . $booking->student->id }}"
                                                            class="dropdown-item">Let’s chat with Student</a>
                                                    </li>
                                                @endif

                                                @if (Auth::user()->role_id == 5)
                                                    <!--<li>-->
                                                    <!--    <a class="dropdown-item cursor-pointer"-->
                                                    <!--        onclick="UpdateSubject('{{ $booking->id }}','{{ $booking->date }}','{{ $booking->time }}','{{ $booking->subjects->name }}','{{ $booking->tutor->username }}','£{{ $booking->amount }}/hr')">-->
                                                    <!--        Edit Booking-->
                                                    <!--    </a>-->
                                                    <!--</li>-->
                                                @endif

                                                @if ($booking->status != 'Completed')
                                                    @if (Auth::user()->role_id == 3 || Auth::user()->role_id == 4)
                                                        @if ($booking->status != 'Pending')
                                                            @if (
                                                                $booking->status != 'Cancelled' &&
                                                                    $booking->status != 'Cancelled By User' &&
                                                                    $booking->status != 'Cancelled By Tutor')
                                                                <li>
                                                                    <!--<a target="_blank"-->
                                                                    <!--    href="{{ url('online-meeting/') . '/' . $booking->uuid }}"-->
                                                                    <!--    class="dropdown-item cursor-pointer">Join-->
                                                                    <!--    Meeting</a>-->
                                                                    @if(Auth::user()->role_id == 4)
                                                                        @if($booking->is_meet_student <= 1)
                                                                        <a target="_blank"
                                                                            href="{{ url('zoom-online-meeting/') . '/' . $booking->uuid }}"
                                                                            class="dropdown-item cursor-pointer">Join Meeting
                                                                             Zoom</a>
                                                                        @endif
                                                                    @endif

                                                                    @if(Auth::user()->role_id == 3)
                                                                        @if($booking->is_meet_tutor <= 1)
                                                                        <a target="_blank"
                                                                            href="{{ url('zoom-online-meeting/') . '/' . $booking->uuid }}"
                                                                            class="dropdown-item cursor-pointer">Join Meeting
                                                                             Zoom</a>
                                                                        @endif
                                                                    @endif
                                                                </li>
                                                            @endif
                                                        @endif
                                                    @endif

                                                    @if (
                                                        $booking->status != 'Cancelled By Tutor' &&
                                                            $booking->status != 'Cancelled By User' &&
                                                            $booking->status != 'Cancelled')
                                                        @if (Auth::user()->role_id == 3)
                                                            @if ($booking->status != 'Scheduled')
                                                                <li>
                                                                    <a href="{{ url('booking-status-change?id=') . $booking->uuid . '&status=Scheduled&tutorId=' . $booking->tutor_id }}"
                                                                        class="dropdown-item cursor-pointer">Accept
                                                                        Booking</a>
                                                                </li>
                                                            @endif
                                                        @endif

                                                        @if (Auth::user()->role_id == 3)
                                                            <li>
                                                                @if ($booking->status != 'Scheduled')
                                                                    <a href="{{ url('booking-status-change?id=') . $booking->uuid . '&status=Cancelled By Tutor&tutorId=' . $booking->tutor_id }}"
                                                                        class="dropdown-item cursor-pointer">Reject
                                                                        Booking</a>
                                                                @else
                                                                    <a href="{{ url('booking-status-change?id=') . $booking->uuid . '&status=Cancelled&tutorId=' . $booking->tutor_id }}"
                                                                        class="dropdown-item cursor-pointer">Cancel
                                                                        Booking</a>
                                                                    <a href="javascript:void(0)"
                                                                        onclick="Rescheduled('{{ $booking->uuid }}',' {{ $booking->tutor_id }}',' {{ $booking->subjects->name }}',' {{ $booking->subjects->id }}')"
                                                                        class="dropdown-item cursor-pointer">Reschedule
                                                                        Booking</a>
                                                                @endif
                                                            </li>
                                                        @elseif (Auth::user()->role_id == 4 || Auth::user()->role_id == 5 || Auth::user()->role_id == 6)
                                                            <li>
                                                                @if ($booking->status != 'Scheduled')
                                                                    <a href="{{ url('booking-status-change?id=') . $booking->uuid . '&status=Cancelled&tutorId=' . $booking->tutor_id }}"
                                                                        class="dropdown-item cursor-pointer">Reject
                                                                        Booking</a>
                                                                @else
                                                                    <a href="{{ url('booking-status-change?id=') . $booking->uuid . '&status=Cancelled&tutorId=' . $booking->tutor_id }}"
                                                                        class="dropdown-item cursor-pointer">Cancel
                                                                        Booking</a>
                                                                    <a href="javascript:void(0)"
                                                                        onclick="Rescheduled('{{ $booking->uuid }}',' {{ $booking->tutor_id }}',' {{ $booking->subjects->name }}',' {{ $booking->subjects->id }}')"
                                                                        class="dropdown-item cursor-pointer">Reschedule
                                                                        Booking</a>
                                                                @endif
                                                            </li>
                                                            @if ($booking->status != 'Pending')
                                                                <li>
                                                                    <a href="javascript:void(0)"
                                                                        class="dropdown-item cursor-pointer"
                                                                        onclick="yourButtonId('{{ $booking->uuid }}','Completed','{{ $booking->tutor_id }}')">Mark
                                                                        As
                                                                        Completed </a>
                                                                </li>
                                                            @endif
                                                        @endif
                                                    @endif
                                                @else
                                                    @if ($booking->request_refound != '1' && $booking->request_refound != '2')
                                                        <li>
                                                            <a onClick="viewRating(`{{ $booking->uuid }}`)"
                                                                class="dropdown-item cursor-pointer" style="cursor: pointer">View Feedback</a>
                                                        </li>
                                                        @if (Auth::user()->role_id != 3)
                                                        <li>
                                                            <a onclick="Refund('{{$booking->uuid}}','{{$booking->tutor_id}}','{{optional($booking->tutor)->username}}','{{optional($booking->subjects)->name}}','{{$booking->booking_fee}}')"
                                                            class="dropdown-item " style="cursor: pointer">
                                                            Request Refund
                                                            </a>

                                                        </li>
                                                        @endif
                                                    @endif
                                                @endif

                                            </ul>











                                        </th>
                                    </tr>
                                @endif
                            @empty
                                <tr>
                                    <td colspan="9">No bookings available</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>
            </div>
        </div>

    </div>


        <div class="modal fade zoomIn" id="RefundModal" tabindex="-1" aria-labelledby="update_doc_modal"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0">
                <div class="modal-header p-3 bg-info-subtle">
                    <h5 class="modal-title" id="update_doc_modal_title">Refund Booking</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        id="close-modal"></button>
                </div>
                <form class="tablelist-form" id="free_meet_form" enctype="multipart/form-data" autocomplete="off" method="post" action="{{ url('request-refound') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="row mt-4">


                            <div class="row mt-4">
                                <div class="col-md-6">
                                    <label class="text-secondary">Booking Id</label><br>
                                   <input type="text" id="booking_ids" disabled class="w-100 p-2">
                                </div>

                                <div class="col-md-6">
                                    <label class="text-secondary">Tutor</label><br>
                                    <input type="text" class="w-100 p-2" disabled id="tutorname">
                                </div>


                            </div>
                             <div class="row mt-4">
                                <div class="col-md-6">
                                    <label class="text-secondary">Subject</label><br>
                                    <input type="text" class="w-100 p-2" disabled id="subjectname">
                                </div>

                                <div class="col-md-6">
                                    <label class="text-secondary">Amount</label><br>
                                    <input type="text" class="w-100 p-2" disabled id="price">
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-md-6">
                                    <label class="text-secondary">Reason</label><br>
                                    <input type="text" required name="reason" class="w-100 p-2">
                                    <input type="hidden" id="tutorId" value="" name="tutorId">
                                     <input type="hidden" id="booking_id" name="id">

                                </div>

                                <div class="col-md-6">
                                    <label class="text-secondary">Image</label><br>
                                    <input type="file" class="w-100 p-2" name="image">
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="hstack gap-2 justify-content-end">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success" id="add-btn">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>










    <div class="modal fade zoomIn" id="RescheduledModal" tabindex="-1" aria-labelledby="update_doc_modal"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0">
                <div class="modal-header p-3 bg-info-subtle">
                    <h5 class="modal-title" id="update_doc_modal_title">Rescheduled Meeting</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        id="close-modal"></button>
                </div>
                <form class="tablelist-form" id="free_meet_form" enctype="multipart/form-data" autocomplete="off"
                    method="post" action="{{ route('rescheduled.meeting') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="row mt-4">
                            <div class="row mt-4">

                                <div class="col-md-12">
                                    <label>Subject & Level</label><br>
                                    <select required name="subject" id="changesubject" class="w-100 p-3">
                                        <option value="" id="subjectoption"></option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-md-6">
                                    <label class="text-secondary">Date</label><br>
                                    <input type="date" id="date" required name="date" minDate="0"
                                        class="w-100 p-3" max="9999-12-31">
                                    <input type="hidden" id="tutor_id" value="" name="tutor_id">
                                    <input type="hidden" id="Reschbooking_id" value="" name="booking_id">
                                </div>

                                <div class="col-md-6">
                                    <label class="text-secondary">Time</label><br>
                                    <input id="time-1" required name="time" type="text" class="w-100 p-3">

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="hstack gap-2 justify-content-end">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success" id="add-btn">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>






    <div class="modal" id="ratingModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title" id="user_feedback_label"></h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        id="close-modal"></button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row ">
                        <div class="col-md-12">
                            <p id="feedback"></p>
                            <div class='rating-stars text-center mt-5'>
                                <ul id='stars' style="text-align:left">

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>
    <script>
        function Rescheduled(bookingId, tutorId, subject, subjectId) {
            $('#tutor_id').val(tutorId);
            $('#Reschbooking_id').val(bookingId);
            $('#subjectoption').val(subjectId);
            $('#changesubject').val(subjectId);
            $('#subjectoption').text(subject);
            $('#RescheduledModal').modal('show');
        }
    </script>



    <script>
        function Refund(bookingId, tutorId,tutorName,Subject,price) {
            $('#tutorId').val(tutorId);
            $('#booking_id').val(bookingId);
            $('#booking_ids').val(bookingId);
            $('#tutorname').val(tutorName);
            $('#subjectname').val(Subject);
            $('#price').val(price);
            $('#RefundModal').modal('show');
        }
    </script>


    <script>
        var picker = '';
        let slots = '';
        $(document).ready(function() {


            var form_count = 1;
            var total_forms = $("fieldset").length;

            var date = new Date().toISOString().slice(0, 10);
            $('#date').attr('min', date);

            $("#date").on("change", function() {
                var date = $(this).val();
                let id = $('#tutor_id').val();
                $.ajax({
                    url: '{{ url('get-slots') }}',
                    type: 'POST',
                    data: {
                        date: date,
                        id: id,
                    },
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    success: function(data) {
                        console.log(data)
                        slots = data.slots;

                        if (slots.length > 0) {
                            if (picker != '') {
                                picker.destroy();
                            }

                            let $interval = '';
                            for (let i = 0; i < slots.length; i++) {
                                // if (slots[i].schedule_time == '12am-5am') {
                                //     $interval +=
                                //         `<button id="option1" onclick="optionsClick(0,5,1)" style="width:auto !important;margin-right: 5px;" type="button">12am - 5am</button>`;
                                // } else
                                if (slots[i].schedule_time == 'Morning') {
                                    $interval +=
                                        `<button id="option2" onclick="optionsClick(6,12,2)" style="width:auto !important;margin-right: 5px;" type="button">Morning</button>`;
                                } else if (slots[i].schedule_time == 'Afternoon') {
                                    $interval +=
                                        `<button id="option2" onclick="optionsClick(12,18,3)" style="width:auto !important;margin-right: 5px;" type="button">Afternoon</button>`;
                                } else if (slots[i].schedule_time == 'Evening') {
                                    $interval +=
                                        `<button id="option2" onclick="optionsClick(18,24,4)" style="width:auto !important;margin-right: 5px;" type="button">Evening</button>`;
                                }

                            }
                            console.log('$interval', $interval)
                            picker = new AppointmentSlotPicker(document.getElementById(
                                'time-1'), {
                                interval: 60,
                                mode: '12h',
                                minTime: 0,
                                maxTime: 5,
                                startTime: 0,
                                endTime: 5,
                                large: true,
                                title: $interval,
                                disabled: data.disabled_slots
                            });

                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            for (var key in errors) {
                                $('#errormsg').append('<p>' + errors[key][0] + '</p>');
                            }
                        }
                    }
                });

            });
            // Hide all fieldsets except the first one
            $("fieldset:not(:first)").hide();

            // Function to set the progress bar
            function setProgressBar(curStep) {
                var percent = (curStep - 1) / (total_forms - 1) * 100;
                $(".progress-bar")
                    .css("width", percent + "%")
                // .html(percent.toFixed(0) + "%");
            }

            // Function to show the next step and hide the current step
            function showNextStep() {
                if (validateStep(form_count)) {
                    var currentFieldset = $("fieldset:visible");
                    var nextFieldset = currentFieldset.next("fieldset");

                    if (nextFieldset.length > 0) {
                        currentFieldset.hide();
                        nextFieldset.show();
                        form_count++;
                        setProgressBar(form_count);
                    }
                } else {
                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: 'Please fill in all required fields.',
                        showConfirmButton: false,
                        timer: 2000,
                        showCloseButton: true
                    });
                }
            }


            function validateStep(step) {
                var isValid = true;
                // You can add your validation logic here for the fields in the current step
                // Example:
                if (step === 1) {
                    if ($('#changesubject').val() === '' || $('#date').val() === '' || $('#time-1').val() === '') {
                        isValid = false;
                    }
                } else if (step === 2) {
                    if ($('#country').val() === '' || $('#address1').val() === '' || $('#address2').val() === '' ||
                        $('#city').val() === '' || $('#postcode').val() === '') {
                        isValid = false;
                    }
                }
                return isValid;
            }

            // Function to show the previous step and hide the current step
            function showPreviousStep() {
                var currentFieldset = $("fieldset:visible");
                var previousFieldset = currentFieldset.prev("fieldset");

                if (previousFieldset.length > 0) {
                    currentFieldset.hide();
                    previousFieldset.show();
                    form_count--;
                    setProgressBar(form_count);
                }
            }

            // Handle the "Next" button click
            $(".next").click(function() {
                showNextStep();
            });

            // Handle the "Previous" button click
            $(".previous").click(function() {
                showPreviousStep();
            });

            // Handle the "Submit" button click (you can adjust this as needed)
            $(".submit").click(function() {
                // You can add your form submission logic here
                alert("Form submitted!");
            });


        });


        function viewRating(id) {

            $.ajax({
                url: '{{ url('get-booking-details') }}',
                type: 'POST',
                data: {
                    id: id,
                },
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                success: function(data) {
                    $('#user_feedback_label').text(data.role);
                    $('#feedback').text(data.feedback);
                    let rating = '';
                    if (data.rating == 0) {

                        rating = `<li class='star' title='Poor' data-value='1'>
                            <i class='fa fa-star fa-fw'></i>
                        </li>
                        <li class='star' title='Fair' data-value='2'>
                            <i class='fa fa-star fa-fw'></i>
                        </li>
                        <li class='star' title='Good' data-value='3'>
                            <i class='fa fa-star fa-fw'></i>
                        </li>
                        <li class='star' title='Excellent' data-value='4'>
                            <i class='fa fa-star fa-fw'></i>
                        </li>
                        <li class='star' title='WOW!!!' data-value='5'>
                            <i class='fa fa-star fa-fw'></i>
                        </li>`;
                    } else if (data.rating == 1) {
                        rating = `<li class='star selected' title='Poor' data-value='1'>
                            <i class='fa fa-star fa-fw'></i>
                        </li>
                        <li class='star' title='Fair' data-value='2'>
                            <i class='fa fa-star fa-fw'></i>
                        </li>
                        <li class='star' title='Good' data-value='3'>
                            <i class='fa fa-star fa-fw'></i>
                        </li>
                        <li class='star' title='Excellent' data-value='4'>
                            <i class='fa fa-star fa-fw'></i>
                        </li>
                        <li class='star' title='WOW!!!' data-value='5'>
                            <i class='fa fa-star fa-fw'></i>
                        </li>`;
                    } else if (data.rating == 2) {
                        rating = `<li class='star selected' title='Poor' data-value='1'>
                            <i class='fa fa-star fa-fw'></i>
                        </li>
                        <li class='star selected' title='Fair' data-value='2'>
                            <i class='fa fa-star fa-fw'></i>
                        </li>
                        <li class='star' title='Good' data-value='3'>
                            <i class='fa fa-star fa-fw'></i>
                        </li>
                        <li class='star' title='Excellent' data-value='4'>
                            <i class='fa fa-star fa-fw'></i>
                        </li>
                        <li class='star' title='WOW!!!' data-value='5'>
                            <i class='fa fa-star fa-fw'></i>
                        </li>`;
                    } else if (data.rating == 3) {
                        rating = `<li class='star selected' title='Poor' data-value='1'>
                            <i class='fa fa-star fa-fw'></i>
                        </li>
                        <li class='star selected' title='Fair' data-value='2'>
                            <i class='fa fa-star fa-fw'></i>
                        </li>
                        <li class='star selected' title='Good' data-value='3'>
                            <i class='fa fa-star fa-fw'></i>
                        </li>
                        <li class='star' title='Excellent' data-value='4'>
                            <i class='fa fa-star fa-fw'></i>
                        </li>
                        <li class='star' title='WOW!!!' data-value='5'>
                            <i class='fa fa-star fa-fw'></i>
                        </li>`;
                    } else if (data.rating == 4) {
                        rating = `<li class='star selected' title='Poor' data-value='1'>
                            <i class='fa fa-star fa-fw'></i>
                        </li>
                        <li class='star selected' title='Fair' data-value='2'>
                            <i class='fa fa-star fa-fw'></i>
                        </li>
                        <li class='star selected' title='Good' data-value='3'>
                            <i class='fa fa-star fa-fw'></i>
                        </li>
                        <li class='star selected' title='Excellent' data-value='4'>
                            <i class='fa fa-star fa-fw'></i>
                        </li>
                        <li class='star' title='WOW!!!' data-value='5'>
                            <i class='fa fa-star fa-fw'></i>
                        </li>`;
                    } else if (data.rating == 5) {
                        rating = `<li class='star selected' title='Poor' data-value='1'>
                            <i class='fa fa-star fa-fw'></i>
                        </li>
                        <li class='star selected' title='Fair' data-value='2'>
                            <i class='fa fa-star fa-fw'></i>
                        </li>
                        <li class='star selected' title='Good' data-value='3'>
                            <i class='fa fa-star fa-fw'></i>
                        </li>
                        <li class='star selected' title='Excellent' data-value='4'>
                            <i class='fa fa-star fa-fw'></i>
                        </li>
                        <li class='star selected' title='WOW!!!' data-value='5'>
                            <i class='fa fa-star fa-fw'></i>
                        </li>`;
                    }

                    $('#stars').html(rating);

                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        var errors = xhr.responseJSON.errors;
                        for (var key in errors) {
                            $('#errormsg').append('<p>' + errors[key][0] + '</p>');
                        }
                    }
                }
            });
            $('#ratingModal').modal('show');
        }

        function optionsClick(strt, end, btn) {

            picker.destroy();

            let $interval = '';
            for (let i = 0; i < slots.length; i++) {
                if (slots[i].schedule_time == '12am-5am') {
                    $interval +=
                        `<button id="option1" onclick="optionsClick(0,5,1)" style="width:auto !important;margin-right: 5px;" type="button">12am - 5am</button>`;
                } else if (slots[i].schedule_time == '6am-11am') {
                    $interval +=
                        `<button id="option2" onclick="optionsClick(6,12,2)" style="width:auto !important;margin-right: 5px;" type="button">6am - 12pm</button>`;
                } else if (slots[i].schedule_time == '12pm-5pm') {
                    $interval +=
                        `<button id="option2" onclick="optionsClick(12,18,3)" style="width:auto !important;margin-right: 5px;" type="button">12pm - 5pm</button>`;
                } else if (slots[i].schedule_time == '6pm-11pm') {
                    $interval +=
                        `<button id="option2" onclick="optionsClick(18,24,4)" style="width:auto !important;margin-right: 5px;" type="button">6pm - 12am</button>`;
                }

            }

            picker = new AppointmentSlotPicker(document.getElementById('time-1'), {
                interval: 60,
                mode: '12h',
                minTime: strt,
                maxTime: end,
                startTime: strt,
                endTime: end,
                large: true,
                title: $interval
            });
            picker.open();
        }
    </script>
    <div class="modal" id="updateSubjectModal">
        <div class="modal-dialog">
            <div class="modal-content" id="subjectmodalget">
            </div>
        </div>
    </div>

    <script>
        function yourButtonId(id, status, tutor) {
            var url = "{{ url('booking-status-compeleted') }}";
            Swal.fire({
                title: 'Are you sure?',
                text: 'Do you want to mark it as completed?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, mark as completed'
            }).then((result) => {
                if (result.isConfirmed) {

                    $.ajax({
                        url: url,
                        type: 'GET',
                        data: {
                            id: id,
                            status: status,
                            tutorId: tutor
                        },
                        success: function(response) {
                            window.location.reload();
                        },

                    });
                }
            });
        };
    </script>

    <script>
        $(document).ready(function() {
            var selectedCriteria = [];

            $('#search').on('click', function() {
                var level = $('#level').val();
                var subject = $('#subject').val();
                var date = $('#date1').val();

                $.ajax({
                    url: '{{ url('bookings') }}',
                    type: 'GET',
                    data: {
                        date: date,
                        level: level,
                        subject: subject,
                    },
                    success: function(data) {
                        $('#ajaxbody').html(data);
                    }
                });
            });

            $(document).on('click', '.pagination a', function(e) {
                e.preventDefault();
                var page = $(this).attr('href').split('page=')[1];
                var level = $('#level').val();
                var subject = $('#subject').val();
                var date = $('#date').val();

                getPaginatedData(page, level, subject, date);
            });

            function getPaginatedData(page, level, subject, date) {
                $.ajax({
                    url: '{{ url('bookings') }}?page=' + page,
                    type: 'GET',
                    data: {
                        date: date,
                        level: level,
                        subject: subject,
                    },
                    success: function(data) {
                        $('#ajaxbody').html(data);
                    }
                });
            }
        });

        function UpdateSubject(id, date, time, subject, tutor, fee) {
            $('#subjectmodalget').html('');
            const modal = document.getElementById("updateSubjectModal");
            const url = `{{ url('/booking-update') }}`;
            let selectOptions = @json($levels);

            const html = `
            <form action="${url}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="${id}">
                <div class="modal-header">
                    <h4 class="modal-title">Update Subject</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" disabled name="subject" value="${subject}" id="floatingInput" placeholder="Name">
                        <label for="floatingInput">Subject</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" disabled name="subject" value="${tutor}" id="floatingInput" placeholder="Name">
                        <label for="floatingInput">Tutor</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" disabled name="subject" value="${fee}" id="floatingInput" placeholder="Name">
                        <label for="floatingInput">Fee</label>
                    </div>
                    <div class="row">
                        <div class="form-floating mb-3 col-md-6">
                        <input type="date" class="form-control" min="${date}" max="9999-12-31" name="date" value="${date}" id="floatingInput" placeholder="Grade">
                        <label for "floatingInput">Date</label>
                    </div>
                    <div class="form-floating mb-3 col-md-6">
                        <input type="time" class="form-control" min="${time}" name="time" value="${time}" id="floatingInput" placeholder="Grade">
                        <label for "floatingInput">Time</label>
                    </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" >Update</button>
                </div>
            </form>`;

            $('#subjectmodalget').append(html);
            new bootstrap.Modal(modal).show();
        }
    </script>
@endsection
