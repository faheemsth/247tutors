@extends('layouts.main')

@section('title', 'Users')

@push('head')
    <link rel="stylesheet" href="{{ asset('plugins/DataTables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/webicons/css/all.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
@endpush

@section('content')
    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8 col-md-6 col-7">
                    <div class="page-header-title">
                        <i class="fa-solid fa-percent bg-blue" style="font-size: 14px;"></i>
                        <div class="d-inline">
                            <h5>{{ __('Coupons') }}</h5>
                            <span>{{ __('List of Coupons') }}</span>
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
                                <a href="#">{{ __('Coupons') }}</a>
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
            <div class="col-md-12 user-table-data col-12 pe-0 pe-md-2">
                <div class="card p-md-3 p-2">
                    <div class="card-header justify-content-between px-0 pe-lg-4">
                        <h3>{{ __('Coupons') }}</h3>
                        <button class="btn-primary text-white rounded-3 px-2 py-1" type="button" data-bs-toggle="modal"
                            data-bs-target="#save_doc_type_modal">Add Coupon</button>
                    </div>
                    <div class="card-body" style="overflow: scroll;">
                        <table id="reviewStudents" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>{{ __('Sr.No') }}</th>
                                    <th>{{ __('Code') }}</th>
                                    <!--<th>{{ __('To User') }}</th>-->
                                    <th>{{ __('Description') }}</th>
                                    <th>{{ __('Discount Type') }}</th>
                                    <th>{{ __('Price') }}</th>
                                    <th>{{ __('Valid From') }}</th>
                                    <th>{{ __('Valid To') }}</th>
                                    <th>{{ __('Status') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($coupons as $coupon)
                                    <tr>
                                        <td style="border-bottom: .5px solid black;">{{ $loop->index + 1 }}</td>
                                        <td style="color:blue;border-bottom: .5px solid black;">{{ $coupon->code }}</td>
                                        <!--<td>-->
                                        @if(!empty(explode(',', $coupon->to_user)))
                                            @foreach (explode(',', $coupon->to_user) as $item)
                                                @php
                                                    $user = \App\Models\User::find($item);
                                                @endphp
                                                @if($user)
                                                    <!--<span class="badge bg-success">{{ $user->first_name . ' ' . $user->last_name }}</span>-->
                                                @endif
                                            @endforeach
                                        @endif
                                        <!--</td>-->
                                        <td style="border-bottom: .5px solid black;">{{ $coupon->description }}</td>
                                        <td style="border-bottom: .5px solid black;">{{ $coupon->discount_type }}</td>
                                        <td style="border-bottom: .5px solid black;">£{{ $coupon->price }}</td>
                                        <td style="border-bottom: .5px solid black;">{{ $coupon->valid_from }}</td>
                                        <td style="border-bottom: .5px solid black;">{{ $coupon->valid_to }}</td>
                                        <td style="border-bottom: .5px solid black;" class="text-center">
                                            @if ($coupon->isExpired)
                                                <p class="alert alert-danger p-1">Expired</p>
                                            @else
                                                <p class="alert alert-success p-1">Valid</p>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center" colspan="8">Record not found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade zoomIn" id="save_doc_type_modal" tabindex="-1" aria-labelledby="save_doc_type_modal"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0">
                <div class="modal-header p-3 bg-info-subtle">
                    <h5 class="modal-title" id="save_doc_type_modal"> Add New Coupon</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        id="close-modal"></button>
                </div>
                <form action="{{url('create-coupon')}}" method="post" enctype="multipart/form-data">
                    @csrf
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
                </form>
            </div>
        </div>
    </div>

    <script src="{{ asset('plugins/select2/dist/js/select2.min.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/v/bs5/dt-1.11.5/datatables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#reviewStudents').DataTable();
        });
    </script>
@endsection
