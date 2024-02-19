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
                            <h5>{{ __('Refund') }}</h5>
                            <span>{{ __('List of Refund') }}</span>
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
                                <a href="#">{{ __('Refund') }}</a>
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
                        <h3>{{ __('Refund') }}</h3>
                    </div>

                    <div class="card-body" style="overflow: scroll;">
                        <table id="reviewStudents" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>{{ __('Sr.No') }}</th>
                                    <th>{{ __('Booking Id') }}</th>
                                    <th>{{ __('Tutor Name') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Date') }}</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($Refound as $user)
                                    <tr>
                                        <td style="border-bottom: .5px solid black;">{{ $loop->index + 1 }}</td>
                                        
                                        <td style="border-bottom: .5px solid black;">
                                            <a onclick="freeMeetmodal('{{ $user->bookingId }}','{{ $user->status }}')" style="cursor: pointer;font-size:20px">
                                              {{ $user->bookingId }}
                                            </a>
                                        </td>
                                        
                                        <td style="border-bottom: .5px solid black;">{{ optional(App\Models\User::find($user->tutorId))->username }}</td>
                                        
                                        <td style="border-bottom: .5px solid black;">{{ $user->status }}</td>
                                        
                                        <td style="border-bottom: .5px solid black;">{{ $user->created_at }}</td>
                                        
                                    </tr>
                                @empty
                                    <tr>
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
    
    
    
        <div class="modal fade zoomIn" id="demo_meeting_modal" tabindex="-1" aria-labelledby="update_doc_modal"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0">
                <div class="modal-header p-3 bg-info-subtle">
                    <h5 class="modal-title" id="update_doc_modal_title">Refund Detail's</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        id="close-modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row mt-4">
                        <div class="col-12">
                            <table>
                                <tbody id="AppendData">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                   <form action="{{ url('refund/Update') }}" method="POST" class="hstack gap-2 justify-content-end d-flex">
                        @csrf
                                  <input type="hidden" id="Tutorid" name="Tutorid">
                                    <select class="form-select " name="status" id="updated_user_status">
                                        <option value="Pending" selected>Pending</option>
                                        <option value="Processing">Processing</option>
                                        <option value="Paid">Paid</option>
                                    </select>

                                   <button type="submit" class="btn btn-success" id="add-btn">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    

    @push('script')
        <script src="{{ asset('plugins/select2/dist/js/select2.min.js') }}"></script>
        <script src="{{ asset('js/custom.js') }}"></script>
        <script>
            function freeMeetmodal(id,status) {
                $('#Tutorid').val(id)
                $('#updated_user_status').val(status);
                $.ajax({
                    url: "/get/refund",
                    method: "GET",
                    data: {
                        id: id
                    },
                    success: function(html) {
                        $("#AppendData").html(html);
                       $('#demo_meeting_modal').modal('show');

                    },

                });
            }
        </script>
    @endpush
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


@endsection
