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
                            <h5>{{ __('Users') }}</h5>
                            <span>{{ __('Create users') }}</span>
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
                                <a href="#">{{ __('Create') }}</a>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <form action="{{ url('/user/store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-12  user-table-data">
                    <div class="card p-3">
                        <div class="card-header justify-content-between">
                            <h3>{{ __('Users')}}</h3>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label class="form-label">First Name</label>
                                <input type="text" class="form-control" id="first-name" name="first_name"
                                    value="{{ old('first_name') }}">
                                @if ($errors->has('first_name'))
                                    <span class="text-danger">{{ $errors->first('first_name') }}</span>
                                @endif

                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="last-name" name="last_name"
                                    value="{{ old('last_name') }}">
                                @if ($errors->has('last_name'))
                                    <span class="text-danger">{{ $errors->first('last_name') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Password</label>
                                <input type="text" class="form-control" id="password" name="password">
                                @if ($errors->has('password'))
                                    <span class="text-danger">{{ $errors->first('password') }}</span>
                                @endif
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Phone</label>
                                <input type="text" class="form-control" id="user-phone" name="phone"
                                    value="{{ old('phone') }}">
                            </div>
                        </div>

                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Date of Birth</label>
                                <input type="text" class="form-control" id="dob" name="dob"
                                    value="{{ old('dob') }}">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Gender</label>
                                <input type="text" class="form-control" id="user-gender" name="gender"
                                    value="{{ old('gender') }}">
                            </div>
                        </div>

                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Facebook Link</label>
                                <input type="text" class="form-control" id="facebook-link" name="facebook_link"
                                    value="{{ old('facebook_link') }}">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Linkedin Link</label>
                                <input type="text" class="form-control" id="linkedin-link" name="linkedin_link"
                                    value="{{ old('linkedin_link') }}">
                            </div>
                        </div>

                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Twitter Link</label>
                                <input type="text" class="form-control" id="twitter-link" name="twitter_link"
                                    value="{{ old('twitter_link') }}">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Status</label>
                                <input type="text" class="form-control" id="status" name="status">
                            </div>
                        </div>

                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Profile Description</label>
                                <input type="text" class="form-control" id="profile-description"
                                    name="profile_description" value="{{ old('profile_description') }}">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Address</label>
                                <input type="text" class="form-control" id="address" name="address"
                                    value="{{ old('address') }}">
                            </div>
                        </div>

                        <div class="row">
                            <div class="mb-3 col-md-12">
                                <label class="form-label">Image</label>
                                <input type="file" class="form-control" id="image" name="image">
                            </div>
                        </div>

                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    value="{{ old('email') }}">
                                @if ($errors->has('email'))
                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                @endif
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Role</label>
                                <select name="role_id" class="form-control">
                                    <option value="">Select Role</option>
                                    @if (!empty($roles))
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <button type="submit" class=" py-1 px-2 border-0 text-white rounded-3"
                                    style="background-color: #19b5fe ;">{{ __('Submit') }}</button>
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
