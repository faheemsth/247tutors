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
    <script src="{{ URL::asset('assets/sweetalert2/sweetalert2.min.js') }}"></script>
    <link href="{{ URL::asset('assets/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />

@endpush
<style>
    .nav-item:hover{
        background-color:transparent !important;
    }
    .nav-item .nav-link{
        min-height:70px ;
    }
</style>

@section('content')
    <div class="page-header">
        <div class="container-fluid">
            <div class="row align-items-end">
            <div class="col-12 col-lg-8 col-md-6 mb-3 mb-md-0">
                <div class="page-header-title">
                    <i class="fa-solid fa-pager bg-blue"></i>
                    <div class="d-inline">
                        <h5>{{ __('Website') }}</h5>
                        <span>{{ __('List of Settings') }}</span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4">
                <nav class="breadcrumb-container" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}"><i class="ik ik-home"></i></a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="#">{{ __('Setting') }}</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('website') }}">{{ __('Website') }}</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="#">{{ __('Pages') }}</a>
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
    <!-- Tabs navs -->

    <ul class="nav nav-tabs pb-0" id="ex1" role="tablist" style="    overflow: scroll;
    flex-wrap: nowrap;">
        {{-- @if (!empty($pages)) --}}
        {{-- @foreach ($pages as $page) --}}
        <li class="nav-item" role="presentation">
            <a class="nav-link active " id="ex1-tab-hf" data-mdb-toggle="tab" href="#ex1-tabs-hf" role="tab"
                aria-controls="ex1-tabs-hf" aria-selected="true">Header-Footer</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="ex1-tab-home" data-mdb-toggle="tab" href="#ex1-tabs-home" role="tab"
                aria-controls="ex1-tabs-home" aria-selected="true">Home</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="ex1-tab-std" data-mdb-toggle="tab" href="#ex1-tabs-std" role="tab"
                aria-controls="ex1-tabs-std" aria-selected="true">Student-Apply-Steps</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="ex1-tab-tutor" data-mdb-toggle="tab" href="#ex1-tabs-tutor" role="tab"
                aria-controls="ex1-tabs-tutor" aria-selected="true">Tutor-Apply-Steps</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="ex1-tab-org" data-mdb-toggle="tab" href="#ex1-tabs-org" role="tab"
                aria-controls="ex1-tabs-org" aria-selected="true">Organization-Apply-Steps</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="ex1-tab-faq" data-mdb-toggle="tab" href="#ex1-tabs-faq" role="tab"
                aria-controls="ex1-tabs-faq" aria-selected="true">FAQ</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="ex1-tab-pricing" data-mdb-toggle="tab" href="#ex1-tabs-pricing" role="tab"
                aria-controls="ex1-tabs-pricing" aria-selected="true">Pricing</a>
        </li>
        {{-- @endforeach --}}
        {{-- @endif --}}
    </ul>

    <!-- Tabs navs -->

    <!-- Tabs content -->
    {{-- @if (!empty($pages)) --}}
    {{-- @foreach ($pages as $page) --}}
    <div class="tab-content" id="ex1-content">
        <div class="tab-pane show active" id="ex1-tabs-hf" role="tabpanel" aria-labelledby="ex1-tab-hf">
            <div class="container bg-white py-5">
                <div class="row">
                    <div class="bg-white">
                        <form id="header_footer_form" method="post">
                            <fieldset class="mb-2">
                                <legend>Top-bar:</legend>
                                <div class="row">
                                    <div class="col-10 col-md-4 my-3">
                                    <label for="hometitle" class="form-label">Support Email</label>
                                    <div class="input-group ">
                                        <input type="email" name="topbaremail" id="topbaremail" class="form-control"
                                            placeholder="Enter Email"
                                            value="@isset($web_settings['topbaremail']) {{ $web_settings['topbaremail'] ?? '' }} @endisset">
                                    </div>
                                </div>
                                <div class="col-10 col-md-4 my-3">
                                    <label for="hometitle" class="form-label">Phone Number</label>
                                    <div class="input-group">
                                        <input type="text" name="Ph_num" id="Ph_num" class="form-control"
                                            placeholder="Enter Ph.number"
                                            value="@isset($web_settings['Ph_num']) {{ $web_settings['Ph_num'] ?? '' }} @endisset">
                                    </div>
                                </div>
                                </div>



                                <div class="row">
                                    <div class="col-10 col-md-4 my-1">
                                    <label for="hometitle" class="form-label">Email</label>
                                    <div class="input-group ">
                                        <input type="email" name="Maintopbaremail" id="Maintopbaremail" class="form-control"
                                            placeholder="Enter Email"
                                            value="@isset($web_settings['Maintopbaremail']) {{ $web_settings['Maintopbaremail'] ?? '' }} @endisset">
                                    </div>
                                </div>
                                <div class="col-10 col-md-4 my-1">
                                    <label for="hometitle" class="form-label">Whatsapp Number</label>
                                    <div class="input-group">
                                        <input type="text" name="MainPh_num" id="MainPh_num" class="form-control"
                                            placeholder="Enter Ph.number"
                                            value="@isset($web_settings['MainPh_num']) {{ $web_settings['MainPh_num'] ?? '' }} @endisset">
                                    </div>
                                </div>
                                </div>


                            </fieldset>
                            <fieldset class="mb-3">
                                <legend>Social Media Link:</legend>
                               <div class="row">
                                    <div class="col-10 col-md-4 my-3">
                                    <label class="form-label">Instagram link</label>
                                    <div class="input-group ">
                                        <input type="text" name="instlink" id="instlink" class="form-control"
                                            placeholder="Enter Instagram link"
                                            value="@isset($web_settings['instlink']) {{ $web_settings['instlink'] ?? '' }} @endisset">
                                    </div>
                                </div>
                                <div class="col-10 col-md-4 my-3">
                                    <label for="hometitle" class="form-label">Twitter link</label>
                                    <div class="input-group ">
                                        <input type="text" name="xlink" id="xlink" class="form-control"
                                            placeholder="Enter Twitter link"
                                            value="@isset($web_settings['xlink']) {{ $web_settings['xlink'] ?? '' }} @endisset">
                                    </div>
                                </div>
                                </div>
                                 <div class="row">
                                <div class="col-10 col-md-4 my-2">
                                    <label for="hometitle" class="form-label">LinkedIn link</label>
                                    <div class="input-group ">
                                        <input type="text" name="inlink" id="inlink" class="form-control"
                                            placeholder="Enter LinkedIn link"
                                            value="@isset($web_settings['inlink']) {{ $web_settings['inlink'] ?? '' }} @endisset">
                                    </div>
                                </div>
                                <div class="col-10 col-md-4 my-2">
                                    <label class="form-label">Facebook link</label>
                                    <div class="input-group">
                                        <input type="text" name="fblink" id="fblink" class="form-control"
                                            placeholder="Enter Facebook link"
                                            value="@isset($web_settings['fblink']) {{ $web_settings['fblink'] ?? '' }} @endisset">
                                    </div>
                                </div>
                               </div>

                            </fieldset>
                            <button class="btn btn-primary px-2 py-2 mt-3" style="height: max-content"
                                type="submit">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane" id="ex1-tabs-home" role="tabpanel" aria-labelledby="ex1-tab-home">
            <div class="container bg-white py-5">
                <div class="row">
                    <div class="bg-white">
                        <form id="home_form" method="post">

                            <fieldset class="mb-5">
                                <legend>Hero section:</legend>
                                <div class="col-12 col-md-8 my-3">
                                    <label for="hometitle" class="form-label">Home Title</label>
                                    <div class="input-group ">
                                        <input type="text" name="home_title" id="home_title" class="form-control"
                                            placeholder="Enter Title"
                                            value="@isset($web_settings['hero_title']) {{ $web_settings['hero_title'] ?? '' }} @endisset">
                                    </div>
                                </div>
                                <div class="col-12 col-md-8 my-3">
                                    <label for="hometitle" class="form-label">Home Description</label>

                                    <textarea class="form-control " placeholder="Enter Description" name="hero_desc"
                                        aria-label="With textarea" id="hero_desc">
@isset($web_settings['hero_desc'])
{{ $web_settings['hero_desc'] ?? '' }}
@endisset
</textarea>

                                </div>
                                <div class="col-12 col-md-8 my-3">
                                    <label for="hometitle" class="form-label">highlight Text</label>
                                    <div class="input-group ">
                                        <input type="text" name="highlight_text" id="highlight_text"
                                            class="form-control" placeholder="Enter Highlight text"
                                            value="@isset($web_settings['highlight_text']) {{ $web_settings['highlight_text'] ?? '' }} @endisset">
                                    </div>
                                </div>
                                <div class="col-12 col-md-8 my-3">
                                    <label for="hometitle" class="form-label">Short Description</label>

                                    <textarea class="form-control " placeholder="Enter short description" id="hero_short_desc"
                                        name="hero_short_desc" aria-label="With textarea"> @isset($web_settings['hero_short_desc'])
{{ $web_settings['hero_short_desc'] ?? '' }}
@endisset
</textarea>
                                </div>
                            </fieldset>
                            <fieldset class="mb-3">
                                <legend>Why Choose us section:</legend>
                                <div class="col-12 col-md-8 my-3">
                                    <label for="hometitle" class="form-label">Tutor Card Title</label>
                                    <div class="input-group input-group-lg">
                                        <input type="text" name="card1_title" id="card1_title" class="form-control"
                                            placeholder="Enter tutor heading"
                                            value="@isset($web_settings['card1_title']) {{ $web_settings['card1_title'] ?? '' }} @endisset">
                                    </div>
                                </div>
                                <div class="col-12 col-md-8 my-3">
                                    <label for="hometitle" class="form-label">Tutor Card Description</label>

                                    <textarea class="form-control " id="card1_desc" placeholder="Enter tutor description"
                                        name="card1_desc" aria-label="With textarea"> @isset($web_settings['card1_desc'])
{{ $web_settings['card1_desc'] ?? '' }}
@endisset </textarea>

                                </div>
                                <div class="col-12 col-md-8 my-3">
                                    <label for="hometitle" class="form-label">Profile Card Title</label>
                                    <div class="input-group input-group-lg">
                                        <input type="text" name="card2_title" id="card2_title" class="form-control"
                                            placeholder="Enter profile title"
                                            value="@isset($web_settings['card2_title']) {{ $web_settings['card2_title'] ?? '' }} @endisset">
                                    </div>
                                </div>
                                <div class="col-12 col-md-8 my-3">
                                    <label for="hometitle" class="form-label">Profile card description</label>

                                    <textarea class="form-control " placeholder="Enter profile description" id="card2_desc"
                                        name="card2_desc" aria-label="With textarea"> @isset($web_settings['card2_desc'])
{{ $web_settings['card2_desc'] ?? '' }}
@endisset </textarea>

                                </div>
                                <div class="col-12 col-md-8 my-3">
                                    <label for="hometitle" class="form-label">Price card title</label>
                                    <div class="input-group input-group-lg">
                                        <input type="text" name="card3_title" id="card3_title" class="form-control"
                                            placeholder="Title"
                                            value="@isset($web_settings['card3_title']) {{ $web_settings['card3_title'] ?? '' }} @endisset">
                                    </div>
                                </div>
                                <div class="col-12 col-md-8 my-3">
                                    <label for="hometitle" class="form-label">Price card description</label>

                                    <textarea class="form-control " name="card3_desc" id="card3_desc" aria-label="With textarea"> @isset($web_settings['card3_desc'])
{{ $web_settings['card3_desc'] ?? '' }}
@endisset </textarea>

                                </div>
                                <div class="col-12 col-md-8 my-3">
                                    <label for="hometitle" class="form-label">Learn card title</label>
                                    <div class="input-group input-group-lg">
                                        <input type="text" name="card4_title" id="card4_title" class="form-control"
                                            placeholder="Title"
                                            value="@isset($web_settings['card4_title']) {{ $web_settings['card4_title'] ?? '' }} @endisset">
                                    </div>
                                </div>
                                <div class="col-12 col-md-8 my-3">
                                    <label for="hometitle" class="form-label">Learn card description</label>

                                    <textarea class="form-control " name="card4_desc" id="card4_desc" aria-label="With textarea"> @isset($web_settings['card4_desc'])
{{ $web_settings['card4_desc'] ?? '' }}
@endisset </textarea>

                                </div>
                            </fieldset>
                            <button class="btn btn-primary px-2 py-2 mt-3" style="height: max-content" type="button"
                                onclick="saveHome()">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane" id="ex1-tabs-std" role="tabpanel" aria-labelledby="ex1-tab-std">
            <div class="container bg-white py-5">
                <div class="row">
                    <div class="bg-white">
                        <form id="student-apply-steps_form" method="post">

                            <fieldset class="mb-5">
                                <legend>Apply Steps:</legend>
                                <div class="col-12 col-md-8 my-3">
                                    <label for="hometitle" class="form-label">Step One:</label>

                                    <textarea class="form-control " name="st_one" id="st_one" aria-label="With textarea"> @isset($web_settings['st_one'])
{{ $web_settings['st_one'] ?? '' }}
@endisset
</textarea>
                                </div>
                                <div class="col-12 col-md-8 my-3">
                                    <label for="hometitle" class="form-label">Step Two:</label>
                                    <textarea class="form-control " name="st_two" id="st_two" aria-label="With textarea"> @isset($web_settings['st_two'])
{{ $web_settings['st_two'] ?? '' }}
@endisset
</textarea>
                                </div>
                                <div class="col-12 col-md-8 my-3">
                                    <label for="hometitle" class="form-label">Step Three:</label>

                                    <textarea class="form-control " name="st_three" id="st_three" aria-label="With textarea"> @isset($web_settings['st_three'])
{{ $web_settings['st_three'] ?? '' }}
@endisset
</textarea>
                                </div>
                                <div class="col-12 col-md-8 my-3">
                                    <label for="hometitle" class="form-label">Step Four:</label>
                                    <textarea class="form-control " name="st_four" id="st_four" aria-label="With textarea"> @isset($web_settings['st_four'])
{{ $web_settings['st_four'] ?? '' }}
@endisset
</textarea>
                                </div>
                            </fieldset>
                            <button class="btn btn-primary px-2 py-2 mt-3" style="height: max-content" type="button"
                                onclick="savestudent();">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane" id="ex1-tabs-tutor" role="tabpanel" aria-labelledby="ex1-tab-tutor">
            <div class="container bg-white py-5">
                <div class="row">
                    <div class="bg-white">
                        <form id="tutor-apply-steps_form" method="post">

                            <fieldset class="mb-5">
                                <legend>Apply Steps:</legend>
                                <div class="col-12 col-md-8 my-3">
                                    <label for="hometitle" class="form-label">Step One:</label>

                                    <textarea class="form-control " name="tutor_one" id="tutor_one" aria-label="With textarea"> @isset($web_settings['tutor_one'])
{{ $web_settings['tutor_one'] ?? '' }}
@endisset
</textarea>
                                </div>
                                <div class="col-12 col-md-8 my-3">
                                    <label for="hometitle" class="form-label">Step Two:</label>
                                    <textarea class="form-control " name="tutor_two" id="tutor_two" aria-label="With textarea"> @isset($web_settings['tutor_two'])
{{ $web_settings['tutor_two'] ?? '' }}
@endisset
</textarea>
                                </div>
                                <div class="col-12 col-md-8 my-3">
                                    <label for="hometitle" class="form-label">Step Three:</label>

                                    <textarea class="form-control " name="tutor_three" id="tutor_three" aria-label="With textarea"> @isset($web_settings['tutor_three'])
{{ $web_settings['tutor_three'] ?? '' }}
@endisset
</textarea>
                                </div>
                                <div class="col-12 col-md-8 my-3">
                                    <label for="hometitle" class="form-label">Step Four:</label>
                                    <textarea class="form-control " name="tutor_four" id="tutor_four" aria-label="With textarea"> @isset($web_settings['tutor_four'])
{{ $web_settings['tutor_four'] ?? '' }}
@endisset
</textarea>
                                </div>
                            </fieldset>
                            <button class="btn btn-primary px-2 py-2 mt-3" style="height: max-content" type="button"
                                onclick="saveTutor()">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane" id="ex1-tabs-org" role="tabpanel" aria-labelledby="ex1-tab-org">
            <div class="container bg-white py-5">
                <div class="row">
                    <div class="bg-white">
                        <form id="organization-apply-steps_form" method="post">

                            <fieldset class="mb-5">
                                <legend>Apply Steps:</legend>
                                <div class="col-12 col-md-8 my-3">
                                    <label for="hometitle" class="form-label">Step One:</label>

                                    <textarea class="form-control " name="org_one" id="org_one" aria-label="With textarea"> @isset($web_settings['org_one'])
{{ $web_settings['org_one'] ?? '' }}
@endisset
</textarea>
                                </div>
                                <div class="col-12 col-md-8 my-3">
                                    <label for="hometitle" class="form-label">Step Two:</label>
                                    <textarea class="form-control " name="org_two" id="org_two" aria-label="With textarea"> @isset($web_settings['org_two'])
{{ $web_settings['org_two'] ?? '' }}
@endisset
</textarea>
                                </div>
                                <div class="col-12 col-md-8 my-3">
                                    <label for="hometitle" class="form-label">Step Three:</label>

                                    <textarea class="form-control " name="org_three" id="org_three" aria-label="With textarea"> @isset($web_settings['org_three'])
{{ $web_settings['org_three'] ?? '' }}
@endisset
</textarea>
                                </div>
                                <div class="col-12 col-md-8 my-3">
                                    <label for="hometitle" class="form-label">Step Four:</label>
                                    <textarea class="form-control " name="org_four" id="org_four" aria-label="With textarea"> @isset($web_settings['org_four'])
{{ $web_settings['org_four'] ?? '' }}
@endisset
</textarea>
                                </div>
                            </fieldset>
                            <button class="btn btn-primary px-2 py-2 mt-3" style="height: max-content" type="button"
                                onclick="saveorganization()">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane" id="ex1-tabs-faq" role="tabpanel" aria-labelledby="ex1-tab-faq">
            <div class="container bg-white py-5">
                <div class="row">
                    <div class="bg-white">
                        <form id="faq_form" method="post">

                            <fieldset class="mb-5">
                                <legend>FAQ Section:</legend>
                                <div class="col-12 col-md-8 my-3">
                                    <label for="hometitle" class="form-label">FAQ Description</label>
                                    <textarea class="form-control " name="faq_desc" id="faq_desc" aria-label="With textarea"> @isset($web_settings['faq_desc'])
{{ $web_settings['faq_desc'] ?? '' }}
@endisset </textarea>
                                </div>
                            </fieldset>
                            <fieldset class="mb-3">
                                <legend>Accordion:</legend>
                                <div class="col-12 col-md-8 my-3">
                                    <label for="hometitle" class="form-label">first Accordion Title</label>
                                    <div class="input-group input-group-lg">
                                        <input type="text" name="accfirst_title" id="accfirst_title"
                                            class="form-control" placeholder="Title"
                                            value="@isset($web_settings['accfirst_title']) {{ $web_settings['accfirst_title'] ?? '' }} @endisset">
                                    </div>
                                </div>
                                <div class="col-12 col-md-8 my-3">
                                    <label for="hometitle" class="form-label">First Accordion Description</label>

                                    <textarea class="form-control " name="accfirst_desc" id="accfirst_desc" aria-label="With textarea"> @isset($web_settings['accfirst_desc'])
{{ $web_settings['accfirst_desc'] ?? '' }}
@endisset </textarea>

                                </div>
                                <div class="col-12 col-md-8 my-3">
                                    <label for="hometitle" class="form-label">Second Accordion Title</label>
                                    <div class="input-group input-group-lg">
                                        <input type="text" name="accsec_title" id="accsec_title" class="form-control"
                                            placeholder="Title"
                                            value="@isset($web_settings['accsec_title']) {{ $web_settings['accsec_title'] ?? '' }} @endisset">
                                    </div>
                                </div>
                                <div class="col-12 col-md-8 my-3">
                                    <label for="hometitle" class="form-label">Second Accordion Description</label>

                                    <textarea class="form-control " name="accsec_desc" id="accsec_desc" aria-label="With textarea"> @isset($web_settings['accsec_desc'])
{{ $web_settings['accsec_desc'] ?? '' }}
@endisset </textarea>

                                </div>
                                <div class="col-12 col-md-8 my-3">
                                    <label for="hometitle" class="form-label">Third Accordion Title</label>
                                    <div class="input-group input-group-lg">
                                        <input type="text" name="accthird_title" id="accthird_title"
                                            class="form-control" placeholder="Title"
                                            value="@isset($web_settings['accthird_title']) {{ $web_settings['accthird_title'] ?? '' }} @endisset">
                                    </div>
                                </div>
                                <div class="col-12 col-md-8 my-3">
                                    <label for="hometitle" class="form-label">Third Accordion Description</label>

                                    <textarea class="form-control " name="accthird_desc" id="accthird_desc" aria-label="With textarea"> @isset($web_settings['accthird_desc'])
{{ $web_settings['accthird_desc'] ?? '' }}
@endisset </textarea>

                                </div>
                                <div class="col-12 col-md-8 my-3">
                                    <label for="hometitle" class="form-label">Fourth Accordion Title</label>
                                    <div class="input-group input-group-lg">
                                        <input type="text" name="accfour_title" id="accfour_title"
                                            class="form-control" placeholder="Title"
                                            value="@isset($web_settings['accfour_title']) {{ $web_settings['accfour_title'] ?? '' }} @endisset">
                                    </div>
                                </div>
                                <div class="col-12 col-md-8 my-3">
                                    <label for="hometitle" class="form-label">Fourth Accordion Description</label>

                                    <textarea class="form-control " name="accfour_desc" id="accfour_desc" aria-label="With textarea"> @isset($web_settings['accfour_desc'])
{{ $web_settings['accfour_desc'] ?? '' }}
@endisset </textarea>

                                </div>
                            </fieldset>
                            <button class="btn btn-primary px-2 py-2 mt-3" style="height: max-content" type="button"
                                onclick="saveSaq()">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane" id="ex1-tabs-pricing" role="tabpanel" aria-labelledby="ex1-tab-pricing">
            <div class="container bg-white py-5">
                <div class="row">
                    <div class="bg-white">
                        <form id="pricing_form" method="post">

                            <fieldset class="mb-5">
                                <legend>Pricing section:</legend>
                                <div class="col-12 col-md-8 my-3">
                                    <label for="hometitle" class="form-label">Hero title</label>
                                    <div class="input-group input-group-lg">
                                        <input type="text" name="pricing_title" id="pricing_title"
                                            class="form-control" placeholder="Title"
                                            value="@isset($web_settings['pricing_title']) {{ $web_settings['pricing_title'] ?? '' }} @endisset">
                                    </div>
                                </div>
                                <div class="col-12 col-md-8 my-3">
                                    <label for="hometitle" class="form-label">Hero description</label>

                                    <textarea class="form-control " name="pricing_desc" id="pricing_desc" aria-label="With textarea"> @isset($web_settings['pricing_desc'])
{{ $web_settings['pricing_desc'] ?? '' }}
@endisset </textarea>

                                </div>

                                <div class="col-12 col-md-8 my-3">
                                    <label for="hometitle" class="form-label">Short description</label>

                                    <textarea class="form-control " name="pricing_short_desc" id="pricing_short_desc"
                                        aria-label="With textarea"> @isset($web_settings['pricing_short_desc'])
{{ $web_settings['pricing_short_desc'] ?? '' }}
@endisset </textarea>

                                </div>
                            </fieldset>
                            <fieldset class="mb-3">
                                <legend>Card's:</legend>

                                <div class="col-12 col-md-8 my-3">
                                    <label for="hometitle" class="form-label">First Pricing card
                                        description</label>

                                    <textarea class="form-control " name="pricecard1_desc" id="pricecard1_desc"
                                        aria-label="With textarea"> @isset($web_settings['pricecard1_desc'])
{{ $web_settings['pricecard1_desc'] ?? '' }}
@endisset </textarea>

                                </div>

                                <div class="col-12 col-md-8 my-3">
                                    <label for="hometitle" class="form-label">Second Pricing card
                                        description</label>

                                    <textarea class="form-control " name="pricecard2_desc" id="pricecard2_desc"
                                        aria-label="With textarea"> @isset($web_settings['pricecard2_desc'])
{{ $web_settings['pricecard2_desc'] ?? '' }}
@endisset </textarea>

                                </div>

                                <div class="col-12 col-md-8 my-3">
                                    <label for="hometitle" class="form-label">Third Pricing card
                                        description</label>

                                    <textarea class="form-control " name="pricecard3_desc" id="pricecard3_desc"
                                        aria-label="With textarea"> @isset($web_settings['pricecard3_desc'])
{{ $web_settings['pricecard3_desc'] ?? '' }}
@endisset </textarea>
                                </div>
                                <div class="col-12 col-md-8 my-3">
                                    <label for="hometitle" class="form-label">Pricing card description</label>

                                    <textarea class="form-control " name="price_desc" id="price_desc" aria-label="With textarea"> @isset($web_settings['price_desc'])
{{ $web_settings['price_desc'] ?? '' }}
@endisset </textarea>
                                </div>
                            </fieldset>
                            <fieldset class="mb-3">
                                <legend>Description:</legend>
                                <div class="col-12 col-md-8 my-3">
                                    <label for="hometitle" class="form-label">title</label>
                                    <div class="input-group input-group-lg">
                                        <input type="text" name="card5_title" id="card5_title" class="form-control"
                                            placeholder="Title"
                                            value="@isset($web_settings['card5_title']) {{ $web_settings['card5_title'] ?? '' }} @endisset">
                                    </div>
                                </div>
                                <div class="col-12 col-md-8 my-3">
                                    <label for="hometitle" class="form-label">description</label>

                                    <textarea class="form-control " name="card5_desc" id="card5_desc" aria-label="With textarea"> @isset($web_settings['card5_desc'])
{{ $web_settings['card5_desc'] ?? '' }}
@endisset </textarea>

                                </div>
                                <div class="col-12 col-md-8 my-3">
                                    <label for="hometitle" class="form-label">Second title</label>
                                    <div class="input-group input-group-lg">
                                        <input type="text" name="card6_title" id="card6_title" class="form-control"
                                            placeholder="Title"
                                            value="@isset($web_settings['card6_title']) {{ $web_settings['card6_title'] ?? '' }} @endisset">
                                    </div>
                                </div>
                                <div class="col-12 col-md-8 my-3">
                                    <label for="hometitle" class="form-label">Second description</label>

                                    <textarea class="form-control " name="card6_desc" id="card6_desc" aria-label="With textarea"> @isset($web_settings['card6_desc'])
{{ $web_settings['card6_desc'] ?? '' }}
@endisset </textarea>

                                </div>


                            </fieldset>
                            <button class="btn btn-primary px-2 py-2 mt-3" style="height: max-content" type="button"
                                onclick="savePricing()">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- @endforeach --}}
    {{-- @endif --}}

    <script>
        $('#header_footer_form').on('submit', function(e) {
            e.preventDefault();

            var topbaremail = $('#topbaremail').val();
            var Ph_num = $('#Ph_num').val();

            var Maintopbaremail = $('#Maintopbaremail').val();
            var MainPh_num = $('#MainPh_num').val();

            var fblink = $('#fblink').val();
            var instlink = $('#instlink').val();
            var inlink = $('#inlink').val();
            var xlink = $('#xlink').val();
            // var cron_run = $('#run_cron').is(":checked") ? 1 : 0;
            $.ajax({
                url: "{{ url('save_website_setting') }}",
                type: "post",
                dataType: "json",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },

                data: {

                    topbaremail: topbaremail,
                    Ph_num: Ph_num,
                    Maintopbaremail: Maintopbaremail,
                    MainPh_num: MainPh_num,
                    fblink: fblink,
                    instlink: instlink,
                    inlink: inlink,
                    xlink: xlink,
                },
                success: function(data) {
                    console.log(data);
                    // toastr.success(data.message, {
                    //     timeOut: 5000
                    // });
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: data.message,
                        showConfirmButton: false,
                        timer: 2000,
                        showCloseButton: true
                    });
                }
            })
        })

        function saveHome() {
            var home_title = document.getElementById("home_title").value;
            // alert(home_title)
            // var hero_desc = $('#home_title').val();
            var hero_desc = $('#hero_desc').val();
            var highlight_text = $('#highlight_text').val();
            var hero_short_desc = $('#hero_short_desc').val();

            var card1_title = $('#card1_title').val();
            var card1_desc = $('#card1_desc').val();
            var card2_title = $('#card2_title').val();
            var card2_desc = $('#card2_desc').val();
            var card3_title = $('#card3_title').val();
            var card3_desc = $('#card3_desc').val();
            var card4_title = $('#card4_title').val();
            var card4_desc = $('#card4_desc').val();

            $.ajax({
                url: "{{ url('save_website_setting') }}",
                type: "post",
                dataType: "json",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },

                data: {

                    hero_title: home_title,
                    hero_desc: hero_desc,
                    highlight_text: highlight_text,
                    hero_short_desc: hero_short_desc,

                    card1_title: card1_title,
                    card1_desc: card1_desc,
                    card2_title: card2_title,
                    card2_desc: card2_desc,
                    card3_title: card3_title,
                    card3_desc: card3_desc,
                    card4_title: card4_title,
                    card4_desc: card4_desc,
                },
                success: function(data) {
                    console.log(data);
                    // toastr.success(data.message, {
                    //     timeOut: 5000
                    // });
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: data.message,
                        showConfirmButton: false,
                        timer: 2000,
                        showCloseButton: true
                    });
                }
            })
        }
    </script>
    <script></script>
    <script>
        function savestudent() {
            var st_one = $('#st_one').val();
            var st_two = $('#st_two').val();
            var st_three = $('#st_three').val();
            var st_four = $('#st_four').val();

            $.ajax({
                url: "{{ url('save_website_setting') }}",
                type: "post",
                dataType: "json",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },

                data: {

                    st_one: st_one,
                    st_two: st_two,
                    st_three: st_three,
                    st_four: st_four,
                },
                success: function(data) {
                    console.log(data);
                    // toastr.success(data.message, {
                    //     timeOut: 5000
                    // });
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: data.message,
                        showConfirmButton: false,
                        timer: 2000,
                        showCloseButton: true
                    });
                }
            })
        }
    </script>
    <script>
        function saveTutor() {
            var tutor_one = $('#tutor_one').val();
            var tutor_two = $('#tutor_two').val();
            // alert(tutor_two)

            var tutor_three = $('#tutor_three').val();
            var tutor_four = $('#tutor_four').val();

            $.ajax({
                url: "{{ url('save_website_setting') }}",
                type: "post",
                dataType: "json",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },

                data: {

                    tutor_one: tutor_one,
                    tutor_two: tutor_two,
                    tutor_three: tutor_three,
                    tutor_four: tutor_four,
                },
                success: function(data) {
                    console.log(data);
                    // toastr.success(data.message, {
                    //     timeOut: 5000
                    // });
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: data.message,
                        showConfirmButton: false,
                        timer: 2000,
                        showCloseButton: true
                    });
                }
            })
        }
    </script>
    <script>
        function saveorganization() {
            var org_one = $('#org_one').val();
            var org_two = $('#org_two').val();
            var org_three = $('#org_three').val();
            var org_four = $('#org_four').val();

            $.ajax({
                url: "{{ url('save_website_setting') }}",
                type: "post",
                dataType: "json",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },

                data: {

                    org_one: org_one,
                    org_two: org_two,
                    org_three: org_three,
                    org_four: org_four,
                },
                success: function(data) {
                    console.log(data);
                    // toastr.success(data.message, {
                    //     timeOut: 5000
                    // });
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: data.message,
                        showConfirmButton: false,
                        timer: 2000,
                        showCloseButton: true
                    });
                }
            })
        }
    </script>
    <script>
        function saveSaq() {
            var faq_desc = $('#faq_desc').val();
            var accfirst_title = $('#accfirst_title').val();
            var accfirst_desc = $('#accfirst_desc').val();
            var accsec_title = $('#accsec_title').val();
            var accsec_desc = $('#accsec_desc').val();
            var accthird_title = $('#accthird_title').val();
            var accthird_desc = $('#accthird_desc').val();
            var accfour_title = $('#accfour_title').val();
            var accfour_desc = $('#accfour_desc').val();

            $.ajax({
                url: "{{ url('save_website_setting') }}",
                type: "post",
                dataType: "json",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },

                data: {

                    faq_desc: faq_desc,
                    accfirst_title: accfirst_title,
                    accfirst_desc: accfirst_desc,
                    accsec_title: accsec_title,
                    accsec_desc: accsec_desc,
                    accthird_title: accthird_title,
                    accthird_desc: accthird_desc,
                    accfour_title: accfour_title,
                    accfour_desc: accfour_desc,

                },
                success: function(data) {
                    console.log(data);
                    // toastr.success(data.message, {
                    //     timeOut: 5000
                    // });
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: data.message,
                        showConfirmButton: false,
                        timer: 2000,
                        showCloseButton: true
                    });
                }
            })
        }
    </script>
    <script>
        function savePricing() {
            var pricing_title = $('#pricing_title').val();
            var pricing_desc = $('#pricing_desc').val();
            var pricing_short_desc = $('#pricing_short_desc').val();

            var pricecard1_desc = $('#pricecard1_desc').val();
            var pricecard2_desc = $('#pricecard2_desc').val();
            var pricecard3_desc = $('#pricecard3_desc').val();
            var price_desc = $('#price_desc').val();

            var card5_title = $('#card5_title').val();
            var card5_desc = $('#card5_desc').val();
            var card6_title = $('#card6_title').val();
            var card6_desc = $('#card6_desc').val();
            // var cron_run = $('#run_cron').is(":checked") ? 1 : 0;


            $.ajax({
                url: "{{ url('save_website_setting') }}",
                type: "post",
                dataType: "json",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },

                data: {

                    pricing_title: pricing_title,
                    pricing_desc: pricing_desc,
                    pricing_short_desc: pricing_short_desc,

                    pricecard1_desc: pricecard1_desc,
                    pricecard2_desc: pricecard2_desc,
                    pricecard3_desc: pricecard3_desc,
                    price_desc: price_desc,

                    card5_title: card5_title,
                    card5_desc: card5_desc,
                    card6_title: card6_title,
                    card6_desc: card6_desc,
                },
                success: function(data) {
                    console.log(data);
                    // toastr.success(data.message, {
                    //     timeOut: 5000
                    // });
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: data.message,
                        showConfirmButton: false,
                        timer: 2000,
                        showCloseButton: true
                    });
                }
            })

        }
        // $('#pricing_form').on('submit', function(e) {
        //     e.preventDefault();

        //     var pricing_title = $('#pricing_title').val();
        //     var pricing_desc = $('#pricing_desc').val();
        //     var pricing_short_desc = $('#pricing_short_desc').val();

        //     var pricecard1_desc = $('#pricecard1_desc').val();
        //     var pricecard2_desc = $('#pricecard2_desc').val();
        //     var pricecard3_desc = $('#pricecard3_desc').val();
        //     var price_desc = $('#price_desc').val();

        //     var card5_title = $('#card5_title').val();
        //     var card5_desc = $('#card5_desc').val();
        //     var card6_title = $('#card6_title').val();
        //     var card6_desc = $('#card6_desc').val();
        //     // var cron_run = $('#run_cron').is(":checked") ? 1 : 0;


        //     $.ajax({
        //         url: "{{ url('save_website_setting') }}",
        //         type: "post",
        //         dataType: "json",
        //         headers: {
        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //         },

        //         data: {

        //             pricing_title: pricing_title,
        //             pricing_desc: pricing_desc,
        //             pricing_short_desc: pricing_short_desc,

        //             pricecard1_desc: pricecard1_desc,
        //             pricecard2_desc: pricecard2_desc,
        //             pricecard3_desc: pricecard3_desc,
        //             price_desc: price_desc,

        //             card5_title: card5_title,
        //             card5_desc: card5_desc,
        //             card6_title: card6_title,
        //             card6_desc: card6_desc,
        //         },
        //         success: function(data) {
        //             console.log(data);
        //             toastr.success(data.message, {
        //                 timeOut: 5000
        //             });
        //         }
        //     })
        // })
    </script>


@endsection
