<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Notification;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Contracts\Session\Session;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use PHPMailer\PHPMailer\PHPMailer;
class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    use VerifiesEmails;

    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }
    public function show(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect($this->redirectPath());
        } else {
            session()->put('resent', 'This is a message!');
            return view('verification.notification');
        }
    }
    public function verifyAccount(Request $request)
    {
        $user = User::where('password', $request->token)->first();
        if (!is_null($user)) {
            if (!$user->email_verified_at) {

                $ActivityLogs = new ActivityLog;
                $ActivityLogs->user_id = $user->id;

                if ($request->role_id == 6) {
                    $ActivityLogs->title = "New Organization";
                    $ActivityLogs->description = "New Organization " . $user->first_name . ' ' . $user->last_name . " verifyAccount At ";
                } else if ($request->role_id == 5) {
                    $ActivityLogs->title = "New Parent";
                    $ActivityLogs->description = "New Parent " . $user->first_name . ' ' . $user->last_name . " verifyAccount At ";
                } else if ($request->role_id == 4) {
                    $ActivityLogs->title = "New Student";
                    $ActivityLogs->description = "New Student " . $user->first_name . ' ' . $user->last_name . " verifyAccount At ";
                } else if ($request->role_id == 3) {
                    $ActivityLogs->title = "New Tutor";
                    $ActivityLogs->description = "New Tutor " . $user->first_name . ' ' . $user->last_name . " verifyAccount At ";
                }
                $ActivityLogs->save();

                $user->email_verified_at = Carbon::now();
                if (Auth::user()->role_id == "5" || Auth::user()->role_id == "4") {
                $user->status = "Active";
                if(Auth::user()->role_id == "5")
                {
                    createNotification(Auth::user()->role_id,Auth::id(),'Email verification',Auth::user()->username.'Has Verified His Parent Account');
                }

                if(Auth::user()->role_id == "4")
                {
                    createNotification(Auth::user()->role_id,Auth::id(),'Email verification',Auth::user()->username.'Has Verified His Student Account');
                }

                }
                $user->save();
                if (Auth::user()->role_id == "3") {
                    return redirect('profile_verification')->with('success', "Your e-mail is Successfully verified.");
                }
                return redirect('dashboard')->with('success', "Your e-mail is Successfully verified.");
            } else {
                return redirect()->route('login')->with('success', "Your e-mail is already verified. You can now login.");
            }
        }

    }

    public function verificationAccount(Request $request)
    {
        $data = Auth::user();
        $data=['token' => Auth::user()->password, 'user' => Auth::user()];

        $environment = env('APP_ENV', 'local');
        if($environment == 'local'){
            Mail::send('email.emailVerificationEmail', ['token' => Auth::user()->password, 'data' => Auth::user()], function ($message) use ($data) {
                $message->to(Auth::user()->email);
                $message->subject('Email Verification Mail');
            });
        }elseif($environment == 'production'){

            $view = \view('email.emailVerificationEmail',$data);
            $view = $view->render();

            $mail = new PHPMailer();
            $mail->CharSet = "UTF-8";


            $mail->setfrom('support@247tutors.com' , '247 Tutors');

            $mail->isHTML(true);
            $mail->Subject = 'Email Verification Mail';
            $mail->Body    = $view;
            $mail->AltBody = '';
            $mail->addAddress(Auth::user()->email, Auth::user()->first_name.''.Auth::user()->last_name);
              $mail->isHTML(true);
              $mail->msgHTML($view);

            if(!$mail->send()) throw new \Exception('Failed to send mail');
        }

        return back();
    }

}
