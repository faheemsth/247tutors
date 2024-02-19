const micJButton = document.getElementById('js-mic-button');
const micJIcon = document.getElementById('js-mic-icon');

const VIDEO_CANVAS = document.getElementById('video-canvas');
const SELF_VIDEO_ELEMENT = document.getElementById('my-self-view-video');
const SELF_VIDEO_CANVAS = document.getElementById('my-self-view-canvas');
const VIDEO_CANVAS_DIMS = {
    Width: 1280,
    Height: 640,
};

const PARTICIPANT_CHANGE_TYPE = {
    ADD: 'add',
    REMOVE: 'remove',
    UPDATE: 'update'
};

const PEER_VIDEO_STATE_CHANGE_ACTION_TYPE = {
Start: 'Start',
Stop: 'Stop'
};

let meet_started = false;
// let isMuted = true;
let isJsButtonAlreadyClicked = false;

if (!isStartedAudio) {
    micJIcon.classList.remove('fa-microphone-slash');
    micJIcon.classList.add('fa-headset');
}

function togglemicJButtonStyle(){
  micJIcon.classList.toggle('fa-microphone');
  micJIcon.classList.toggle('fa-microphone-slash');
  micJButton.classList.toggle('meeting-control-button__off');
};

const toggleJMuteUnmute = () => (isMuted ? stream.muteAudio() : stream.unmuteAudio());

function isMutedSanityCheck() {
  const mediaStreamIsMuted = stream.isAudioMuted();
  console.log('Sanity check: is muted? ', mediaStreamIsMuted);
  console.log('Does this match button state? ', mediaStreamIsMuted === isMuted);
};

//   const onClick = async (event) => {
function onMicJClick(event){
    event.preventDefault();
    if (!isButtonAlreadyClicked) {
      // Blocks logic from executing again if already in progress
      isButtonAlreadyClicked = true;
      if (isStartedAudio) {
        try {
          isMuted = !isMuted;
        //   await toggleJMuteUnmute();
          toggleJMuteUnmute();

          togglemicJButtonStyle();
          isMutedSanityCheck();
        } catch (e) {
          console.error('Error toggling mute', e);
        }

        isButtonAlreadyClicked = false;
      } else {
        try {
        //   if (state.audioDecode && state.audioEncode) {
            // await mediaStream.startAudio();
            stream.startAudio();

            micJIcon.classList.remove('fa-headset');
            if (stream.isAudioMuted()) {
              micJIcon.classList.add('fa-microphone-slash');
              isMuted = true;
            } else {
              micJIcon.classList.add('fa-microphone');
              isMuted = false;
            }
            isStartedAudio = true;
            isButtonAlreadyClicked = false;
        //   } else {
        //     console.warn('Please wait until media workers are ready');
        //   }
        } catch (e) {
          console.error('Error start audio', e);
        }
      }
    } else {
      console.log('=== WARNING: already toggling mic ===');
    }
  };

  micJButton.addEventListener('click', onMicJClick);

// Webcam handling
//   const webcamJButton = document.getElementById('js-webcam-button');
  let prevIsSelfVideoOn = false;
  let prevIsParticipantVideoOn = false;

  let isWebJcamOn = false;

  const togglewebcamJButtonStyle = () => webcamJButton.classList.toggle('meeting-control-button__off');

  const onJsVideoClick = async (event) => {
    event.preventDefault();
    if (!isJsButtonAlreadyClicked) {
      // Blocks logic from executing again if already in progress
      isJsButtonAlreadyClicked = true;

      try {
        isWebJcamOn = !isWebJcamOn;
        await toggleSelfVideo(stream, isWebJcamOn);
        togglewebcamJButtonStyle();
        if(!meet_started){
             try {
                const audio_stream = await navigator.mediaDevices.getUserMedia({
                    audio: true
                });
                const canvas = document.querySelector("#my-self-view-video");
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
                meet_started = true;
            } catch (error) {
                console.error('Error accessing display media:', error);
            }
        }
      } catch (e) {
        isWebJcamOn = !isWebJcamOn;
        console.error('Error toggling video', e);
      }

      isJsButtonAlreadyClicked = false;
    } else {
      console.log('=== WARNING: already toggling webcam ===');
    }
  };

  const toggleSelfVideo = async (mediaStream, isVideoOn) => {
    const isUsingVideoElementToStartVideo =
      typeof window.OffscreenCanvas === 'function' && !mediaStream.isSupportMultipleVideos();
    const isRenderingSingleVideoOnCanvas =
      typeof window.OffscreenCanvas !== 'function' && !mediaStream.isSupportMultipleVideos();
    if (typeof isVideoOn !== 'boolean' || prevIsSelfVideoOn === isVideoOn) {
      
      return;
    }
    const canvas = isRenderingSingleVideoOnCanvas ? SELF_VIDEO_CANVAS : VIDEO_CANVAS;
    if (isVideoOn) {
      if (isUsingVideoElementToStartVideo) {
        let participants = client.getAllUser()
        console.log('participants',participants);
        SELF_VIDEO_ELEMENT.style.display = 'block';

        if(participants.length > 1){
            SELF_VIDEO_ELEMENT.style.width = '50%';
            SELF_VIDEO_ELEMENT.style.left = '50%';
        }
        
        await mediaStream.startVideo({ videoElement: SELF_VIDEO_ELEMENT });
      } else {
        await mediaStream.startVideo();
        if (isRenderingSingleVideoOnCanvas) {
          SELF_VIDEO_CANVAS.style.display = 'block';
          SELF_VIDEO_CANVAS.style.width = '50%';
          SELF_VIDEO_CANVAS.style.height = '50%';
          SELF_VIDEO_CANVAS.style.left = '50%';
          SELF_VIDEO_CANVAS.style.top = '50%';
          SELF_VIDEO_CANVAS.style.transform = 'translateY(-50%)';
          await mediaStream.renderVideo(
            canvas,
            client.getSessionInfo().userId,
            VIDEO_CANVAS_DIMS.Width / 2,
            VIDEO_CANVAS_DIMS.Height / 2,
            0,
            0,
            VideoQuality.Video_360P
          );
        } else {
          await mediaStream.renderVideo(
            canvas,
            client.getSessionInfo().userId,
            VIDEO_CANVAS_DIMS.Width / 2,
            VIDEO_CANVAS_DIMS.Height,
            VIDEO_CANVAS_DIMS.Width / 2,
            0,
            VideoQuality.Video_360P
          );
        }
      }
    } else {
      await mediaStream.stopVideo();
      if (!isUsingVideoElementToStartVideo) {
        if (isRenderingSingleVideoOnCanvas) {
          SELF_VIDEO_CANVAS.style.display = 'none';
        }
        await mediaStream.stopRenderVideo(canvas, client.getSessionInfo().userId);
      } else {
        SELF_VIDEO_ELEMENT.style.display = 'none';
      }
    }
    prevIsSelfVideoOn = isVideoOn;
  };

  webcamJButton.addEventListener('click', onJsVideoClick);

  const toggleParticipantVideo = async (mediaStream, userId, isVideoOn) => {
    if (typeof isVideoOn !== 'boolean' || prevIsParticipantVideoOn === isVideoOn) {
      return;
    }
  
    if (isVideoOn) {
      await mediaStream.renderVideo(
        VIDEO_CANVAS,
        userId,
        VIDEO_CANVAS_DIMS.Width / 2,
        VIDEO_CANVAS_DIMS.Height,
        0,
        0,
        2
      );
    } else {
      await mediaStream.stopRenderVideo(VIDEO_CANVAS, userId);
    }
    prevIsParticipantVideoOn = isVideoOn;
  };

  // Leave call

const leaveButton = document.getElementById('js-leave-button');

const onEndClick = async (event) => {
    event.preventDefault();
    try {

      $('#confirmationModal').modal('show');
      // await Promise.all([toggleSelfVideo(stream, false), toggleParticipantVideo(stream, false)]);
      // await client.leave();
      // document.getElementById('js-video-view').classList.toggle('hidden');
      // document.getElementById('js-end-view').classList.toggle('hidden');
    } catch (e) {
      console.error('Error leaving session', e);
    }
};

leaveButton.addEventListener('click', onEndClick);

// users listeners

client.on('user-added', (payload) => {
    console.log(`User added`, payload);
    participants = client.getAllUser();
});
  
client.on('user-removed', (payload) => {
    console.log(`User removed`, payload);
    participants = client.getAllUser();
});
  
client.on('user-updated', (payload) => {
    console.log(`User updated`, payload);
    participants = client.getAllUser();
});

client.on('peer-video-state-change', async (payload) => {
    console.log('onPeerVideoStateChange', payload);
    const { action, userId } = payload;

    if (participants.findIndex((user) => user.userId === userId) === -1) {
      console.log('Detected unrecognized participant ID. Ignoring: ', userId);
      return;
    }

    if (action === PEER_VIDEO_STATE_CHANGE_ACTION_TYPE.Start) {
      toggleParticipantVideo(stream, userId, true);
    } else if (action === PEER_VIDEO_STATE_CHANGE_ACTION_TYPE.Stop) {
      toggleParticipantVideo(stream, userId, false);
    }
});
  
  
  
  