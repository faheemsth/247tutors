@extends('layouts.main')
@section('title', 'Users')
@section('content')
    <!-- push external head elements to head -->
    @push('head')
        <link rel="stylesheet" href="{{ asset('plugins/DataTables/datatables.min.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/bootstrap/css/bootstrap.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/webicons/css/all.css') }}">
    @endpush


    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-users bg-blue"></i>
                        <div class="d-inline">
                            <h5>{{ __('Levels') }}</h5>
                            <span>{{ __('Update Levels') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ url('level') }}">{{ __('Level') }}</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#">{{ __('Update') }}</a>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <form action="{{ url('/level/update') . '/' . $level->id }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-12  user-table-data">
                    <div class="card p-3">
                        <div class="card-header justify-content-between">
                            <h3>{{ __('Levels') }}</h3>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Level</label>
                                <input type="text" class="form-control" id="first-name" name="level"
                                    value="{{ $level->level }}">
                                @if ($errors->has('level'))
                                    <span class="text-danger">{{ $errors->first('level') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <button type="submit" class=" py-1 px-2 border-0 text-white rounded-3"
                                    style="background-color: #19b5fe ;">Submit</button>
                            </div>
                            <div class="col-md-10"></div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>


    @push('script')
        <script src="{{ asset('plugins/select2/dist/js/select2.min.js') }}"></script>
        <!--server side users table script-->
        <!-- <script src="{{ asset('js/custom.js') }}"></script> -->
    @endpush
@endsection
