@extends('pages.dashboard.appstudent')

@section('content')
    @if (Auth::check())
        @if (Auth::user()->role_id == '4')
            @include('layouts.studentnav')
        @elseif (Auth::user()->role_id == '3')
            @include('layouts.tutornav')
        @elseif (Auth::user()->role_id == '5')
            @include('layouts.parentnav')
        @elseif (Auth::user()->role_id == '1' || Auth::user()->role_id == '2')
            @include('layouts.navbar')
        @endif
    @else
        @include('layouts.navbar')
    @endif
    <script src="{{ URL::asset('assets/sweetalert2/sweetalert2.min.js') }}"></script>
    <link href="{{ URL::asset('assets/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    <style>
        .chat-sec {
            height: 100vh;
        }

        .cont-text {
            max-width: fit-content;
            border: 1px solid rgb(249, 248, 248);
            padding: 5px 15px;
            /* font-size: 12px; */
            /* font-weight: bold; */
            background-color: rgb(243, 240, 232);

        }

        .chat-container {
            overflow-y: scroll;
            overflow-x: hidden;
        }

        .chat-container span {
            font-size: 14px;
            color: rgb(185, 185, 185);
        }

        /* width */
        ::-webkit-scrollbar {
            width: 0px;
        }

        /* Track */
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
    </style>
    <script src="{{ asset('js/jsdelivrcore.js') }}"></script>
    <script src="{{ asset('js/jsdelivr.js') }}"></script>

    <div class="container mt-3 chat-sec">
        <div class="row   " style="height: 90vh;">
            <div class="col-md-9 border border-secondary border-opacity-10 h-100">
                <a href="{{ url('tutor/messages') }}" class="btn btn-outline-success mt-3 btn-sm"><i
                        class="fa-solid fa-arrow-left" style="padding-right: 5px;"></i>Back</a>
                <div class="cont-parts mt-3 sidebar chat-container" id="chat" style="height: 69%;">
                    @if (!empty($chats))
                        @foreach ($chats as $chat)
                            @php $inputDatetime = new DateTime($chat->created_at); @endphp
                            @if ($chat->sender_id == Auth::id())
                                {{-- me --}}

                                <div class="row justify-content-end">
                                    <div class="col-4 col-lg-3">
                                        <span class="text-capitalize">{{ App\Models\User::find($chat->sender_id)->username }}</span>

                                        <span class="text-capitalize">{{ $inputDatetime->format('D, j M y:H:i') }}</span>

                                        <h6 class="mt-2 cont-text me-3" style="float: right"> {!! $chat->message !!}</h6>
                                    </div>
                                </div>
                            @else
                                {{-- you --}}
                                <div class="row">
                                    <div class=" col-4 col-lg-3">
                                        <span class="text-capitalize">{{ App\Models\User::find($chat->sender_id)->username }}</span>

                                        <span class="text-capitalize">{{ $inputDatetime->format('D, j M y:H:i') }}</span>

                                        <h6 class="mt-2 cont-text text-center me"> {!! $chat->message !!}</h6>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @endif
                </div>
                <form id="chat-form">
                    @csrf
                    <div class="input-group " style="border-top:1px solid gainsboro  ;">
                        <input type="hidden" name="reciver_id" value="{{ $id }}" id="username">
                        <input type="text" name="message" id="message" class="form-control my-3" required placeholder=""
                            aria-label="Recipient's username" aria-describedby="button-addon2" oninput="checkInput()" autofocus>
                        <span id="errorText" style="color: red;"></span>
                        <button class="btn btn-outline-success my-3 mx-2" type="submit" id="button-addon2">Send</button>
                    </div>
                </form>
            </div>
            <!-- second card body -->
            <div class="col-md-3 d-none d-md-inline-block  border border-secondary border-opacity-10 text-center ">
                @if (
                    !empty(App\Models\User::find($id)->image) &&
                        file_exists(public_path(!empty(App\Models\User::find($id)->image) ? App\Models\User::find($id)->image : '')))
                    <img src="{{ asset(App\Models\User::find($id)->image) }}" alt="" class="rounded-circle mt-4"
                       style="width: 80px;height: 80px;border-radius: 50%;border: 1px solid rgb(233, 226, 226);">
                @else

                        @if(App\Models\User::find($id)->gender == 'Male')
                            <img src="{{ asset('assets/images/male.jpg') }}" class="rounded-circle mt-4"
                        style="width: 80px; border: 1px solid rgb(233, 226, 226); ">
                        @elseif(App\Models\User::find($id)->gender == 'Female')
                            <img src="{{ asset('assets/images/female.jpg') }}" class="rounded-circle mt-4"
                        style="width: 80px; border: 1px solid rgb(233, 226, 226); ">
                        @else
                            <img src="{{ asset('assets/images/default.png') }}" class="rounded-circle mt-4"
                        style="width: 80px; border: 1px solid rgb(233, 226, 226); ">
                        @endif
                @endif

                <h5 class="img-name mt-2 text-capitalize" style="color: rgb(104, 224, 164);">
                    {{ App\Models\User::find($id)->username }}
                </h5>

                @if(App\Models\User::find($id)->role_id == '3')
                <p class="img-price fw-bold">&#163;{{ $subject->min('fee') }}-&#163;{{ $subject->max('fee') }}/hr</p>
                @endif
                
                <div class="d-grid gap-2 my-5">
                    @if (Auth::user()->role_id == 4)
                        <a href="{{ url('tutor/book/') . '/' . $id }}" class="btn btn-success" type="button">Book meeting
                        </a>
                    @endif
                </div>



            </div>
        </div>
    </div>




    <script src="{{ asset('vendor/jquery/jquery3.7.0.js') }}"></script>
    <script>
        var authenticatedUserId = <?php echo json_encode(Auth::id()); ?>;
        var username = <?php echo json_encode(Auth::user()->username); ?>;
        var reciverUserId = <?php echo json_encode($id); ?>;

        setInterval(function() {
            refreshchat();
        }, 3000);
        $('#chat-form').submit(function(event) {
            event.preventDefault();

            // Clear the previous error message
            $('#errorText').text('');

            var inputValue = $('#message').val();
            if (!isSafeInput(inputValue) && !isSameAsAuthenticatedUser(inputValue)) {
                showError('Error: Please do not enter email addresses, links, phone numbers, or your own username.');
            } else if (containsPhoneNumber(inputValue)) {
                showError('Error: Please do not enter email addresses, links, phone numbers, or your own username.');
            } else {
                var formData = $(this).serialize();
                $.ajax({
                    url: "{{ url('send/message') }}",
                    type: 'post',
                    data: formData,
                    success: function(response) {
                        if (response.status === 'true') {
                            // location.reload();
                        } else {
                            showError('Error: Something went wrong.');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        showError('Error: Something went wrong!');
                    }
                });
            }
        });

        function refreshchat() {

            $.ajax({
                    url: "{{ url('get/message') }}",
                    type: 'GET',
                    data: {id : reciverUserId},
                    success: function(response) {
                    var chats = response.chats;
                    $('.chat-container').html('');
                    for (let i = 0; i < chats.length; i++) {
                        var chat = chats[i];
                        var inputDatetime = new Date(chats[i].created_at);

                        if (chats[i].sender_id == authenticatedUserId) {
                            var meHtml = `
                                <div class="row justify-content-end">
                                    <div class="col-4 col-lg-3">
                                        <span class="text-capitalize">${chats[i].sender.username}</span>
                                        <span class="text-capitalize">${inputDatetime.toLocaleString()}</span>
                                        <h6 class="mt-2 cont-text me-3" style="float: right">${chats[i].message}</h6>
                                    </div>
                                </div>
                            `;
                            $('.chat-container').append(meHtml);
                        } else {
                            var otherHtml = `
                                <div class="row">
                                    <div class="col-4 col-lg-3">
                                        <span class="text-capitalize">${chats[i].sender.username}</span>
                                        <span class="text-capitalize">${inputDatetime.toLocaleString()}</span>
                                        <h6 class="mt-2 cont-text text-center me">${chats[i].message}</h6>
                                    </div>
                                </div>
                            `;
                            $('.chat-container').append(otherHtml);
                            console.log(otherHtml);
                        }
                     }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        showError('Error: Something went wrong!');
                    }
                });

        }

        function showError(errorMessage) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: errorMessage,
            });
        }

        function isSafeInput(value) {
            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            var linkRegex = /^(http|https):\/\/[^\s]+$/;
            return !emailRegex.test(value) && !linkRegex.test(value);
        }

        function isSameAsAuthenticatedUser(value) {
            return username == value;
        }
        function containsPhoneNumber(message) {
            var phoneRegex = /\b\d{7,25}\b/;
            var phoneRegex = /\b\d{1,3}([.\s-]?\d{3}){2,4}\b/;
            return phoneRegex.test(message);
        }
    </script>


    <script>
        document.getElementById("chat-form").addEventListener("submit", function(event) {
            event.preventDefault();
            document.getElementById("message").value = "";
        });
    </script>

@endsection
