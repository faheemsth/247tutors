<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Models\Wallet;

class LoginWithGoogleController extends Controller
{
     public function redirectToGoogle()
    {
        if(!empty($_GET['role'])){
            setcookie('id', $_GET['role'], time() + (86400 * 30), "/");
        }
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {

        $dateString = Carbon::now();
        try {
            $user = Socialite::driver('google')->user();

            $finduser = User::where('google_id', $user->id)->first();
            // dd($finduser);
            if($finduser){

                Auth::login($finduser);

                return redirect()->intended('dashboard');

            }else{

                $finduser = User::where('email', $user->email)->first();
                if($finduser){
                    return redirect('login')->with('failed', 'Kindly login using your account password.');
                }else{
                    $value = $_COOKIE['id'] ?? null;
                    if($value != null){
                        if($value == 3){
                            $f_name = '';
                            $l_name = '';

                            if($user->name != null && $user->name != ''){
                                $name = explode(' ',$user->name);
                                $f_name = $name[0];
                                $l_name = $name[1];

                            }
                            $newUser = User::create([
                                'first_name' => $f_name,
                                'last_name' => $l_name,
                                'username' => $l_name.rand ( 100 , 999 ),
                                'phone' => '1234',
                                'email' => $user->email,
                                'status' => 'Pending',
                                'role_id' => 3,
                                'email_verified_at' => $dateString,
                                'google_id' => $user->id,
                                'password' => Hash::make($user->password),
                            ]);
                           $wallet = new Wallet();
                           $wallet->user_id = $newUser->id;
                           $wallet->wallet_id = Str::uuid()->toString();
                           $wallet->save();
                           createNotification($newUser->role_id,$newUser->id,'Tutor Signup','Comptaint By ' .$newUser->username);
                            $ActivityLogs = new ActivityLog;
                            $ActivityLogs->user_id = $newUser->id;
                            $ActivityLogs->title = "New Tutor";
                            $ActivityLogs->description ="New Tutor".$newUser->first_name .'   '. $newUser->last_name."  SignUp At ";
                            $ActivityLogs->save();

                            Auth::login($newUser);

                            return redirect('profile_verification');

                        }elseif($value == 4){
                            $f_name = '';
                            $l_name = '';

                            if($user->name != null && $user->name != ''){
                                $name = explode(' ',$user->name);
                                $f_name = $name[0];
                                $l_name = $name[1] ?? $f_name;

                            }
                            $newUser = User::create([
                                'first_name' => $f_name,
                                'last_name' => $l_name,
                                'username' => $l_name.rand ( 100 , 999 ),
                                'phone' => '1234',
                                'email' => $user->email,
                                'status' => 'Active',
                                'role_id' => 4,
                                'email_verified_at' => $dateString,
                                'google_id' => $user->id,
                                'password' => Hash::make($user->password),
                            ]);
                           $wallet = new Wallet();
                           $wallet->user_id = $newUser->id;
                           $wallet->wallet_id = Str::uuid()->toString();
                           $wallet->save();

                            $ActivityLogs = new ActivityLog;
                            $ActivityLogs->user_id = $newUser->id;
                            $ActivityLogs->title = "New Student";
                            $ActivityLogs->description ="New Student".$user->first_name .'   '. $user->last_name."  SignUp At ";
                            $ActivityLogs->save();

                            Auth::login($newUser);

                            return redirect('student/home');

                        }elseif($value == 5){
                            $f_name = '';
                            $l_name = '';

                            if($user->name != null && $user->name != ''){
                                $name = explode(' ',$user->name);
                                $f_name = $name[0];
                                $l_name = $name[1];

                            }
                            $newUser = User::create([
                                'first_name' => $f_name,
                                'last_name' => $l_name,
                                'username' => $l_name.rand ( 100 , 999 ),
                                'phone' => '1234',
                                'email' => $user->email,
                                'status' => 'Active',
                                'role_id' => 5,
                                'email_verified_at' => $dateString,
                                'google_id' => $user->id,
                                'password' => Hash::make($user->password),
                            ]);
                           $wallet = new Wallet();
                           $wallet->user_id = $newUser->id;
                           $wallet->wallet_id = Str::uuid()->toString();
                           $wallet->save();

                            $ActivityLogs = new ActivityLog;
                            $ActivityLogs->user_id = $newUser->id;
                            $ActivityLogs->title = "New Parent";
                            $ActivityLogs->description ="New Parent".$user->first_name .'   '. $user->last_name."  SignUp At ";
                            $ActivityLogs->save();

                            Auth::login($newUser);

                            return redirect('parent/home');

                        }elseif($value == 6){
                            $f_name = '';
                            $l_name = '';

                            if($user->name != null && $user->name != ''){
                                $name = explode(' ',$user->name);
                                $f_name = $name[0];
                                $l_name = $name[1];
                            }
                            $newUser = User::create([
                                'first_name' => $f_name,
                                'last_name' => $l_name,
                                'username' => $l_name.rand ( 100 , 999 ),
                                'phone' => '1234',
                                'email' => $user->email,
                                'status' => 'Active',
                                'role_id' => 6,
                                'email_verified_at' => $dateString,
                                'google_id' => $user->id,
                                'password' => Hash::make($user->password),
                            ]);

                           $wallet = new Wallet();
                           $wallet->user_id = $newUser->id;
                           $wallet->wallet_id = Str::uuid()->toString();
                           $wallet->save();

                            $ActivityLogs = new ActivityLog;
                            $ActivityLogs->user_id = $newUser->id;
                            $ActivityLogs->title = "New Organization";
                            $ActivityLogs->description ="New Organization".$user->first_name .'   '. $user->last_name."  SignUp At ";
                            $ActivityLogs->save();

                            Auth::login($newUser);

                            return redirect('organization/home');
                        }

                    }else{
                        return redirect('login')->with('failed', 'Kindly select proper user role you want to sign in with.');
                    }

                }

            }

        } catch (Exception $e) {
            dd($e);
           return back();
        }
    }
}
