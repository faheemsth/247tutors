@extends('layouts.main')
@section('title', 'Users')
@section('content')
<!-- push external head elements to head -->
@push('head')
<link rel="stylesheet" href="{{ asset('plugins/DataTables/datatables.min.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/bootstrap/css/bootstrap.css') }}">
<link rel="stylesheet" href="{{ asset('assets/webicons/css/all.css') }}">
@endpush


<form action="{{ url('/subject/store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="mb-3 col-md-6">
            <label class="form-label">Name</label>
            <input type="text" class="form-control" id="first-name" name="name">
            @if($errors->has('name'))
            <span class="text-danger">{{ $errors->first('name') }}</span>
            @endif

        </div>


        <div class="mb-3 col-md-6">
            <label class="form-label">Level</label>
            <select name="level_id" class="form-control" required>
                @if (!empty($levels))
                <option value="">Select Option</option>
                 @foreach ($levels as $level)
                 <option value="{{ $level->id }}">{{ $level->level }}</option>
                 @endforeach
                @endif
            </select>
            @if($errors->has('name'))
            <span class="text-danger">{{ $errors->first('level_id') }}</span>
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
