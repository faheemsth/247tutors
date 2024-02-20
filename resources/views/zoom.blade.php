<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('videosdk-ui-toolkit-web-main/dist/videosdk-ui-toolkit.css') }}">


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body id="app">
    <style>
        /* Globally set text font to a sans-serif font */
        * {
            font-family: Arial, Helvetica, sans-serif;
            font-weight: 250;
            letter-spacing: 1px;
        }

        .videokit {
            height: 100vh !important;
            padding-top: 0px !important;
        }

        /* Centers all app content in middle of page */
        /*html,*/
        /*body {*/
        /*  height: 100vh;*/
        /*  display: flex;*/
        /*  align-content: center;*/
        /*  justify-content: center;*/
        /*  overflow: hidden;*/
        /*}*/

        /* Generic container class to conveniently center all contents */
        .container {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Styles for the video canvas to slightly improve aesthetics */
        .video-canvas {
            background: rgba(0, 0, 0, 1);
            margin: 1px;
            border-radius: 14px;
            border: 1px solid rgba(0, 0, 0, 1);
        }

        /* Helper class to conveniently toggle hide/unhide */
        .hidden {
            display: none;
        }


        /* Preview page styles */

        .preview__root {
            flex-direction: column;
            height: fit-content;
        }

        .preview-video {
            width: 800px;
            height: 450px;
            background: rgba(0, 0, 0, 1);
            margin: 1px;
            border-radius: 14px;
            border: 1px solid rgba(0, 0, 0, 1);
        }

        .join-button {
            color: rgba(255, 255, 255, 1);
            background: rgba(0, 141, 250, 1);
            border-radius: 14px;
            font-size: 16px;
            height: 3em;
            width: 24em;
            margin: 2em auto;
            cursor: pointer;
            border: none;
            font-stretch: expanded;
            transition: filter 0.15s ease-out;
        }

        .join-button:hover {
            filter: brightness(110%);
        }

        /* The "active" pseudo-class MUST come after "hover" */
        .join-button:active {
            filter: brightness(80%);
        }


        /* Loading styles */

        .loading-view {
            flex-direction: column;
            animation: blink 5s linear infinite;
        }

        .loading-spinner {
            font-size: 32px;
            color: rgba(0, 141, 250, 1);
            animation: spin 2s cubic-bezier(0.68, -0.55, 0.265, 1.55) infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        @keyframes blink {
            0% {
                opacity: 1;
            }

            50% {
                opacity: 0.6;
            }
        }


        /* Video app styles */

        /* Container for the video-app that helps place the meeting controls at the bottom */
        .video-app {
            flex-direction: column;
            height: fit-content;
            justify-content: flex-end;
            position: relative;
        }


        /* Additional styling for the meeting control buttons' container */
        .meeting-control-layer {
            /* `position: absolute;` places the controls above the canvas */
            position: absolute;
            border-radius: 14px;
            background-color: rgba(125, 125, 125, 0.18);
            margin-block-end: 5px;
        }

        /* Styles for the buttons */
        .meeting-control-button {
            border-radius: 50%;
            border: none;
            font-size: 24px;
            color: rgba(0, 0, 0, 1);
            background-color: rgba(255, 255, 255, 1);
            height: 2em;
            width: 2em;
            margin: 0.5em;
            cursor: pointer;
            transition: all 0.15s ease-out;
        }

        .meeting-control-button__off {
            color: white;
            background-color: red;
        }

        .meeting-control-button__leave-session {
            color: red;
            /* background-color: red; */
            transform: rotate(-135deg);
        }

        .meeting-control-button:hover {
            filter: brightness(90%);
        }

        /* The "active" pseudo-class MUST come after "hover" */
        .meeting-control-button:active {
            filter: brightness(80%);
        }

        .vertical-divider {
            border: 1px solid rgba(0, 0, 0, 1);
            margin: 10px 5px;
            align-self: stretch;
        }

        /*
 * Classes to help show mic volume feedback for different intensities
 * Add more styles to create smoother transitions */
        .mic-feedback__very-low {
            background: linear-gradient(0deg, #00FFFF 20%, #FFFFFF 20%);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .mic-feedback__low {
            background: linear-gradient(0deg, #00FFFF 35%, #FFFFFF 35%);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .mic-feedback__medium {
            background: linear-gradient(0deg, #00FFFF 50%, #FFFFFF 50%);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .mic-feedback__high {
            background: linear-gradient(0deg, #00FFFF 65%, #FFFFFF 65%);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .mic-feedback__very-high {
            background: linear-gradient(0deg, #00FFFF 80%, #FFFFFF 80%);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .mic-feedback__max {
            background: #00FFFF;
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .self-video {
            display: none;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        .self-video-canvas {
            display: none;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        #my-self-view-video,
        #my-self-view-canvas {
            display: none;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }



        .success-box {
            margin: 50px 0;
            padding: 10px 10px;
            border: 1px solid #eee;
            background: #f9f9f9;
        }

        .success-box img {
            margin-right: 10px;
            display: inline-block;
            vertical-align: top;
        }

        .success-box>div {
            vertical-align: top;
            display: inline-block;
            color: #888;
        }



        /* Rating Star Widgets Style */
        .rating-stars ul {
            list-style-type: none;
            padding: 0;

            -moz-user-select: none;
            -webkit-user-select: none;
        }

        .rating-stars ul>li.star {
            display: inline-block;

        }

        /* Idle State of the stars */
        .rating-stars ul>li.star>i.fa {
            font-size: 2.5em;
            /* Change the size of the stars */
            color: #ccc;
            /* Color on idle state */
        }

        /* Hover state of the stars */
        .rating-stars ul>li.star.hover>i.fa {
            color: #FFCC36;
        }

        /* Selected state of the stars */
        .rating-stars ul>li.star.selected>i.fa {
            color: #FF912C;
        }

        .self-view {
            width: 100%;
            max-width: 200px;
            height: 200px;
            border-radius: 17px !important;
            position: absolute !important;
            right: 0;
            z-index: 99;
            border: 2px solid white;

            background: #972121;
        }

        .user-view {
            height: 100vh;
            aspect-ratio: 0;


        }

        #participant-canvas {
            height: 100vh !important;
            border-radius: 0px !important;
        }

        .controlskit {
            position: absolute;
            bottom: 0;
            background-color: transparent !important;
            margin-bottom: 0px !important;
        }

        .msger {
            width: 348px !important;
            margin: 0px !important;
            position: absolute;
            bottom: 8px !important;
            right: 3px !important;
        }

        .row {
            margin-right: 1px !important;
            margin-left: 1px !important;
        }
    </style>
    <!-- <video id="my-self-view-video" width="1920" height="1080"></video>
<canvas id="my-self-view-canvas" width="1920" height="1080"></canvas>
<canvas id="participant-videos-canvas" width="1920" height="1080"></canvas> -->
    <!-- <div id='previewContainer'></div> -->
    <div id='sessionContainer'></div>
    <input type="hidden" id="recording-uuid" value="">
    {{-- <div class="container app-root" id="container">
  <!-- Preview view -->
  <div id="js-preview-view" class="container preview__root">
      <span>
          <h1>Join Video Session</h1>
      </span>
      <div class="container video-app">
          <!-- You can use any height or width you wish for the preview -->
          <video id="js-preview-video" class="preview-video" playsinline="" muted="" data-video="0"></video>
          <div class="container meeting-control-layer">
              <!-- "fas" and "fa" are icon prefixes for the font-awesome library -->
              <button id="js-preview-mic-button" class="meeting-control-button">
                  <i id="js-preview-mic-icon" class="fas fa-microphone-slash"></i>
              </button>
              <button id="js-preview-webcam-button" class="meeting-control-button">
                  <i id="js-preview-webcam-icon" class="fas fa-video webcam__off"></i>
              </button>
          </div>
      </div>
      <button id="js-preview-join-button" class="join-button">
          Join
      </button>
  </div>
  <!-- Loading view -->
  <div id="js-loading-view" class="container loading-view hidden">
      <h1>Joining session, sit tight...</h1>
      <i class="fas fa-spinner loading-spinner"></i>
  </div>
  <!-- In-session view -->
  <div id="js-video-view" class="container video-app hidden">
      <canvas id="video-canvas" class="video-canvas" width="1280" height="640"></canvas>
      <video id="my-self-view-video" class="self-video"></video>
      <canvas id="my-self-view-canvas" class="self-video-canvas" width="640" height="360"></canvas>
      <div class="container meeting-control-layer">
          <!-- "fas" and "fa" are icon prefixes for the font-awesome library -->
          <button id="js-mic-button" class="meeting-control-button">
              <i id="js-mic-icon" class="fas fa-microphone-slash"></i>
          </button>
          <button id="js-webcam-button" class="meeting-control-button">
              <i id="js-webcam-icon" class="fas fa-video webcam__off"></i>
          </button>
          <div class="vertical-divider"></div>
          <button id="js-leave-button" 
              class="meeting-control-button meeting-control-button__leave-session">
              <i id="js-leave-session-icon" class="fas fa-phone"></i>
          </button>
      </div>
  </div>
  <!-- Ending view -->
  <div id="js-end-view" class="container ending-view hidden">
      <h1>You have successfully left the session!</h1>
  </div>
  
</div>
--}}
    <video id="recordedVideo" controls hidden></video>
    <button type="button" class="btn btn-danger" id="startButton" style="display:none">Start</button>
    <button type="button" class="btn btn-danger" id="stopButton" style="display:none">Stop</button>
    <a id="downloadButton" download="recordedScreenCapture.webm" hidden>Download</a>

    <div class="modal" id="confirmationModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title">Are you sure to confirm class is done?</h4>
                    <button type="button" class="btn-close" onclick="closeModal()">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row mt-5">
                        <div class="col-md-12">

                            <label for="exampleFormControlInput1" class="form-label">Your Feedback</label>
                            <textarea type="text" name="user_feedback" class="form-control" id="user_feedback" required
                                placeholder="Enter your feedback"></textarea>
                            <input type="text" id="booking_id"
                                value="{{ !empty($booking->uuid) ? $booking->uuid : request()->segment(2) }}" hidden>
                            <br>
                            <div class='rating-stars text-center mt-5'>
                                <ul id='stars' style="text-align:left">
                                    <li class='star' title='Poor' data-value='1'>
                                        <i class='fa fa-star fa-fw'></i>
                                    </li>
                                    <li class='star' title='Fair' data-value='2'>
                                        <i class='fa fa-star fa-fw'></i>
                                    </li>
                                    <li class='star' title='Good' data-value='3'>
                                        <i class='fa fa-star fa-fw'></i>
                                    </li>
                                    <li class='star' title='Excellent' data-value='4'>
                                        <i class='fa fa-star fa-fw'></i>
                                    </li>
                                    <li class='star' title='WOW!!!' data-value='5'>
                                        <i class='fa fa-star fa-fw'></i>
                                    </li>
                                </ul>
                            </div>

                            <div class='success-box'>
                                <div class='clearfix'></div>
                                <img alt='tick image' width='32'
                                    src='data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTkuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iTGF5ZXJfMSIgeD0iMHB4IiB5PSIwcHgiIHZpZXdCb3g9IjAgMCA0MjYuNjY3IDQyNi42NjciIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDQyNi42NjcgNDI2LjY2NzsiIHhtbDpzcGFjZT0icHJlc2VydmUiIHdpZHRoPSI1MTJweCIgaGVpZ2h0PSI1MTJweCI+CjxwYXRoIHN0eWxlPSJmaWxsOiM2QUMyNTk7IiBkPSJNMjEzLjMzMywwQzk1LjUxOCwwLDAsOTUuNTE0LDAsMjEzLjMzM3M5NS41MTgsMjEzLjMzMywyMTMuMzMzLDIxMy4zMzMgIGMxMTcuODI4LDAsMjEzLjMzMy05NS41MTQsMjEzLjMzMy0yMTMuMzMzUzMzMS4xNTcsMCwyMTMuMzMzLDB6IE0xNzQuMTk5LDMyMi45MThsLTkzLjkzNS05My45MzFsMzEuMzA5LTMxLjMwOWw2Mi42MjYsNjIuNjIyICBsMTQwLjg5NC0xNDAuODk4bDMxLjMwOSwzMS4zMDlMMTc0LjE5OSwzMjIuOTE4eiIvPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8L3N2Zz4K' />
                                <div class='text-message'></div>
                                <div class='clearfix'></div>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" onclick="updateMeetingStatus()">Mark as
                        Completed</button>
                    <button type="button" class="btn btn-danger" onclick="closeModal()">Not Completed</button>
                </div>

            </div>
        </div>
    </div>

    <div class="modal" id="recordingModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Class Recording</h4>
                    <button type="button" class="btn-close" onclick="closeRecordingModal()">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row mt-5">
                        <div class="col-md-12">

                            <label for="exampleFormControlInput1" class="form-label">Here is your recording kindly
                                download for future use.</label>


                        </div>
                    </div>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" onclick="downloadRecording()">Download
                        Recording</button>
                    <!--<button type="button" class="btn btn-danger"  onclick="closeModal()">Not Completed</button>-->
                </div>
            </div>
        </div>
    </div>
    <script>
        let booking_id = {!! json_encode(!empty($booking->uuid) ? $booking->uuid : request()->segment(2)) !!};
        let user = {!! json_encode(Auth::user()) !!};
    </script>
    <script src="https://source.zoom.us/videosdk/zoom-video-1.9.8.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jsrsasign/8.0.20/jsrsasign-all-min.js"></script>
    <script src="{{ asset('videosdk-ui-toolkit-web-main/index.js') }}" type="module"></script>
    <script src="{{ asset('assets/js/zoom_uitoolkit.js') }}" type="module"></script>

    <!-- <script src="{{ asset('assets/js/zoom_preview.js') }}" type="module"></script>
<script src="{{ asset('assets/js/zoom_session.js') }}"></script> -->


    <script>
        function closeModal() {
            $('#confirmationModal').modal('hide');
        }

        function closeRecordingModal() {
            $('#recordingModal').modal('hide');
            window.location.href = '{{ url('bookings') }}';
        }
        $(document).ready(function() {

            // $(".ctrl-btn mdc-fab mat-mdc-fab mat-primary mat-mdc-button-base ng-star-inserted").click(function() {
            //   console.log('Video enabled')
            // });
            /* 1. Visualizing things on Hover - See next part for action on click */
            $('#stars li').on('mouseover', function() {
                var onStar = parseInt($(this).data('value'), 10); // The star currently mouse on
                // Now highlight all the stars that's not after the current hovered star
                $(this).parent().children('li.star').each(function(e) {
                    if (e < onStar) {
                        $(this).addClass('hover');
                    } else {
                        $(this).removeClass('hover');
                    }
                });

            }).on('mouseout', function() {
                $(this).parent().children('li.star').each(function(e) {
                    $(this).removeClass('hover');
                });
            });


            /* 2. Action to perform on click */
            $('#stars li').on('click', function() {
                var onStar = parseInt($(this).data('value'), 10); // The star currently selected
                var stars = $(this).parent().children('li.star');

                for (i = 0; i < stars.length; i++) {
                    $(stars[i]).removeClass('selected');
                }

                for (i = 0; i < onStar; i++) {
                    $(stars[i]).addClass('selected');
                }

                // JUST RESPONSE (Not needed)
                ratingValue = parseInt($('#stars li.selected').last().data('value'), 10);
                var msg = "";
                if (ratingValue > 1) {
                    msg = "Thanks! You rated this " + ratingValue + " stars.";
                } else {
                    msg = "We will improve ourselves. You rated this " + ratingValue + " stars.";
                }
                responseMessage(msg);

            });


        });


        function responseMessage(msg) {
            $('.success-box').fadeIn(200);
            $('.success-box div.text-message').html("<span>" + msg + "</span>");
        }


        // let mediaRecorder;
        // let recordedChunks = [];

        const startButton = document.getElementById('startButton');
        const stopButton = document.getElementById('stopButton');
        const downloadButton = document.getElementById('downloadButton');
        // const recordedVideo = document.getElementById('recordedVideo');

        startButton.addEventListener('click', startRecording);
        stopButton.addEventListener('click', stopRecording);
        downloadButton.addEventListener('click', saveVideo);

        async function startRecording() {
            try {
                const audio_stream = await navigator.mediaDevices.getUserMedia({
                    audio: true
                });
                const canvas = document.querySelector("#my-self-view-video");
                const stream = canvas.captureStream(25);

                var newStream = new MediaStream();
                newStream.addTrack(audio_stream.getAudioTracks()[0]);
                newStream.addTrack(stream.getVideoTracks()[0]);

                mediaRecorder = new MediaRecorder(newStream);

                mediaRecorder.ondataavailable = function(event) {
                    if (event.data.size > 0) {
                        recordedChunks.push(event.data);
                    }
                };

                mediaRecorder.onstop = function() {
                    const blob = new Blob(recordedChunks, {
                        type: 'video/webm'
                    });
                    recordedChunks = [];
                    recordedVideo.src = URL.createObjectURL(blob);
                    downloadButton.style.display = 'inline';
                };

                startButton.style.display = 'none';
                stopButton.style.display = 'inline';

                mediaRecorder.start();
            } catch (error) {
                console.error('Error accessing display media:', error);
            }
        }

        function stopRecording() {
            if (mediaRecorder && mediaRecorder.state !== 'inactive') {
                mediaRecorder.stop();
                startButton.style.display = 'inline';
                stopButton.style.display = 'none';
            }
        }

        function downloadRecording() {
            if (recordedVideo.src) {
                const a = document.createElement('a');
                console.log('recordedVideo.src', recordedVideo.src)
                a.href = recordedVideo.src;
                a.download = 'recordedScreenCapture.webm';
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
            }
        }
        async function saveVideo() {

            const videoBlob = await fetch(recordedVideo.src).then(response => response.blob());
            console.log(videoBlob)
            const myFile = new File([videoBlob], "demo.webm", {
                type: 'video/webm'
            });
            var formData = new FormData()

            formData.append('source', myFile)

            $.ajax({
                url: "{{ url('saveRecording') }}",
                type: "POST",
                processData: false,
                contentType: false,
                cache: false,
                enctype: 'multipart/form-data',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: formData,
                success: function(data) {
                    console.log(data)
                    if (data.status_code == 200) {}
                },
            })
        }

        function updateMeetingStatus() {
            var id = $('#booking_id').val()
            var user_feedback = $('#user_feedback').val()
            var rating = ratingValue
            $.ajax({
                url: "{{ url('endJitsiMeeting') }}",
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    id: id,
                    user_feedback: user_feedback,
                    rating: rating,
                },
                success: function(data) {
                    if (data.status_code == 200) {

                        //   $('#confirmationModal').modal('hide');
                        $('#recordingModal').modal('show');
                        if (mediaRecorder && mediaRecorder.state !== 'inactive') {
                            mediaRecorder.stop();
                            startButton.style.display = 'inline';
                            stopButton.style.display = 'none';
                        }
                        saveVideo();
                        client.leave();

                        //   

                    } else {
                        $('#confirmationModal').modal('hide');
                        $('#recordingModal').modal('show');
                        if (mediaRecorder && mediaRecorder.state !== 'inactive') {
                            mediaRecorder.stop();
                            startButton.style.display = 'inline';
                            stopButton.style.display = 'none';
                        }
                        saveVideo();
                        client.leave();
                    }
                },
            })
        }
    </script>

</body>

</html>
