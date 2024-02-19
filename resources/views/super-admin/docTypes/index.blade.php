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
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <i class="ik ik-users bg-blue"></i>
                    <div class="d-inline">
                        <h5>Document Types</h5>
                        <span>Document Types for tutor verification</span>
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
                            <a href="#">{{ __('Settings') }}</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('documentTypes') }}">Document Types</a>
                        </li>

                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            @include('include.message')
        </div>
    </div>




            <div class="container">
                <div class="row">
                    <!-- start message area-->
                    <!-- end message area-->
                    <div class="col-md-12  user-table-data">
                        <div class="card p-3">
                            <div class="card-header justify-content-between">
                                <h3>{{ __('Document Types') }}</h3>

                                    <button  class="bg-primary px-3 py-2 text-white rounded-3" type="button" data-bs-toggle="modal" data-bs-target="#save_doc_type_modal">
                                        <i class="fa-solid fa-plus m-auto" ></i> Add Document Type</button>


                            </div>
                            <div class="card-body">
                                <table id="user_table" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Sr.No') }}</th>
                                            <th>{{ __('Title') }}</th>
                                            <th>{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($doc_types as $key => $doc_type)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $doc_type->title }}</td>
                                                <td>
                                                    <div class="d-flex gap-2">
                                                        <a onclick="updateDoc({{$doc_type->id }},`{{$doc_type->title}}`)"
                                                            class="btn btn-primary btn-sm" style="height: max-content;"><i
                                                                class="fa-regular fa-pen-to-square m-auto"></i></a>
                                                        {{-- <a href="{{ url('blog/delete?id=') . $doc_type->id }}"
                                                            class="btn btn-danger btn-sm" style="height: max-content;"><i
                                                                class="fa-solid fa-trash-can m-auto"></i></a> --}}
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
            <!-- Save Doc Type Modal -->
            <div class="modal fade zoomIn" id="save_doc_type_modal" tabindex="-1" aria-labelledby="save_doc_type_modal" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content border-0">
                        <div class="modal-header p-3 bg-info-subtle">
                            <h5 class="modal-title" id="save_doc_type_modal"> Add New Document Type</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                        </div>
                        <form class="tablelist-form" id="save_doc_type_form" method="post" autocomplete="off" action="{{ route('save_document_types') }}">
                            @csrf
                            <div class="modal-body">
                                <div class="row g-3">
                                    <div class="col-lg-12">
                                        <div>
                                            <label for="orderId" class="form-label">Document Title</label>
                                            <input type="text" id="doc_name" name="doc_name" class="form-control" placeholder="Title" required/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <div class="hstack gap-2 justify-content-end">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-success" id="add-btn">Add</button>
                                    {{-- <button type="button" class="btn btn-success" id="edit-btn">Update</button> --}}
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
             <!-- Update Doc Type Modal -->
             <div class="modal fade zoomIn" id="update_doc_type_modal" tabindex="-1" aria-labelledby="save_doc_type_modal" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content border-0">
                        <div class="modal-header p-3 bg-info-subtle">
                            <h5 class="modal-title" id="update_doc_type_modal"> Update Document Type</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                        </div>
                        <form class="tablelist-form" id="update_doc_type_form" method="post" autocomplete="off" action="{{ route('update_document_types') }}">
                            @csrf
                            <div class="modal-body">
                                <div class="row g-3">
                                    <div class="col-lg-12">
                                        <div>
                                            <label for="orderId" class="form-label">Document Title</label>
                                            <input type="text" id="up_doc_name" name="up_doc_name" class="form-control" placeholder="Title" required/>
                                        </div>
                                        <input type="text" id="doc_id" name="doc_id" class="form-control"  hidden/>

                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <div class="hstack gap-2 justify-content-end">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-success" id="add-btn">Add</button>
                                    {{-- <button type="button" class="btn btn-success" id="edit-btn">Update</button> --}}
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <script>
                function updateDoc(id,name){
                    $('#up_doc_name').val(name);
                    $('#doc_id').val(id);
                    $('#update_doc_type_modal').modal('show');
                }
            </script>
@endsection
