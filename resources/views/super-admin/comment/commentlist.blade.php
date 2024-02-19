@extends('layouts.main')
@section('title', 'Comment Section')
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
                        <i class="fa-solid fa-comments bg-blue"></i>
                        <div class="d-inline">
                            <h5>{{ __('Comment') }}</h5>
                            <span>{{ __('List of Comments') }}</span>
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
                                <a href="#">{{ __('Comments') }}</a>
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
                        <h3>{{ __('Comments') }}</h3>
                    </div>
                    <div class="card-body" style="overflow: scroll;">
                        <table id="reviewStudents" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>{{ __('Sr.No') }}</th>
                                    <th>{{ __('Post Slug') }}</th>
                                    <th>{{ __('User') }}</th>
                                    <th>{{ __('Description') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Action') }}</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @if(!empty($BlogReplies))
                                 @foreach($BlogReplies as $key => $BlogReply)
                                    <tr>
                                        <td>{{ $key + 1}}</td>
                                        <td>{{ optional(App\Models\Blog::find($BlogReply->post_id))->slug }}</td>
                                        <td>{{ optional(App\Models\User::find($BlogReply->user_id))->first_name.' '.optional(App\Models\User::find($BlogReply->user_id))->last_name }}</td>
                                        <td>{{ $BlogReply->reply }}</td>
                                        <td>{{ $BlogReply->status }}</td>
                                        <td>
                                            <div class="dropdown">
                                              <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                                Change Status
                                              </button>
                                              <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                <li><a class="dropdown-item" href="{{ url('change/reply/status/').'/'.$BlogReply->id.'/Active'}}">Active</a></li>
                                                <li><a class="dropdown-item" href="{{ url('change/reply/status/').'/'.$BlogReply->id.'/Inactive'}}">Inactive</a></li>
                                              </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css"/>
                        <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.11.5/datatables.min.js"></script>
                       
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




@endsection
