<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" >

<head>
<meta name="csrf-token" content="{{ csrf_token() }}">
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">


  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body id="app" >

<script src='https://8x8.vc/vpaas-magic-cookie-8d3bcf37e1c44245a9ac53d5b8cca469/external_api.js' async></script>

<style>html, body, #jaas-container { height: 100%; }
body{
  margin:0px !important;
}
        

* {
  -webkit-box-sizing:border-box;
  -moz-box-sizing:border-box;
  box-sizing:border-box;
}

*:before, *:after {
-webkit-box-sizing: border-box;
-moz-box-sizing: border-box;
box-sizing: border-box;
}

.clearfix {
  clear:both;
}

.text-center {text-align:center;}

a {
  color: tomato;
  text-decoration: none;
}

a:hover {
  color: #2196f3;
}

pre {
display: block;
padding: 9.5px;
margin: 0 0 10px;
font-size: 13px;
line-height: 1.42857143;
color: #333;
word-break: break-all;
word-wrap: break-word;
background-color: #F5F5F5;
border: 1px solid #CCC;
border-radius: 4px;
}

.header {
  padding:20px 0;
  position:relative;
  margin-bottom:10px;
  
}

.header:after {
  content:"";
  display:block;
  height:1px;
  background:#eee;
  position:absolute; 
  left:30%; right:30%;
}

.header h2 {
  font-size:3em;
  font-weight:300;
  margin-bottom:0.2em;
}

.header p {
  font-size:14px;
}



#a-footer {
  margin: 20px 0;
}

.new-react-version {
  padding: 20px 20px;
  border: 1px solid #eee;
  border-radius: 20px;
  box-shadow: 0 2px 12px 0 rgba(0,0,0,0.1);
  
  text-align: center;
  font-size: 14px;
  line-height: 1.7;
}

.new-react-version .react-svg-logo {
  text-align: center;
  max-width: 60px;
  margin: 20px auto;
  margin-top: 0;
}





.success-box {
  margin:50px 0;
  padding:10px 10px;
  border:1px solid #eee;
  background:#f9f9f9;
}

.success-box img {
  margin-right:10px;
  display:inline-block;
  vertical-align:top;
}

.success-box > div {
  vertical-align:top;
  display:inline-block;
  color:#888;
}



/* Rating Star Widgets Style */
.rating-stars ul {
  list-style-type:none;
  padding:0;
  
  -moz-user-select:none;
  -webkit-user-select:none;
}
.rating-stars ul > li.star {
  display:inline-block;
  
}

/* Idle State of the stars */
.rating-stars ul > li.star > i.fa {
  font-size:2.5em; /* Change the size of the stars */
  color:#ccc; /* Color on idle state */
}

/* Hover state of the stars */
.rating-stars ul > li.star.hover > i.fa {
  color:#FFCC36;
}

/* Selected state of the stars */
.rating-stars ul > li.star.selected > i.fa {
  color:#FF912C;
}

      </style>

        <!-- </script> -->

      <div id="jaas-container" ></div>

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
                          <textarea type="text" name="user_feedback" class="form-control" id="user_feedback"
                              required placeholder="Enter your feedback"></textarea>
                              <input type="text" id="booking_id" value="{{$id}}" hidden>
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
                                <img alt='tick image' width='32' src='data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTkuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iTGF5ZXJfMSIgeD0iMHB4IiB5PSIwcHgiIHZpZXdCb3g9IjAgMCA0MjYuNjY3IDQyNi42NjciIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDQyNi42NjcgNDI2LjY2NzsiIHhtbDpzcGFjZT0icHJlc2VydmUiIHdpZHRoPSI1MTJweCIgaGVpZ2h0PSI1MTJweCI+CjxwYXRoIHN0eWxlPSJmaWxsOiM2QUMyNTk7IiBkPSJNMjEzLjMzMywwQzk1LjUxOCwwLDAsOTUuNTE0LDAsMjEzLjMzM3M5NS41MTgsMjEzLjMzMywyMTMuMzMzLDIxMy4zMzMgIGMxMTcuODI4LDAsMjEzLjMzMy05NS41MTQsMjEzLjMzMy0yMTMuMzMzUzMzMS4xNTcsMCwyMTMuMzMzLDB6IE0xNzQuMTk5LDMyMi45MThsLTkzLjkzNS05My45MzFsMzEuMzA5LTMxLjMwOWw2Mi42MjYsNjIuNjIyICBsMTQwLjg5NC0xNDAuODk4bDMxLjMwOSwzMS4zMDlMMTc0LjE5OSwzMjIuOTE4eiIvPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8L3N2Zz4K'/>
                                <div class='text-message'></div>
                                <div class='clearfix'></div>
                              </div>

                        </div>
                      </div>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" onclick="updateMeetingStatus()" >Mark as Completed</button>
                        <button type="button" class="btn btn-danger"  onclick="closeModal()">Not Completed</button>
                    </div>

            </div>
        </div>
    </div>
    
    <script type="text/javascript">
          let api
          const recordedVideo = document.getElementById('recordedVideo');
          let mediaRecorder;

          window.onload = () => {
            api = new JitsiMeetExternalAPI("8x8.vc", {
              roomName: "vpaas-magic-cookie-8d3bcf37e1c44245a9ac53d5b8cca469/{{ $id }}",
              parentNode: document.querySelector('#jaas-container'),
            
              configOverwrite: {
                                          TOOLBAR_BUTTONS: [
                                              // Include only the buttons you want to display
                                              'microphone', 'camera', 'closedcaptions', 'desktop', 'fullscreen',
                                              'fodeviceselection', 'hangup', 'profile', 'recording',
                                              'livestreaming', 'etherpad', 'sharedvideo', 'settings', 'raisehand',
                                              'videoquality', 'filmstrip', 'invite', 'feedback', 'stats', 'shortcuts',
                                              'tileview', 'videobackgroundblur', 'download', 'help', 'mute-everyone'
                                          ],buttonsWithNotifyClick: [{key:'hangup',preventExecution:true}] 

                                        },
							// Make sure to include a JWT if you intend to record,
							// make outbound calls or use any other premium features!

							jwt: "{{ $token }}"

            });
            api.on('readyToClose', () => {
              window.location.href = '{{ url('bookings') }}';
            });
           
           // Wait for Jitsi to be ready
           let localParticipantId;
          let localTracks = [];

          // Add an event listener to the "Hang Up" button
          api.on('toolbarButtonClicked', (e) => {
            console.log('eeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee',e)
            if(e.key == 'hangup'){
              $('#confirmationModal').modal('show');
            }
            // window.location.href = '{{ url('jwt') }}';
          });
          
          // // Wait for Jitsi to be ready
          api.addEventListener('videoConferenceJoined', async () => {
            // var element = document.querySelector('[aria-disabled="false"]');
            // let element = document.querySelector('[aria-label="Leave the meeting"]');
            // console.log('videoConferenceJoined',element)

              

                const audio_stream = await navigator.mediaDevices.getUserMedia({
                    audio: true
                });
                const canvas = document.querySelector("#largeVideo");

                var iframe_div = document.getElementById('jitsiConferenceFrame0');
                // .document.getElementById('largeVideo');
var content = iframe_div;
console.log('content',content)
console.log('content',content.document)

                console.log('Canvas ',canvas)
                const can_stream = canvas.captureStream(25);
                
                var newStream = new MediaStream();
                newStream.addTrack(audio_stream.getAudioTracks()[0]);
                newStream.addTrack(can_stream.getVideoTracks()[0]);
                                
                mediaRecorder = new MediaRecorder(newStream);

                mediaRecorder.ondataavailable = function (event) {
                    if (event.data.size > 0) {
                        recordedChunks.push(event.data);
                    }
                };

                mediaRecorder.onstop = function () {
                    const blob = new Blob(recordedChunks, { type: 'video/webm' });
                    recordedChunks = [];
                    recordedVideo.src = URL.createObjectURL(blob);
                    // downloadButton.style.display = 'inline';
                };

                // startButton.style.display = 'none';
                // stopButton.style.display = 'inline';

                mediaRecorder.start();
           
          })

          api.addEventListener('participantJoined', (participant) => {
            console.log('participantJoined',);
            let element = document.querySelector('[aria-label="Leave the meeting"]');
                      console.log('elementelementelementelementelement',element)
          });

          

          

          function endMeeting(){
              api.executeCommand('hangup');

          }

};



function shouldPreventHangUp() {
    // Add your condition here based on your requirements
    // For example, return true if you want to prevent hang-up
    return false;
}

// api.addEventListener('participantJoined', (participant) => {
//   console.log('participantJoined',);
//   onParticipantJoined(participant);
// });

// api.addEventListener('participantLeft', (participant) => {
//   onParticipantLeft(participant);
// });
          //  navigator.mediaDevices.getDisplayMedia({ video: true, audio: true });
          // }
          function downloadRecording(blob) {
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            document.body.appendChild(a);
            a.style = 'display: none';
            a.href = url;
            a.download = 'recording.webm';
            a.click();
            window.URL.revokeObjectURL(url);
          }


          var ratingValue = 0;
      function closeModal(){
        $('#confirmationModal').modal('hide');
      }
      $(document).ready(function(){
  
        /* 1. Visualizing things on Hover - See next part for action on click */
        $('#stars li').on('mouseover', function(){
          var onStar = parseInt($(this).data('value'), 10); // The star currently mouse on
        
          // Now highlight all the stars that's not after the current hovered star
          $(this).parent().children('li.star').each(function(e){
            if (e < onStar) {
              $(this).addClass('hover');
            }
            else {
              $(this).removeClass('hover');
            }
          });
          
        }).on('mouseout', function(){
          $(this).parent().children('li.star').each(function(e){
            $(this).removeClass('hover');
          });
        });
        
        
        /* 2. Action to perform on click */
        $('#stars li').on('click', function(){
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
          }
          else {
              msg = "We will improve ourselves. You rated this " + ratingValue + " stars.";
          }
          responseMessage(msg);
          
        });
        
        
      });


      function responseMessage(msg) {
        $('.success-box').fadeIn(200);  
        $('.success-box div.text-message').html("<span>" + msg + "</span>");
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
            success: function (data) {
                if (data.status_code == 200) {
                    
                    $('#confirmationModal').modal('hide');
                    saveVideo();

                    // api.executeCommand('hangup');

                }
            },
        })
    }

    async function saveVideo() {
           
           const videoBlob = await fetch(recordedVideo.src).then(response => response.blob());
           console.log(videoBlob)
           const myFile = new File([videoBlob],"demo.webm",{ type: 'video/webm' });
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
                 success: function (data) {
                   console.log(data)
                     if (data.status_code == 200) {
                     }
                 },
             })
           }

    </script>
  </body>
</html>

