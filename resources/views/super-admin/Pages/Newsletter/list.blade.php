@extends('layouts.main')
@section('title', 'Users')

<link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.css" rel="stylesheet" />
<!-- MDB -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.js"></script>

@push('head')
    <link rel="stylesheet" href="{{ asset('plugins/DataTables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/webicons/css/all.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <script type="text/javascript" src="../js/languages/ro.js"></script>
@endpush
@section('content')
    <div class="page-header">
        <div class="container-fluid">
        <div class="row align-items-end">
            <div class="col-lg-8 col-md-6 col-12">
                <div class="page-header-title">
                    <i class="fa-solid fa-envelopes-bulk bg-blue"></i>
                    <div class="d-inline">
                        <h5>{{ __('Newsletter') }}</h5>
                        <span>{{ __('List of Newsletters') }}</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-12 mt-4 mt-md-0">
                <nav class="breadcrumb-container" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}"><i class="ik ik-home"></i></a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="#">{{ __('Settings') }}</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ url('Newsletter') }}">{{ __('Newsletter') }}</a>
                        </li>

                    </ol>
                </nav>
            </div>
        </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            @include('include.message')
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@12"></script>



    <div class="container">
        <div class="row">
            <!-- start message area-->
           
            <!-- end message area-->
            <div class="col-md-12  user-table-data col-12 pe-0 pe-md-2">
                <div class="card p-md-3 p-2">
                    <div class="card-header d-flex justify-content-between">
                        <h3 class="col-auto">{{ __('Newsletter') }}</h3>
                        <!--<form method="GET" action="" class="col-12 d-flex  align-items-center gap-2">-->
                            <button id="copy-all-emails" class="btn-sm btn-primary ">Copy All Emails</button>
                        <!--    <select class="form-control" name="date">-->
                        <!--        <option value="">All</option>-->
                        <!--        <option value="Today" {{ !empty($_GET['date']) && $_GET['date'] == 'Today' ? 'selected':'' }}>Today</option>-->
                        <!--        <option value="15 Days" {{ !empty($_GET['date']) && $_GET['date'] == '15 Days' ? 'selected':'' }}>15 Days</option>-->
                        <!--        <option value="30 Days" {{ !empty($_GET['date']) && $_GET['date'] == '30 Days' ? 'selected':'' }}>30 Days</option>-->
                        <!--    </select>-->
                        <!--    <input type="text" name="search" value="{{ $_GET['search'] ?? '' }}" class="form-control" placeholder="Search">-->
                        <!--    <button type="submit" class="btn btn-primary">Search</button>-->
                        <!--</form>-->
                    </div>
                    <div class="card-body" style="overflow:scroll;">
                        <table id="reviewStudents" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>{{ __('Sr.No') }}</th>
                                    <th>{{ __('Email') }}</th>
                                    <th>{{ __('Day') }}</th>
                                    <th>{{ __('Action') }}</th>

                                </tr>
                            </thead>
                            <tbody>
                                @forelse($blogs as $key => $blog)
                                    <tr>
                                        <td  style="border-bottom: .5px solid black;">{{ $key + 1 }}</td>
                                        <td style="border-bottom: .5px solid black;">
                                            <a href="#" class="copy-email" data-email="{{ $blog->email }}" title="Click to copy">{{ $blog->email }}</a>
                                        </td>
                                        <td style="border-bottom: .5px solid black;">{{ Carbon\Carbon::parse($blog->created_at)->format('F j, Y g:i A') }}</td>
                                         <td style="border-bottom: .5px solid black;"><a href="{{ url('delete/newsletter').'/'.$blog->id}}" class="btn btn-danger"> <i class="fa fa-trash"></i></a></td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4">Record not found</td>
                                    </tr>
                                @endforelse

                                <script>
                                    $(document).ready(function() {
                                        $(".copy-email").click(function() {
                                            var emailToCopy = $(this).data('email');
                                            copyToClipboard(emailToCopy);
                                        });
                                
                                        $("#copy-all-emails").click(function() {
                                            var allEmails = $(".copy-email").map(function() {
                                                return $(this).data('email');
                                            }).get().join(', ');
                                
                                            copyToClipboard(allEmails);
                                
                                            Swal.fire({
                                                title: 'Copied!',
                                                text: 'All emails copied to clipboard: ' + allEmails,
                                                icon: 'success',
                                                confirmButtonText: 'OK'
                                            });
                                        });
                                
                                        function copyToClipboard(text) {
                                            var tempInput = $("<input>");
                                            $("body").append(tempInput);
                                            tempInput.val(text).select();
                                
                                            try {
                                                document.execCommand("copy");
                                            } catch (err) {
                                                console.error('Unable to copy to clipboard:', err);
                                            }
                                
                                            tempInput.remove();
                                        }
                                    });
                                </script>


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

@endsection
