@extends('layouts.main')
@section('title', 'Levels')
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
            <div class="col-lg-8">
                <div class="page-header-title">
                    <i class="ik ik-users bg-blue"></i>
                    <div class="d-inline">
                        <h5>{{ __('Levels')}}</h5>
                        <span>{{ __('List of Levels')}}</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <nav class="breadcrumb-container" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{route('dashboard')}}"><i class="ik ik-home"></i></a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="#">{{ __('Levels')}}</a>
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
                    <h3>{{ __('Levels')}}</h3>
                    <div class="btn btn-primary px-2 py-1" style="height: max-content;">
                    <a href="{{ url('/level/create') }}" class="text-light"><i class="fa-solid fa-plus m-auto" ></i></a>
                    </div>

                </div>
                <div class="card-body">
                    <table id="user_table" class="table table-bordered">
                        <thead>
                            <tr>
                            <th>{{ __('Sr.No')}}</th>
                                <th>{{ __('Name')}}</th>
                                <th>{{ __('Action')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $key =>$user)

                            <tr>

                                <td>{{ $key+1}}</td>
                                <td>{{ $user->level}}</td>

                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ url('/level/update').'/'.$user->id}}" class="btn btn-primary btn-sm" style="height: max-content;" style="font-size: 15px;"><i class="fa-regular fa-pen-to-square m-auto"></i></a>
                                        <a href="{{ url('/level/delete').'/'.$user->id}}" class="btn btn-danger btn-sm" style="height: max-content;" style="font-size: 15px;"><i class="fa-solid fa-trash-can m-auto"></i></a>
                                    </div>
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
<!-- push external js -->
@push('script')
<script src="{{ asset('plugins/select2/dist/js/select2.min.js') }}"></script>
<!--server side users table script-->
<!-- <script src="{{ asset('js/custom.js') }}"></script> -->
@endpush
@endsection
