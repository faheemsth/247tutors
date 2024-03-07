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
                            <h5>{{ __('Students') }}</h5>
                            <span>{{ __('List of Students') }}</span>
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
                                <a href="#">{{ __('Students') }}</a>
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
                        <h3>{{ __('Students') }}</h3>
                    </div>

                    <!--<div class="card-header px-0 pe-md-4 d-flex justify-content-between">-->
                    <!--    <h3 class="col-auto d-none d-md-inline-block">{{ __('') }}</h3>-->
                    <!--    <form method="GET" action="" class="col-12 col-md-6  col-lg-6 col-xl-5 d-flex px-0 justify-content-between align-items-center gap-2">-->
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
                                    <th>{{ __('First Name') }}</th>
                                    <th>{{ __('Last Name') }}</th>
                                    <th>{{ __('Email') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    {{-- <th>{{ __('Verify Email') }}</th> --}}
                                    {{-- <th>{{ __('Coupon Code') }}</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($students as $user)
                                    <tr>
                                        <td style="border-bottom: .5px solid black;">{{ $loop->index + 1 }}</td>
                                        <td style="border-bottom: .5px solid black;">{{ $user->first_name }}</td>
                                        <td style="border-bottom: .5px solid black;">{{ $user->last_name }}</td>
                                        <td style="border-bottom: .5px solid black;">{{ $user->email }}</td>
                                        <td style="border-bottom: .5px solid black;">
                                            @if ($user->request_refound != 1)
                                            <span
                                                class="badge
                                        @if ($user->status == 'Completed') bg-success
                                        @elseif($user->status == 'Scheduled')
                                        bg-info
                                        @elseif($user->status == 'Cancelled By Tutor' || $user->status == 'Cancelled By User')
                                        bg-danger
                                        @elseif($user->status == 'Cancelled')
                                        bg-danger
                                        @elseif($user->status == 'Pending')
                                        bg-warning
                                        @elseif($user->status == 'Active')
                                        bg-success
                                        @elseif($user->status == 'Inctive')
                                        bg-danger
                                        @endif
                                        ">
                                                {{ $user->status }}
                                            </span>
                                        @else
                                            <span class="badge bg-secondary">
                                                {{ 'Request Refound' }}
                                            </span>
                                        @endif
                                        </td>
                                        {{-- <td>                                         @if(empty($user->email_verified_at))
                                            <a href="{{url('userVerify').'/'.$user->id}}" class="bg-primary px-3 py-2 rounded-3 text-white">Click to Verify</a>
                                         @endif</td> --}}
                                        {{-- <td>
                                            <a onclick="assignCoupon('{{ $user->id }}')"
                                                class="btn btn-primary btn-sm text-white" style="height: max-content;">
                                                Assign Coupon
                                            </a>

                                        </td> --}}
                                    </tr>
                                @empty
                                    <tr colspan="5" class="text-center">
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

    <div class="modal" id="updateSubjectModal">
        <div class="modal-dialog">
            <div class="modal-content" id="subjectmodalget">
            </div>
        </div>
    </div>

    @push('script')
        <script src="{{ asset('plugins/select2/dist/js/select2.min.js') }}"></script>
        <script src="{{ asset('js/custom.js') }}"></script>
    @endpush
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    @forelse($students as $user)
        <script>
            $(document).ready(function() {
                $('#flexSwitchCheckDefault{{ $user->id }}').on('change', function() {
                    var status = $(this).val();
                    var id = $('#iduser{{ $user->id }}').val();
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

            function assignCoupon(id) {
                $('#subjectmodalget').html('');
                const modal = document.getElementById("updateSubjectModal");
                const url = `{{ url('/create-coupon?id=') }}${id}`;

                const html = `
            <form action="${url}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title">Assign Coupon</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
            <div class="form-group">
                <label for="description">Description:</label>
                <input type="text" class="form-control" id="description" name="description">
            </div>
            <div class="form-group">
                <label for="discount_type">Discount Type:</label>
                <select class="form-control" id="discount_type" name="discount_type">
                    <option value="percentage">Percentage</option>
                    <option value="fixed_amount">Fixed Amount</option>
                    <option value="free_shipping">Free Shipping</option>
                </select>
            </div>
            <div class="form-group">
                <label for="price">Discount Value:</label>
                <input type="number" class="form-control" id="price" name="price" step="0.01" required>
            </div>
            <div class="form-group">
                <label for="valid_from">Valid From:</label>
                <input type="datetime-local" class="form-control" id="valid_from" name="valid_from" required>
            </div>
            <div class="form-group">
                <label for="valid_to">Valid To:</label>
                <input type="datetime-local" class="form-control" id="valid_to" name="valid_to" required>
            </div>
            <div class="form-group">
                <label for="usage_limit">Usage Limit:</label>
                <input type="number" class="form-control" id="usage_limit" name="usage_limit" min="1" value="1">
            </div>
            </div>
            <div class="modal-footer">
                    <button type="submit" class="btn btn-success px-2 py-2" style="height: max-content;">Save</button>
                </div>
        </form>`;

                $('#subjectmodalget').append(html);
                new bootstrap.Modal(modal).show();
            }
        </script>
    @empty
    @endforelse


@endsection
