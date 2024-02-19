@extends('layouts.main')
@section('title', 'Reviews')
@section('content')
    <!-- push external head elements to head -->
    @push('head')
        <link rel="stylesheet" href="{{ asset('plugins/DataTables/datatables.min.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/bootstrap/css/bootstrap.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/webicons/css/all.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    @endpush


    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8 col-md-6 col-12">
                    <div class="page-header-title">
                        <i class="ik ik-users bg-blue"></i>
                        <div class="d-inline">
                            <h5>{{ __('Reviews') }}</h5>
                            <span>{{ __('List of Reviews') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-12 mt-3 m-md-0">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#">{{ __('Reviews') }}</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#">{{ __('Student') }}</a>
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
            <div class="col-md-12  user-table-data">
                <div class="card p-3">
                    <div class="card-header justify-content-between">
                        <h3>{{ __('Student Reviews') }}</h3>
                    </div>
                    <div class="card-body" style="overflow:scroll;">

                        <!--<div class="card-header d-flex justify-content-between">-->
                        <!--    {{-- <h3 class="col-auto">{{ __('Complaint') }}</h3> --}}-->
                        <!--    <form method="GET" action="" class="col-md-3 d-flex justify-content-between align-items-center gap-2">-->
                        <!--        {{-- <input type="text" name="search" value="{{ $_GET['search'] ?? '' }}" class="form-control" placeholder="Search">-->
                        <!--        <button type="submit" class="btn btn-primary">Search</button> --}}-->
                        <!--    </form>-->
                        <!--</div>-->

                        <table id="reviewStudents" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>{{ __('# Booking ID') }}</th>
                                    <th>{{ __('Tutor') }}</th>
                                    <th>{{ __('Tutor Rating') }}</th>
                                    <th>{{ __('Tutor Feedback') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($reviewStudents as $Parent)
                                @if(!empty($Parent->tutor))
                                    <tr>
                                        <td style="border-bottom: .5px solid black;">{{ $Parent->uuid }}</td>
                                        <td style="border-bottom: .5px solid black;">{{ optional($Parent->tutor)->username }}</td>
                                        <td style="border-bottom: .5px solid black;">
                                            @for ($i=0;$i < $Parent->tutor_rating ;$i++)
                                            <i class="fa fa-star" style="color: yellow"></i>
                                            @endfor
                                            {{-- {{  }} --}}
                                        </td>
                                        <td style="border-bottom: .5px solid black;">{{ $Parent->tutor_feedback }}</td>
                                    </tr>
                                @endif
                                @empty
                                    <tr>
                                        <td>Record not found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css"/>
                        <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.11.5/datatables.min.js"></script>
                        <script>
                            $(document).ready(function(){
                                $('#reviewStudents').DataTable();
                            });
                        </script>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade zoomIn" id="demo_meeting_modal" tabindex="-1" aria-labelledby="update_doc_modal"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0">
            <div class="modal-header p-3 bg-info-subtle">
                <h5 class="modal-title" id="update_doc_modal_title">Make Interview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                    id="close-modal"></button>
            </div>
            <form class="tablelist-form" id="free_meet_form" enctype="multipart/form-data" autocomplete="off"
                method="post" action="{{ url('save/interview') }}">
                @csrf
                <div class="modal-body">
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <label class="text-secondary">Date</label><br>
                            <input type="date" name="date" id="date" class="w-100 p-3" required max="9999-12-31">
                            <input type="hidden" name="id" id="Tutorid" class="w-100 p-3" required>
                        </div>

                        <div class="col-md-6">
                            <label class="text-secondary">Time</label><br>
                            <input type="time" id="time-1" name="time" class="w-100 p-3" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="hstack gap-2 justify-content-end">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success" id="add-btn">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
    @push('script')
        <script src="{{ asset('plugins/select2/dist/js/select2.min.js') }}"></script>
        <script src="{{ asset('js/custom.js') }}"></script>
        <script>
    function freeMeetmodal(id) {
            $('#Tutorid').val(id)
            $('#demo_meeting_modal').modal('show')
        }
        </script>
    @endpush
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endsection
