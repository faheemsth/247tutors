<?php

namespace App\Http\Controllers;

use Stripe;
use Session;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Subject;
use App\Models\Transaction;
use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;

class DashboardController extends Controller
{
    public function detailprofile()
    {

        $users = User::find(Auth::id());
        return view('super-admin.detailprofile',compact('users'));
    }

    public function upload_file(Request $request){

        $user = User::find(Auth::id());
        $user->update([
            'first_name' => ucfirst(strtolower($request->input('first_name'))),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            // 'password' => Hash::make($request->input('password')), // Hash the password
            'gender' => $request->input('gender'),
            'dob' => $request->input('dob'),
            'profile_description' => $request->input('profile_description'),
            'address' => $request->input('address'),
        ]);
        return redirect('profile_details');

    }
    Public function upload_passwd(Request $request){

        $request->validate([
            'password' => 'required|confirmed'
        ]);

        $user = User::find(Auth::id());
        $user->update([
            'password' => Hash::make($request->input('password')), // Hash the password
        ]);
        return redirect('profile_details');
    }

    public function upload_profile_img(Request $request){
        $imageName = null;
        if($request->hasFile('image')){
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();

            // Move the uploaded image to the 'public/images' directory
            $image->move(public_path('images'), $imageName);
        }


        // Create or retrieve the current user
        $user = User::find(Auth::id());

        $user->update([
        'image' => 'images/' . $imageName, // Store the image path
    ]);


    return redirect('profile_details');

    }
    public function students()
    {
        if (Auth::user()->role_id != 1) {
            return redirect('dashboard');
         }
        $students = User::query();

        if (!empty($_GET['status'])) {
            $students->where('status', $_GET['status']);
        }
        if (!empty($_GET['search'])) {
            $students->where(function ($query) {
                $query->Where('email', 'like', '%' . $_GET['search'] . '%')
                    ->orWhere('first_name', 'like', '%' . $_GET['search'] . '%')
                    ->orWhere('last_name', 'like', '%' . $_GET['search'] . '%')
                    ->orWhere('username', 'like', '%' . $_GET['search'] . '%');
            });
        }

        $students = $students->where('role_id', 4)->paginate(10);
        return view('super-admin.student.index', compact('students'));
    }

    public function update_user_status(Request $request)
    {
        $check_trans = Transaction::where('tutor_id', $request->get('id'))->where('status', '0')->with(['tutor', 'subjects', 'user'])->get();
        User::where('id', $request->get('id'))
            ->update([
                'status' => $request->post('status'),
            ]);
        if (!empty($check_trans)) {

            foreach ($check_trans as $check_tran) {

                $url = URL::temporarySignedRoute(
                    'apperove-subject',
                    Carbon::now()->addMinutes(Config::get('auth.verification.expire', 1)),
                    [
                        'id' => $check_tran->tutor_id,
                        'hash' => sha1($check_tran->id),
                    ]
                );
                $data = [
                    'url' => $url,
                    'tutor' => $check_tran->tutor->first_name . ' ' . $check_tran->tutor->last_name,
                    'student' => $check_tran->user->first_name . ' ' . $check_tran->user->last_name,
                ];
                if ($check_tran->tutor->status != 'Active') {
                    $environment = env('APP_ENV', 'local');
                    if($environment == 'local'){
                        Mail::send('pages.mails.tutorverifybooking', $data, function ($message) use ($check_tran) {
                            $message->to($check_tran->tutor->email, $check_tran->tutor->first_name . ' ' . $check_tran->tutor->last_name)
                                ->subject($check_tran->user->first_name . ' ' . $check_tran->user->last_name . ' Hired You For ' . ($check_tran->subject ? $check_tran->subject->name : 'Unknown'));
                            $message->from($check_tran->user->email, $check_tran->user->first_name . ' ' . $check_tran->user->last_name);
                        });
                    }elseif($environment == 'production'){
                        $view = \view('pages.mails.tutorverifybooking', $data);
                        $view = $view->render();
                        $mail = new PHPMailer();
                        $mail->CharSet = "UTF-8";
                        $mail->setfrom('support@247tutors.com' , '247 Tutors');
                        $mail->isHTML(true);
                        $mail->Subject = $check_tran->user->first_name . ' ' . $check_tran->user->last_name . ' Hired You For ' . ($check_tran->subject ? $check_tran->subject->name : 'Unknown');
                        $mail->Body    = $view;
                        $mail->AltBody = '';
                        $mail->addaddress($check_tran->tutor->email, $check_tran->tutor->first_name . ' ' . $check_tran->tutor->last_name);
                        // dd($mail);
                          $mail->isHTML(true);
                          $mail->msgHTML($view);
                        if(!$mail->send()) throw new \Exception('Failed to send mail');
                    }




                }
            }
        }
    }
}
