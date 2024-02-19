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
            height: 100vh;
            background: #97a4b4;
            margin: 0 auto;
            font-size: 0;
            overflow: hidden;
        }

        #sitebar {
            width: 25%;
            height: 100vh;
            background-color: #3b3e49;
            display: inline-block;
            font-size: 15px;
            vertical-align: top;
        }

        .chat-menu {
            box-shadow: none !important;
            outline: none !important;
        }

        .chat-menu:focus {
            background-color: #6e6e6e;
        }

        #main-chat {
            width: 75%;
            height: 10vh;
            display: inline-block;
            font-size: 15px;
            vertical-align: top;
        }


        #sitebar header {
            padding: 30px 20px;
        }

        #sitebar input {
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

        #sitebar input::placeholder {
            color: #fff;
        }

        #sitebar ul {
            padding-left: 0;
            margin: 0;
            list-style-type: none;
            overflow-y: scroll;
            height: 83vh;
        }

        #sitebar li {
            padding: 10px 0;
        }

        #sitebar li:hover {
            background-color: #5e616a;
        }

        h2,
        h3 {
            margin: 0;
        }

        #sitebar li img {
            border-radius: 50%;
            margin-left: 20px;
            margin-right: 8px;
        }

        #sitebar li div {
            display: inline-block;
            vertical-align: top;
            margin-top: 12px;
        }

        #sitebar li h2 {
            font-size: 14px;
            color: #fff;
            font-weight: normal;
            margin-bottom: 5px;
        }

        #sitebar li h3 {
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

        #main-chat header {
            height: 90px;
            padding: 15px 20px 30px 40px;
        }

        #main-chat header>* {
            display: inline-block;
            vertical-align: top;
        }

        #main-chat header img:first-child {
            border-radius: 50%;
        }

        #main-chat header img:last-child {
            width: 24px;
            margin-top: 8px;
            float: right;
        }

        #main-chat header div {
            margin-left: 10px;
            margin-right: 145px;
        }

        #main-chat header h2 {
            font-size: 16px;
            margin-bottom: 5px;
        }

        #main-chat header h3 {
            font-size: 14px;
            font-weight: normal;
            color: #7e818a;
        }

        #chat {
            padding-left: 0;
            margin: 0;
            list-style-type: none;
            overflow-y: scroll;
            height: 73vh;
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
            padding: 20px;
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

        #main-chat footer {
            height: 13vh;
            padding: 10px 30px 10px 10px;
            display: flex;
        }

        #main-chat footer textarea {
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

        #main-chat footer textarea::placeholder {
            color: #ddd;
        }

        #main-chat footer img {
            height: 30px;
            cursor: pointer;
        }

        #main-chat footer a {
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

        #chat-drop {
            height: max-content !important;
            left: -130px !important;
            top: 5px;
            overflow: hidden;
        }

        .modal-header {
            background-color: rgba(171, 255, 0, 1);
        }



        @media only screen and (min-device-width : 320px) and (max-device-width : 480px) {
            #main-chat {
                width: 100%;
            }

            #sitebar {
                display: none !important;
                visibility: hidden;
            }

            #chat-drop {
                left: 0px !important;
            }

            #main-chat header {
                display: flex;
                align-items: center;
                padding: 15px 5px 20px 5px;
                gap: 10px;
            }

            #main-chat header div {
                margin-left: 0px;
                margin-right: 15px;
            }
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

                <div id="container">
                    <aside id="sitebar">
                        <div class="bg-light d-flex justify-content-between align-items-center">
                            <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/1940306/chat_avatar_01.jpg"
                                alt="">
                            <div class="d-flex gap-3 align-items-center">
                                <i class="fa-solid fa-user-group"></i>
                                <i class="fa-solid fa-message"></i>

                                <div class="dropdown">
                                    <a class="btn chat-menu" href="#" role="button" id="dropdownMenuLink"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                    </a>

                                    <ul class="dropdown-menu" id="chat-drop" aria-labelledby="dropdownMenuLink">
                                        <li><button class="dropdown-item" class="btn btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#myModal">Group</button></li>
                                        <li><a class="dropdown-item" href="#">Setting</a></li>
                                        <li><a class="dropdown-item" href="#">Profile</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <header>
                            <input type="text" placeholder="search" id="searchInput">
                        </header>
                        <ul class="sidebar" id="sidebar">
                            @if (!empty($groups))
                                @foreach ($groups as $group)
                                @if (Auth::id() == $group->user_id || Auth::user()->parent_id == $group->user_id)
                                <li onclick="GetChat({{ $group->id }})" class="">
                                    <img src="{{ asset($group->image) }}" alt="" width="50" height="50">
                                    <div>
                                        <h2>{{ $group->name }}</h2>
                                        <h3>
                                            <span class="status green"></span>
                                            online
                                        </h3>
                                    </div>
                                </li>
                                @endif
                                @endforeach
                            @endif
                        </ul>
                    </aside>
                    <main id="main-chat">
                        <header>
                            <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/1940306/chat_avatar_01.jpg"
                                alt="">
                            <div>
                                <h2>Chat with Vincent Porter</h2>
                                <h3>already 1902 messages</h3>
                            </div>
                            <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/1940306/ico_star.png" alt="">
                        </header>
                        <ul id="chat" class="sidebar chat-container">

                        </ul>

                        <form id="chat-form">
                            @csrf
                            <input type="hidden" id="group" name="group" value="">
                            <span class="d-flex">
                                <input type="text" name="message" id="message" placeholder="Enter Message" required
                                    class="form-control text-dark">
                                <input type="submit" class="btn btn-primary" value="Send">
                            </span>
                        </form>

                    </main>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ url('create/group') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title">Create Group</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                        </button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="name" id="floatingInput" placeholder="Name">
                            <label for="floatingInput">Group Name</label>
                        </div>
                        <div class="form-floating mb-3">
                            <textarea class="form-control" name="description" placeholder="Leave a description here" id="floatingTextarea2"
                                style="height: 100px"></textarea>
                            <label for="floatingTextarea2">Description</label>
                        </div>
                        <div class="form-floating">
                            <input type="file" class="form-control" name="image" id="floatingInput"
                                placeholder="Name">
                            <label for="floatingInput">Group Image</label>
                        </div>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" data-bs-dismiss="modal">Create</button>
                    </div>
                </form>


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
        var group_id;
        function GetChat(id) {
            $('#chat').html('');
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            $('#group').val(id);
            group_id = id;
            $.ajax({
                url: "{{ url('get_chat') }}",
                type: 'post',
                data: {
                    id: id,
                    _token: csrfToken
                },
                success: function(response) {
                    $('#chat').append(response);
                },
            });
        }

        var authenticatedUserId = <?php echo json_encode(Auth::id()); ?>;
        var sendername = <?php echo json_encode(Auth::user()->first_name. ' ' .Auth::user()->last_name); ?>;
        $('#chat-form').submit(function(event) {
            event.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
    url: "{{ url('chat_with_students') }}",
    type: 'post',
    data: formData,
    success: function(response) {
            if (authenticatedUserId == response.sender_id) {
                var html = `<li class="me">
                    <div class="entete">
                        <h3>10:12AM</h3>
                        <h2>${sendername}</h2>
                        <span class="status blue"></span>
                    </div>
                    <div class="message">
                        ${response.message}
                    </div>
                </li>`;
                $('.chat-container').append(html);
            }
    },
});

        });
        window.Echo.channel('groupmessage').listen('GroupChat', (e) => {

            if (authenticatedUserId == e.sender_id) {
                var html = `<li class="me">
                    <div class="entete">
                        <h3>10:12AM</h3>
                        <h2>${e.sender}</h2>
                        <span class="status blue"></span>
                    </div>

                    <div class="message">
                        ${e.message}
                    </div>
                </li>`;
                $('.chat-container').append(html);
            } else if (group_id == e.group_id) {
                var html = `<li class="you">
                    <div class="entete">
                        <span class="status green"></span>
                        <h2>${e.sender}</h2>
                        <h3>10:12AM</h3>
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

    <script>
        $(document).ready(function () {
    $('#searchInput').keyup(function () {
        var searchText = $(this).val().toLowerCase();

        $('#sidebar li').each(function () {
            var name = $(this).find('h2').text().toLowerCase();

            if (name.includes(searchText)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });
});
</script>
@endsection
