<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Subject;
use App\Models\TutorSubjectOffer;
use App\Models\User;
use App\Models\Wallet;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Exception;
use PHPMailer\PHPMailer\PHPMailer;
use Carbon\Carbon;
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    // use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    // protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function select_user_type()
    {
        return view('auth.selectusertype');
    }

    public function Student()
    {
        $subjects = Subject::all();
        return view('auth.student', compact('subjects'));
    }

    public function Tutor()
    {
        $subjects = Subject::all();
        return view('auth.tutor', compact('subjects'));
    }

    public function Parent()
    {
        $subjects = Subject::all();
        return view('auth.parent', compact('subjects'));
    }

    public function Organization()
    {
        $subjects = Subject::all();
        return view('auth.organization', compact('subjects'));
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $commonRules = [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:255'],
        ];

        if ($data['role_id'] !== '6') {
            $commonRules['password'] = ['required', 'string'];
        } else {
            $commonRules += [
                'fname' => ['required', 'string', 'max:255'],
                'lname' => ['required', 'string', 'max:255'],
            ];
        }

        return Validator::make($data, $commonRules);
    }



    protected function email_check(Request $request)
    {
        $email = $request->input('email');

        $user = User::where('email', $email)->first();

        if ($user) {
            return response()->json(['unique' => false]);
        }

        return response()->json(['unique' => true]);
    }
    protected function username_check(Request $request)
    {
        $username = $request->input('username');

        $user = User::where('username', $username)->first();

        if ($user) {
            return response()->json(['unique' => false]);
        }

        return response()->json(['unique' => true]);
    }





    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function register(Request $request)
    {
        // tutor
        $data = $request->all();



        if ($data['role_id'] == 3) {
            $user = User::create([
                'first_name' => ucfirst(strtolower($data['fname'])),
                'last_name' => ucfirst(strtolower($data['lname'])),
                'phone' => $data['code'] . $data['phone'],
                'email' => $data['email'],
                'status' => 'Pending',
                'role_id' => $data['role_id'],
                'dob' => $data['dob'],
                'username' => ucfirst(strtolower($data['username'])),
                'subjects' => !empty($data['subject']) ? implode(',', $data['subject']) : null,
                'password' => Hash::make($data['password']),
            ]);
            $ActivityLogs = new ActivityLog;
            $ActivityLogs->user_id = $user->id;
            $ActivityLogs->title = "New Tutor";
            $ActivityLogs->description ="New Tutor".$user->first_name .'   '. $user->last_name."  SignUp At ";
            $ActivityLogs->save();

        }
        // student
        else if ($data['role_id'] == '4') {
            $user = User::create([
                'first_name' => ucfirst(strtolower($data['fname'])),
                'last_name' => ucfirst(strtolower($data['lname'])),
                'phone' => $data['code'] . $data['phone'],
                'email' => $data['email'],
                'status' => 'Pending',
                'role_id' => $data['role_id'],
                'username' => ucfirst(strtolower($data['username'])),
                'dob' => $data['dob'],
                'subjects' => implode(',', $data['subject']),
                'password' => Hash::make($data['confirm-password']),
            ]);

            $ActivityLogs = new ActivityLog;
            $ActivityLogs->user_id = $user->id;
            $ActivityLogs->title = "New Student";
            $ActivityLogs->description ="New Student".$user->first_name .'   '. $user->last_name."  SignUp At ";
            $ActivityLogs->save();
        }
        // parent
        else if ($data['role_id'] == '5') {
            $user = User::create([
                'first_name' => ucfirst(strtolower($data['fname'])),
                'last_name' => ucfirst(strtolower($data['lname'])),
                'phone' => $data['code'] . $data['phone'],
                'email' => $data['email'],
                'status' => 'Pending',
                'role_id' => $data['role_id'],
                'username' => ucfirst(strtolower($data['username'])),
                'subjects' => implode(',', $data['subject']),
                'password' => Hash::make($data['password']),
                'parent_authority' => $data['parent_authority'],
            ]);
        $parentId=User::where('email', $data['email'])->first()->id;
            $studentData = [
                'first_name' => ucfirst(strtolower($request->input('stufname'))),
                'last_name' => $request->input('stulname'),
                'phone' => $request->input('stucode') . $request->input('stuphone'),
                'email' => $request->input('stuemail'),
                'username' => $request->input('stulname').rand ( 100 , 999 ),

                'status' => 'Active',
                'email_verified_at' => Carbon::now(),
                'role_id' => '4',
                'password' => Hash::make($data['password']),
                'parent_id' => $parentId
            ];

            User::create($studentData);
            $ActivityLogs = new ActivityLog;
            $ActivityLogs->user_id = $user->id;
            $ActivityLogs->title = "New Parent";
            $ActivityLogs->description ="New Parent".$user->first_name .'   '. $user->last_name."  SignUp At ";
            $ActivityLogs->save();
        }

        // orgnizations
        else if ($data['role_id'] == '6') {

            // $nameArray = explode(' ', $request->name);

            // $firstName = $nameArray[0];
            // $lastName = $nameArray[1];

            $user = User::create([
                'first_name' => ucfirst(strtolower($request->name)),
                'last_name' => '',
                'phone' => $data['code'] . $data['phone'],
                'email' => $data['email'],
                'cpfname' => $data['cpfname'],
                'cplname' => $data['cplname'],
                'cpemail' => $data['cpemail'],
                'zipcode' => $data['zipcode'],
                'status' => 'Active',
                'role_id' => $data['role_id'],
                'password' => Hash::make('1234'),
            ]);
            $ActivityLogs = new ActivityLog;
            $ActivityLogs->user_id = $user->id;
            $ActivityLogs->title = "New Orgnization";
            $ActivityLogs->description ="New Orgnization".$user->first_name .'   '. $user->last_name."  SignUp At ";
            $ActivityLogs->save();
        }



        $wallet = new Wallet();
        $wallet->user_id = $user->id;
        $wallet->wallet_id = Str::uuid()->toString();
        $wallet->save();

        try {
            $data=['token' => $user->password, 'user' => $user];

            $environment = env('APP_ENV', 'local');
            if($environment == 'local'){
                Mail::send('email.emailVerificationEmail', ['token' => $user->password, 'user' => $user], function ($message) use ($user) {
                    $message->to($user->email);
                    $message->subject('Email Verification Mail');
                });
            }elseif($environment == 'production'){
                $imagePath = public_path('assets/images/247 NEW Logo 1.png');


                $view = \view('email.emailVerificationEmail',$data);
                $view = $view->render();
                $mail = new PHPMailer();
                $mail->CharSet = "UTF-8";
                $mail->setfrom('support@247tutors.com' , '247 Tutors');
                $mail->isHTML(true);
                $mail->Subject = 'Email Verification Mail';
                $mail->Body = $view;
                $mail->AddEmbeddedImage($imagePath, 'logo');
                $mail->AltBody = '';
                $mail->addAddress($user->email, $user->first_name.''.$user->last_name);
                $mail->isHTML(true);
                $mail->msgHTML($view);

                if(!$mail->send()) throw new \Exception('Failed to send mail');
            }


        } catch (Exception $e) {
            $response['success'] = false;
            $response['message'] = 'Error in mail sending';
            $response['status'] = 202;

        }

        // Auth::login($user);

        $response['success'] = true;
        $response['message'] = 'User created successfully!';
        $response['status'] = 200;
        // return redirect('tutor/home');

        return response()->json($response);

    }
}
