// import uitoolkit from '/videosdk-ui-toolkit-web-main/index.js'
// import { uitoolkit } from "@zoom/videosdk-ui-toolkit";
import uitoolkit from '/videosdk-ui-toolkit-web-main/index.js'
var previewContainer = document.getElementById('previewContainer')

uitoolkit.openPreview(previewContainer)

const ZoomVideo = window.WebVideoSDK.default
ZoomVideo.preloadDependentAssets();
// console.log('ZoomVideo',ZoomVideo)
// ZoomVideo.checkSystemRequirements().video;
// ZoomVideo.checkSystemRequirements().audio;
// console.log('ZoomVideo.checkSystemRequirements().video',ZoomVideo.checkSystemRequirements().video)
// console.log('ZoomVideo.checkSystemRequirements().audio',ZoomVideo.checkSystemRequirements().audio)

const client = ZoomVideo.createClient();
let participants = [];
// This code is to setup preview

const audioTrack = ZoomVideo.createLocalAudioTrack();
const videoTrack = ZoomVideo.createLocalVideoTrack();
let isPreviewAudioConnected = false;
let isWebcamOn = false;
isStartedAudio = false;
// These variables are for audio
const VOLUME_ANIMATION_INTERVAL_MS = 100;
let volumeAnimation = null;
let prevVolumeAnimationStyle = '';

const micButton = document.getElementById('js-preview-mic-button');
const micIcon = document.getElementById('js-preview-mic-icon');
const PREVIEW_VIDEO_ELEMENT = document.getElementById('js-preview-video');

const webcamJButton = document.getElementById('js-webcam-button');

let isMuted = true;

let isButtonAlreadyClicked = false;

let mediaRecorder;
let recordedChunks = [];
// Video variables
const recordedVideo = document.getElementById('recordedVideo');

function toggleMicButtonStyle(){
    micIcon.classList.toggle('fa-microphone');
    micIcon.classList.toggle('fa-microphone-slash');
    micButton.classList.toggle('meeting-control-button__off');
    
    if (prevVolumeAnimationStyle) {
        micIcon.classList.toggle(prevVolumeAnimationStyle);
        prevVolumeAnimationStyle = '';
    }
}

function animateMicVolume(){

    const newVolume = audioTrack.getCurrentVolume();
    let newVolumeAnimationStyle = '';

    if (newVolume === 0) {
        newVolumeAnimationStyle = '';
    } else if (newVolume <= 0.1) {
        newVolumeAnimationStyle = 'mic-feedback__very-low';
    } else if (newVolume <= 0.2) {
        newVolumeAnimationStyle = 'mic-feedback__low';
    } else if (newVolume <= 0.3) {
        newVolumeAnimationStyle = 'mic-feedback__medium';
    } else if (newVolume <= 0.4) {
        newVolumeAnimationStyle = 'mic-feedback__high';
    } else if (newVolume <= 0.5) {
        newVolumeAnimationStyle = 'mic-feedback__very-high';
    } else {
        newVolumeAnimationStyle = 'mic-feedback__max';
    }

    if (prevVolumeAnimationStyle !== '') {
        micIcon.classList.toggle(prevVolumeAnimationStyle);
    }

    if (newVolumeAnimationStyle !== '') {
        micIcon.classList.toggle(newVolumeAnimationStyle);
    }
    prevVolumeAnimationStyle = newVolumeAnimationStyle;

}

function startVolumeAnimation(){
    if (!volumeAnimation) {
        volumeAnimation = setInterval(animateMicVolume, VOLUME_ANIMATION_INTERVAL_MS);
    }
}

function endVolumeAnimation(){
    if (volumeAnimation) {
        clearInterval(volumeAnimation);
        volumeAnimation = null;
    }
}

function toggleMuteUnmute(){
    if (isMuted) {
        audioTrack.mute();
        endVolumeAnimation();
    } else {
        audioTrack.unmute();
        startVolumeAnimation();
    }
}

const onClick = async (event) => {
    
    event.preventDefault();
    if (!isButtonAlreadyClicked) {
        // Blocks logic from executing again if already in progress
        isButtonAlreadyClicked = true;
        
        try {
            if (!isPreviewAudioConnected) {
                await audioTrack.start();
                isPreviewAudioConnected = true;
            }
            isMuted = !isMuted;
            await toggleMuteUnmute();
            toggleMicButtonStyle();
        } catch (e) {
            console.error('Error toggling mute', e);
        }

        isButtonAlreadyClicked = false;
    } else {
        console.log('=== WARNING: already toggling mic ===');
    }

};


micButton.addEventListener("click", onClick);

// Video preview functions
const webcamButton = document.getElementById('js-preview-webcam-button');

const toggleWebcamButtonStyle = () => webcamButton.classList.toggle('meeting-control-button__off');
const togglePreviewVideo = async () => isWebcamOn ? videoTrack.start(PREVIEW_VIDEO_ELEMENT) : videoTrack.stop();

const videoOnClick = async (event) => {
    event.preventDefault();
    if (!isButtonAlreadyClicked) {
        // Blocks logic from executing again if already in progress
        isButtonAlreadyClicked = true;

        try {
            isWebcamOn = !isWebcamOn;
            await togglePreviewVideo();
            toggleWebcamButtonStyle();
        } catch (e) {
            isWebcamOn = !isWebcamOn;
            console.error('Error toggling video preview', e);
        }

        isButtonAlreadyClicked = false;
    } else {
        console.log('=== WARNING: already toggling webcam ===');
    }
};

webcamButton.addEventListener("click", videoOnClick);

//Join session function

const joinButton = document.getElementById('js-preview-join-button');

// const joinOnClick = async (event) => {
async function joinOnClick(event) {
    event.preventDefault();
    if (!isButtonAlreadyClicked) {
        // Blocks logic from executing again if already in progress
        isButtonAlreadyClicked = true;
        try {
            if (isPreviewAudioConnected) {
              audioTrack.stop();
              isPreviewAudioConnected = false;
            }
            if (isWebcamOn) {
                videoTrack.stop();
            }
            // switchPreviewToLoadingView();
            document.getElementById('js-preview-view').classList.toggle('hidden');
            document.getElementById('js-loading-view').classList.toggle('hidden');

            await joinSession(client);
            
            
            document.getElementById('js-loading-view').classList.toggle('hidden');
            document.getElementById('js-video-view').classList.toggle('hidden');
            $("#js-webcam-button").trigger("click");

           
            
            
            // switchLoadingToSessionView();
        } catch (e) {
            console.error('Error joining session', e);
        }

        isButtonAlreadyClicked = false;
    } else {
        console.log('=== WARNING: already toggling webcam ===');
    }
};

joinButton.addEventListener("click", joinOnClick);

//Join session function 

let stream;


// const joinSession = async (client) => {
function joinSession(){
    return new Promise((resolve) => {

        client.init('en-US').then(() => {

            const iat = Math.round(new Date().getTime() / 1000);
            const exp = iat + 60 * 60 * 2;
            let sdkSecret = 'eSP2SX5hSILcfsu6QX7YyJX9B0yV1mlFewdI';
            // Header
            const oHeader = { alg: 'HS256', typ: 'JWT' };
            // Payload
            const oPayload = {
                app_key: 'ZLUBqdZ0RxWyKzbE5E8F7Q',
                iat,
                exp,
                tpc: 'TEST',
                pwd: '1234',
                user_identity: '',
                session_key: '',
                cloud_recording_option:0,
                role_type: 1 // role=1, host, role=0 is attendee, only role=1 can start session when session not start
            };
            console.log(oPayload)
            const sHeader = JSON.stringify(oHeader);
            const sPayload = JSON.stringify(oPayload);
            // if (cloud_recording_option) {
            //   Object.assign(oPayload, { cloud_recording_option: parseInt(cloud_recording_option, 10) });
            // }
            // if (cloud_recording_election) {
            //   Object.assign(oPayload, { cloud_recording_election: parseInt(cloud_recording_election, 10) });
            // }
            // if (telemetry_tracking_id) {
            //   Object.assign(oPayload, { telemetry_tracking_id });
            // }
            signature = KJUR.jws.JWS.sign('HS256', sHeader, sPayload, sdkSecret);
            console.log(signature)
        
            client.join('TEST', signature, 'userName', '1234').then(() => {
                stream = client.getMediaStream()
                // stream.startVideo()
                stream.startAudio()
                console.log('stream',stream)
                // if Desktop Chrome, Edge, and Firefox with SharedArrayBuffer not enabled, Android browsers, and on devices with less than 4 logical processors available
                if(stream.isRenderSelfViewWithVideoElement()) {
                // start video - video will render automatically on HTML Video element
                    // stream.startVideo({ videoElement: document.querySelector('#my-self-view-video') }).then(() => {
                    //     // show HTML Video element in DOM
                    //     document.querySelector('#my-self-view-video').style.display = 'block'
                    // }).catch((error) => {
                    //     console.log(error)
                    // })
                    // Copy to Clipboard

                    resolve('resolved');
                // desktop Chrome, Edge, and Firefox with SharedArrayBuffer enabled, and all other browsers
                } else {
                // start video
                    // stream.startVideo().then(() => {
                    //     // render video on HTML Canvas element
                    //     stream.renderVideo(document.querySelector('#my-self-view-canvas'), client.getCurrentUserInfo().userId, 1920, 1080, 0, 0, 2).then(() => {
                    //         // show HTML Canvas element in DOM
                    //         document.querySelector('#my-self-view-canvas').style.display = 'block'
                    //     }).catch((error) => {
                    //         console.log(error)
                    //     })
                    //     resolve('resolved');
                    // }).catch((error) => {
                    //     console.log(error)
                    // })
                }
        
            }).catch((error) => {
                console.log(error)
            })
            
            // client.on('user-added', (payload) => {
            //     console.log(payload[0].userId + ' joined the session')
            // })
        
            // client.on('peer-video-state-change', (payload) => {
            //     if (payload.action === 'Start') {
            //         stream.renderVideo(document.querySelector('#participant-videos-canvas'), payload.userId, 1920, 1080, 0, 0, 3)
            //     } else if (payload.action === 'Stop') {
            //         stream.stopRenderVideo(document.querySelector('#participant-videos-canvas'), payload.userId)
            //     }
            // })
        
            // client.on('media-sdk-change', (payload) => {
            //     if (payload.type === 'audio' && payload.result === 'success') {
            //         if (payload.action === 'encode') {
            //         // encode for sending audio stream (speak)
            //         audioEncode = true
            //         } else if (payload.action === 'decode') {
            //         // decode for receiving audio stream (hear)
            //         audioDecode = true
            //         }
            //     }
            // })
        
        //     let participants = client.getAllUser()
        
        // stream.renderVideo(document.querySelector('#participant-videos-canvas'), participants[0].userId, 960, 540, 0, 540, 2)
        // stream.renderVideo(document.querySelector('#participant-videos-canvas'), participants[1].userId, 960, 540, 960, 540, 2)
        //   // continue with business logic and join session function
        }).catch((error) => {
        console.log(error)
        }) 
    }) 

    

}


