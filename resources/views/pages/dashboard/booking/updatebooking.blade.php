@extends('layouts.main')
@section('title', 'Users')
@section('content')
<!-- push external head elements to head -->
@push('head')
<link rel="stylesheet" href="{{ asset('plugins/DataTables/datatables.min.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/bootstrap/css/bootstrap.css') }}">
<link rel="stylesheet" href="{{ asset('assets/webicons/css/all.css') }}">
@endpush


<form action="{{ url('/booking/update').'/'.$subject->id }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="mb-3 col-md-6">
            <label class="form-label">Name</label>
            <input type="text" class="form-control" id="first-name" name="name" value="{{ $subject->name }}">
            @if($errors->has('name'))
            <span class="text-danger">{{ $errors->first('name') }}</span>
            @endif

        </div>


        <div class="mb-3 col-md-6">
            <label class="form-label">Name</label>
            <input type="text" class="form-control" id="first-name" name="name" value="{{ $subject->name }}">
            @if($errors->has('name'))
            <span class="text-danger">{{ $errors->first('name') }}</span>
            @endif

        </div>


    </div>
    <button type="submit">Submit</button>
</form>



@push('script')
<script src="{{ asset('plugins/select2/dist/js/select2.min.js') }}"></script>
<!--server side users table script-->
<!-- <script src="{{ asset('js/custom.js') }}"></script> -->
@endpush
@endsection
