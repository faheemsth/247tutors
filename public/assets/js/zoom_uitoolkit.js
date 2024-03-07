import uitoolkit from '/videosdk-ui-toolkit-web-main/index.js';

var previewContainer = document.getElementById('previewContainer');

// uitoolkit.openPreview(previewContainer)
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
    tpc: booking_id,
    pwd: '1234',
    user_identity: '',
    session_key: '',
    cloud_recording_option: 0,
    role_type: 1, // role=1, host, role=0 is attendee, only role=1 can start session when session not start
    features: ['video', 'audio', 'share', 'chat', 'users', 'settings']
};

console.log(oPayload);

const sHeader = JSON.stringify(oHeader);
const sPayload = JSON.stringify(oPayload);
let signature = KJUR.jws.JWS.sign('HS256', sHeader, sPayload, sdkSecret);

console.log(signature);
console.log(booking_id);

var config = {
    videoSDKJWT: signature,
    sessionName: booking_id,
    userName: user.first_name + ' ' + user.last_name,
    tpc: booking_id,
    sessionPasscode: '1234',
    features: ['video', 'audio', 'share', 'chat', 'users', 'settings']
};

var sessionContainer = document.getElementById('sessionContainer');

uitoolkit.joinSession(sessionContainer, config);

var sessionJoined = (() => {
    console.log('session joined');
    var role_id = $("#role_id").val();

    if(role_id == 3){
        startRecording();
    }
});

var sessionClosed = (() => {
    console.log('session closed');
    var role_id = $("#role_id").val();

    if(role_id == 3){
        stopRecording();
    }
});

let systemAudioRecorder;
let screenRecorder;
let captureStream;

async function startRecording() {
    try {
        // Capture screen and system audio
        captureStream = await navigator.mediaDevices.getDisplayMedia({ video: true, audio: true });

        if (!captureStream.getAudioTracks().length) {
            // Stop the screen sharing tracks
            captureStream.getTracks().forEach(track => track.stop());

            alert('No audio device is connected. Please connect an audio device to enable system audio.');
            startRecording();
            return;
        }

        // Extract screen stream and system audio stream
        const screenStream = new MediaStream(captureStream.getVideoTracks());
        const systemAudioStream = new MediaStream(captureStream.getAudioTracks());

        // Initialize system audio recorder
        systemAudioRecorder = new MediaRecorder(systemAudioStream);
        let systemAudioChunks = [];
        systemAudioRecorder.ondataavailable = (event) => {
            systemAudioChunks.push(event.data);
        };
        systemAudioRecorder.onstop = () => {};
        systemAudioRecorder.start();

        // Capture microphone audio
        const microphoneStream = await navigator.mediaDevices.getUserMedia({ audio: true });

        // Combine system audio and microphone audio streams
        const audioCtx = new AudioContext();
        const systemAudioSource = audioCtx.createMediaStreamSource(systemAudioStream);
        const microphoneSource = audioCtx.createMediaStreamSource(microphoneStream);
        const destination = audioCtx.createMediaStreamDestination();
        systemAudioSource.connect(destination);
        microphoneSource.connect(destination);
        const combinedAudioStream = destination.stream;

        // Start screen recording with combined audio
        const combinedStream = new MediaStream([...screenStream.getTracks(), ...combinedAudioStream.getTracks()]);
        screenRecorder = new MediaRecorder(combinedStream);
        let screenChunks = [];
        screenRecorder.ondataavailable = (event) => {
            screenChunks.push(event.data);
        };
        screenRecorder.onstop = () => {
            const screenBlob = new Blob(screenChunks, { type: 'video/webm' });
            saveVideo(screenBlob); // Save the video
        };

        screenRecorder.start();
    } catch (error) {
        if (error.name === 'NotAllowedError') {
            alert('Permission denied. Please allow access to screen and audio devices.');
            startRecording();
        } else {
            console.error('Error accessing media devices:', error);
        }
    }
}

function stopRecording() {
    if (systemAudioRecorder) {
        systemAudioRecorder.stop();
    }

    if (screenRecorder) {
        screenRecorder.stop();
    }

    // Stop the screen sharing tracks if they exist
    if (captureStream) {
        captureStream.getTracks().forEach(track => track.stop());
    }
}

function saveVideo(blob) {
    const formData = new FormData();
    const booking_id = $("#recording-uuid").val();
    formData.append('video', blob);
    formData.append('booking_uid', booking_id);


    // Get the CSRF token value from the meta tag
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    fetch('/save-video', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken // Include the CSRF token in the headers
        },
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        console.log(data); // Log the response from the server
        if (data && data.message) {
            console.log(data.message);
        } else {
            console.error('Failed to save video on server');
        }
    })
    .catch(error => console.error('Error:', error));
}

uitoolkit.onSessionJoined(sessionJoined);

uitoolkit.onSessionClosed(sessionClosed);
