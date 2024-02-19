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
           .profileeditdiv{
            opacity: 1;
            position: absolute;
            top:0px;
            left:50px;
        }
        @media only screen and (max-width: 1026px){
            .profileeditdiv{
                 position: absolute;
            top:0px;
            left:7px;
        }
        @media only screen and (max-width: 770px){
            .profileeditdiv{
                 position: absolute;
            top:0px;
            left:33px;
        }
        @media only screen and (max-width: 426px){
            .profileeditdiv{
                 position: absolute;
            top:0px;
            left:55px;
        }
        @media only screen and (max-width: 375px){
            .profileeditdiv{
                 position: absolute;
            top:0px;
            left:38px;
        }
        @media only screen and (max-width: 325px){
            .profileeditdiv{
                 position: absolute;
            top:0px;
            left:19px;
        }
        @media only screen and (min-width: 1440px){
            .profileeditdiv{
                 position: absolute;
            top:0px;
            left:79px;
        }
        }
        .profileeditdiv:hover{
            opacity: 0.8;
        }

</style>
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-4 col-8">
                <div class="card mt-n5">
                    <div class="card-body p-4">
                        <div class="text-center">
                            <div class="profile-user position-relative">
                                <div  class="profileeditdiv d-flex justify-content-center align-items-center" style="width: 100px;height: 100px;background-color: #cfcfcf;border-radius: 50%; ">
                                    <button type="button" data-bs-toggle="modal" data-bs-target="#staticBackdrop" class="btn px-3" style="background-color: #080808;
                                    color: white;">Edit</button>
                                </div>
                                <img src="{{ asset(Auth::user()->image) }}" class="user-profile-image" style="width: 100px;height: 100px;border-radius: 50%;" alt="user-profile-image">
                            </div>
                            <!-- Modal -->
            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="staticBackdropLabel">Upload Profile</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="form1" runat="server" action="{{ url('/update/profile') }}" method="post" enctype="multipart/form-data">
                        @csrf
                            <div class="modal-body">
                            <div class="row gap-4">

                                <div class="col-12 my-3" style="position: relative;">
                                    <div class="btn text-center btn-primary w-100 p-1">
                                        <h5>Upload Image</h5>
                                    </div>
                                    <div class="btn btn-primary w-100 p-1" style="position: absolute;top:0px;left:0px;opacity: 0;">
                                        <input  id="imgInp"  type="file" name="image"
                                        placeholder="Select Your picture"class="w-100" >
                                    </div>
                                </div>
                                <div class="col-12 text-center d-none">
                                    <img id="blah" alt="your image" src="#"  style="width: 80px;height: 80px;
                                    border-radius: 50%;">
                                </div>
                            </div>
                            </div>

                            <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Upload</button>
                            </div>
                     </form>
                  </div>
                </div>
            </div>




                            <h5 class="fs-17 mb-1">{{ $users->first_name }} {{ $users->last_name }}</h5>
                            <p class="text-muted mb-0">Admin</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-9 col-md-8 col-12">
                <div class="card mt-xxl-n5">
                    <div class="card-header">
                        <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" data-bs-toggle="tab" href="#personalDetails" role="tab" aria-selected="true">
                                    <i class="fas fa-home"></i>
                                    Personal Details
                                </a>
                            </li>
                            <li class="nav-item " role="presentation">
                                <a class="nav-link" data-bs-toggle="tab" href="#programs" role="tab" aria-selected="false" tabindex="-1">
                                    <i class="far fa-user"></i>
                                    Password
                                </a>
                            </li>
                            <li class="nav-item d-none" role="presentation">
                                <a class="nav-link" data-bs-toggle="tab" href="#documents" role="tab" aria-selected="false" tabindex="-1">
                                    <i class="far fa-envelope"></i>
                                    Documents
                                </a>
                            </li>

                        </ul>
                    </div>
                    <div class="card-body p-4">
                        <div class="tab-content">
                            <div class="tab-pane active" id="personalDetails" role="tabpanel">
                                <form action="{{ url('/update/profile/info') }}" method="post">
                                    @csrf                              <div class="row">
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="first_name" class="form-label">First
                                                    Name</label>
                                                <input type="text" class="form-control" id="first_name" value="{{  $users->first_name  }}" name="first_name" >
                                            </div>
                                        </div>
                                        <!--end col-->

                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="first_name" class="form-label">Last
                                                    Name</label>
                                                <input type="text" class="form-control" id="last_name" value="{{ $users->last_name }}" name="last_name" >
                                            </div>

                                        </div>
                                        <!--end col-->

                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="contact" class="form-label">Email
                                                    </label>
                                                <input type="email" class="form-control" name="email" id="email"  value="{{ $users->email }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="websiteInput1" class="form-label">Postcode</label>
                                                <input type="text" class="form-control" name="address" value="{{ $users->address }}">
                                               {{-- <textarea name="postel_address" class="form-control" id="postel_address" >Address</textarea> --}}
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="websiteInput1" class="form-label">Profile Description</label>
                                                <input type="text" class="form-control" name="profile_description" value="{{ $users->profile_description }}">
                                               {{-- <textarea name="postel_address" class="form-control" id="postel_address" >Address</textarea> --}}
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="websiteInput1" class="form-label">Date of Birth</label>
                                                <input type="date" class="form-control" max="9999-12-31" name="dob" value="{{ $users->dob }}">
                                               {{-- <textarea name="postel_address" class="form-control" id="postel_address" >Address</textarea> --}}
                                            </div>
                                        </div>

                                        <!--end col-->

                                        <div class="col-8">
                                            <label class="me-1">Gender :<span style="color:red"></span></label>
                                            <div class="mb-3 col-md-10 gap-4 d-flex">
                                               <div>
                                                <input class="form-check-input" type="radio" name="gender" value="Male" {{ $users->gender == 'Male' ? 'Checked' : '' }}>
                                                <label class="form-check-label" >Male</label>
                                               </div>
                                                <div>
                                                    <input class="form-check-input" type="radio" name="gender" value="Female" {{ $users->gender == 'Female' ? 'Checked' : '' }}>
                                                <label class="form-check-label">Female</label>
                                                </div>
                                               <div>
                                                <input class="form-check-input" type="radio" name="gender" value="Other" {{ $users->gender == 'Other' ? 'Checked' : '' }}>
                                                <label class="form-check-label">Others</label>
                                               </div>
                                            </div>
                                        </div>
                                        <!--end col-->

                                        <div class="col-lg-12">
                                            <div class="hstack gap-2 justify-content-end">
                                                <button type="submit" class="py-2 px-3 bg-primary border-0 rounded-3 text-white" >Updates</button>
                                                <button type="button" class="ms-2 py-2 px-3  border-0 rounded-3">Cancel</button>
                                            </div>
                                        </div>
                                        <!--end col-->
                                    </div>
                                    <!--end row-->
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                </form>
                            </div>

                            <div class="tab-pane" id="programs" role="tabpanel">
                                <form action="{{ url('/update/profile/password') }}" method="POST">
                                    @csrf
                                <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="websiteInput1" class="form-label">New Password</label>
                                        <input type="password" class="form-control" name="password"  placeholder="Enter New Password" autocomplete="current-password">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="websiteInput1" class="form-label">Confirm Password*</label>
                                        <input type="password" class="form-control" name="password_confirmation"  placeholder="Confirm Password" >
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="hstack gap-2 justify-content-end">
                                        <button type="submit" class="py-2 px-3 bg-primary border-0 rounded-3 text-white" >Updates</button>
                                        <button type="button" class="ms-2 py-2 px-3  border-0 rounded-3">Cancel</button>
                                    </div>
                                </div>
                            </form>
                            </div>

                            </div>
                            <!--end tab-pane-->
                            <div class="tab-pane" id="documents" role="tabpanel">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-4">
                                            <h5 class="card-title flex-grow-1 mb-0">Documents</h5>

                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="table-responsive">
                                                    <table class="table table-borderless align-middle mb-0">
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th scope="col">File Name</th>
                                                                <th scope="col">Files</th>
                                                                <th scope="col">Status</th>
                                                                <th scope="col">Description</th>
                                                                <th scope="col">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                                                                                                                                                <tr>
                                                                <td>
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="avatar-sm">
                                                                            <div class="avatar-title bg-primary-subtle text-primary rounded fs-20">
                                                                                <i class="ri-attachment-line"></i>

                                                                            </div>
                                                                        </div>
                                                                        <div class="ms-3 flex-grow-1">
                                                                            <h6 class="fs-15 mb-0"><a href="javascript:void(0)">Original Deposit Slip (as evidence for the fee deposited)</a>
                                                                            </h6>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                                                                                                                                                                                                                    </td>
                                                                <td>
                                                                                                                                    <a href="javascript:void(0);" class="badge bg-warning-subtle text-warning">Pending</a>
                                                                                                                                </td>
                                                                <td>---</td>
                                                                <td>
                                                                    <a style="cursor:pointer" onclick="updateDoc(1,`Original Deposit Slip (as evidence for the fee deposited)`)" class="link-success fs-20" tooltip="Add File"><i class="ri-edit-box-line"></i></a>
                                                                </td>
                                                            </tr>
                                                                                                                                                                                <tr>
                                                                <td>
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="avatar-sm">
                                                                            <div class="avatar-title bg-primary-subtle text-primary rounded fs-20">
                                                                                <i class="ri-attachment-line"></i>

                                                                            </div>
                                                                        </div>
                                                                        <div class="ms-3 flex-grow-1">
                                                                            <h6 class="fs-15 mb-0"><a href="javascript:void(0)">Affiliation as University, Board, Medical Faculty, Other (attached document):</a>
                                                                            </h6>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                                                                                                                                                                                                                    </td>
                                                                <td>
                                                                                                                                    <a href="javascript:void(0);" class="badge bg-warning-subtle text-warning">Pending</a>
                                                                                                                                </td>
                                                                <td>---</td>
                                                                <td>
                                                                    <a style="cursor:pointer" onclick="updateDoc(2,`Affiliation as University, Board, Medical Faculty, Other (attached document):`)" class="link-success fs-20" tooltip="Add File"><i class="ri-edit-box-line"></i></a>
                                                                </td>
                                                            </tr>
                                                                                                                                                                                <tr>
                                                                <td>
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="avatar-sm">
                                                                            <div class="avatar-title bg-primary-subtle text-primary rounded fs-20">
                                                                                <i class="ri-attachment-line"></i>

                                                                            </div>
                                                                        </div>
                                                                        <div class="ms-3 flex-grow-1">
                                                                            <h6 class="fs-15 mb-0"><a href="javascript:void(0)">Copy of institution/organization profile</a>
                                                                            </h6>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                                                                                                                                                                                                                    </td>
                                                                <td>
                                                                                                                                    <a href="javascript:void(0);" class="badge bg-warning-subtle text-warning">Pending</a>
                                                                                                                                </td>
                                                                <td>---</td>
                                                                <td>
                                                                    <a style="cursor:pointer" onclick="updateDoc(3,`Copy of institution/organization profile`)" class="link-success fs-20" tooltip="Add File"><i class="ri-edit-box-line"></i></a>
                                                                </td>
                                                            </tr>
                                                                                                                </tbody>
                                                    </table>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end tab-pane-->

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
