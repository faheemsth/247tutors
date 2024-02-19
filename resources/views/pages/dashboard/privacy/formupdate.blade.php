@extends('layouts.main')
@section('title', 'Privacy & Policy')

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
                        <h5>{{ __('Privacy & Policy') }}</h5>
                        <span>{{ __('List of Privacy & Policy') }}</span>
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
                            <a href="#">{{ __('Privacy & Policy') }}</a>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <!-- start message area-->
            @include('include.message')
            <!-- end message area-->
            <div class="col-md-12  user-table-data">
                <div class="card p-3">
                    <div class="card-header justify-content-between">
                        <h3>{{ __('Privacy & Policy') }}</h3>
                    </div>
                    <div class="card-body">
                        <div class="col-md-12 col-lg-12">
                            <form action="{{ url('admin/privacy_policy?id=' . (!empty($TermsAndCondition) ? $TermsAndCondition->id : '')) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-floating mb-3">
                                    <input type="text" name="type" class="form-control" required id="floatingInput" value="{{ !empty($TermsAndCondition) ? $TermsAndCondition->type :'' }}"
                                        placeholder="Enter Slug">
                                    <label for="floatingInput">Type</label>
                                </div>
                                <div class="form-group">
                                    <label for="name">Content</label>
                                    <div id="froala-editor-blog">
                                      {!! !empty($TermsAndCondition) ? $TermsAndCondition->content :'' !!}
                                    </div>
                                    <input type="hidden" name="content" id="editor-content-blog">
                                </div>
                                <button type="submit" class="btn btn-primary px-2 py-2" style="height: max-content;">
                                    Submit
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <link rel="stylesheet" href="{{ asset('assets/css/froala_editor.pkgd.min.css') }}">
    <script src="{{ asset('assets/js/froala_editor.pkgd.min.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            const froalaEditor = new FroalaEditor(`div#froala-editor-blog`, {
                language: 'ro'
            });
            $('form').submit(function(event) {
                const editorContent = froalaEditor.html.get();
                $(`#editor-content-blog`).val(editorContent);
            });
        });
    </script>

@endsection
