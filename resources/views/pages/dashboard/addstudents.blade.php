@extends('pages.dashboard.appstudent')
@section('content')
@if (Auth::check())
@if (Auth::user()->role_id == '4')
    @include('layouts.studentnav')
@elseif (Auth::user()->role_id == '3')
    @include('layouts.tutornav')
@elseif (Auth::user()->role_id == '5' || Auth::user()->role_id == '6')
    @include('layouts.parentnav')

@elseif (Auth::user()->role_id == '1' || Auth::user()->role_id == '2')
  @include('layouts.navbar')
@endif
@else
@include('layouts.navbar')
@endif

<style>
    #qualification tr th{
        padding-left: 10px
    }
    #qualification tr td{
        padding-left: 10px
    }
</style>
<script src="{{ asset('js/jsdelivrcore.js') }}"></script>
<script src="{{ asset('js/jsdelivr.js') }}"></script>
    <div class="container-fluid pb-5">
        <div class="container pb-5">
            <div class=" my-5 pt-md-5 pt-0">
                <div class="row mb-4">
                @if (session('failed'))
            <div class="alert alert-danger">
                {{ session('failed') }}
            </div>
        @endif
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <style>
            .yours{
                font-size:3rem;
            }
            @media only screen 
and (max-width : 1024px) {
.yours{
                font-size:3rem;
            }
}
 @media only screen 
and (max-width : 768px) {
.yours{
                font-size:2.8rem;
            }
}
@media only screen 
and (max-width : 425px) {
.yours{
                font-size:1.7rem;
            }
}
        </style>
                    <div class="col-12">
                        <a href="" class="btn qualification float-end me-2" data-bs-toggle="modal"
                        data-bs-target="#addSubjectofferModal">Add Student</a>
                    </div>
                    <div class="col-12 mb-4 mt-4 mt-md-0">
                        <h1 class="yours" style="font-weight:600;color: #4fb5ff">Your Students</h1>

                    </div>
                </div>
                <div class="row">
                    <div class="col-12 p-4 custom-table" style="border: 1px solid rgb(214, 214, 214);background-color: white;">
                        <h3>Active Student's</h3>

                    <table class="table table-bordered border-dark mt-4 custom-table">
                        <thead class="qualification" id="qualification">
                            <tr>
                                <th scope="">First Name</th>
                                <th scope="">Last Name</th>
                                <th scope="">Email</th>
                                <th scope="">Status</th>
                                <th scope="" style="width: 17%;">Remove from account</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!empty($students))
                                @foreach($students as $student)
                                    <tr>
                                        <td>{{$student->first_name}}</td>
                                        <td>{{$student->last_name}}</td>
                                        <td>{{$student->email}}</td>
                                        <td>
                                            @if($student->status == 'pending')
                                                <span class="badge bg-warning">{{$student->status}}</span>
                                            @elseif($student->status == 'active')
                                                <span class="badge bg-success">{{$student->status}}</span>
                                            @elseif($student->status == 'inactive')
                                                <span class="badge bg-danger">{{$student->status}}</span>
                                            @else
                                                <span class="badge bg-secondary">{{$student->status}}</span>
                                            @endif
                                        </td>
                                        <td class="">
                                            <a href="{{ url('delete-student?id=').$student->id}}" class="btn qualification"><i class="fa-solid fa-trash"></i> Remove</a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
            <div class="modal" id="addSubjectofferModal">
        <div class="modal-dialog">
            <div class="modal-content">
            <form action="{{ url('add_student') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                    <div class="modal-header">
                        <h4 class="modal-title">Create Students</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                        </button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="row mt-5">
                                <div class="col-md-6">

                                    <label for="exampleFormControlInput1" class="form-label">First Name</label>
                                    <input type="text" name="first_name" class="form-control" id=""
                                        required placeholder="Type First Name">

                                </div>
                                <div class="col-md-6 ">
                                    <label for="exampleFormControlInput1" class="form-label">Last Name</label>
                                    <input type="text" name="last_name" class="form-control" id=""
                                        required placeholder="Type Last Name">

                                </div>
                            </div>


                            <div class="row mt-5">
                                <div class="col-md-6 ">
                                    <label for="exampleFormControlInput1" class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control" id="email"
                                        required placeholder="Type Email Address">
                                        <span id="email-validation-message" style="color: red;"></span>
                                </div>

                                <div class="col-md-6 ">
                                    <label for="exampleFormControlInput1" class="form-label">Password</label>
                                    <input type="password" name="password" class="form-control" id=""
                                        required placeholder="Type Password">

                                </div>
                            </div>
                            

                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" id="next2">Create</button>
                    </div>
                </form>


            </div>
        </div>
    </div>
        </div>
    </div>
    <script src="{{ asset('vendor/jquery/jquery3.7.0.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#email').on('keyup', function() {
                var email = $(this).val();
                $.ajax({
                    type: 'POST',
                    url: 'email-check',
                    data: {
                        email: email
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.unique === false) {
                            $('#email-validation-message').text(
                                'This email is already registered.');
                            $('#next2').prop('disabled', true);
                        } else {
                            $('#email-validation-message').text('');
                            $('#next2').prop('disabled', false);
                        }
                    }
                });
            });
        });
    </script>
    @endsection
