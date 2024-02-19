<?php

use App\Models\ActivityLog;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

if (!function_exists('viewlike')) {
function viewlike($to){
    $viewlike=\App\Models\LikeDislike::where('from_user_id',Auth::id())
                                  ->where('to_user_id',$to)->first();
     if(empty($viewlike)){
        return 0;
     }else{
       return $viewlike->action;
     }
}
}


function CheckAgeUnder16()
{
    if(Auth::check()){
        if (time() - strtotime(Auth::user()->dob) < 16 * 31536000) {
            return false;
        }
        return true;
    }

}

function createNotification($UserType,$UserID,$Title,$Description)
{
    if(Auth::check()){
     $noti = new Notification;
     $noti->user_type = $UserType;
     $noti->user_id = $UserID;
     $noti->title = $Title;
     $noti->description = $Description;
     $noti->save();
     return true;
    }

}


function createActivityLog($UserID,$Title,$Description)
{
    if(Auth::check()){
        $ActivityLogs = new ActivityLog;
        $ActivityLogs->user_id = $UserID;
        $ActivityLogs->title = $Title;
        $ActivityLogs->description = $Description;
        $ActivityLogs->save();
     return true;
    }

}
?>
