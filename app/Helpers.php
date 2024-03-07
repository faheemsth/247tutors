<?php

use App\Models\ActivityLog;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\Payout;
use Stripe\Transfer;
use Stripe\Balance;
use App\Models\Wallet;

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


function PayoutAmount($Price,$AccountNo)
{
    if(Auth::check()){
        
        Stripe::setApiKey(env('STRIPE_SECRET'));
        // $balance = Balance::retrieve();
        // $amount = $balance->available[0]->amount;
        // dd($amount);
        try {
            
            $wallet = Wallet::where('user_id', \Auth::user()->id)->first();
            if (!empty($wallet) && $wallet->net_income > 0) {
                
            // $payout = Payout::create([
            //     'amount' => 10,
            //     'currency' => 'usd',
            //     'destination' => 'acct_1OoKzjSDq7qRUMRw',
            //     'source_type' => 'bank_account',
            // ]);
            
            $transfer = Transfer::create([
                'amount' => 10,
                'currency' => 'usd',
                'destination' => 'acct_1OokqSRAiypBZtje',
                //'source_type' => 'bank_account',
            ]);
            $wallet->withdrawn += $Price;
            $wallet->net_income = $wallet->net_income - $Price;
            $wallet->save();
            
            $response['message'] = " Withdraw successfull! ";
            $response['success'] = true;
            $response['status_code'] = 200;
            return response()->json($response);
                    
            }else{
            $response['message'] = " We cannot process this request! ";
            $response['success'] = true;
            $response['status_code'] = 501;
            return response()->json($response);
            }
                    
        } catch (\Stripe\Exception\CardException $e) {
            $response['message'] = $e->getMessage();
            $response['success'] = true;
            $response['data'] = $e;
            $response['status_code'] = 501;
            return response()->json($response);
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            $response['message'] = $e->getMessage();
            $response['success'] = true;
            $response['data'] = $e;
            $response['status_code'] = 501;
            return response()->json($response);
        } catch (\Stripe\Exception\AuthenticationException $e) {
            $response['message'] = $e->getMessage();
            $response['success'] = true;
            $response['data'] = $e;
            $response['status_code'] = 501;
            return response()->json($response);
        } catch (\Stripe\Exception\ApiConnectionException $e) {
            $response['message'] = $e->getMessage();
            $response['success'] = true;
            $response['data'] = $e;
            $response['status_code'] = 501;
            return response()->json($response);
        } catch (\Stripe\Exception\ApiErrorException $e) {
            $response['message'] = $e->getMessage();
            $response['success'] = true;
            $response['data'] = $e;
            $response['status_code'] = 501;
            return response()->json($response);
        }
        
       
    }

}

?>
