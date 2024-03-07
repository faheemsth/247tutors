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
                        <i class="fa-solid fa-users bg-blue"></i>
                        <div class="d-inline">
                            <h5>{{ __('Parents') }}</h5>
                            <span>{{ __('List of Parents') }}</span>
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
                                <a href="#">{{ __('Parents') }}</a>
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
                    <div class="card-header justify-content-between">
                        <h3>{{ __('Parents') }}</h3>
                    </div>

                    <div class=" mt-4  px-0 pe-md-4 d-flex justify-content-between">
                        <h3 class="col-auto  d-none d-md-inline-block">{{ __('') }}</h3>
                        <form method="GET" action="" class="col-12 col-md-6 col-lg-6 col-xl-5 d-flex px-0 justify-content-between align-items-center gap-2">
                            <select name="status" id="status" class="col-md-6 select2 form-select">
                                <option value="">All Search</option>
                                <option value="Active" {{ !empty($_GET['status']) && $_GET['status'] == 'Active' ? 'selected':'' }}>Active</option>
                                <option value="Pending" {{ !empty($_GET['status']) && $_GET['status'] == 'Pending' ? 'selected':'' }}>Pending</option>
                                <option value="InActive" {{ !empty($_GET['status']) && $_GET['status'] == 'InActive' ? 'selected':'' }}>InActive</option>

                            </select>
                            <input type="text" name="search" value="{{ $_GET['search'] ?? '' }}" class="form-control" placeholder="Search">
                            <button type="submit" class="btn btn-primary">Search</button>
                        </form>
                    </div>

                    <div class="card-body" style="overflow: scroll;">
                        <table id="user_table" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>{{ __('Sr.No') }}</th>
                                    <th>{{ __('First Name') }}</th>
                                    <th>{{ __('Last Name') }}</th>
                                    <th>{{ __('Email') }}</th>
                                    <th>{{ __('Verify Email') }}</th>
                                    <th>{{ __('Status') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($Parents as $Parent)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $Parent->first_name }}</td>
                                        <td>{{ $Parent->last_name }}</td>
                                        <td>{{ $Parent->email }}</td>
                                        <td>
                                            @if(empty($Parent->email_verified_at))
                                            <a href="{{url('userVerify').'/'.$Parent->id}}" class="btn btn-primary">Click to Verify</a>
                                            @else
                                         <button class="btn btn-success px-2 py-1">verified</button>
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

                                    </tr>
                                @empty
                                    <tr>
                                        <td  colspan="6" class="text-center">Record not found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('script')
        <script src="{{ asset('plugins/select2/dist/js/select2.min.js') }}"></script>
        <script src="{{ asset('js/custom.js') }}"></script>
    @endpush
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    @forelse($Parents as $Parent)
        <script>
            $(document).ready(function() {
                $('#flexSwitchCheckDefault{{ $Parent->id }}').on('change', function() {
                    var status = $(this).val();
                    var id = $('#iduser{{ $Parent->id }}').val();
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
