import uitoolkit from '/videosdk-ui-toolkit-web-main/index.js'
var previewContainer = document.getElementById('previewContainer')

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
    cloud_recording_option:0,
    role_type: 1, // role=1, host, role=0 is attendee, only role=1 can start session when session not start
    features: ['video', 'audio', 'share', 'chat', 'users', 'settings']

};
console.log(oPayload)
const sHeader = JSON.stringify(oHeader);
const sPayload = JSON.stringify(oPayload);
let signature = KJUR.jws.JWS.sign('HS256', sHeader, sPayload, sdkSecret);

console.log(signature)
console.log(booking_id)

var config = {
    videoSDKJWT: signature,
    sessionName: booking_id,
    userName: user.first_name+' '+user.last_name,
    tpc: booking_id,
    sessionPasscode: '1234',
    features: ['video', 'audio', 'share', 'chat', 'users', 'settings']
  }

  var sessionContainer = document.getElementById('sessionContainer')

uitoolkit.joinSession(sessionContainer, config)

var sessionJoined = (() => {
    console.log('session joined')
    startRecording();
})

var sessionClosed = (() => {
    console.log('session closed')
    stopRecording();
})

function startRecording() {
    $.ajax({
        url: "/start-recording",
        type: "GET",
        contentType: "application/json",
        data: JSON.stringify({}),
        async: true, // Explicitly setting async to true (default behavior)
        success: function (responseData) {
            $("#recording-uuid").val(responseData.sessionId);
            alert(responseData.sessionId);
            console.log(responseData);
        },
        error: function (xhr, status, error) {
            console.error("Error starting recording:", error);
        },
    });
}

function stopRecording() {
    var uuid = $("#recording-uuid").val();
    // Create a new XMLHttpRequest object
    var xhr = new XMLHttpRequest();

    // Configure the request
    xhr.open("GET", "/stop-recording?uuid=" + uuid, true);

    // Set up a callback function to handle the response
    xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                // Handle the response from the server
                console.log(xhr.responseText);
            } else {
                // Handle errors
                console.error("Request failed:", xhr.status);
            }
        }
    };

    // Send the request
    xhr.send();
}


uitoolkit.onSessionJoined(sessionJoined)

uitoolkit.onSessionClosed(sessionClosed)

