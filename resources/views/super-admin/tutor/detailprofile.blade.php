@extends('layouts.main')
@section('title', 'Users')
@section('content')
<!-- push external head elements to head -->
@push('head')
        <link rel="stylesheet" href="{{ asset('plugins/DataTables/datatables.min.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/bootstrap/css/bootstrap.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/webicons/css/all.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
            <link href="{{ URL::asset('assets/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />

    @endpush
    <style>
    .select2-container {
        width: 100% !important;
    }
    .bachset {
    background-color: white !important
    border: 1px solid rgb(59 59 59 / 61%) !important;
    }
    .minlitem{
        min-width:170px;
    }
    table tr th{
        min-width:150px;
        
    }
</style>

<div class="container">
    <div class="row">
        @if (session('success'))
        <div class="alert alert-success mt-4">
            {{ session('success') }}
        </div>
        @endif

        @if (session('failed'))
        <div class="alert alert-danger mt-4">
            {{ session('failed') }}
        </div>
        @endif
        <div class="col-lg-3 col-md-4 col-8">
            <div class="card mt-n5">
                <div class="card-body p-lg-2 p-xl-4 px-4">
                    <div class="text-center">
                        <div class="profile-user">

                            @if (!empty($tutor->image) && file_exists(public_path(!empty($tutor) ? $tutor->image : '')))
                            <img src="{{ asset($tutor->image) }}"
                                 style="width: 150px;
    border-radius: 50%;
    height: 150px;"
                                alt="user-profile-image">
                            @else

                            @if($tutor->gender == 'Male')
                            <img src="{{ asset('assets/images/male.jpg') }}"
                                
                                alt="user-profile-image"  style="width: 150px;
    border-radius: 50%;
    height: 150px;">
                            @elseif($tutor->gender == 'Female')
                            <img src="{{ asset('assets/images/female.jpg') }}"
                                
                                alt="user-profile-image"  style="width: 150px;
    border-radius: 50%;
    height: 150px;">
                            @else
                            <img src="{{ asset('assets/images/default.png') }}"
                                
                                alt="user-profile-image"  style="width: 150px;
    border-radius: 50%;
    height: 150px;">
                            @endif
                            @endif


                            <div class="avatar-xs p-0 mt-2 rounded-circle profile-photo-edit">
                            </div>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        </div>
                        <h5 class="fs-17 mb-1">{{ $tutor->first_name }} {{ $tutor->last_name }}</h5>
                        <p class="text-muted mb-0">Tutor</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-9 col-md-8 col-12">
            <div class="card mt-xxl-n5">
                <div class="card-header">
                    <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0 " style=" overflow: scroll;
    flex-wrap: nowrap;" role="tablist">
                        <li class="nav-item minlitem" role="presentation" >
                            <a class="nav-link active" data-bs-toggle="tab" href="#personalDetails" role="tab"
                                aria-selected="true">
                                <i class="fas fa-home"></i>
                                Personal Details
                            </a>
                        </li>
                        <li class="nav-item minlitem" role="presentation">
                            <a class="nav-link" data-bs-toggle="tab" href="#programs" role="tab" aria-selected="false"
                                tabindex="-1">
                                <i class="far fa-user"></i>
                                Qualification
                            </a>
                        </li>
                        <li class="nav-item minlitem" role="presentation">
                            <a class="nav-link" data-bs-toggle="tab" href="#documents" role="tab" aria-selected="false"
                                tabindex="-1">
                            <i class="fa-regular fa-folder-open"></i>
                                Documents
                            </a>
                        </li>
                        <li class="nav-item minlitem" role="presentation">
                            <a class="nav-link" data-bs-toggle="tab" href="#availability" role="tab"
                                aria-selected="false" tabindex="-1">
                                <i class="fa-solid fa-chalkboard-user"></i>
                                Availability
                            </a>
                        </li>

                       @if(!empty($complaintUser) && $complaintUser->count() > 0)
                            <li class="nav-item minlitem" role="presentation">
                                <a class="nav-link" data-bs-toggle="tab" href="#warning" role="tab"
                                    aria-selected="false" tabindex="-1">
                                    <i class="fa-solid fa-triangle-exclamation"></i>
                                    Complaint
                                </a>
                            </li>
                      @endif

                    </ul>
                </div>
                <div class="card-body p-md-4 px-2">
                    <div class="tab-content">
                        <div class="tab-pane active" id="personalDetails" role="tabpanel">
                            <form action="{{ url('tutor/update/') . '/' . $tutor->id }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="first_name" class="form-label">First
                                                Name</label>
                                            <input type="text" name="first_name" class="form-control bachset "
                                                value="{{ $tutor->first_name }}" d="first_name"
                                                placeholder="Enter your FullName" value="{{ $tutor->email }}"
                                                name="first_name" >
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="first_name" class="form-label">Last
                                                Name</label>
                                            <input type="text" name="last_name" class="form-control bachset"
                                                value="{{ $tutor->last_name }}" d="first_name"
                                                placeholder="Enter your FullName" value="{{ $tutor->email }}"
                                                name="first_name" >
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="ceo_name" class="form-label">Email</label>
                                            <input type="text" class="form-control bachset" value="{{ $tutor->email }}"
                                                name="email" id="email"
                                                placeholder="Enter your Name of the Head of Institution/CEO/Owner"
                                                value="Mr ABC">
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="contact" class="form-label">Contact
                                                Number</label>
                                            <input type="text" class="form-control bachset" value="{{ $tutor->phone }}"
                                                name="phone" id="phone" placeholder="Enter your phone number"
                                                value="12345678">
                                        </div>
                                    </div>
                                    <!--end col-->

                                    <!--end col-->

                                    <!--end col-->
                                    <!--end col-->

                                    <!--end col-->

                                    <!--end col-->



                                    <div class="col-8">
                                        <label class="me-1">Gender :<span style="color:red">*</span></label>
                                        <div class="mb-3 col-md-10 gap-4 d-flex">
                                            <div>
                                                <input class="form-check-input bachset" type="radio" value="Male" {{
                                                    $tutor->gender === 'Male' ? 'checked' : '' }} name="gender"
                                                value="male">
                                                <label class="form-check-label">Male</label>
                                            </div>
                                            <div>
                                                <input class="form-check-input bachset" type="radio" value="Female" {{
                                                    $tutor->gender === 'Female' ? 'checked' : '' }} name="gender"
                                                value="female">
                                                <label class="form-check-label">Female</label>
                                            </div>
                                            <div>
                                                <input class="form-check-input bachset" type="radio" value="Others" {{
                                                    $tutor->gender === 'Others' ? 'checked' : '' }} name="gender"
                                                value="other">
                                                <label class="form-check-label">Others</label>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label for="zipcodeInput bachset" class="form-label">Biography
                                            </label>
                                            {{-- <input type="text" class="form-control" id="profile_description"
                                                value="" name="profile_description" placeholder="Enter Province*"
                                                value="Frderal"> --}}
                                            <textarea name="profile_description" class="form-control"
                                                id="profile_description" cols="60"
                                                rows="3">{{ $tutor->profile_description }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="mb-3 pb-2">
                                            <label for="description" class="form-label">Address</label>
                                            <textarea class="form-control" value="" name="address" id="address"
                                                placeholder="Enter your description"
                                                rows="3">{{ $tutor->address }}</textarea>
                                        </div>
                                    </div>


                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="countryInput" class="form-label">Postcode
                                            </label>
                                            <input type="text" class="form-control bachset" value="{{ $tutor->zipcode }}"
                                                name="zipcode" id="zipcode" placeholder="District" value="ICT">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="countryInput" class="form-label">Subjects</label>
                                            <select class="wform-control select2 bachset"  id="subject" name="subjects[]"
                                                multiple>
                                                @foreach ($Subjects as $subject)
                                                @php
                                                $selected = in_array($subject->id, explode(',', $tutor->subjects)) ?
                                                'selected' : '';
                                                @endphp
                                                <option value="{{ $subject->id }}" {{ $selected }}>
                                                    {{ $subject->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="countryInput bachset" class="form-label">Status</label>
                                            <select class="form-select w-75" name="status" id="updated_user_status">
                                                <option value="Pending" {{ $tutor->status=='Pending'?'selected':'' }}>Pending</option>
                                                <option value="Active" {{ $tutor->status=='Active'?'selected':'' }}>Active</option>
                                                <option value="InActive" {{ $tutor->status=='InActive'?'selected':'' }}>Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-lg-12">
                                        <div class="hstack gap-2 justify-content-end">
                                            <button type="submit"
                                                class="py-2 px-3 bg-primary border-0 rounded-3 text-white">Update</button>
                                            <button type="button"
                                                class="ms-2 py-2 px-3  border-0 rounded-3">Cancel</button>
                                        </div>
                                    </div>
                                    <!--end col-->
                                </div>
                                <!--end row-->
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            </form>
                        </div>

                        <div class="tab-pane" id="programs" role="tabpanel">

                            <div class="card">
                                <div class="card-body">

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="table-responsive">
                                                <table class="table table-borderless align-middle mb-0">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th scope="col">Degree Title</th>
                                                            <th scope="col">Institute</th>
                                                            <th scope="col">Grade</th>
                                                            <th scope="col">Type</th>
                                                            <th scope="col">Completed Date</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @isset($tutor_qualifications)
                                                        @foreach ($tutor_qualifications as $item)
                                                        <tr>
                                                            <td>{{ $item->degree_title != null ? $item->degree_title :
                                                                '--' }}
                                                            </td>
                                                            <td>{{ $item->institute != null ? $item->institute : '--' }}
                                                            </td>
                                                            @php
                                                            $grade = '--';
                                                            if ($item->grade) {
                                                            if ($item->grade == 1) {
                                                            $grade = 'A+';
                                                            } elseif ($item->grade == 2) {
                                                            $grade = 'B+';
                                                            } else {
                                                            $grade = 'C+';
                                                            }
                                                            }
                                                            @endphp
                                                            <td>{{ $grade }}</td>
                                                            <td>{{ $item->type != null ? $item->type : '--' }}</td>
                                                            <td>{{ $item->degree_completed != null ?
                                                                $item->degree_completed : '--' }}
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                        @endisset
                                                    </tbody>
                                                </table>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end card-body-->

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
                                                            <th scope="col">Expiry Date</th>
                                                            <th scope="col">Status</th>
                                                            <th scope="col">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @isset($tutor_application)
                                                        @isset($tutor_application->user_id)
                                                        <tr>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <div class="avatar-sm">
                                                                        <div
                                                                            class="avatar-title bg-primary-subtle text-primary rounded fs-20">
                                                                            <i class="ri-attachment-line"></i>

                                                                        </div>
                                                                    </div>
                                                                    <div class="ms-3 flex-grow-1">
                                                                        <h6 class="fs-15 mb-0"><a
                                                                                href="javascript:void(0)">Tutor Id</a>
                                                                        </h6>
                                                                    </div>
                                                                </div>

                                                            </td>
                                                            <td >
                                                                @php $extension =
                                                                strtolower(pathinfo(storage_path($tutor_application->user_id),
                                                                PATHINFO_EXTENSION)); @endphp
                                                                @if (in_array($extension, ['png', 'jpg', 'jpeg', 'gif',
                                                                'bmp', 'svg', 'webp', 'ico', 'raw']))
                                                                @if (!empty($tutor_application->user_id) &&
                                                                file_exists(public_path(!empty($tutor_application->user_id)
                                                                ? $tutor_application->user_id : '')))
                                                                <button type="button" class="btn btn-default"
                                                                    onclick="getimage('{{ asset($tutor_application->user_id) }}')">
                                                                    <img src="{{ asset($tutor_application->user_id) }}"
                                                                        width="50" height="50" />
                                                                </button>
                                                                @endif
                                                                @elseif (in_array($extension, ['pdf']))
                                                                <button type="button" class="btn btn-default "
                                                                onclick="getpdf('{{ asset($tutor_application->user_id) }}')">
                                                                    @if ($extension == 'pdf')
                                                                    <img src="{{ asset('assets\document_images\pdf.png') }}"
                                                                        width="50" height="50" />
                                                                    @endif
                                                                </button>
                                                                @elseif (in_array($extension, ['docx']))
                                                                <button type="button" class="btn btn-default "
                                                                onclick="getdocx('{{ asset($tutor_application->user_id) }}')">
                                                                    <img src="{{ asset('assets\document_images\word.jpg') }}"
                                                                        width="50" height="50" />
                                                                </button>
                                                                @endif
                                                            </td>

                                                            <td>{{ $tutor_application->user_id_expiry }}</td>
                                                            <td>
                                                                @if ($tutor_application->user_id_status == 'pending')
                                                                <a href="javascript:void(0);"
                                                                    class="badge bg-warning-subtle text-warning"
                                                                    id="user_id">Pending</a>
                                                                @elseif($tutor_application->user_id_status ==
                                                                'accepted')
                                                                <a href="javascript:void(0);"
                                                                    class="badge bg-success-subtle text-success"
                                                                    id="user_id">Accepted</a>
                                                                @else
                                                                <a href="javascript:void(0);"
                                                                    class="badge bg-danger-subtle text-danger"
                                                                    id="user_id">Rejected</a>
                                                                @endif
                                                                <span class="user_id"></span>
                                                            </td>
                                                            <td>
                                                                <a style="cursor:pointer"
                                                                    onclick="updateDoc({{ $tutor_application->id }},'user_id')"
                                                                    class="link-success fs-20" tooltip="Add File"><i
                                                                        class="ri-edit-box-line" style="font-size:22px;"></i></a>
                                                            </td>

                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <div class="avatar-sm">
                                                                        <div
                                                                            class="avatar-title bg-primary-subtle text-primary rounded fs-20">
                                                                            <i class="ri-attachment-line"></i>

                                                                        </div>
                                                                    </div>
                                                                    <div class="ms-3 flex-grow-1">
                                                                        <h6 class="fs-15 mb-0"><a
                                                                                href="javascript:void(0)">Tutor
                                                                                Selfie</a>
                                                                        </h6>
                                                                    </div>
                                                                </div>

                                                            </td>
                                                            <td>
                                                                @php $extension =
                                                                strtolower(pathinfo(storage_path($tutor_application->selfie),
                                                                PATHINFO_EXTENSION)); @endphp
                                                                @if (in_array($extension, ['png', 'jpg', 'jpeg', 'gif',
                                                                'bmp', 'svg', 'webp', 'ico', 'raw']))
                                                                @if (!empty($tutor_application->selfie) &&
                                                                file_exists(public_path(!empty($tutor_application->selfie)
                                                                ? $tutor_application->selfie : '')))
                                                                <button type="button" class="btn btn-default"
                                                                onclick="getimage('{{ asset($tutor_application->selfie) }}')">
                                                                    <img src="{{ asset($tutor_application->selfie) }}"
                                                                        width="50" height="50" />
                                                                </button>
                                                                @endif
                                                                @elseif (in_array($extension, ['pdf']))
                                                                <button type="button" class="btn btn-default"
                                                                onclick="getpdf('{{ asset($tutor_application->selfie) }}')">
                                                                    @if ($extension == 'pdf')
                                                                    <img src="{{ asset('assets\document_images\pdf.png') }}"
                                                                        width="50" height="50" />
                                                                    @endif
                                                                </button>
                                                                @elseif (in_array($extension, ['docx']))
                                                                <button type="button" class="btn btn-default"
                                                                onclick="getdocx('{{ asset($tutor_application->selfie) }}')">
                                                                    <img src="{{ asset('assets\document_images\word.jpg') }}"
                                                                        width="50" height="50" />
                                                                </button>
                                                                @endif
                                                            </td>
                                                            <td>--</td>
                                                            <td>
                                                                @if ($tutor_application->selfie_status == 'pending')
                                                                <a href="javascript:void(0);"
                                                                    class="badge bg-warning-subtle text-warning"
                                                                    id="selfie">Pending</a>
                                                                @elseif($tutor_application->selfie_status == 'accepted')
                                                                <a href="javascript:void(0);"
                                                                    class="badge bg-success-subtle text-success"
                                                                    id="selfie">Accepted</a>
                                                                @else
                                                                <a href="javascript:void(0);"
                                                                    class="badge bg-danger-subtle text-danger"
                                                                    id="selfie">Rejected</a>
                                                                @endif
                                                                <span class="selfie"></span>
                                                            </td>
                                                            <td>
                                                                <a style="cursor:pointer"
                                                                    onclick="updateDoc({{ $tutor_application->id }},'selfie')"
                                                                    class="link-success fs-20" tooltip="Add File"><i
                                                                        class="ri-edit-box-line" style="font-size:22px;"></i></a>
                                                            </td>

                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <div class="avatar-sm">
                                                                        <div
                                                                            class="avatar-title bg-primary-subtle text-primary rounded fs-20">
                                                                            <i class="ri-attachment-line"></i>

                                                                        </div>
                                                                    </div>
                                                                    <div class="ms-3 flex-grow-1">
                                                                        <h6 class="fs-15 mb-0"><a
                                                                                href="javascript:void(0)">Address
                                                                                Proof</a>
                                                                        </h6>
                                                                    </div>
                                                                </div>

                                                            </td>
                                                            <td>
                                                                @php $extension =
                                                                strtolower(pathinfo(storage_path($tutor_application->address_proof),
                                                                PATHINFO_EXTENSION)); @endphp
                                                                @if (in_array($extension, ['png', 'jpg', 'jpeg', 'gif',
                                                                'bmp', 'svg', 'webp', 'ico', 'raw']))
                                                                @if (!empty($tutor_application->address_proof) &&
                                                                file_exists(public_path(!empty($tutor_application->address_proof)
                                                                ? $tutor_application->address_proof : '')))
                                                                <button type="button" class="btn btn-default "
                                                                onclick="getimage('{{ asset($tutor_application->address_proof) }}')">
                                                                    <img src="{{ asset($tutor_application->address_proof) }}"
                                                                        width="50" height="50" />
                                                                </button>
                                                                @endif
                                                                @elseif (in_array($extension, ['pdf']))
                                                                <button type="button" class="btn btn-default"
                                                                onclick="getpdf('{{ asset($tutor_application->address_proof) }}')">
                                                                    @if ($extension == 'pdf')
                                                                    <img src="{{ asset('assets\document_images\pdf.png') }}"
                                                                        width="50" height="50" />
                                                                    @endif
                                                                </button>
                                                                @elseif (in_array($extension, ['docx']))
                                                                <button type="button" class="btn btn-default"
                                                                onclick="getdocx('{{ asset($tutor_application->address_proof) }}')">
                                                                    <img src="{{ asset('assets\document_images\word.jpg') }}"
                                                                        width="50" height="50" />
                                                                </button>
                                                                @endif
                                                            </td>
                                                            <td>{{ $tutor_application->address_proof_expiry }}</td>
                                                            <td>
                                                                @if ($tutor_application->address_proof_status ==
                                                                'pending')
                                                                <a href="javascript:void(0);"
                                                                    class="badge bg-warning-subtle text-warning"
                                                                    id="addressproof">Pending</a>
                                                                @elseif($tutor_application->address_proof_status ==
                                                                'accepted')
                                                                <a href="javascript:void(0);"
                                                                    class="badge bg-success-subtle text-success"
                                                                    id="addressproof">Accepted</a>
                                                                @else
                                                                <a href="javascript:void(0);"
                                                                    class="badge bg-danger-subtle text-danger"
                                                                    id="addressproof">Rejected</a>
                                                                @endif
                                                                <span class="addressproof"></span>
                                                            </td>
                                                            <td>
                                                                <a style="cursor:pointer"
                                                                    onclick="updateDoc({{ $tutor_application->id }},'addressproof')"
                                                                    class="link-success fs-20" tooltip="Add File"><i
                                                                        class="ri-edit-box-line" style="font-size:22px;"></i></a>
                                                            </td>

                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <div class="avatar-sm">
                                                                        <div
                                                                            class="avatar-title bg-primary-subtle text-primary rounded fs-20">
                                                                            <i class="ri-attachment-line"></i>

                                                                        </div>
                                                                    </div>
                                                                    <div class="ms-3 flex-grow-1">
                                                                        <h6 class="fs-15 mb-0"><a
                                                                                href="javascript:void(0)">Enhaced
                                                                                DBS</a>
                                                                        </h6>
                                                                    </div>
                                                                </div>

                                                            </td>
                                                            <td>
                                                                @php $extension =
                                                                strtolower(pathinfo(storage_path($tutor_application->enhaced_dbs),
                                                                PATHINFO_EXTENSION)); @endphp
                                                                @if (in_array($extension, ['png', 'jpg', 'jpeg', 'gif',
                                                                'bmp', 'svg', 'webp', 'ico', 'raw']))
                                                                @if (!empty($tutor_application->enhaced_dbs) &&
                                                                file_exists(public_path(!empty($tutor_application->enhaced_dbs)
                                                                ? $tutor_application->enhaced_dbs : '')))
                                                                <button type="button" class="btn btn-default"
                                                                onclick="getimage('{{ asset($tutor_application->enhaced_dbs) }}')">
                                                                    <img src="{{ asset($tutor_application->enhaced_dbs) }}"
                                                                        width="50" height="50" />
                                                                </button>
                                                                @endif
                                                                @elseif (in_array($extension, ['pdf']))
                                                                <button type="button" class="btn btn-default"
                                                                    onclick="getpdf(`{{ asset($tutor_application->enhaced_dbs) }}`)">
                                                                    @if ($extension == 'pdf')
                                                                    <img src="{{ asset('assets\document_images\pdf.png') }}"
                                                                        width="50" height="50" />
                                                                    @endif
                                                                </button>
                                                                @elseif (in_array($extension, ['docx']))
                                                                <button type="button" class="btn btn-default"
                                                                onclick="getdocx('{{ asset($tutor_application->enhaced_dbs) }}')">
                                                                    <img src="{{ asset('assets\document_images\word.jpg') }}"
                                                                        width="50" height="50" />
                                                                </button>
                                                                @endif
                                                            </td>
                                                            <td>{{ $tutor_application->enhaced_dbs_expiry }}</td>
                                                            <td>
                                                                @if ($tutor_application->enhaced_dbs_status ==
                                                                'pending')
                                                                <a href="javascript:void(0);"
                                                                    class="badge bg-warning-subtle text-warning"
                                                                    id="enhaced_dbs">Pending</a>
                                                                @elseif($tutor_application->enhaced_dbs_status ==
                                                                'accepted')
                                                                <a href="javascript:void(0);"
                                                                    class="badge bg-success-subtle text-success"
                                                                    id="enhaced_dbs">Accepted</a>
                                                                @else
                                                                <a href="javascript:void(0);"
                                                                    class="badge bg-danger-subtle text-danger"
                                                                    id="enhaced_dbs">Rejected</a>
                                                                @endif
                                                                <span class="enhaced_dbs"></span>
                                                            </td>
                                                            <td>
                                                                <a style="cursor:pointer"
                                                                    onclick="updateDoc({{ $tutor_application->id }},'enhaced_dbs')"
                                                                    class="link-success fs-20" tooltip="Add File"><i
                                                                        class="ri-edit-box-line" style="font-size:22px;"></i></a>
                                                            </td>

                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <div class="avatar-sm">
                                                                        <div
                                                                            class="avatar-title bg-primary-subtle text-primary rounded fs-20">
                                                                            <i class="ri-attachment-line"></i>

                                                                        </div>
                                                                    </div>
                                                                    <div class="ms-3 flex-grow-1">
                                                                        <h6 class="fs-15 mb-0"><a
                                                                                href="javascript:void(0)">CV</a>
                                                                        </h6>
                                                                    </div>
                                                                </div>

                                                            </td>
                                                            <td>
                                                                @php $extension =
                                                                strtolower(pathinfo(storage_path($tutor_application->cv),
                                                                PATHINFO_EXTENSION)); @endphp
                                                                @if (in_array($extension, ['png', 'jpg', 'jpeg', 'gif',
                                                                'bmp', 'svg', 'webp', 'ico', 'raw']))
                                                                @if (!empty($tutor_application->cv) &&
                                                                file_exists(public_path(!empty($tutor_application->cv) ?
                                                                $tutor_application->cv : '')))
                                                                <button type="button" class="btn btn-default"
                                                                onclick="getimage('{{ asset($tutor_application->cv) }}')">
                                                                    <img src="{{ asset($tutor_application->cv) }}"
                                                                        width="50" height="50" />
                                                                </button>
                                                                @endif
                                                                @elseif (in_array($extension, ['pdf']))
                                                                <button type="button" class="btn btn-default"
                                                                onclick="getpdf('{{ asset($tutor_application->cv) }}')">
                                                                    @if ($extension == 'pdf')
                                                                    <img src="{{ asset('assets\document_images\pdf.png') }}"
                                                                        width="50" height="50" />
                                                                    @endif
                                                                </button>
                                                                @elseif (in_array($extension, ['docx']))
                                                                <button type="button" class="btn btn-default"
                                                                onclick="getdocx('{{ asset($tutor_application->cv) }}')">
                                                                    <img src="{{ asset('assets\document_images\word.jpg') }}"
                                                                        width="50" height="50" />
                                                                </button>
                                                                @endif
                                                            </td>
                                                            <td>--</td>
                                                            <td>
                                                                @if ($tutor_application->cv_status == 'Pending')
                                                                <a href="javascript:void(0);"
                                                                    class="badge bg-warning-subtle text-warning"
                                                                    id="cv">Pending</a>
                                                                @elseif($tutor_application->cv_status == 'accepted')
                                                                <a href="javascript:void(0);"
                                                                    class="badge bg-success-subtle text-success"
                                                                    id="cv">Accepted</a>
                                                                @else
                                                                <a href="javascript:void(0);"
                                                                    class="badge bg-danger-subtle text-danger"
                                                                    id="cv">Rejected</a>
                                                                @endif
                                                                <span class="cv"></span>
                                                            </td>
                                                            <td>
                                                                <a style="cursor:pointer"
                                                                    onclick="updateDoc({{ $tutor_application->id }},'cv')"
                                                                    class="link-success fs-20" tooltip="Add File"><i
                                                                        class="ri-edit-box-line" style="font-size:22px;"></i></a>
                                                            </td>
                                                        </tr>
                                                        @endisset
                                                        @endisset
                                                    </tbody>
                                                </table>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="availability" role="tabpanel">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-4">
                                        <h5 class="card-title flex-grow-1 mb-0">Availability</h5>

                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr class="thh">

                                                            <th class="col " style="width:30%;" scope="col" ></th>
                                                            <th scope="col">Mon</th>
                                                            <th scope="col">Tue</th>
                                                            <th scope="col">Wed</th>
                                                            <th scope="col">Thu</th>
                                                            <th scope="col">Fri</th>
                                                            <th scope="col">Sat</th>
                                                            <th scope="col">Sun</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if ($availabilitys)
                                                        @foreach ($availabilitys as $availability)
                                                        @php $days = explode(',', $availability->day_of_the_week);
                                                        @endphp
                                                        <tr>
                                                            <td class="tdd d-flex gap-2 align-items-center">
                                                                @if ($availability->schedule_time == 'Morning')
                                                                <img src="/assets/images/11111.png"
                                                                    alt="Morning"><h6 class="w-50 mb-0">Morning</h6>
                                                                @elseif ($availability->schedule_time == 'Afternoon')
                                                                <img src="/assets/images/sunny 1.png"
                                                                    alt="Afternoon"><h6 class="w-md-50 mb-0">Afternoon</h6>
                                                                @elseif ($availability->schedule_time == 'Evening')
                                                                <img src="/assets/images/sunrise 1.png"
                                                                    alt="Evening"><h6 class="w-50 mb-0">Evening</h6>
                                                                @endif
                                                            </td>

                                                            @for ($i = 1; $i <= 7; $i++) <td class="text-center">
                                                                @if (in_array($i, $days))
                                                                <img src="{{ asset('assets/images/Vector (3).png') }}"
                                                                    alt="" data-days="{{ $i }}" width="25" height="25">
                                                                @endif
                                                                </td>
                                                                @endfor
                                                        </tr>
                                                        @endforeach
                                                        @endif
                                                    </tbody>
                                                </table>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end tab-pane-->









                        <div class="tab-pane" id="warning" role="tabpanel">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-4">
                                        <h5 class="card-title flex-grow-1 mb-0">Complaint</h5>

                                    </div>
                                    <div class="row">
                                        <form action="{{ url('complaint/stages/submit') }}" method="POST" class="col-lg-12">
                                            @csrf
                                            <input type="hidden" value="{{$tutor->id}}" name="id">
                                            <div class="table-responsive">
                                                <div class="col-lg-12 px-0 px-md-2">
                                                <div class="mb-3">
                                                    <label for="zipcodeInput" class="form-label">Comment's
                                                    </label>
                                                    
                                                    <textarea name="complaint_message" class="bachset form-control" required
                                                        id="profile_description" cols="60"
                                                        rows="3">{{ $tutor->complaint_message }}</textarea>
                                                   </div>
                                                </div>
                                                <div class="col-lg-4 px-0 px-md-2">
                                                    <div class="mb-3">
                                                        <label for="countryInput bachset" class="form-label">Stage's</label>
                                                        <select class="form-select w-75" name="complaint_stage" id="updated_user_status" required>
                                                             <!--<option value="">Select Stage</option>-->
                                                             <option value="Default" {{ $tutor->complaint_stage=='Default'?'selected':'' }}>Default</option>
                                                            <option value="Personal inform" {{ $tutor->complaint_stage=='Personal inform'?'selected':'' }}>Personal inform</option>
                                                            <option value="Disclaimer" {{ $tutor->complaint_stage=='Disclaimer'?'selected':'' }}>Disclaimer</option>
                                                            <option value="Blocked" {{ $tutor->complaint_stage=='Blocked'?'selected':'' }}>Blocked</option>
                                                        </select>
                                                    </div>
                                                </div>

                                            </div>



                                         <div class="col-lg-12 px-0 px-md-2">
                                               <div class="hstack gap-2 justify-content-end">
                                                  <button type="submit" class="py-2 px-3 bg-primary border-0 rounded-3 text-white">Update</button>
                                               </div>
                                         </div>
                                    
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>



                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade zoomIn" id="status_model" tabindex="-1" aria-labelledby="save_doc_type_modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content border-0">
            <div class="modal-header p-3 bg-info-subtle">
                <h5 class="modal-title" id="status_model_title"> Update Document Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                    id="close-modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3 mb-3">
                    <div class="col-lg-12">
                        <input type="hidden" name="changed_type" id="changed_type" value="">
                        <input type="hidden" name="applicaton_id" id="applicaton_id" value="">
                        <div>
                            <label for="status_type" class="form-label">Status Type</label>
                            <select name="status_type" id="status_type" class="form-control"
                                onchange="checkStatusType(this.value)">
                                <option value="">Choose Status</option>
                                <option value="accepted">Accepted</option>
                                <option value="rejected">Rejected</option>
                            </select>
                        </div>
                        <div id="reason_dev" class="d-none">
                            <label for="">Reason for Rejectedd</label>
                            <textarea name="rejected_reason" class="form-control" id="rejected_reason" cols="10"
                                rows="4"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="hstack gap-2 justify-content-end d-flex align-items-center">
                        <button type="button" class="btn px-3 py-2 btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="bg-success px-3 py-2 rounded-2 border-0 text-white"
                            onclick="updateStatus()">Update</button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


{{-- other --}}
<div class="modal" id="DocxModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <iframe src=""
                    frameborder="0" style="width:100%;min-height:640px;" id="docxappend"></iframe>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>
{{-- image --}}
<div class="modal" id="imgModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <img src="" id="imagappend" />
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>

{{-- pdf --}}
<div class="modal" id="pdfModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <iframe src="" frameborder="0" id="pdfappend" style="width:100%;min-height:640px;"></iframe>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
    <script src="{{ URL::asset('assets/sweetalert2/sweetalert2.min.js') }}"></script>


<script>

    function getdocx(docx) {
        alert(docx);
        $('#docxappend').attr('src', 'https://view.officeapps.live.com/op/view.aspx?src='+docx);
        $('#DocxModal').modal('show');
    }
    function getpdf(pdf) {

        $('#pdfappend').attr('src', pdf);
        $('#pdfModal').modal('show');
    }
    function getimage(image) {
        $('#imagappend').attr('src', image);
        $('#imgModal').modal('show');
    }



    function updateDoc(id, type) {
        $('#applicaton_id').val(id)
        $('#changed_type').val(type)
        $('#status_model').modal('show');
    }

    function checkStatusType(statuType) {
        if (statuType == 'rejected') {
            $('#reason_dev').removeClass('d-none')
        } else {
            $('#reason_dev').addClass('d-none')
        }
    }

    function updateStatus() {
        var id = $('#applicaton_id').val()
        var changed_type = $('#changed_type').val()
        var rejected_reason = $('#rejected_reason').val()
        var status_type = $('#status_type').val()
        $.ajax({
            url: "{{ url('update-document-status') }}",
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                id: id,
                status_type: status_type,
                rejected_reason: rejected_reason,
                changed_type: changed_type,
            },
            success: function (data) {
                if (data.success == true) {
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: data.message,
                        showConfirmButton: false,
                        timer: 2000,
                        showCloseButton: true
                    });
                    $('#status_model').modal('hide');
                    $('#reason_dev').addClass('d-none');
                    $('#status_type').val('').trigger('change');
                    var html = '';
                    if (status_type == 'accepted') {
                        var html =
                            `<a href="javascript:void(0);" class="badge bg-success-subtle text-success" id="user_id">Accepted</a>`;
                    } else {
                        var html =
                            `<a href="javascript:void(0);" class="badge bg-danger-subtle text-danger" id="user_id">Rejected</a>`
                    }
                    $('.' + changed_type).empty()
                    $('#' + changed_type).addClass('d-none');
                    $('.' + changed_type).append(html)
                }
            },
        })
    }

    function UpdateUserStatus(value, id) {
        $.ajax({
            url: "{{ url('update-user-profile-status') }}",
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                id: id,
                status: value
            },
            success: function (data) {
                if (data.success == true) {
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: data.message,
                        showConfirmButton: false,
                        timer: 2000,
                        showCloseButton: true
                    });
                } else {
                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: data.message,
                        showConfirmButton: false,
                        timer: 2000,
                        showCloseButton: true
                    });
                }

            },
            error: function (data) {

            }
        })
    }
</script>

@endsection
