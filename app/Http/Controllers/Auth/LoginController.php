<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Mail\MagicLoginLink;
use App\Models\User;
use App\Models\LoginToken;
use PHPMailer\PHPMailer\PHPMailer;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest')->except('logout');
    }

    public function loginRoles(){
        return view('auth/loginRoles');
    }
    public function roleget()
    {
        session(['login_message' => $_GET['message']]);
        session(['login_message1' => $_GET['message1']]);
        return response()->json(['message' =>$_GET['message']]);
    }

    public function showLoginForm(){
        return view('auth/login');
    }
    
    public function adminshowLoginForm(){
        return view('auth/adminlogin');
    }

    // custom logout function
    // redirect to login page
    public function logout(Request $request)
    {
        unset($_COOKIE['id']);
        $user=Auth::user();
        $user->code=null;
        $user->code_verify=null;
        $user->save();
        createActivityLog(Auth::user()->id,"SignUp User ",Auth::user()->first_name .'   '. Auth::user()->last_name."  Logout At ");
        $this->guard()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($response = $this->loggedOut($request)) {

            return $response;
        }

        return $request->wantsJson()
            ? new Response('', 204)
            : redirect('/login');
    }

    public function magicLogin($email){
        $user = User::where('email',$email)->first();
        
        $name= !empty($user)? $user->first_name. ' '.$user->last_name : '';
        
        if($user){
            if($user->role_id == 1){
                return redirect('login')->with('failed', 'Login using your password');
            }else{
                $plaintext = Str::random(32);
                $token = $user->loginTokens()->create([
                    'token' => hash('sha256', $plaintext),
                    'expires_at' => now()->addYear(1),
                ]);
                // dd($user);
                $html = (new MagicLoginLink($plaintext, $token->expires_at, $name))->render();
                $template = htmlentities($html);

                $admin_temp = html_entity_decode($template);
               $environment = env('APP_ENV', 'local');
               if ($environment == 'local') {

                Mail::raw($admin_temp, function ($message) use ($user,$admin_temp) {
                    $message->to($user->email)
                        ->subject('Login with Magic Link')
                    ->html($admin_temp);
                 });
               } elseif ($environment == 'production') {

                    $mail = new PHPMailer();
                    $mail->CharSet = "UTF-8";

                    $mail->setfrom('support@247tutors.com', '247 Tutors');

                    $mail->isHTML(true);
                    $mail->Subject = 'Login with Magic Link';
                    $mail->Body = $admin_temp;
                    $mail->AltBody = '';
                    $mail->addaddress($user->email);
                    $mail->isHTML(true);
                    $mail->msgHTML($admin_temp);

                    if (!$mail->send())
                        throw new \Exception('Failed to send mail');



               }
                return redirect('login')->with('success', 'Check your email and click on magic link for login');

            }

        }else{

            return redirect('login')->with('failed', 'Try again');
        }
    }

    public function userverifyLoginToken($token){

        $token = LoginToken::whereToken(hash('sha256', $token))->firstOrFail();
        $user = $token->user;

        if($user->role_id == 3){

            \Auth::login($token->user);
            return redirect('tutor/home');

        }elseif($user->role_id == 4){

            \Auth::login($token->user);
            return redirect('student/home');

        }elseif($user->role_id == 5){

            \Auth::login($token->user);
            return redirect('parent/home');

        }elseif($user->role_id == 6){

            \Auth::login($token->user);
            return redirect('organization/home');

        }


    }
}
