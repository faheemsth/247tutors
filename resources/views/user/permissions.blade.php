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
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-users bg-blue"></i>
                        <div class="d-inline">
                            <h5>{{ __('Users') }}</h5>
                            <span>{{ __('List of users') }}</span>
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
                                <a href="{{ url('users') }}">{{ __('Users') }}</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#">{{ __('Permissions') }}</a>
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
                        <h3>{{ __('Permissions') }}</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ url('/user/' . $id . '/permissions') }}">
                            @csrf
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check1" name="manage_role"
                                            value="1" checked>
                                        <label class="form-check-label">Manage Role</label>
                                    </div>
                                </div>

                                <div class="mb-3 col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check1" name="manage_permission"
                                            value="1" checked>
                                        <label class="form-check-label">Manage Permission</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check1" name="manage_user"
                                            value="1" checked>
                                        <label class="form-check-label">Manage User</label>
                                    </div>
                                </div>

                                <div class="mb-3 col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check1" name="super_admin_dashboard"
                                            value="1" checked>
                                        <label class="form-check-label">Super Admin Dashboard</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check1" name="student/profile"
                                            value="1" checked>
                                        <label class="form-check-label">Student Dashboard</label>
                                    </div>
                                </div>

                                <div class="mb-3 col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check1" name="parent/profile"
                                            value="1" checked>
                                        <label class="form-check-label">Parent Dashboard</label>
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check1" name="organization/home"
                                            value="1" checked>
                                        <label class="form-check-label">Organization Dashboard</label>
                                    </div>
                                </div>

                                <div class="mb-3 col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check1" name="tutor/home"
                                            value="1" checked>
                                        <label class="form-check-label">Tutor Dashboard</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-2">
                                    <button type="submit" class=" py-1 px-2 border-0 text-white rounded-3"
                                        style="background-color: #19b5fe ;">{{ __('Submit') }}</button>
                                </div>
                                <div class="mb-3 col-md-10"></div>
                            </div>
                        </form>
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
