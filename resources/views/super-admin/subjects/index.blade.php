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
    <style>
        .select2-container {
            z-index: 100000;
        }

    </style>

    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8 col-md-6 col-7">
                    <div class="page-header-title">
                        <!--<i class="fa-solid fa-file-shield" style="color: rgb(50 50 50 / 94%);font-size: 15px;"></i>-->
                        <i class="fa-solid fa-book bg-blue" style="margin-right: 10px;"></i>
                        <div class="d-inline">
                            <h5>{{ __('Subjects') }}</h5>
                            <span>{{ __('List of Subjects') }}</span>
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
                                <a href="#">{{ __('Subjects') }}</a>
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
            <div class="col-md-12  user-table-data col-12 pe-0 pe-md-2 ">
                <div class="card p-md-3 p-2">
                    <div class="card-header justify-content-between">
                        <h3>{{ __('Subjects') }}</h3>
                        <div class="btn btn-primary px-1 py-1" data-bs-toggle="modal" data-bs-target="#addSubjectModal" style="height: max-content;">
                            <a class="text-light"  ><i
                                    class="fa-solid fa-plus m-auto px-1"></i></a>
                        </div>
                    </div>
                    <div class="card-body" style="overflow: scroll;">
                        <table id="reviewStudents" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>{{ __('Sr.No') }}</th>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    {{-- <th>{{ __('Levels') }}</th> --}}
                                    <th>{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (!empty($subjects))
                                    @foreach ($subjects as $key => $subject)
                                        <tr>
                                            <td style="border-bottom: .5px solid black;">{{ $key + 1 }}</td>
                                            <td style="border-bottom: .5px solid black;">{{ $subject->name }}</td>
                                            <td style="border-bottom: .5px solid black;">
                                                @if ($subject->status == 1)
                                                    <span class="badge bg-success">Active</span>
                                                @else
                                                    <span class="badge bg-danger">Inactive</span>
                                                @endif

                                            </td style="border-bottom: .5px solid black;">
                                            {{-- <td>
                                                @foreach (explode(',', $subject->levels) as $level)
                                                    @if ($levelModel = \App\Models\Level::find($level))
                                                        <span class="badge bg-secondary">{{ $levelModel->level }}</span>
                                                    @endif
                                                @endforeach
                                            </td> --}}
                                            <td style="border-bottom: .5px solid black;" class="d-flex justify-content-center  align-items-center gap-2 text-white">
                                                <a href="{{ url('subject/delete') . '/' . $subject->id }}"
                                                    class="btn btn-danger p-2 ">
                                                    <i class="fa-solid fa-trash" style="font-size: 14px;"></i></a>
                                                <a class="btn btn-primary p-2"
                                                    onclick="UpdateSubject('{{ $subject->id }}','{{ $subject->name }}','{{ $subject->levels }}')"><i
                                                        class="fa-solid fa-edit" style="font-size: 14px;"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else 
                                    <tr>
                                        <td colspan="4" class="text-center">Record not found</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" id="updateSubjectModal">
        <div class="modal-dialog">
            <div class="modal-content" id="subjectmodalget">
                <form method="post" id="updateidmodal" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title">Create Subject</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                        </button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="name" id="update_name" placeholder="Name">
                            <label for="update_name">Name</label>
                        </div>
                        {{-- <div class="form-floating mb-3">
                            <select class="form-select select2" id="update_level_id" name="level_id[]"
                                aria-label="Floating label select example" multiple>
                                @if ($levels)
                                    @foreach ($levels as $level)
                                        <option value="{{ $level->id }}">{{ $level->level }}</option>
                                    @endforeach
                                @endif
                            </select>
                            <label for="floatingSelectGrid">Levels</label>
                        </div> --}}
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success px-2 py-2" style="height: max-content;"
                            data-bs-dismiss="modal">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal" id="addSubjectModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ url('subject/store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title">Create Subject</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                        </button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="name" id="floatingInput" placeholder="Name">
                            <label for="floatingInput">Name</label>
                        </div>
                        {{-- <div class="form-floating mb-3">
                            <select class="form-select select2" id="floatingSelectGrid" name="level_id[]"
                                aria-label="Floating label select example" multiple>
                                @if ($levels)
                                    @foreach ($levels as $level)
                                        <option value="{{ $level->id }}">{{ $level->level }}</option>
                                    @endforeach
                                @endif
                            </select>
                            <label for="floatingSelectGrid">Levels</label>
                        </div> --}}
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success px-2 py-2" style="height: max-content;"
                            data-bs-dismiss="modal">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="{{ asset('vendor/jquery/jquery3.7.0.js') }}"></script>
    <script>
        function UpdateSubject(id, name, level) {
            var levels = level.split(',');
            const url = `{{ url('/subject/update') }}/${id}`;
            let selectOptions = @json($levels);
            $('#update_name').val(name);
            $('#update_level_id').val(levels).trigger("change");
            $('#updateidmodal').attr('action', url);
            $('#updateSubjectModal').modal('show');

        }
    </script>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                multiple: true
            });
        });
    </script>
    @push('script')
        <script src="{{ asset('plugins/select2/dist/js/select2.min.js') }}"></script>
        <script src="{{ asset('js/custom.js') }}"></script>
    @endpush
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css"/>
                        <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.11.5/datatables.min.js"></script>
                        <script>
                            $(document).ready(function(){
                                $('#reviewStudents').DataTable();
                            });
                        </script>




@endsection
