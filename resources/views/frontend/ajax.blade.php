 @if (!empty($TutorSubjectOffers))
                            @foreach ($TutorSubjectOffers->unique('id') as $tutor)
                                <input type="hidden"
                                    value="{{ !empty($TutorSubjectOffers->total()) ? $TutorSubjectOffers->total() : '0' }}"
                                    id="checkcount">
                                <div class="row py-3 ms-1 me-3 m-md-1" style="border-bottom: 1px  dotted #d5d4d4; ">
                                    <div class="col-md-12">
                                        <div class="row ">
                                            <div class="col-md-3 col-lg-4 col-xl-3 ">
                                                @if (!empty($tutor->image) && file_exists(public_path(!empty($tutor->image) ? $tutor->image : '')))
                                                    <img src="{{ $tutor->image }}" alt=""
                                                        style="    width:100%;height: 140px;" class="rounded-3">
                                                @else
                                                    @if ($tutor->gender == 'Male')
                                                        <img src="{{ asset('assets/images/male.jpg') }}" alt=""
                                                            style="    width:100%;height: 140px;" class="rounded-3">
                                                    @elseif($tutor->gender == 'Female')
                                                        <img src="{{ asset('assets/images/female.jpg') }}" alt=""
                                                            style="    width:100%;height: 140px;" class="rounded-3">
                                                    @else
                                                        <img src="{{ asset('assets/images/default.png') }}"
                                                            alt=""
                                                            style="    width:100%;height: 140px;" class="rounded-3">
                                                    @endif
                                                @endif
                                            </div>
                                            <div
                                                class="col-md-9 col-lg-8 col-xl-9 justify-content-lg-start mt-4 mt-md-0 pt-3">
                                                <div class="row">
                                                    <div class="col-md-7">
                                                        <div class="d-flex justify-content-between pb-1">

                                                            <div class="d-flex align-items-center text-capitalize">
                                                                <h4 class=" mb-0 d-none d-md-inline-block">{{ !empty($tutor) ? $tutor->username : '' }}
                                                                </h4>
                                                                <h5 class="mb-0 d-md-none">{{ !empty($tutor) ? $tutor->username : '' }}</h5>
                                                                <img src="./assets/images/Verified-p.png"
                                                                    class="correctiocn mx-1" alt="">
                                                            </div>
                                                            <div class="d-sm-block d-md-none">
                                                              <a
                                                        href="{{ url('likeDislike?tutor=') . (!empty($tutor) ? $tutor->id : '') }}"
                                                        style="text-decoration: none;color: inherit;">
                                                                  @php
                                                            $tutorId = !empty($tutor) ? $tutor->id : '';
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
                                                            </div>
                                                        </div>
                                                        <h6 style="font-weight: 500;color:#3d3d3d;">
                                                            {{ $tutor->facebook_link }}</h6>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <div class="row" style="text-align:inline-end;">

                                                            <div class="col-12 dollor text-end pe-3 d-none d-md-inline-block">

                                                                @if (
                                                                    \App\Models\TutorSubjectOffer::where('tutor_id', $tutor->id)->max('fee') != 0 &&
                                                                        \App\Models\TutorSubjectOffer::where('tutor_id', $tutor->id)->min('fee') != 0 &&
                                                                        \App\Models\TutorSubjectOffer::where('tutor_id', $tutor->id)->min('fee') !=
                                                                            \App\Models\TutorSubjectOffer::where('tutor_id', $tutor->id)->max('fee'))
                                                                    <span
                                                                        class="fs-4"><strong>£{{ \App\Models\TutorSubjectOffer::where('tutor_id', $tutor->id)->min('fee') ?? '' }}-{{ \App\Models\TutorSubjectOffer::where('tutor_id', $tutor->id)->max('fee') ?? '' }}</strong>
                                                                        /hr</span>
                                                                @else
                                                                    <span
                                                                        class="fs-4"><strong>£{{ \App\Models\TutorSubjectOffer::where('tutor_id', $tutor->id)->max('fee') ?? '' }}</strong>
                                                                        /hr</span>
                                                                @endif

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="d-flex py-ld-3 align-items-center justify-content-between">
                                                    <p class="d-none d-md-inline-block one px-5 py-2 alert alert-{{ !empty($tutor) && $tutor->status == 'Active' ? 'success' : 'danger' }}">
                                                        {{ !empty($tutor) ? $tutor->status : 'Pending' }}
                                                    </p>
                                                    <p class="d-md-none one px-4 py-1 alert alert-{{ !empty($tutor) && $tutor->status == 'Active' ? 'success' : 'danger' }}">
                                                        {{ !empty($tutor) ? $tutor->status : 'Pending' }}
                                                    </p>
                                                    <div class="dollor text-end pe-3 d-md-none">
                                                        @if (
                                                            \App\Models\TutorSubjectOffer::where('tutor_id', $tutor->id)->max('fee') != 0 &&
                                                                \App\Models\TutorSubjectOffer::where('tutor_id', $tutor->id)->min('fee') != 0 &&
                                                                \App\Models\TutorSubjectOffer::where('tutor_id', $tutor->id)->min('fee') !=
                                                                    \App\Models\TutorSubjectOffer::where('tutor_id', $tutor->id)->max('fee'))
                                                            <span
                                                                class="fs-6"><strong>£{{ \App\Models\TutorSubjectOffer::where('tutor_id', $tutor->id)->min('fee') ?? '' }}-{{ \App\Models\TutorSubjectOffer::where('tutor_id', $tutor->id)->max('fee') ?? '' }}</strong>
                                                                /hr</span>
                                                        @else
                                                            <span
                                                                class="fs-5"><strong>£{{ \App\Models\TutorSubjectOffer::where('tutor_id', $tutor->id)->max('fee') ?? '' }}</strong>
                                                                /hr</span>
                                                        @endif
                                                    </div>

                                                </div>
                                                <div class="row align-items-center mt-2">
                                                    <a class="col-xl-2 col-md-3 d-none d-md-block"
                                                        href="{{ url('likeDislike?tutor=') . (!empty($tutor) ? $tutor->id : '') }}"
                                                        style="text-decoration: none;color: inherit;">
                                                        @php
                                                            $tutorId = !empty($tutor) ? $tutor->id : '';
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

                                                    <div class="col-xl-10 col-md-9 d-flex justify-content-md-end ">
                                                        <a href="{{ url('chat' . '/' . $tutor->id) }}"
                                                            class="btn button1 text-center border-1"><b>Let’s
                                                                chat</b></a>
                                                        <a href="{{ url('tutor/profile' . '/' . $tutor->id) }}"
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