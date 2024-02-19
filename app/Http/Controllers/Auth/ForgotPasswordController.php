<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */
    // use SendsPasswordResetEmails;

    public function sendResetLinkEmail(Request $request)
    {
        
        $imagePath = public_path('assets/images/247 NEW Logo 1.png');
        try {
            $name=User::where('email',$request->input('email'))->first();
            $data = [
                'url' => url('password/reset') . '/' . $request->input('_token') . '?email=' . $request->input('email'),
                'name' => !empty($name)? $name->first_name .' '.$name->last_name :'',
            ];
            $view = \view('auth.passwords.resetPassword', $data);
            $view = $view->render();

            $mail = new PHPMailer();
            $mail->CharSet = "UTF-8";

            $mail->setfrom('support@247tutors.com', '247 Tutors');

            $mail->isHTML(true);
            $mail->Subject = 'Reset Password';
            $mail->Body = $view;
            $mail->AddEmbeddedImage($imagePath, 'logo');
            $mail->AltBody = '';
            $mail->addaddress($request->input('email'));
            $mail->isHTML(true);
            $mail->msgHTML($view);

            if (!$mail->send()) {
                throw new \Exception('Failed to send mail. Error: ' . $mail->ErrorInfo);
            }
            return back()->with('success', 'Check Your Email');
        } catch (\Exception $e) {
            echo 'Message could not be sent. Mailer Error: ', $e->getMessage();
        }
    }




    public function verifyCode(Request $request)
    {

        $user = User::where('code', $request->code)->first();

        if (!$user) {
            return redirect()->back()->with('error', 'code is Incorrect.');
        }

        Auth::login($user);

        return redirect('dashboard')->with('success', 'Password reset successfully.');
    }
    
    public function ResetPassword(Request $request)
    {

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return redirect()->back()->with('error', 'Email not found.');
        }

        $hashedPassword = Hash::make($request->password);

        $user->password = $hashedPassword;
        $user->save();

        Auth::login($user);

        return redirect('dashboard')->with('success', 'Password reset successfully.');
    }
}
