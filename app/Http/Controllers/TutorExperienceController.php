<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Availability;
use App\Models\Booking;
use App\Models\Wallet;
use App\Models\Level;
use App\Models\Subject;
use App\Models\Transaction;
use App\Models\TutorSubjectOffer;
use App\Models\User;
use App\Models\DocumentType;
use App\Models\Document;
use App\Models\TutorApplication;
use App\Models\TutorQualification;
use Carbon\Carbon;
use Exception;
use PHPMailer\PHPMailer\PHPMailer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\{DB, File};

class TutorExperienceController extends Controller
{
    public function update_tutor()
    {
        $subjects = Subject::with('level')->get();
        $tutorsubjectoffers = TutorSubjectOffer::where('tutor_id', Auth::id())->with(['level', 'tutor', 'subject'])->get();
        $levels = Level::all();
        $availabilitys = Availability::where('tutor_id', Auth::id())->get();
        $TutorQualifications = TutorQualification::where('tutor_id', Auth::id())->get();
        return view('pages.dashboard.profiledetails', compact('TutorQualifications', 'availabilitys', 'subjects', 'levels', 'tutorsubjectoffers'));
    }

    public function profileVerification()
    {

        $subject_ids = Auth::user()->subjects;
        $subject_ids = explode(',', $subject_ids);

        $subjects = Subject::with('level')->get();
        $tutorsubjectoffers = TutorSubjectOffer::where('tutor_id', Auth::id())->with(['level', 'tutor', 'subject'])->get();
        $levels = Level::all();
        $availabilitys = Availability::where('tutor_id', Auth::id())->get();

        $doc_types = DocumentType::all();

        foreach ($doc_types as $doc_type) {
            $documents = Document::where('user_id', Auth::user()->id)->where('doc_type', $doc_type->id)->get();
            $doc_type->documents = $documents;
        }

        return view('pages.dashboard.profile_verification', compact('doc_types', 'availabilitys', 'subjects', 'levels', 'tutorsubjectoffers'));

    }

public function update_tutor_post(Request $request)
{
    try {
        // Create or retrieve the current user
        $user = User::find(Auth::id());
        
        $request->validate([
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            // Add other validation rules as needed
        ]);

        // Update user attributes
        $user->update([
            'first_name' => ucfirst(strtolower($request->input('first_name'))),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'gender' => $request->input('gender'),
            'dob' => $request->input('dob'),
            'facebook_link' => $request->input('facebook_link'),
            'linkedin_link' => $request->input('linkedin_link'),
            'twitter_link' => $request->input('twitter_link'),
            'profile_description' => $request->input('profile_description'),
            'address' => $request->input('address'),
            'zipcode' => $request->input('zipcode'),
        ]);

        $updateType = TutorApplication::where('tutor_id', Auth::id())->first();

        if (!empty($updateType)) {
            $updateType->tutor_type = $request->tutor_type;
            $updateType->save();
        }

        return back()->with('success', 'Update Profile successfully.');
    } catch (\Exception $e) {
        return back()->with('failed', 'Error updating profile. Please try again.');
    }
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

    $updateType=TutorApplication::where('tutor_id',Auth::id())->first();
    if(!empty($updateType)){
        $updateType->tutor_type=$request->tutor_type;
        $updateType->save();
    }

    return redirect('tutor/settings');

    }
    public function tutor_profile()
    {
        $subject_ids = Auth::user()->subjects;
        $subject_ids = explode(',', $subject_ids);

        $subjects = Subject::whereIn('id', $subject_ids)->with('level')->get();
        $tutorsubjectoffers = TutorSubjectOffer::where('tutor_id', Auth::id())->with(['level', 'tutor', 'subject'])->get();
        $levels = Level::all();
        $TutorQualifications = TutorQualification::where('tutor_id', Auth::id())->get();
        $availabilitys = Availability::where('tutor_id', Auth::id())->get();
        $AllSubjects = Subject::distinct('name')->pluck('name');
        return view('pages.dashboard.profile', compact('AllSubjects','subjects', 'levels', 'tutorsubjectoffers', 'availabilitys', 'TutorQualifications'));
    }

    public function tutor_payments_post()
    {
        return view('pages.dashboard.payments');
    }

    public function verify_transaction($id, $id2)
    {
        $chats = Transaction::where('tutor_id', $id)->where('id', $id2)->first();
        $data = array('name' => $chats->user->first_name);

        Mail::send(['text' => 'pages/dashboard/mail'], $data, function ($message) use ($chats) {
            $message->to($chats->user->email, $chats->user->first_name)->subject('Dear Student get Your Link and join meeting');
            $message->from('sherazaleem015@gmail.com', 'tutor247');
        });

        // $view = \view('pages.mails.tutorverifybooking',$data);
        // $view = $view->render();

        // $mail = new PHPMailer();
        // $mail->CharSet = "UTF-8";
        // $mail->setfrom('support@247tutors.com' , '247 Tutors');
        // $mail->isHTML(true);
        // $mail->Subject = 'asdasd';
        // $mail->Body    = $view;
        // $mail->AltBody = '';
        // $mail->addaddress('muhammadkashif70000@gmail.com', 'Kashif');
        //   $mail->isHTML(true);
        //   $mail->msgHTML($view);

        // if(!$mail->send()) throw new \Exception('Failed to send mail');


        if ($chats && $chats->status == 0) {
            $chats->update(['status' => 1]);
            return back();
        }
    }

    public function booking_update(Request $request)
    {
        Booking::where('uuid', $request->post('id'))
            ->update([
                'booking_date' => $request->post('date'),
                'booking_time' => $request->post('time'),
            ]);
        return redirect('parent/home')->with('success', 'Your booking has been successfully updated.');
    }

    public function availability_store(Request $request)
    {
        $limit = Availability::where('tutor_id', Auth::id())->count();

        if ($limit >= 4) {
            return back()->with('failed', 'You have reached the maximum limit of 3 availabilities.');
        }

        $check = Availability::where('tutor_id', Auth::id())->where('schedule_time', $request->schedule_time)->count();

        if ($check > 0) {
            return back()->with('failed', 'You have previously saved ' . $request->schedule_time);
        }

        // If both conditions pass, you can save the availability.
        $availability = new Availability;
        $availability->tutor_id = Auth::id();
        $availability->day_of_the_week = implode(',', $request->day_of_the_week);
        $availability->schedule_time = $request->schedule_time;
        $availability->save();
        return back()->with('success', 'Availability saved successfully');

    }

    public function availability_update(Request $request)
    {
        Availability::where('id', $request->get('id'))
            ->update([
                'day_of_the_week' => implode(',', $request->post('day_of_the_week')),
            ]);
        return back()->with('success', 'Update Availability successfully');

    }
    public function availability_delete($id)
    {
        Availability::find($id)->delete();
        return back()->with('success', 'Update Delete successfully');

    }
    public function SaveprofileVerification(Request $request)
    {
        // try {
            // dd($request->all());

            $ActivityLogs = new ActivityLog;
            $ActivityLogs->user_id = Auth::user()->id;
            $ActivityLogs->title = "New Profile Verification";
            $ActivityLogs->description ="New Profile Verification  ".Auth::user()->first_name .'   '. Auth::user()->last_name."  Profile Verify ";
            $ActivityLogs->save();

            createNotification(Auth::user()->role_id,Auth::id(),'Tutor Application',Auth::user()->username.' Has Submitted His Application');
            $userRecords = json_decode($request->input('userRecords'), true);
            $tutorId = Auth::id();
            $existingScheduleTimes = Availability::where('tutor_id', $tutorId)->pluck('schedule_time')->toArray();
            foreach ($userRecords as $record) {
                $scheduleTime = $record['period'];
                if (!in_array($scheduleTime, $existingScheduleTimes) && count($existingScheduleTimes) < 3) {
                    $availability = new Availability();
                    $availability->day_of_the_week = implode(',', $record['checkboxes']);
                    $availability->schedule_time = $scheduleTime;
                    $availability->tutor_id = $tutorId;
                    $availability->save();
                    $existingScheduleTimes[] = $scheduleTime;
                }
            }


            $subjects = !empty($request->subjects)? explode(',', $request->subjects): null;
            $teachingLevels = explode(',', $request->teaching_level);
            $user = auth()->user();

            if(!empty($subjects)){
            foreach ($subjects as $key => $subjectId) {
                $TutorSubjectOffer_check = TutorSubjectOffer::where('tutor_id', $user->id)
                    ->where('levelstring', $teachingLevels[$key])
                    ->where('subject_id', $subjectId)
                    ->pluck('levelstring', 'id')
                    ->toArray();

                if (count($TutorSubjectOffer_check) < 1) {
                    TutorSubjectOffer::create([
                        'tutor_id' => $user->id,
                        'level_id' => 1, // You might need to adjust this based on your requirements
                        'levelstring' => $teachingLevels[$key],
                        'subject_id' => !empty($subjectId)?$subjectId:null,
                        'fee' => 0,
                    ]);
                }
             }
            }


            DB::beginTransaction();
            $tutor = new TutorApplication;
            $tutor->tutor_id = auth()->user()->id;
            $tutor->is_criminal = $request->is_criminal;
            $tutor->is_criminal = $request->is_criminal;
            $tutor->criminal_description = $request->criminal_description;
            $tutor->tutor_type = $request->tutortype;
            $tutor->week_hours = $request->week_hours;
            $tutor->licence_number = $request->licence_number;
            // $tutor->tutoring_slot = $request->tutoring_slot;
            $tutor->is_willing_travel = $request->is_willing_travel;
            $tutor->traveling_distance = $request->traveling_distance;
            $tutor->allowed_drive = $request->allowed_drive;
            $tutor->experience = $request->experience;
            $tutor->subjects = $request->subjects;
            $tutor->biography = $request->biography;
            $tutor->gender = $request->gender;
            // $tutor->teaching_level = $request->teaching_level;
            // $tutor->tutoring_organisation = $request->tutoring_organisation;
            $tutor->user_id_expiry = $request->user_id_expiry;
            $tutor->enhaced_dbs_expiry = $request->enhaced_dbs_expiry;
            // $tutor->address_proof_expiry = $request->address_proof_expiry;
            $tutor->reference = $request->reference;
            $tutor->refrance_relationship = $request->refrance_relationship;
            $tutor->refrance_contact_number = $request->refrance_contact_number;
            $tutor->refrance_email = $request->refrance_email;
            $tutor->disclaimer = $request->disclaimer;
            $tutor->address = $request->address;
            $tutor->save();

            if ($request->user_id != 'undefined') {
                $images[] = null;
                $images_src[] = null;
                $image = $request->file('user_id');
                $imageName = $_FILES['user_id']['name'];
                $imageName = strtolower($imageName);
                $imageName = str_replace(" ", "_", $imageName);
                $target_dir = 'storage/' . 'tutor' . auth()->user()->id;
                if (!File::isDirectory($target_dir)) {
                    mkdir($target_dir, 0777, true);
                }
                $image->move($target_dir, $imageName);
                $tutor->user_id = $target_dir . '/' . $imageName;
                $tutor->save();
            }
            if ($request->enhaced_dbs != 'undefined') {
                $image = $request->file('enhaced_dbs');
                $imageName = $_FILES['enhaced_dbs']['name'];
                $imageName = strtolower($imageName);
                $imageName = str_replace(" ", "_", $imageName);
                $target_dir = 'storage/' . 'tutor' . auth()->user()->id;
                if (!File::isDirectory($target_dir)) {
                    mkdir($target_dir, 0777, true);
                }
                $image->move($target_dir, $imageName);
                $tutor->enhaced_dbs = $target_dir . '/' . $imageName;
                $tutor->save();
            }
            if ($request->selfie != 'undefined') {
                $image = $request->file('selfie');
                $imageName = $_FILES['selfie']['name'];
                $imageName = strtolower($imageName);
                $imageName = str_replace(" ", "_", $imageName);
                $target_dir = 'storage/' . 'tutor' . auth()->user()->id;
                if (!File::isDirectory($target_dir)) {
                    mkdir($target_dir, 0777, true);
                }
                $image->move($target_dir, $imageName);
                $tutor->selfie = $target_dir . '/' . $imageName;
                $tutor->save();
            }
            if ($request->address_proof != 'undefined') {
                $image = $request->file('address_proof');
                $imageName = $_FILES['address_proof']['name'];
                $imageName = strtolower($imageName);
                $imageName = str_replace(" ", "_", $imageName);
                $target_dir = 'storage/' . 'tutor' . auth()->user()->id;
                if (!File::isDirectory($target_dir)) {
                    mkdir($target_dir, 0777, true);
                }
                $image->move($target_dir, $imageName);
                $tutor->address_proof = $target_dir . '/' . $imageName;
                $tutor->save();
            }

            if ($request->cv != 'undefined') {
                $image = $request->file('cv');
                $imageName = $_FILES['cv']['name'];
                $imageName = strtolower($imageName);
                $imageName = str_replace(" ", "_", $imageName);
                $target_dir = 'storage/' . 'tutor' . auth()->user()->id;
                if (!File::isDirectory($target_dir)) {
                    mkdir($target_dir, 0777, true);
                }
                $image->move($target_dir, $imageName);
                $tutor->cv = $target_dir . '/' . $imageName;
                $tutor->save();
                // update users
                User::find(auth()->user()->id)->update([
                    'profile_description' => $request->biography,
                    'address' => $request->address,
                    'image' =>  $tutor->selfie,
                ]);
            }


            //save quliation //
            $qualification_type = explode(',', $request->qualification_type);
            $qualification_title = explode(',', $request->qualification_title);
            $qualification_grade = explode(',', $request->qualification_grade);
            $qualification_institution = explode(',', $request->qualification_institution);
            $year_completed = explode(',', $request->year_completed);
            if (sizeof($qualification_type) > 0) {
                foreach ($qualification_type as $key => $item) {
                    $tutor_qaul = new TutorQualification;
                    $tutor_qaul->tutor_id = auth()->user()->id;
                    $tutor_qaul->degree_title = $qualification_title[$key];
                    $tutor_qaul->institute = $qualification_institution[$key];
                    $tutor_qaul->degree_completed = $year_completed[$key];
                    $tutor_qaul->grade = $qualification_grade[$key];
                    $tutor_qaul->type = $item;
                    $tutor_qaul->notes = '-';
                    $tutor_qaul->save();
                }
            }
            $user = User::where('id', auth()->user()->id)->first();
            if (!empty($user)) {
                $user->profile_status = 1;
                $user->save();
            }

            $user = User::where('id', auth()->user()->id)->first();
            if (!empty($user)) {
                $user->subjects = $request->subjects;
                $user->save();
            }
            $response['message'] = " Application Submit Successfully!";
            $response['success'] = true;
            $response['status_code'] = 200;
            DB::commit();
            return response()->json($response);
        // } catch (Exception $e) {
        //     $response['message'] = $e->getMessage();
        //     $response['success'] = false;
        //     $response['status_code'] = 400;
        //     DB::rollBack();
        //     return response()->json($response);
        // }

    }
    public function tutor_payments(Request $request)
    {

        $bookings = Booking::with(['student', 'tutor', 'subjects'])
            ->where('tutor_id', Auth::id())
            ->get();

        $bookings1 = Booking::with(['student', 'tutor', 'subjects'])
            ->where('tutor_id', Auth::id())
            ->where('status', 'Completed')
            ->get();

        if(!empty($bookings1)){
            $total = 0;
            foreach($bookings1 as $booking){
                if($booking->booking_fee !== 'Free'){
                    $total += $booking->booking_fee;
                }
            }
        }else{
            $total = 0;
        }
        $wallet = Wallet::where('user_id', Auth::id())->first();
        // dd($wallet);
        return view('pages.dashboard.tutorpayments', get_defined_vars());
    }










}
