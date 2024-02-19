@extends('layouts.app')
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
    <script src="{{ asset('js/jsdelivrcore.js') }}"></script>
    <script src="{{ asset('js/jsdelivr.js') }}"></script>
    <style>
        * {
            margin: 0px;
            padding: 0px;
            box-sizing: border-box;
        }

        #container {
            width: 100%;
            height: 70vh;
            background: #97a4b4;
            margin: 0 auto;
            font-size: 0;
            overflow: hidden;
        }

        aside {
            width: 25%;
            height: 100vh;
            background-color: #3b3e49;
            /* display:inline-block; */
            display: none;
            font-size: 15px;
            vertical-align: top;
        }

        main {
            width: 100%;
            /* height: 80vh; */
            display: inline-block;
            font-size: 15px;
            vertical-align: top;
        }

        aside header {
            padding: 30px 20px;
        }

        aside input {
            width: 100%;
            height: 50px;
            line-height: 50px;
            padding: 0 50px 0 20px;
            background-color: #5e616a;
            border: none;
            border-radius: 3px;
            color: #fff;
            background-image: url(https://s3-us-west-2.amazonaws.com/s.cdpn.io/1940306/ico_search.png);
            background-repeat: no-repeat;
            background-position: 240px;
            background-size: 40px;
        }

        aside input::placeholder {
            color: #fff;
        }

        aside ul {
            padding-left: 0;
            margin: 0;
            list-style-type: none;
            overflow-y: scroll;
            height: 83vh;
        }

        aside li {
            padding: 10px 0;
        }

        aside li:hover {
            background-color: #5e616a;
        }

        h2,
        h3 {
            margin: 0;
        }

        aside li img {
            border-radius: 50%;
            margin-left: 20px;
            margin-right: 8px;
        }

        aside li div {
            display: inline-block;
            vertical-align: top;
            margin-top: 12px;
        }

        aside li h2 {
            font-size: 14px;
            color: #fff;
            font-weight: normal;
            margin-bottom: 5px;
        }

        aside li h3 {
            font-size: 12px;
            color: #7e818a;
            font-weight: normal;
        }

        .status {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 7px;
        }

        .green {
            background-color: #58b666;
        }

        .orange {
            background-color: #ff725d;
        }

        .blue {
            background-color: #6fbced;
            margin-right: 0;
            margin-left: 7px;
        }

        main header {
            height: 90px;
            padding: 15px 20px 30px 40px;
        }

        main header>* {
            display: inline-block;
            vertical-align: top;
        }

        main header img:first-child {
            border-radius: 50%;
        }

        main header img:last-child {
            width: 24px;
            margin-top: 8px;
            float: right;
        }

        main header div {
            margin-left: 10px;
            margin-right: 145px;
        }

        main header h2 {
            font-size: 16px;
            margin-bottom: 5px;
        }

        main header h3 {
            font-size: 14px;
            font-weight: normal;
            color: #7e818a;
        }

        #chat {
            padding-left: 0;
            margin: 0;
            list-style-type: none;
            overflow-y: scroll;
            /* height: 73vh; */
            border-top: 2px solid #fff;
            border-bottom: 2px solid #fff;
        }

        #chat li {
            padding: 10px 30px;
        }

        #chat h2,
        #chat h3 {
            display: inline-block;
            font-size: 13px;
            font-weight: normal;
        }

        #chat h3 {
            color: #bbb;
        }

        #chat .entete {
            margin-bottom: 5px;
        }

        #chat .message {
            padding: 10px 20px 10px 20px;
            color: #fff;
            line-height: 25px;
            max-width: 90%;
            display: inline-block;
            text-align: left;
            border-radius: 5px;
        }

        #chat .me {
            text-align: right;
        }

        #chat .you .message {
            background-color: #58b666;
        }

        #chat .me .message {
            background-color: #6fbced;
        }

        #chat .triangle {
            width: 0;
            height: 0;
            border-style: solid;
            border-width: 0 10px 10px 10px;
        }

        #chat .you .triangle {
            border-color: transparent transparent #58b666 transparent;
            margin-left: 15px;
        }

        #chat .me .triangle {
            border-color: transparent transparent #6fbced transparent;
            margin-left: 375px;
        }

        main footer {
            height: 13vh;
            padding: 10px 30px 10px 10px;
            display: flex;
        }

        main footer textarea {
            resize: none;
            border: none;
            display: block;
            width: 100%;
            height: 10vh;
            border-radius: 3px;
            padding: 20px;
            font-size: 13px;
            margin-bottom: 13px;
        }

        main footer textarea::placeholder {
            color: #ddd;
        }

        main footer img {
            height: 30px;
            cursor: pointer;
        }

        main footer a {
            text-decoration: none;
            text-transform: uppercase;
            font-weight: bold;
            color: #6fbced;
            vertical-align: top;
            display: inline-flex;
            align-items: end;
        }

        .sidebar::-webkit-scrollbar {
            width: 5px;
        }
    </style>
    <div class="container">
        <div class="row">
            <div class="col-md-12 d-flex justify-content-between mt-5 mb-4 d-none">
                <img src="assets/images/247 NEW Logo 2.png" alt="Logo" width="150" height="auto">
                <div class="col-md-1 text-center">
                    <a href="#" class="link-dark"><i class="fa-solid fa-xmark fa-2x"></i></a>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="panel-group">
            <div class="row panel panel-primary">
                <br>
                <div class="container">
                    <div class="row">
                        <div class="col-md-8 mx-auto">
                            <div class="card-body chat-care">
                                <div id="chat-part">
                                    <main>
                                        <header
                                            style="background-color: #d7d7d7;display: flex;align-items: center;border-radius: 5px">
                                            <img src="" alt="" width="60" height="60">
                                            <div>
                                                <h2>Chat with

                                                </h2>
                                                <h3>already {{ $chats->count() }} messages</h3>
                                            </div>
                                            <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/1940306/ico_star.png"
                                                alt="">
                                        </header>
                                        <ul id="chat" class="sidebar chat-container">
                                            @if (!empty($chats))
                                                @foreach ($chats as $chat)
                                                    @if ($chat->sender_id == Auth::id())
                                                        <li class="me">
                                                            <div class="entete">
                                                                <h3>10:12AM</h3>
                                                                <h2>{{ App\Models\User::find($chat->sender_id)->first_name . ' ' . App\Models\User::find($chat->sender_id)->last_name }}
                                                                </h2>
                                                                <span class="status blue"></span>
                                                            </div>

                                                            <div class="message">
                                                                {!! $chat->message !!}
                                                            </div>
                                                        </li>
                                                    @else
                                                        <?php $check_sender = App\Models\GroupChat::where('sender_id', Auth::id())->first(); ?>
                                                        @if (!empty($check_sender) || $chats[0]->sender_id == Auth::user()->parent_id)
                                                            <li class="you">
                                                                <div class="entete">
                                                                    <span class="status green"></span>
                                                                    <h2>{{ App\Models\User::find($chat->sender_id)->first_name . ' ' . App\Models\User::find($chat->sender_id)->last_name }}
                                                                    </h2>
                                                                    <h3>10:12AM</h3>
                                                                </div>

                                                                <div class="message">
                                                                    {!! $chat->message !!}
                                                                </div>
                                                            </li>
                                                        @endif
                                                    @endif
                                                @endforeach
                                            @endif
                                        </ul>
                                    </main>
                                    {{-- chat Start --}}
                                    <form id="chat-form">
                                        @csrf
                                        <span class="d-flex">
                                            <input type="text" name="message" id="message" placeholder="Enter Message "
                                                required class="form-control text-dark">
                                            <input type="submit" class="btn btn-primary" value="Send">
                                        </span>
                                    </form>
                                    {{-- chat end --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- main js file -->
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <!-- jquery file -->
    <script src="{{ asset('vendor/jquery/jquery3.7.0.js') }}"></script>
    <!-- Bootstrap js file -->
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/intlInputPhone.min.js') }}"></script>

    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        var authenticatedUserId = <?php echo json_encode(Auth::id()); ?>;
        $('#chat-form').submit(function(event) {
            event.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                url: "{{ url('chat_with_students') }}",
                type: 'post',
                data: formData,
                success: function(response) {
                    // location.reload();
                },
            });
        });
        window.Echo.channel('groupmessage').listen('GroupChat', (e) => {
            if (authenticatedUserId == e.sender_id) {
                var html = `<li class="me">
                    <div class="entete">
                        <span class="status blue"></span>
                        <h2>${e.sender}</h2>
                        <h3>10:12AM</h3>
                    </div>

                    <div class="message">
                        ${e.message}
                    </div>
                </li>`;
                $('.chat-container').append(html);
            } else if (e.check_sender !== '' ||e.sender_index === e.parent_id) {
                var html = `<li class="you">
                    <div class="entete">
                        <h3>10:12AM</h3>
                        <h2>${e.sender}</h2>
                        <span class="status green"></span>
                    </div>

                    <div class="message">
                        ${e.message}
                    </div>
                </li>`;
                $('.chat-container').append(html);
            }
        });

    </script>

    <script>
        document.getElementById("chat-form").addEventListener("submit", function(event) {
            event.preventDefault();
            document.getElementById("message").value = "";
        });
    </script>
@endsection
