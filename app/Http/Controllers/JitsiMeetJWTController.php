<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Firebase\JWT\JWT;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Support\Facades\{File};

class JitsiMeetJWTController extends Controller
{

    public function index($id){

        $user = \Auth::user();
        $API_KEY="vpaas-magic-cookie-8d3bcf37e1c44245a9ac53d5b8cca469/d584f5";
        $APP_ID="vpaas-magic-cookie-8d3bcf37e1c44245a9ac53d5b8cca469";
        $USER_EMAIL=$user->email;
        $USER_NAME=$user->username;
        $USER_IS_MODERATOR = (Auth::user()->role_id == '3') ? true : false;
        $USER_AVATAR_URL="";
        $USER_ID=$user->id;
        $LIVESTREAMING_IS_ENABLED=true;
        $RECORDING_IS_ENABLED=true;
        $OUTBOUND_IS_ENABLED=false;
        $TRANSCRIPTION_IS_ENABLED=false;
        $EXP_DELAY_SEC=7200;
        $NBF_DELAY_SEC=0;
        $private_key = file_get_contents(public_path('images/rsa-private.pk'));
        $token = $this->create_jaas_token($API_KEY,$APP_ID,$USER_EMAIL,$USER_NAME,$USER_IS_MODERATOR,
        $USER_AVATAR_URL,$USER_ID,$LIVESTREAMING_IS_ENABLED,$RECORDING_IS_ENABLED,$OUTBOUND_IS_ENABLED,
                            $TRANSCRIPTION_IS_ENABLED,$EXP_DELAY_SEC,$NBF_DELAY_SEC,$private_key);
        return view('pages.onlinemeeting.jitsi',compact('id','token'));
    }

    // Use the following function to generate your JaaS JWT.
    private function create_jaas_token($api_key,$app_id,$user_email,$user_name,$user_is_moderator,
        $user_avatar_url,$user_id,$live_streaming_enabled,$recording_enabled,$outbound_enabled,$transcription_enabled,
        $exp_delay,$nbf_delay,$private_key) {


        $payload = array(
            'iss' => 'chat',
            'aud' => 'jitsi',
            'exp' => time() + $exp_delay,
            'nbf' => time() - $nbf_delay,
            'room'=> '*',
            'sub' => $app_id,
            'context' => [
                'user' => [
                    'moderator' => $user_is_moderator ? "true" : "false",
                    'email' => $user_email,
                    'name' => $user_name,
                    'avatar' => $user_avatar_url,
                    'id' => $user_id
                ],
                'features' => [
                    'recording' => $recording_enabled ? "true" : "false",
                    'livestreaming' => $live_streaming_enabled ? "true" : "false",
                    'transcription' => $transcription_enabled ? "true" : "false",
                    'outbound-call' => $outbound_enabled ? "true" : "false"
                ]
            ]
        );
        $token = JWT::encode($payload, $private_key, "RS256", $api_key);
        return $token;
    }

    public function zoom_meet($id){
        $booking = Booking::where('uuid',$id)->first();
        if(Auth::user()->role_id == 3){
            $booking->is_meet_tutor += 1;
        }
        
        if(Auth::user()->role_id == 4){
            $booking->is_meet_student += 1;
        }
        
        
        //$booking->save();

        return view('zoom',compact('booking'));
    }
    
    public function zoom_meet_interview($id){
        $booking = User::where('Interview_meeting_id',$id)->first();
        if(Auth::user()->role_id == 3){
            $booking->is_meet_tutor += 1;
        }
        
        if(Auth::user()->role_id == 1){
            $booking->is_meet_admin += 1;
        }
        
        
        $booking->save();

        return view('zoom',compact('booking'));
    }
    

    public function saveRecording(Request $request){

        $file = $request->file('source');

        $target_dir = 'storage/videos';

        if (!File::isDirectory($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        
        $random_no = time();
        $file_name = '247T-'.$random_no.'-'.$file->getClientOriginalName();
        
        $file->move($target_dir, $file_name);

        // file_put_contents($target_dir, base64_decode($videoData));

        return response()->json(['success' => true, 'filePath' => $file_name]);

    }

}
