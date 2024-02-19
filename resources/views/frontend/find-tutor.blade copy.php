@extends('layouts.app')
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
    <div class="container">
        <!-- row 1 -->
        <div class="row align-items-md-end align-items-baseline mt-5">
            <div class="col-md-6 col-12">
                <h4 id="appendcount">{{ $TutorSubjectOffers->total() }} Search result in <strong></strong> tutors</h4>
            </div>
            <div class="col-md-6 col-12">
                <div class="d-flex gap-2 gap-md-2 justify-content-md-end align-items-baseline">
                    <small>Sort by: </small>
                    <ul class="navbar-nav px-2">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-dark" href="#" id="navbarDarkDropdownMenuLink"
                                role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <strong>Price </strong>
                            </a>
                            <ul class="dropdown-menu " aria-labelledby="navbarDarkDropdownMenuLink">
                                <li><a class="dropdown-item" id="dropdown-item" href="javascript:void(0)">low to high</a>
                                </li>
                                <li><a class="dropdown-item" id="dropdown-item" href="javascript:void(0)">high to low</a>
                                </li>
                            </ul>
                        </li>
                    </ul>


                    <div class="btn p-0">
                        <ul class="navbar-nav">
                            <li class="nav-item dropdown">
                                <a class="nav-link text-dark" href="#" id="navbarDarkDropdownMenuLink" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <img src="./assets/images/menu-bar.png">

                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDarkDropdownMenuLink">
                                    <li><a class="dropdown-item" id="dropdown-item" href="javascript:void(0)">Online</a></li>
                                    <li><a class="dropdown-item" id="dropdown-item" href="javascript:void(0)">In Person</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>










                    {{-- <div>
                        <img src="./assets/images/menu.png">
                    </div> --}}
                </div>
            </div>
        </div>
        <!-- row 2 -->
        <div class="row py-4">
            <div class="col-md-10 col-12 align-items-baseline">
                <div class="row border border-muted rounded-1 border-1 mx-1 mx-md-0">
                    <div class="col-xl-7 col-md-6 col-12 py-3">
                        <img src="./assets/images/Search.png">
                        <input style="width: 80%;" class="border-0 search-bar-filter" type="text" id="search"
                            placeholder="What do you want to explore?">
                    </div>
                    <div class="col-xl-3 col-md-3 col-12 py-2 d-flex justify-content-md-end">
                        <ul class="navbar-nav px-2 ">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle text-dark" href="#" id="navbarDarkDropdownMenuLink"
                                    role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <img src="./assets/images/logo.png">
                                    <strong class="pe-2">Select Gender</strong>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDarkDropdownMenuLink">
                                    <li><a class="dropdown-item" id="dropdown-item" href="javascript:void(0)">Male</a></li>
                                    <li><a class="dropdown-item" id="dropdown-item" href="javascript:void(0)">Female</a>
                                    </li>
                                    <li><a class="dropdown-item" id="dropdown-item" href="javascript:void(0)">Any</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="col-xl-2 col-md-3 col-12 py-2 d-none">
                        <button class="btn filter-search-btn  rounded-0">
                            <small>Search now</small>
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-md-2 d-none d-md-flex">
                <div class="fromhere">
                    <img src="./assets/images/Type.png">
                </div>
            </div>
        </div>
        <!-- row 3 -->
        <div class="row">
            <div class="col-md-12">
                <div class="d-flex flex-wrap gap-2" id="searchbox">

                </div>
            </div>
        </div>
    </div>
    <div class="container my-5 pb-3 tutor-list">
        <div class="row justify-content-lg-center">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-4 d-none d-lg-block">

                        <div class="card">
                            <div class="card-body">


                                <div class="education-level py-2 my-2">
                                    <label for="">
                                        <h5>Education level</h5>
                                    </label>

                                    <select name="" id="outline-remove"
                                        class="form form-control form-select Education_level">
                                        <option value="" selected>All Levels</option>
                                        <option value="KS1 (Primary)" data-level="KS1 (Primary)">KS1 (Primary)</option>
                                        <option value="KS2 (Primary)" data-level="KS2 (Primary)">KS2 (Primary)</option>
                                        <option value="KS3 (GCSE)" data-level="KS3 (GCSE)">KS3 (GCSE)</option>
                                        <option value="KS4 (A Level)" data-level="KS4 (A Level)">KS4 (A Level)</option>
                                        <option value="University" data-level="University">University</option>
                                    </select>
                                </div>
                                <div class="education-level py-2 my-2">
                                    <div class="availabilityWrapper css-lod8fa"><button class="dropdownTriggerButton">
                                            <div class="triggerButtonText" data-cy="availabilityFilter">
                                                All Availability
                                            </div>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="12"
                                                style="margin-left: 10px;" height="8" viewBox="0 0 16 8"
                                                fill="none">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M0.96967 0.21967C1.23594 -0.0465966 1.6526 -0.0708027 1.94621 0.147052L2.03033 0.21967L8 6.189L13.9697 0.21967C14.2359 -0.0465966 14.6526 -0.0708027 14.9462 0.147052L15.0303 0.21967C15.2966 0.485936 15.3208 0.9026 15.1029 1.19621L15.0303 1.28033L8.53033 7.78033C8.26406 8.0466 7.8474 8.0708 7.55379 7.85295L7.46967 7.78033L0.96967 1.28033C0.676777 0.987437 0.676777 0.512563 0.96967 0.21967Z"
                                                    fill="#00918A" />
                                            </svg>
                                        </button>
                                        <section class="dropdownContainer" id="dropdownContainer">
                                            <header class="mobileHeading">
                                                <h2>Availability</h2>
                                                <div class="filterClose">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="12"
                                                        style="margin-left: 10px;"height="8" viewBox="0 0 16 8"
                                                        fill="none">
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M0.96967 0.21967C1.23594 -0.0465966 1.6526 -0.0708027 1.94621 0.147052L2.03033 0.21967L8 6.189L13.9697 0.21967C14.2359 -0.0465966 14.6526 -0.0708027 14.9462 0.147052L15.0303 0.21967C15.2966 0.485936 15.3208 0.9026 15.1029 1.19621L15.0303 1.28033L8.53033 7.78033C8.26406 8.0466 7.8474 8.0708 7.55379 7.85295L7.46967 7.78033L0.96967 1.28033C0.676777 0.987437 0.676777 0.512563 0.96967 0.21967Z"
                                                            fill="#00918A" />
                                                    </svg>
                                                </div>
                                            </header>
                                            <div class="dropdownContent">
                                                <div class="availabilityGrid">
                                                    <div class="availabilityGridRow headerRow">
                                                        <div class="availabilityGridCell"></div>
                                                        <div class="availabilityGridCell">12am-5am</div>
                                                        <div class="availabilityGridCell">6am-11am</div>
                                                        <div class="availabilityGridCell">12pm-5pm</div>
                                                        <div class="availabilityGridCell">6pm-11pm</div>
                                                    </div>

                                                    <div class="availabilityGridRow">
                                                        <div class="availabilityGridCell">Mon</div>
                                                        <div class="availabilityGridCell"><input type="checkbox"
                                                                name="availability" value="1-12am5am">
                                                        </div>
                                                        <div class="availabilityGridCell"><input type="checkbox"
                                                                name="availability" value="1-6am11am">
                                                        </div>
                                                        <div class="availabilityGridCell"><input type="checkbox"
                                                                name="availability" value="1-12pm5pm">
                                                        </div>
                                                        <div class="availabilityGridCell"><input type="checkbox"
                                                                name="availability" value="1-6pm11pm">
                                                        </div>
                                                    </div>
                                                    <div class="availabilityGridRow">
                                                        <div class="availabilityGridCell">Tue</div>
                                                        <div class="availabilityGridCell"><input type="checkbox"
                                                                name="availability" value="2-12am5am"></div>
                                                        <div class="availabilityGridCell"><input type="checkbox"
                                                                name="availability" value="2-6am11am">
                                                        </div>
                                                        <div class="availabilityGridCell"><input type="checkbox"
                                                                name="availability" value="2-12pm5pm">
                                                        </div>
                                                        <div class="availabilityGridCell"><input type="checkbox"
                                                                name="availability" value="2-6pm11pm">
                                                        </div>

                                                    </div>
                                                    <div class="availabilityGridRow">
                                                        <div class="availabilityGridCell">Wed</div>
                                                        <div class="availabilityGridCell"><input type="checkbox"
                                                                name="availability" value="3-12am5am"></div>
                                                        <div class="availabilityGridCell"><input type="checkbox"
                                                                name="availability" value="3-6am11am"></div>
                                                        <div class="availabilityGridCell"><input type="checkbox"
                                                                name="availability" value="3-12pm5pm"></div>
                                                        <div class="availabilityGridCell"><input type="checkbox"
                                                                name="availability" value="3-6pm11pm">
                                                        </div>
                                                    </div>
                                                    <div class="availabilityGridRow">
                                                        <div class="availabilityGridCell">Thur</div>
                                                        <div class="availabilityGridCell"><input type="checkbox"
                                                                name="availability" value="4-12am5am"></div>
                                                        <div class="availabilityGridCell"><input type="checkbox"
                                                                name="availability" value="4-6am11am">
                                                        </div>
                                                        <div class="availabilityGridCell"><input type="checkbox"
                                                                name="availability" value="4-12pm5pm">
                                                        </div>
                                                        <div class="availabilityGridCell"><input type="checkbox"
                                                                name="availability" value="4-6pm11pm">
                                                        </div>
                                                    </div>
                                                    <div class="availabilityGridRow">
                                                        <div class="availabilityGridCell">Fri</div>
                                                        <div class="availabilityGridCell"><input type="checkbox"
                                                                name="availability" value="5-12am5am"></div>
                                                        <div class="availabilityGridCell"><input type="checkbox"
                                                                name="availability" value="5-6am11am"></div>
                                                        <div class="availabilityGridCell"><input type="checkbox"
                                                                name="availability" value="5-12pm5pm">
                                                        </div>
                                                        <div class="availabilityGridCell"><input type="checkbox"
                                                                name="availability" value="5-6pm11pm">
                                                        </div>

                                                    </div>
                                                    <div class="availabilityGridRow">
                                                        <div class="availabilityGridCell">Sat</div>
                                                        <div class="availabilityGridCell"><input type="checkbox"
                                                                name="availability" value="6-12am5am"></div>
                                                        <div class="availabilityGridCell"><input type="checkbox"
                                                                name="availability" value="6-6am11am"></div>
                                                        <div class="availabilityGridCell"><input type="checkbox"
                                                                name="availability" value="6-12pm5pm">
                                                        </div>

                                                        <div class="availabilityGridCell"><input type="checkbox"
                                                                name="availability" value="6-6pm11pm">
                                                        </div>

                                                    </div>
                                                    <div class="availabilityGridRow">
                                                        <div class="availabilityGridCell">Sun</div>
                                                        <div class="availabilityGridCell"><input type="checkbox"
                                                                name="availability" value="7-12am5am"></div>
                                                        <div class="availabilityGridCell"><input type="checkbox"
                                                                name="availability" value="7-6am11am"></div>
                                                        <div class="availabilityGridCell"><input type="checkbox"
                                                                name="availability" value="7-12pm5pm">
                                                        </div>
                                                        <div class="availabilityGridCell"><input type="checkbox"
                                                                name="availability" value="7-6pm11pm">
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <footer class="dropdownFooter"><button type="button"
                                                    class="applyButton css-16s8ewt button2">Apply filters</button>
                                                    <button data-href="{{url('/find-tutor')}}" class="resetLink">Clear filters</button>
                                            </footer>
                                        </section>
                                    </div>
                                    <style data-emotion="css lod8fa">
                                        #dropdownContainer {
                                            display: none;
                                        }

                                        .css-lod8fa {
                                            width: 100%;
                                            position: relative;
                                        }

                                        .css-lod8fa .dropdownTriggerButton {
                                            border: 1px solid #CCCCCC;
                                            background-color: #FFFFFF;
                                            text-align: left;
                                            font-size: 14px;
                                            border-radius: 4px;
                                            height: 48px;
                                            padding: 12px 16px 12px 8px;
                                            display: grid;
                                            grid-template-columns: 1fr 20px;
                                            -webkit-align-items: center;
                                            -webkit-box-align: center;
                                            -ms-flex-align: center;
                                            align-items: center;
                                            -webkit-box-pack: start;
                                            -ms-flex-pack: start;
                                            -webkit-justify-content: flex-start;
                                            justify-content: flex-start;
                                            overflow: hidden;
                                            width: 100%;
                                            -webkit-transition: 0.4s;
                                            transition: 0.4s;
                                            text-transform: capitalize;
                                        }

                                        .css-lod8fa .dropdownTriggerButton:hover,
                                        .css-lod8fa .dropdownTriggerButton:focus {
                                            border: 1px #abff00 solid;
                                            outline: none;
                                        }

                                        .css-lod8fa .dropdownTriggerButton .triggerButtonText {
                                            color: #333333;
                                            font-family: "FoundersGrotesk", sans-serif;
                                            font-weight: 500;
                                            font-size: 16px;
                                            height: -webkit-fit-content;
                                            height: -moz-fit-content;
                                            height: fit-content;
                                            display: -webkit-box;
                                            display: -webkit-flex;
                                            display: -ms-flexbox;
                                            display: flex;
                                            -webkit-box-pack: start;
                                            -ms-flex-pack: start;
                                            -webkit-justify-content: flex-start;
                                            justify-content: flex-start;
                                            -webkit-box-flex-wrap: nowrap;
                                            -webkit-flex-wrap: nowrap;
                                            -ms-flex-wrap: nowrap;
                                            flex-wrap: nowrap;
                                            overflow: hidden;
                                            width: 100%;
                                        }

                                        .css-lod8fa .dropdownTriggerButton .triggerButtonText>p {
                                            color: #333333;
                                        }

                                        .css-lod8fa .dropdownContainer {
                                            background-color: #FFFFFF;
                                            box-shadow: 0 6px 6px hsla(0, 0%, 50%, 0.5);
                                            max-width: 200%;
                                            padding: 1em;
                                            width: 100vw;
                                            height: 100vh;
                                            top: 0;
                                            left: 0;
                                            position: fixed;
                                            z-index: 2147483002;
                                            display: grid;
                                            grid-template-rows: 40px minmax(0, 1fr) 90px;
                                            -webkit-align-items: flex-start;
                                            -webkit-box-align: flex-start;
                                            -ms-flex-align: flex-start;
                                            align-items: flex-start;
                                        }

                                        @media (min-width: 766px) {
                                            .css-lod8fa .dropdownContainer {
                                                position: absolute;
                                                width: 100%;
                                                min-width: 385px;
                                                height: auto;
                                                max-width: 50vw;
                                                top: 100%;
                                                left: 1px;
                                                display: block;
                                            }
                                        }

                                        @media (min-width: 992px) {
                                            .css-lod8fa .dropdownContainer {
                                                max-width: 70vw;
                                            }
                                        }

                                        .css-lod8fa .dropdownContainerHidden {
                                            display: none;
                                        }

                                        .css-lod8fa .dropdownFooter {
                                            display: grid;
                                            grid-template-columns: 1fr;
                                            row-gap: 10px;
                                            justify-items: center;
                                            -webkit-align-items: center;
                                            -webkit-box-align: center;
                                            -ms-flex-align: center;
                                            align-items: center;
                                        }

                                        @media (min-width: 766px) {
                                            .css-lod8fa .dropdownFooter {
                                                row-gap: 0;
                                                grid-template-columns: 1fr 1fr;
                                            }
                                        }

                                        .css-lod8fa .dropdownFooter .resetLink {
                                            display: inline-block;
                                            font-family: "FoundersGrotesk", sans-serif;
                                            margin: 0 auto;
                                            padding: 0.25em;
                                            font-size: 16px;
                                            font-weight: 500;
                                            cursor: pointer;
                                            color: #abff00;
                                            border: none;
                                            background: none;
                                            outline: 0;
                                        }

                                        .css-lod8fa .mobileHeading {
                                            display: grid;
                                            grid-template-columns: 60px 1fr 60px;
                                            -webkit-box-pack: center;
                                            -ms-flex-pack: center;
                                            -webkit-justify-content: center;
                                            justify-content: center;
                                            -webkit-align-items: center;
                                            -webkit-box-align: center;
                                            -ms-flex-align: center;
                                            align-items: center;
                                            font-size: 18px;
                                            font-weight: 500;
                                        }

                                        @media (min-width: 766px) {
                                            .css-lod8fa .mobileHeading {
                                                display: none;
                                            }
                                        }

                                        .css-lod8fa .mobileHeading h2 {
                                            grid-column: 2;
                                            text-align: center;
                                            margin: 0;
                                            font-size: 22px;
                                        }

                                        .css-lod8fa .mobileHeading .filterClose {
                                            grid-column: 3;
                                            justify-self: flex-end;
                                            position: static;
                                            margin: 0;
                                        }

                                        .css-lod8fa .availabilityGrid {
                                            display: grid;
                                            grid-template-rows: 24px;
                                            row-gap: 10px;
                                            padding: 0 0 20px 0;
                                        }

                                        .css-lod8fa .availabilityGrid .headerRow {
                                            white-space: nowrap;
                                        }

                                        .css-lod8fa .availabilityGrid .availabilityGridRow {
                                            display: grid;
                                            grid-template-columns: 45px 80px 80px 80px 80px;
                                            justify-items: center;
                                            font-size: 14px;
                                        }

                                        .css-lod8fa .availabilityGrid .availabilityGridRow div:first-of-type {
                                            justify-self: flex-start;
                                            font-weight: 500;
                                        }

                                        .css-lod8fa .availabilityGrid .availabilityGridRow input[type="checkbox"] {
                                            -webkit-transition: all 0.15s cubic-bezier(0, 1.05, 0.72, 1.07);
                                            transition: all 0.15s cubic-bezier(0, 1.05, 0.72, 1.07);
                                            border-radius: 0.25em;
                                            border: 1px solid #ebded5;
                                            width: 18px;
                                            height: 18px;
                                            color: #FFFFFF;
                                        }

                                        .css-lod8fa .availabilityGrid .availabilityGridRow input[type="checkbox"]:checked,
                                        .css-lod8fa .availabilityGrid .availabilityGridRow input[type="checkbox"]:checked:hover {
                                            accent-color: #abff00;
                                            color: #FFFFFF;
                                        }

                                        .css-lod8fa .availabilityGrid .availabilityGridRow input[type="checkbox"]:hover,
                                        .css-lod8fa .availabilityGrid .availabilityGridRow input[type="checkbox"]:focus {
                                            border-color: #abff00;
                                        }

                                        .css-lod8fa .applyButton {
                                            font-size: 1rem;
                                            font-weight: 500;
                                        }
                                    </style>
                                </div>
                                <div class="check my-2">
                                    <label for="">
                                        <h5>Choose subjects</h5>
                                    </label>

                                    <div class="mx-3">
                                        @if (!empty($Subjects))
                                            @foreach ($Subjects as $Subject)
                                                <?php $Subject_id = App\Models\Subject::where('name', $Subject)
                                                    ->join('tutor_subject_offers', 'tutor_subject_offers.subject_id', '=', 'subjects.id')
                                                    ->first();
                                                ?>
                                                @if ($Subject_id)
                                                    <input type="checkbox" id="checksubject{{ $Subject_id->subject_id }}"
                                                        class="checkbox1" value="{{ $Subject_id->subject_id }}"
                                                        data-name="{{ $Subject }}">
                                                    <label for="checksubject{{ $Subject_id->subject_id }}"
                                                        class="mx-2">{{ $Subject }}</label><br>
                                                @endif
                                            @endforeach
                                        @endif
                                    </div>

                                    <div class="d-grid findButton  py-2">
                                        <button class="btn py-2" type="button" id="bg-btn-action"><b>Load
                                                more</b></button>
                                    </div>
                                </div>
                                <div class="range my-2">
                                    <label for="">
                                        <h5>Price</h5>
                                    </label>
                                    <div class="range-input">
                                        <input type="number" placeholder="Min Price "
                                            value="{{ $_GET['min_price'] ?? '' }}" name="fee" id="min_price"
                                            class="form form-control mx-1 " id="outline-remove">
                                        <input type="number" placeholder="Max Price"
                                            value="{{ $_GET['max_price'] ?? '' }}" name="fee" id="max_price"
                                            class="form form-control  " id="outline-remove">
                                    </div>
                                </div>
                                {{-- <div class="rating my-2 ">
                                    <label for="">
                                        <h5>Rating</h5>
                                    </label>

                                    <div class="single-rating mx-3 d-flex align-items-baseline ">
                                        <input type="checkbox">
                                        <label class="d-flex align-items-baseline">
                                            <img src="./assets/images/full_star.png" alt=""
                                                class="img-fluid mx-2 w-75 h-75" style="margin-top: -10px;">
                                            <img src="./assets/images/full_star.png" alt=""
                                                class="img-fluid w-75 h-75" width="" style="margin-top: -10px;">
                                            <img src="./assets/images/full_star.png" alt=""
                                                class="img-fluid mx-2 w-75 h-75" width=""
                                                style="margin-top: -10px;">
                                            <img src="./assets/images/full_star.png" alt=""
                                                class="img-fluid w-75 h-75" width="" style="margin-top: -10px;">
                                            <img src="./assets/images/full_star.png" alt=""
                                                class="img-fluid mx-2 w-75 h-75" width=""
                                                style="margin-top: -10px;">

                                            <span>5.0/5.0</span>
                                        </label>

                                    </div>
                                    <div class="single-rating mx-3 d-flex align-items-baseline ">
                                        <input type="checkbox">
                                        <label class="d-flex align-items-baseline">
                                            <img src="./assets/images/full_star.png" alt=""
                                                class="img-fluid mx-2 w-75 h-75" style="margin-top: -10px;">
                                            <img src="./assets/images/full_star.png" alt=""
                                                class="img-fluid w-75 h-75" width="" style="margin-top: -10px;">
                                            <img src="./assets/images/full_star.png" alt=""
                                                class="img-fluid mx-2 w-75 h-75" width=""
                                                style="margin-top: -10px;">
                                            <img src="./assets/images/full_star.png" alt=""
                                                class="img-fluid w-75 h-75" width="" style="margin-top: -10px;">
                                            <img src="./assets/images/full_star.png" alt=""
                                                class="img-fluid mx-2 w-75 h-75" width=""
                                                style="margin-top: -10px;">

                                            <span>4.0//5.0</span>
                                        </label>

                                    </div>
                                    <div class="single-rating mx-3 d-flex align-items-baseline ">
                                        <input type="checkbox">
                                        <label class="d-flex align-items-baseline">
                                            <img src="./assets/images/full_star.png" alt=""
                                                class="img-fluid mx-2 w-75 h-75" style="margin-top: -10px;">
                                            <img src="./assets/images/full_star.png" alt=""
                                                class="img-fluid w-75 h-75" width="" style="margin-top: -10px;">
                                            <img src="./assets/images/full_star.png" alt=""
                                                class="img-fluid mx-2 w-75 h-75" width=""
                                                style="margin-top: -10px;">
                                            <img src="./assets/images/full_star.png" alt=""
                                                class="img-fluid w-75 h-75" width="" style="margin-top: -10px;">
                                            <img src="./assets/images/full_star.png" alt=""
                                                class="img-fluid mx-2 w-75 h-75" width=""
                                                style="margin-top: -10px;">

                                            <span>3.0/5.0</span>
                                        </label>

                                    </div>
                                    <div class="single-rating mx-3 d-flex align-items-baseline ">
                                        <input type="checkbox">
                                        <label class="d-flex align-items-baseline">
                                            <img src="./assets/images/full_star.png" alt=""
                                                class="img-fluid mx-2 w-75 h-75" style="margin-top: -10px;">
                                            <img src="./assets/images/full_star.png" alt=""
                                                class="img-fluid w-75 h-75" width="" style="margin-top: -10px;">
                                            <img src="./assets/images/full_star.png" alt=""
                                                class="img-fluid mx-2 w-75 h-75" width=""
                                                style="margin-top: -10px;">
                                            <img src="./assets/images/full_star.png" alt=""
                                                class="img-fluid w-75 h-75" width="" style="margin-top: -10px;">
                                            <img src="./assets/images/full_star.png" alt=""
                                                class="img-fluid mx-2 w-75 h-75" width=""
                                                style="margin-top: -10px;">

                                            <span>2.0/5.0</span>
                                        </label>

                                    </div>
                                    <div class="single-rating mx-3 d-flex align-items-baseline ">
                                        <input type="checkbox">
                                        <label class="d-flex align-items-baseline">
                                            <img src="./assets/images/full_star.png" alt=""
                                                class="img-fluid mx-2 w-75 h-75" style="margin-top: -10px;">
                                            <img src="./assets/images/full_star.png" alt=""
                                                class="img-fluid w-75 h-75" width="" style="margin-top: -10px;">
                                            <img src="./assets/images/full_star.png" alt=""
                                                class="img-fluid mx-2 w-75 h-75" width=""
                                                style="margin-top: -10px;">
                                            <img src="./assets/images/full_star.png" alt=""
                                                class="img-fluid w-75 h-75" width="" style="margin-top: -10px;">
                                            <img src="./assets/images/full_star.png" alt=""
                                                class="img-fluid mx-2 w-75 h-75" width=""
                                                style="margin-top: -10px;">

                                            <span>1.0/5.0</span>
                                        </label>
                                    </div>
                                </div> --}}

                                <div class="location my-2">
                                    <label for="">
                                        <h5>Location</h5>
                                    </label>

                                    <div class="location-content ">
                                        <input type="text" class="form-control zipcode" value="" name="zipcode"
                                            id="outline-remove" style=" height: 50px; " placeholder="Enter zipcode ">

                                    </div>

                                </div>

                                <div class="mb-2">
                                    <div class="row">
                                        <h5> Miscellaneous</h5>
                                    </div>
                                    <div class="single-rating mx-2 py-1">
                                        <input type="radio" class="mx-2" name="only" value="Male"
                                            class="checkbox2">
                                        Male
                                    </div>

                                    <div class="single-rating mx-2 py-1">
                                        <input type="radio" class="mx-2" name="only" value="Female"
                                            class="checkbox2">
                                        Female
                                    </div>
                                    <div class="single-rating mx-2 py-1">
                                        <input type="radio" class="mx-2" name="only" value="Any"
                                            class="checkbox2">
                                        Any
                                    </div>
                                </div>


                                <div class="filters-btn d-none">

                                    <div class="d-grid py-2">
                                        <button class="btn py-2" type="button" id="bg-btn-action"><b>Filter</b></button>
                                    </div>

                                    <button class="btn w-100 filter-clear" type="button"><b>Clear</b></button>

                                </div>


                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8 col-12" id="TutorSubjectOffer">
                        @if (!empty($TutorSubjectOffers))
                            @foreach ($TutorSubjectOffers as $tutor)
                                @php
                                    $imagePath = public_path(!empty($tutor->tutor)?$tutor->tutor->image:'');
                                @endphp
                                <input type="hidden"
                                    value="{{ !empty($TutorSubjectOffers->total()) ? $TutorSubjectOffers->total() : '0' }}"
                                    id="checkcount">
                                <div class="row py-3 ms-1 me-3 m-md-1">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-3 col-lg-4 col-xl-3">
                                                @if (!empty($tutor->tutor->image) && file_exists($imagePath))
                                                    <img src="{{ $tutor->tutor->image }}" alt=""
                                                        class="w-100 h-100">
                                                @else
                                                    <img src="{{ asset('assets/images/default.png') }}" alt=""
                                                        class="w-100">
                                                @endif
                                            </div>
                                            <div class="col-md-9 col-lg-8 col-xl-9 justify-content-lg-start mt-4 mt-md-0">
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="d-flex justify-content-between pb-1">

                                                            <div class="d-flex align-items-center text-capitalize">
                                                                <h3>{{ !empty($tutor->tutor) ? $tutor->tutor->first_name . ' ' . $tutor->tutor->last_name : '' }}</h3>
                                                                <img src="./assets/images/Verified-p.png"
                                                                    class="correctiocn mx-1" alt="">
                                                            </div>
                                                            <div class="d-sm-block d-md-none">
                                                                <img src="./assets/images/Icon4.png" alt="">
                                                                Saved
                                                            </div>
                                                        </div>
                                                        <p>Spreading knowledge everywhere that's all I do</p>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="row">
                                                            {{-- <span>Starting from:</span> --}}
                                                            <div class="dollor text-end pe-3">
                                                                <span class="fs-3"><strong>£{{ $tutor->fee }}</strong> /hr</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="d-flex py-ld-3">
                                                    <p class="one px-5 py-2 alert alert-{{ !empty($tutor->tutor) && $tutor->tutor->status == 'Active' ? 'success' : 'danger' }}">
                                                        {{ !empty($tutor->tutor) ? $tutor->tutor->status : 'Pending' }}
                                                    </p>

                                                </div>
                                                <div class="row align-items-center mt-2">
                                                    <a class="col-xl-2 col-md-3 d-none d-md-block"
                                                    href="{{ url('likeDislike?tutor=') . (!empty($tutor->tutor) ? $tutor->tutor->id : '') }}"
                                                    style="text-decoration: none;color: inherit;">
                                                     @php
                                                         $tutorId = !empty($tutor->tutor) ? $tutor->tutor->id : '';
                                                         $action = App\Models\LikeDislike::where('to_user_id', $tutorId)
                                                             ->where('from_user_id', Auth::id())
                                                             ->first();
                                                     @endphp
                                                     @if (!empty($action) && $action->action == '1')
                                                         <span class="text-danger">❤</span>
                                                     @else
                                                         <span class="text-default">❤</span>
                                                     @endif
                                                     Saved
                                                 </a>

                                                    <div
                                                        class="col-xl-10 col-md-9 d-flex justify-content-center justify-content-md-end ">
                                                        <a href=""
                                                            class="btn button1 text-center border-1"><b>Let’s
                                                                chat</b></a>
                                                        <a href="{{ url('tutor_profiles?offer=' . $tutor->id) }}"
                                                            class="btn button2 mx-1 "><b>View full
                                                                profile</b></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            @endforeach
                            <div class="container mt-5 pt-xl-5">
                                {{ $TutorSubjectOffers->links() }}
                            </div>
                        @endif
                    </div>
                </div>
                {{-- <div class="py-5 mt-5">
                    <div class="text-center speaktutor">
                        <h2>Speak to a Tutor and get Tuition Sorted Today</h2>
                    </div>
                    <div class="text-center findButton mt-4">
                        <a type="button" class="btn fw-bold px-4 py-2">Find a Tutor</a>
                    </div>

                </div> --}}
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            var selectedCriteria = [];
            var checkcountValue = '0';
            var selectedValues = [];
            var subject = {!! json_encode(!empty($_GET['subject']) ? $_GET['subject'] : '') !!};
            $('#search, .zipcode, .Education_level, .checkbox1, input[name="only"], #max_price, #min_price, #dropdown-item, .applyButton')
                .on('keyup change click', function() {
                    var sort = $(this).text().trim();
                    var gender = $('input[name="only"]:checked').val();
                    var query = $('#search').val();
                    var zipcode = $('.zipcode').val();
                    var level = $('.Education_level').val();
                    var selectedSubjects = $('.checkbox1:checked').map(function() {
                        return this.value;
                    }).get();
                    var max_price = $('#max_price').val();
                    var min_price = $('#min_price').val();

                    $('input[name="availability"]:checked').each(function() {
                        var valueParts = $(this).val().split('-');
                        var day = valueParts[0];
                        var slot = valueParts[1];
                        selectedValues.push({
                            day: day,
                            slot: slot
                        });
                    });


                    updateSelectedCriteria();

                    $.ajax({
                        url: '{{ url('find-tutor') }}',
                        type: 'GET',
                        data: {
                            query: query,
                            level: level,
                            subjects: selectedSubjects,
                            max_price: max_price,
                            min_price: min_price,
                            sort: sort,
                            zipcode: zipcode,
                            gender: gender,
                            availabilityData: selectedValues,
                            subject: subject,
                        },
                        success: function(data) {
                            $('#TutorSubjectOffer').html(data);
                            $('#search').val(query);
                            $('.Education_level').val(level);
                            $('.zipcode').val(zipcode);

                            var checkcountValue = $('#checkcount').val();
                            var searchResultText = (typeof checkcountValue === 'undefined') ?
                                'undefined' : checkcountValue;
                            if (searchResultText === 'undefined') {
                                searchResultText = '0';
                            }
                            searchResultText += ' Search result in <strong>"' + query +
                                '"</strong> tutors';
                            $('#appendcount').html(searchResultText);

                            getPaginatedData(page, query, level, selectedSubjects, max_price,
                                min_price, sort, zipcode, gender);
                        }
                    });
                });

            $(document).on('click', '.pagination a', function(e) {
                e.preventDefault();
                var sort = $(this).text().trim();
                var zipcode = $('.zipcode').val();
                var gender = $('input[name="only"]:checked').val();
                var page = $(this).attr('href').split('page=')[1];
                var query = $('#search').val();
                var level = $('.Education_level').val();
                var selectedSubjects = $('.checkbox1:checked').map(function() {
                    return this.value;
                }).get();
                var max_price = $('#max_price').val();
                var min_price = $('#min_price').val();
                $('input[name="availability"]:checked').each(function() {
                    var valueParts = $(this).val().split('-');
                    var day = valueParts[0];
                    var slot = valueParts[1];

                    selectedValues.push({
                        day: day,
                        slot: slot
                    });
                });
                updateSelectedCriteria();
                getPaginatedData(page, query, level, selectedSubjects, max_price, min_price, sort, zipcode,
                    gender, selectedValues);
            });

            function getPaginatedData(page, query, level, selectedSubjects, max_price, min_price, sort, zipcode,
                gender, selectedValues) {
                $.ajax({
                    url: '{{ url('find-tutor') }}?page=' + page,
                    type: 'GET',
                    data: {
                        query: query,
                        level: level,
                        subjects: selectedSubjects,
                        max_price: max_price,
                        min_price: min_price,
                        sort: sort,
                        zipcode: zipcode,
                        gender: gender,
                        availabilityData: selectedValues,
                        subject: subject,
                    },
                    success: function(data) {
                        $('#TutorSubjectOffer').html(data);
                        $('#search').val(query);
                        $('.Education_level').val(level);
                        $('.zipcode').val(zipcode);
                        var checkcountValue = $('#checkcount').val();
                        var searchResultText = (typeof checkcountValue === 'undefined') ?
                            'undefined' : checkcountValue;
                        if (searchResultText === 'undefined') {
                            searchResultText = '0';
                        }
                        searchResultText += ' Search result in <strong>"' + query +
                            '"</strong> tutors';
                        $('#appendcount').html(searchResultText);
                    }
                });
            }

            function updateSelectedCriteria() {
                selectedCriteria = [];
                $('.checkbox1:checked').each(function() {
                    selectedCriteria.push(
                        '<a class="py-1 px-3 border-muted border fw-bold rounded-2 text-dark" style="text-decoration: none;">' +
                        '<small>' + $(this).next().text() +
                        '</small> <img src="./assets/images/cross.png"></a>');
                });

                var searchQuery = $('#search').val().trim();
                var zipcode = $('.zipcode').val().trim();
                var selectedLevel = $('.Education_level option:selected').val();
                var selectedLevel1 = $('.Education_level option:selected').text();

                if (searchQuery !== '') {
                    selectedCriteria.push(
                        '<a class="py-1 px-3 border-muted border fw-bold rounded-2 text-dark" style="text-decoration: none;">' +
                        '<small>' + searchQuery + '</small> <img src="./assets/images/cross.png"></a>');
                }
                if (zipcode !== '') {
                    selectedCriteria.push(
                        '<a class="py-1 px-3 border-muted border fw-bold rounded-2 text-dark" style="text-decoration: none;">' +
                        '<small>zipcode: ' + zipcode + '</small> <img src="./assets/images/cross.png"></a>');
                }

                if (selectedLevel1 !== 'All Levels') {
                    selectedCriteria.push(
                        '<a class="py-1 px-3 border-muted border fw-bold rounded-2 text-dark" style="text-decoration: none;">' +
                        '<small>' + selectedLevel1 + '</small> <img src="./assets/images/cross.png"></a>');
                }

                var minPrice = $('#min_price').val();
                var maxPrice = $('#max_price').val();

                if (minPrice !== '') {
                    selectedCriteria.push(
                        '<a class="py-1 px-3 border-muted border fw-bold rounded-2 text-dark" style="text-decoration: none;">' +
                        '<small>Min ' + minPrice + '</small> <img src="./assets/images/cross.png"></a>');
                }

                if (maxPrice !== '') {
                    selectedCriteria.push(
                        '<a class="py-1 px-3 border-muted border fw-bold rounded-2 text-dark" style="text-decoration: none;">' +
                        '<small>Max ' + maxPrice + '</small> <img src="./assets/images/cross.png"></a>');
                }
                var gender = $('input[name="only"]:checked').val();
                if (gender !== undefined) {
                    selectedCriteria.push(
                        '<a class="py-1 px-3 border-muted border fw-bold rounded-2 text-dark" style="text-decoration: none;">' +
                        '<small>' + gender + '</small> <img src="./assets/images/cross.png"></a>'
                    );
                }

                $('#searchbox').html(selectedCriteria.join(' '));
            }



        });
        $(document).on('click', '#searchbox a img', function() {
            var parentAnchor = $(this).parent();
            parentAnchor.remove();
            var remover = parentAnchor.text().trim();
            var min_price = $('#min_price').val().trim();
            var max_price = $('#max_price').val().trim();
            var query = $('#search').val();
            var zipcode = $('.zipcode').val().trim();
            var gender = $('input[name="only"]:checked').val();
            var selectedSubjects = $('.checkbox1:checked').map(function() {
                if ($(this).data("name") !== remover) {
                    return this.value;
                }
            }).get();

            if (remover === gender) {
                $('input[name="only"]:checked').prop('checked', false);
            }

            if (remover === query) {
                var query = $('#search').val('');
            }
            var newText0 = remover.replace(/\bzipcode: \s*/g, "");
            if (newText0 === zipcode) {
                var zipcode = $('.zipcode').val('');
            }
            var newText1 = remover.replace(/\bMin\s*/g, "");
            if (newText1 === min_price) {
                var min_price = $('#min_price').val('');
            }
            var newText2 = remover.replace(/\bMax\s*/g, "");
            if (newText2 === max_price) {
                var max_price = $('#max_price').val('');
            }

            $('.Education_level option:selected').each(function() {
                if ($(this).data("level") === remover) {
                    this.selected = false;
                }
            });

            $('.checkbox1:checked').each(function() {
                if ($(this).data("name") === remover) {
                    this.checked = false;
                }
            });
            if (remover === level) {
                var level = $('.Education_level').val('');
            }


            $.ajax({
                url: '{{ url('find-tutor') }}',
                type: 'GET',
                data: {
                    query: query,
                    max_price: max_price,
                    min_price: min_price,
                    zipcode: zipcode,
                    subjects: selectedSubjects,
                    subject: subject,

                },
                success: function(data) {
                    $('#TutorSubjectOffer').html(data);
                    updateSelectedCriteria();
                    var checkcountValue = $('#checkcount').val();
                    var searchResultText = (typeof checkcountValue === 'undefined') ?
                        'undefined' : checkcountValue;
                    if (searchResultText === 'undefined') {
                        searchResultText = '0';
                    }
                    searchResultText += ' Search result in <strong>"' + query +
                        '"</strong> tutors';
                    $('#appendcount').html(searchResultText);
                }
            });
            updateSelectedCriteria();
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const button = document.querySelector(".dropdownTriggerButton");
            const dropdown = document.querySelector(".dropdownContainer");
            const applyButton = document.querySelector(".applyButton");

            button.addEventListener("click", function() {
                dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";
            });

            applyButton.addEventListener("click", function() {
                dropdown.style.display = "none"; // Close the dropdown
            });
        });
    </script>


@endsection
