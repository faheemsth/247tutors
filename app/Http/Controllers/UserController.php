<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Controllers\DB;
use App\Models\ActivityLog;
use App\Models\Subject;
use App\Models\TutorApplication;
use App\Models\TutorQualification;
use App\Models\TutorSubjectOffer;
use App\Models\User;
use App\Models\Availability;
use App\Models\Notification;
use DataTables;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Mail;
use PHPMailer\PHPMailer\PHPMailer;
use Illuminate\Support\Facades\Auth;
use PDF;

class UserController extends Controller
{
    /**
     * Show the users dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $users = User::get();

        return view('user.users', ['users' => $users]);
    }



    public function create()
    {
        $roles = Role::all();
        return view('/user.adduser', compact('roles'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'password' => 'required',
            'email' => 'required'
        ]);
        $image = $request->file('image');
        $imageName = time() . '_' . $image->getClientOriginalName();
        $image->move(public_path('images'), $imageName);

        $newUser = User::create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'phone' => $request->input('phone'),
            'gender' => $request->input('gender'),
            'dob' => $request->input('dob'),
            'facebook_link' => $request->input('facebook_link'),
            'linkedin_link' => $request->input('linkedin_link'),
            'twitter_link' => $request->input('twitter_link'),
            'status' => $request->input('status'),
            'profile_description' => $request->input('profile_description'),
            'address' => $request->input('address'),
            'image' => 'images/' . $imageName,
        ]);

        return redirect('/users');
    }

    public function edit($id)
    {
        $user = user::where('id', $id)->first();
        $roles = Role::all();
        return view('user/edituser', ['users' => $user, 'roles' => $roles]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'password' => 'required',
            'email' => 'required'
        ]);
        $image = $request->file('image');
        $imageName = time() . '_' . $image->getClientOriginalName();
        $image->move(public_path('images'), $imageName);
        $edituser = User::where('id', $id)->first();
        $edituser->update([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'phone' => $request->input('phone'),
            'gender' => $request->input('gender'),
            'dob' => $request->input('dob'),
            'facebook_link' => $request->input('facebook_link'),
            'linkedin_link' => $request->input('linkedin_link'),
            'twitter_link' => $request->input('twitter_link'),
            'status' => $request->input('status'),
            'profile_description' => $request->input('profile_description'),
            'address' => $request->input('address'),
            'image' => 'images/' . $imageName,
        ]);
        return redirect('/users');
    }

    public function delete($id)
    {
        $deleteuser = User::where('id', $id)->first();
        $deleteuser->delete();
        return redirect('/users');
    }

    public function permissions($id)
    {
        return view('user.permissions', compact('id'));
    }

    public function tutors()
    {
        if (Auth::user()->role_id != 1) { return redirect('dashboard'); }
        $tutors = User::query();

        if (!empty($_GET['status'])) {
            $tutors->where('status', $_GET['status']);
        }
        if (!empty($_GET['search'])) {
            $tutors->where(function ($query) {
                $query->Where('email', 'like', '%' . $_GET['search'] . '%')
                    ->orWhere('first_name', 'like', '%' . $_GET['search'] . '%')
                    ->orWhere('last_name', 'like', '%' . $_GET['search'] . '%')
                    ->orWhere('username', 'like', '%' . $_GET['search'] . '%');
            });
        }
        $tutors = $tutors->where('role_id', 3)->paginate(10);

        return view('super-admin.tutor.index', compact('tutors'));
    }

    public function tutorProfile($id)
    {
        if (Auth::user()->role_id != 1) { return redirect('dashboard'); }
         $complaintUser=User::join('bookings', 'users.id', '=', 'bookings.tutor_id')
                            ->join('complaints', 'bookings.uuid', '=', 'complaints.booking_id')
                            ->where('users.id',$id)
                            ->select('users.*')->get();
        
                        
        if(!empty($_GET['NoteId']))
        {
            Notification::find($_GET['NoteId'])->update(['is_read' => 1]);
        }
        $tutor = User::find($id);
        $Subjects = Subject::all();
        $tutor_qualifications = TutorQualification::where('tutor_id', $id)->get();
        $tutor_application = TutorApplication::where('tutor_id', $id)->first();
        $availabilitys = Availability::where('tutor_id', $id)->get();
        return view('super-admin.tutor.detailprofile', get_defined_vars());
    }































    public function complaintStagesSubmit(Request $request)
    {
            $this->validate($request, [
                'id' => 'required|numeric',
                'complaint_message' => 'required|string',
                'complaint_stage' => 'required|string',
            ]);
            $tutor = User::find($request->id);
            if (!$tutor) {
                throw new \Exception('User not found');
            }

            $data = [
                'tutor' => $tutor->first_name . ' ' . $tutor->last_name,
            ];
            $imagePath = public_path('assets/images/247 NEW Logo 1.png');
            
            if($request->input('complaint_stage') == 'Personal inform'){
                
                    $view = view('pages.mails.TutorComplaintActionInform', $data)->render();
                    $mail = new PHPMailer(true);
                    $mail->CharSet = 'UTF-8';
                    $mail->setFrom('support@247tutors.com', '247 Tutors');
                    $mail->isHTML(true);
                    $mail->Subject = " Important Notice Regarding Action Taken on Student Complaint";
                    $mail->Body = $view;
                    $mail->AddEmbeddedImage($imagePath, 'logo');
                    $mail->AltBody = '';
                    $mail->addAddress($tutor->email, $tutor->first_name . ' ' . $tutor->last_name);
                    $mail->isHTML(true);
                    $mail->msgHTML($view);
                    $mail->send();
                    
                    

            }elseif($request->input('complaint_stage') == 'Disclaimer'){
                
                    $view = view('pages.mails.TutorComplaintActionDisclaimer', $data)->render();
                    $mail = new PHPMailer(true);
                    $mail->CharSet = 'UTF-8';
                    $mail->setFrom('support@247tutors.com', '247 Tutors');
                    $mail->isHTML(true);
                    $mail->Subject = "Final Warning Regarding Student Complaint Action";
                    $mail->Body = $view;
                    $mail->AddEmbeddedImage($imagePath, 'logo');
                    $mail->AltBody = '';
                    $mail->addAddress($tutor->email, $tutor->first_name . ' ' . $tutor->last_name);
                    $mail->isHTML(true);
                    $mail->msgHTML($view);
                    $mail->send();
                
            }elseif($request->input('complaint_stage') == 'Blocked'){
                
                    $view = view('pages.mails.TutorComplaintActionBlocked', $data)->render();
                    $mail = new PHPMailer(true);
                    $mail->CharSet = 'UTF-8';
                    $mail->setFrom('support@247tutors.com', '247 Tutors');
                    $mail->isHTML(true);
                    $mail->Subject = "Final Notice: Profile Blocked Due to Student Complaint";
                    $mail->Body = $view;
                    $mail->AddEmbeddedImage($imagePath, 'logo');
                    $mail->AltBody = '';
                    $mail->addAddress($tutor->email, $tutor->first_name . ' ' . $tutor->last_name);
                    $mail->isHTML(true);
                    $mail->msgHTML($view);
                    $mail->send();
            }
                
                    $tutor->complaint_message = $request->input('complaint_message');
                    $tutor->complaint_stage = $request->input('complaint_stage');
                    $tutor->save();
                    
            return back()->with('success', 'Tutor updated successfully');
        
    }









































    public function update_tutor(Request $request, $id)
    {
        $imagePath = public_path('assets/images/247 NEW Logo 1.png');
        $edituser = User::where('id', $id)->first();
        $admin = User::where('role_id', 1)->first();
        
        $findApplication = TutorApplication::where('tutor_id', $id)->first();
        if(!empty($findApplication)){
          if (($findApplication->user_id_status == 'pending' || $findApplication->user_id_status == 'rejected')
            || ($findApplication->address_proof_status == 'pending' || $findApplication->address_proof_status == 'rejected') || ($findApplication->selfie_status == 'pending' || $findApplication->selfie_status == 'rejected') || ($findApplication->enhaced_dbs_status == 'pending' || $findApplication->enhaced_dbs_status == 'rejected')
          ) {
            return back()->with('failed', 'Please first Approved Document !');
          } 
        }else{
            return back()->with('failed', 'Tutor not have Any Document !');
        }
        

        $edituser = User::where('id', $id)->first();

        if ($edituser) {

            $data = [
                'tutorMessage' => 'Dear Tutor' . $edituser->username . ' Verify Your Documents',
                'student' => $edituser->first_name . ' ' . $edituser->last_name,
                'tutor' => $edituser->first_name . ' ' . $edituser->last_name,
                'id' => $edituser->id,
            ];
            
            if($request->input('status') == 'Active'){
                $view = \view('pages.mails.TutorActive', $data);
                $view = $view->render();
    
                $mail = new PHPMailer();
                $mail->CharSet = "UTF-8";
    
                $mail->setfrom('support@247tutors.com', '247 Tutors');
    
                $mail->isHTML(true);
                $mail->Subject ='Verification Successful';
                $mail->Body = $view;
                $mail->AddEmbeddedImage($imagePath, 'logo');
                $mail->AltBody = '';
                $mail->addaddress($edituser->email, $edituser->first_name . ' ' . $edituser->last_name);
                $mail->isHTML(true);
                $mail->msgHTML($view);
    
                if (!$mail->send())
                throw new \Exception('Failed to send mail');  
            }else{
                
                $view = \view('pages.mails.TutorInactive', $data);
                $view = $view->render();
    
                $mail = new PHPMailer();
                $mail->CharSet = "UTF-8";
    
                $mail->setfrom('support@247tutors.com', '247 Tutors');
    
                $mail->isHTML(true);
                $mail->Subject ='Rejection of Your Profile on 247Tutor';
                $mail->Body = $view;
                $mail->AddEmbeddedImage($imagePath, 'logo');
                $mail->AltBody = '';
                $mail->addaddress($edituser->email, $edituser->first_name . ' ' . $edituser->last_name);
                $mail->isHTML(true);
                $mail->msgHTML($view);
    
                if (!$mail->send())
                throw new \Exception('Failed to send mail');
                
            }
            

        }


        $ActivityLogs = new ActivityLog;
        $ActivityLogs->user_id = Auth::id();
        $ActivityLogs->title = "Tutor Profile Update";
        $ActivityLogs->description = $edituser->first_name .'   '. $edituser->last_name." Tutor Profile Updated By  ".Auth::user()->first_name."  ".Auth::user()->last_name;
        $ActivityLogs->save();

        $edituser->update([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'gender' => $request->input('gender'),
            'profile_description' => $request->input('profile_description'),
            'address' => $request->input('address'),
            'subjects' => !empty($request->input('subjects'))?implode(',', $request->input('subjects')):null,
            'zipcode' => $request->input('zipcode'),
            'status' => $request->input('status'),
        ]);

        return back()->with('success', 'Tutor Update Successfully');;
    }

    public function parent()
    {
        if (Auth::user()->role_id != 1) { return redirect('dashboard'); }
        $Parents = User::query();
        if (!empty($_GET['status'])) {
            $Parents->where('status', $_GET['status']);
        }
        if (!empty($_GET['search'])) {
            $Parents->where(function ($query) {
                $query->Where('email', 'like', '%' . $_GET['search'] . '%')
                    ->orWhere('first_name', 'like', '%' . $_GET['search'] . '%')
                    ->orWhere('last_name', 'like', '%' . $_GET['search'] . '%')
                    ->orWhere('username', 'like', '%' . $_GET['search'] . '%');
            });
        }
        $Parents = $Parents->where('role_id', 5)->paginate(10);

        return view('super-admin.Pages.parent.index', compact('Parents'));
    }
    public function organization()
    {
        if (Auth::user()->role_id != 1) { return redirect('dashboard'); }
        $Parents = User::where('role_id', 6)->get();
        return view('super-admin.Pages.organization.index', compact('Parents'));
    }

    public function verification()
    {
        return view('auth.verifytutor');
    }
    public function updateTutorStatus(Request $request)
    {
        $findApplication = TutorApplication::where('id', $request->id)->first();
        if (!empty($findApplication)) {
            if ($request->changed_type == 'user_id') {
                $findApplication->user_id_status = $request->status_type;
                $findApplication->user_id_rejected_reason = $request->rejected_reason;
                $findApplication->save();
            } else if ($request->changed_type == 'enhaced_dbs') {
                $findApplication->enhaced_dbs_status = $request->status_type;
                $findApplication->enhaced_dbs_rejected_reason = $request->rejected_reason;
                $findApplication->save();
            } else if ($request->changed_type == 'selfie') {
                $findApplication->selfie_status = $request->status_type;
                $findApplication->selfie_rejected_reason = $request->rejected_reason;

                $findApplication->save();
            } else if ($request->changed_type == 'addressproof') {
                $findApplication->address_proof_status = $request->status_type;
                $findApplication->address_proof_rejected_reason = $request->rejected_reason;
                $findApplication->save();
            } else if ($request->changed_type == 'cv') {
                $findApplication->cv_status = $request->status_type;
                $findApplication->cv_rejected_reason = $request->rejected_reason;
                $findApplication->save();
            }
            $response['message'] = 'Status Updated Successfully!';
            $response['success'] = true;
            $response['status_code'] = 200;
            return $response;
        } else {
            $response['message'] = 'Something Wrong!';
            $response['success'] = false;
            $response['status_code'] = 401;
            return $response;
        }
    }
    public function updateUserStatus(Request $request)
    {
        $findUser = User::where('id', $request->id)->first();
        $findApplication = TutorApplication::where('tutor_id', $request->id)->first();
        if (!empty($findApplication)) {
            if ($request->status == 'Active') {
                if (
                    ($findApplication->user_id_status == 'pending' || $findApplication->user_id_status == 'rejected')
                    || ($findApplication->address_proof_status == 'pending' || $findApplication->address_proof_status == 'rejected') || ($findApplication->selfie_status == 'pending' || $findApplication->selfie_status == 'rejected') || ($findApplication->enhaced_dbs_status == 'pending' || $findApplication->enhaced_dbs_status == 'rejected')
                ) {
                    $response['message'] = 'Please first Approved Document !';
                    $response['success'] = false;
                    $response['status_code'] = 400;
                } else {
                    $findUser->profile_status = 2;
                    $findUser->status = 'Active';

                    $findUser->save();
                    $environment = env('APP_ENV', 'local');
                    if ($environment == 'local') {
                        Mail::send('email.tutoractivetedemail', ['token' => $findUser->password, 'data' => $findUser], function ($message) use ($findUser) {
                            $message->to($findUser->email);
                            $message->subject('Email Verification Mail');
                        });
                    } elseif ($environment == 'production') {
                        $view = \view('email.tutoractivetedemail', ['token' => $findUser->password, 'data' => $findUser]);
                        $view = $view->render();

                        $mail = new PHPMailer();
                        $mail->CharSet = "UTF-8";


                        $mail->setfrom('support@247tutors.com', '247 Tutors');

                        $mail->isHTML(true);
                        $mail->Subject = 'Profile verified';
                        // $mail->Body    = $view;
                        $mail->AltBody = '';
                        $mail->addaddress($findUser->email, $findUser->first_name . ' ' . $findUser->last_name);
                        // dd($mail);
                        $mail->isHTML(true);
                        $mail->msgHTML($view);

                        if (!$mail->send()) throw new Exception('Failed to send mail');
                    }


                    // $view = (string)View::make('email.tutoractivetedemail',$data);


                    // TutorSubjectOffer create of tutor
                    TutorSubjectOffer::where('tutor_id', $request->id)
                        ->whereIn('subject_id', explode(',', $findApplication->subjects))
                        ->doesntExist()
                        && collect(explode(',', $findApplication->subjects))->each(function ($subjectName) use ($request, $findApplication) {
                            TutorSubjectOffer::create([
                                'tutor_id' => $request->id,
                                'level_id' => 1,
                                'subject_id' => $subjectName,
                                'levelstring' => $findApplication->teaching_level,
                                'fee' => '0',
                            ]);
                        });
                    $response['message'] = 'Status Actived Successfully! !';
                    $response['success'] = true;
                    $response['status_code'] = 200;
                }
            } else {
                $findUser->profile_status = 1;
                $findUser->save();
                $response['message'] = 'Status Updated Successfully! !';
                $response['success'] = true;
                $response['status_code'] = 200;
            }
        } else {
            $response['message'] = 'Application not found!';
            $response['success'] = false;
            $response['status_code'] = 400;
        }
        return response()->json($response);
    }



    public function userVerify($id)
    {
        $editUser = User::find($id);
        if ($editUser) {

            $ActivityLogs = new ActivityLog;
            $ActivityLogs->user_id = Auth::id();
            $ActivityLogs->title = "Verified Email ";
            $ActivityLogs->description = "For ".$editUser->first_name .'   '. $editUser->last_name."Verified Email By  ".Auth::user()->first_name."  ".Auth::user()->last_name;
            $ActivityLogs->save();

            $editUser = User::find($id);
            $editUser->email_verified_at = Carbon::now();
            $editUser->save();
            return back()->with('success', 'User Verified Successfully');
        } else {
            return back()->with('error', 'User not found');
        }
    }

    public function user_card_create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'paypal_email' => 'required|email',
            'paypal_email_confirm' => 'required|email|same:paypal_email',
            // Add other fields and validation rules as needed
        ]);

        if ($validator->fails()) {
            return redirect('tutor/settings')
                ->withErrors($validator)
                ->withInput();
        }

        $user = User::find(Auth::id());
        $user->paypal_email = $request->post('paypal_email');
        $user->save();
        return back()->with('success', 'Paypal configured successfully!');
    }

    public function user_card_create_profile(Request $request)
    {
        $user = User::find(Auth::id());
        $user->account_holder_name = $request->post('account_holder_name');
        $user->card_number = $request->post('card_number');
        $user->cvc = $request->post('cvc');
        $user->exp_month = $request->post('exp_month');
        $user->exp_year = $request->post('exp_year');
        $user->save();
        return back()->with('success', 'Paypal configured successfully!');
    }



    public function dowunloadPdf()
    {
        $recents = User::orderBy('id', 'desc')->get();
        $html = view('pdf')->with('recents', $recents)->render();
        $pdf = PDF::loadHTML($html);

        return $pdf->download('document.pdf');

    }
}
