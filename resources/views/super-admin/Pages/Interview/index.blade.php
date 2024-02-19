@extends('layouts.main')
@section('title', 'Interviews')
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
                <div class="col-lg-8 col-md-6 col-7 pe-0">
                    <div class="page-header-title">
                        <i class="fa-solid fa-people-arrows bg-blue"></i>
                        <div class="d-inline">
                            <h5>{{ __('Interviews') }}</h5>
                            <span>{{ __('List of Interviews') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-5 pe-0 pe-3">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#">{{ __('Interviews') }}</a>
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
                    <div class="card-header justify-content-between ">
                        <h3>{{ __('Interviews') }}</h3>
                    </div>

                    <div class="card-header px-0 pe-md-4 d-flex justify-content-between">
                        <h3 class="col-auto  d-none d-md-inline-block">{{ __('') }}</h3>
                        <form method="GET" action="" class="col-12 col-md-4 col-lg-5 col-xl-3 d-flex px-0 justify-content-between align-items-center gap-2">
                            {{-- <select name="status" id="status" class="col-md-6 select2 form-select">
                                <option value="">All Search</option>
                                <option value="Active" {{ !empty($_GET['status']) && $_GET['status'] == 'Active' ? 'selected':'' }}>Active</option>
                                <option value="Pending" {{ !empty($_GET['status']) && $_GET['status'] == 'Pending' ? 'selected':'' }}>Pending</option>
                                <option value="InActive" {{ !empty($_GET['status']) && $_GET['status'] == 'InActive' ? 'selected':'' }}>InActive</option>

                            </select> --}}
                            <input type="text" name="search" value="{{ $_GET['search'] ?? '' }}" class="form-control" placeholder="Search">
                            <button type="submit" class="btn btn-primary">Search</button>
                        </form>
                    </div>

                    <div class="card-body" style="overflow: scroll;">
                        <table id="user_table" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>{{ __('Sr.No') }}</th>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Email') }}</th>
                                     <th>{{ __('Date') }} & {{ __('Time') }} </th>
                                     
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Interview') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($Interviewer as $Parent)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $Parent->first_name }}</td>
                                        <td>{{ $Parent->email }}</td>
                                        <td>
                                            @if(!empty($Parent->meeting_Interview_date) && !empty($Parent->meeting_Interview_time))
                                            {{ $Parent->meeting_Interview_date }} at {{ $Parent->meeting_Interview_time }}
                                            @else
                                            0000-00-00 at 00-00
                                            @endif
                                        </td>
                                    
                                        <td>
                                            @if ($Parent->request_refound != 1)
                                            <span
                                                class="badge
                                        @if ($Parent->status == 'Completed') bg-success
                                        @elseif($Parent->status == 'Scheduled')
                                        bg-info
                                        @elseif($Parent->status == 'Cancelled By Tutor' || $Parent->status == 'Cancelled By User')
                                        bg-danger
                                        @elseif($Parent->status == 'Cancelled')
                                        bg-danger
                                        @elseif($Parent->status == 'Pending')
                                        bg-warning
                                        @elseif($Parent->status == 'Active')
                                        bg-success
                                        @elseif($Parent->status == 'Inctive')
                                        bg-danger
                                        @endif
                                        ">
                                                {{ $Parent->status }}
                                            </span>
                                        @else
                                            <span class="badge bg-secondary">
                                                {{ 'Request Refound' }}
                                            </span>
                                        @endif
                                        </td>
                                        <td>
                                        @if ($Parent->is_Interviewed == 0)
                                            <button class="btn btn-info p-2 text-white" onclick="freeMeetmodal({{ $Parent->id }})">Schedule Interview </button>
                                        @elseif ($Parent->is_Interviewed == 1)
                                            @if($Parent->is_meet_admin > 0)
                                              <a class="btn btn-success p-2 text-white" target="_blank">Interview Completed</a>
                                            @else
                                              <a href="{{ url('zoom-online-interiew-meeting').'/'.$Parent->Interview_meeting_id }}" class="btn btn-primary p-2 text-white" target="_blank">Join Interview Meeting</a>
                                            @endif
                                        @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td>Record not found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
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
