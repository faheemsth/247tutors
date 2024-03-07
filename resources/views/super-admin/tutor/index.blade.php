@extends('layouts.main')
@section('title', 'Users')
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
                <div class="col-lg-8 col-md-6 col-7">
                    <div class="page-header-title">
                        <i class="ik ik-users bg-blue"></i>
                        <div class="d-inline">
                            <h5>{{ __('Tutors') }}</h5>
                            <span>{{ __('List of Tutors') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-5">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#">{{ __('Tutors') }}</a>
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
                <div class="card  p-md-3 p-2">
                    <div class="card-header justify-content-between">
                        <h3>{{ __('Tutors') }}</h3>
                    </div>

                    <!--<div class="card-header px-0 pe-md-4 d-flex justify-content-between">-->
                    <!--    <h3 class="col-auto d-none d-md-inline-block">{{ __('') }}</h3>-->
                    <!--    <form method="GET" action="" class="col-12 col-md-6 col-lg-6 col-xl-5 d-flex px-0 justify-content-between align-items-center gap-2">-->
                    <!--        <select name="status" id="status" class="col-md-6 select2 form-select">-->
                    <!--            <option value="">All Search</option>-->
                    <!--            <option value="Active" {{ !empty($_GET['status']) && $_GET['status'] == 'Active' ? 'selected':'' }}>Active</option>-->
                    <!--            <option value="Pending" {{ !empty($_GET['status']) && $_GET['status'] == 'Pending' ? 'selected':'' }}>Pending</option>-->
                    <!--            <option value="InActive" {{ !empty($_GET['status']) && $_GET['status'] == 'InActive' ? 'selected':'' }}>InActive</option>-->

                    <!--        </select>-->
                    <!--        <input type="text" name="search" value="{{ $_GET['search'] ?? '' }}" class="form-control" placeholder="Search">-->
                    <!--        <button type="submit" class="btn btn-primary">Search</button>-->
                    <!--    </form>-->
                    <!--</div>-->
                    <div class="card-body" style="overflow: scroll;">
                        <table id="reviewStudents" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>{{ __('Sr.No') }}</th>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Email') }}</th>
                                    <th>{{ __('Verify Email') }}</th>
                                    <th>{{ __('Status') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($tutors as $tutor)
                                    <tr>
                                        <td style="border-bottom: .5px solid black;">{{ $loop->index + 1 }}</td>
                                        <td style="border-bottom: .5px solid black;"><a href="{{ url('tutorProfile/').'/'.$tutor->id}}">{{ $tutor->first_name }} {{ $tutor->last_name }}</a></td>
                                        <td style="border-bottom: .5px solid black;">{{ $tutor->email }}</td>
                                        <td style="border-bottom: .5px solid black;">
                                         @if(empty($tutor->email_verified_at))
                                            <a href="{{url('userVerify').'/'.$tutor->id}}" class="btn btn-primary">Click to Verify</a>
                                         @else
                                         <button class="btn btn-success px-2 py-1">Verified</button>
                                         @endif
                                        </td>
                                        <td style="border-bottom: .5px solid black;">
                                            @if ($tutor->request_refound != 1)
                                            <span
                                                class="py-2 badge
                                        @if ($tutor->status == 'Completed') bg-success
                                        @elseif($tutor->status == 'Scheduled')
                                        bg-info
                                        @elseif($tutor->status == 'Cancelled By Tutor' || $tutor->status == 'Cancelled By User')
                                        bg-danger
                                        @elseif($tutor->status == 'Cancelled')
                                        bg-danger
                                        @elseif($tutor->status == 'Pending')
                                        bg-warning
                                        @elseif($tutor->status == 'Active')
                                        bg-success
                                        @elseif($tutor->status == 'InActive')
                                        bg-danger
                                        @endif
                                        ">
                                                {{ $tutor->status }}
                                            </span>
                                        @else
                                            <span class="badge bg-secondary">
                                                {{ 'Request Refound' }}
                                            </span>
                                        @endif
                                        </td>

                                    </tr>
                                @empty
                                    <tr colspan="5" class="text-center">
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
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css"/>
                        <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.11.5/datatables.min.js"></script>
                        <script>
                            $(document).ready(function(){
                                $('#reviewStudents').DataTable();
                            });
                        </script>

    @push('script')
        <script src="{{ asset('plugins/select2/dist/js/select2.min.js') }}"></script>
        <script src="{{ asset('js/custom.js') }}"></script>
    @endpush
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    @forelse($tutors as $tutor)
        <script>
            $(document).ready(function() {
                $('#flexSwitchCheckDefault{{ $tutor->id }}').on('change', function() {
                    var status = $(this).val();
                    var id = $('#iduser{{ $tutor->id }}').val();
                    $.ajax({
                        type: 'POST',
                        url: '{{ url('update-user-status?id=') }}' + id,
                        data: {
                            id: id,
                            status: status,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            window.location.reload();
                        }
                    });
                });

            });
        </script>
    @empty
    @endforelse


@endsection
