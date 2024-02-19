<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\TutorSubjectOffer;
use App\Models\Availability;
use App\Models\Booking;

use App\Models\User;
use App\Models\TempSlot;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Str;
use App\Models\Chat;
use Illuminate\Support\Facades\Mail;
use PHPMailer\PHPMailer\PHPMailer;

class StudentController extends Controller
{
    public function update_student_post(Request $request)
    {
        $imageName = null;
        if($request->hasFile('image')){
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();

            // Move the uploaded image to the 'public/images' directory
            $image->move(public_path('images'), $imageName);
        }


        $user = User::find(Auth::id());
        $user->update([
            'first_name' => ucfirst(strtolower($request->input('first_name'))),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            // 'password' => Hash::make($request->input('password')),
            'phone' => $request->input('phone'),
            'gender' => $request->input('gender'),
            'dob' => $request->input('dob'),
            'facebook_link' => $request->input('facebook_link'),
            // 'linkedin_link' => $request->input('linkedin_link'),
            // 'twitter_link' => $request->input('twitter_link'),
            'profile_description' => $request->input('profile_description'),
            'address' => $request->input('address'),
            'image' => 'images/' . $imageName,
            'zipcode' => $request->input('zipcode'),
            'image' => $user->image,
        ]);
        return back()->with('success', 'Update Profile Successfully');
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

    return redirect('student/profile');

    }
    public function student_profile()
    {
        return view('pages.dashboard.profilestudent');
    }

    public function student_payments()
    {
        $bookings = Booking::where('student_id','=', Auth::user()->id)
            ->with(['student', 'tutor', 'subjects'])
            ->get();
        return view('pages.dashboard.student_payments', get_defined_vars());
    }




























    public function book_tutor($id)
    {
        $tutor = User::find($id);
        $students = User::where('parent_id', Auth::id())->get();
        $dayOfTheWeek = Carbon::now()->dayOfWeek;
        if ($dayOfTheWeek == 0) {
            $dayOfTheWeek = 7;
        }
        // $tutor_slots=Availability::where('tutor_id',$tutor->tutor_id)->get();
        $tutor_slots = DB::table('availabilities')
            ->whereRaw('FIND_IN_SET(' . $dayOfTheWeek . ', day_of_the_week)')
            ->where('tutor_id', $tutor->id)
            ->get();
        $offersubjects = TutorSubjectOffer::where('tutor_id', $tutor->id)->with(['level', 'tutor', 'subject'])->get();
        $Wallet = Wallet::where('user_id', Auth::id())->first();
        if (Auth::check()) {
            // return view('pages.dashboard.booking', compact('Wallet','tutor', 'offersubjects', 'tutor_slots', 'students'));
            
            return view('pages.dashboard.StripeBook', compact('Wallet','tutor', 'offersubjects', 'tutor_slots', 'students'));
        } else {
            return redirect('login');
        }

    }
    
    public function book_tutor_wallet($id)
    {
        $tutor = User::find($id);
        $students = User::where('parent_id', Auth::id())->get();
        $dayOfTheWeek = Carbon::now()->dayOfWeek;
        if ($dayOfTheWeek == 0) {
            $dayOfTheWeek = 7;
        }
        // $tutor_slots=Availability::where('tutor_id',$tutor->tutor_id)->get();
        $tutor_slots = DB::table('availabilities')
            ->whereRaw('FIND_IN_SET(' . $dayOfTheWeek . ', day_of_the_week)')
            ->where('tutor_id', $tutor->id)
            ->get();
        $offersubjects = TutorSubjectOffer::where('tutor_id', $tutor->id)->with(['level', 'tutor', 'subject'])->get();
        $Wallet = Wallet::where('user_id', Auth::id())->first();
        if (Auth::check()) {
            return view('pages.dashboard.walletBook', compact('Wallet','tutor', 'offersubjects', 'tutor_slots', 'students'));
        } else {
            return redirect('login');
        }

    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    public function student_profile_get($id)
    {
        $tutor = User::find($id);
        return view('pages.dashboard.profilestudentget', compact('tutor'));
    }

    public function getSlots(Request $request)
    {

        $dayOfTheWeek = Carbon::parse($request->date)->dayOfWeek;

        if ($dayOfTheWeek == 0) {
            $dayOfTheWeek = 7;
        }
        $date = Carbon::parse($request->date);
        if ($date->isPast()) {
            //means current date

            $booked_slots = Booking::where('booking_date', $request->date)->get()->pluck('booking_time')->toArray();
            // dd($bookings);
            // dd('The date is in the past.');
        } else {
            $booked_slots = Booking::where('booking_date', $request->date)->get()->pluck('booking_time')->toArray();
            // dd($bookings);
            // dd('The date is in the future.');
        }
        $temp_slots = TempSlot::where('tutor_id',$request->id)->get()->pluck('slot')->toArray();

        $tutor_slots = DB::table('availabilities')
            ->whereRaw('FIND_IN_SET(' . $dayOfTheWeek . ', day_of_the_week)')
            ->where('tutor_id', $request->id)
            ->get();
        $disabled_slots = array();
        $disabled_slots = array_merge($booked_slots,$temp_slots);

        $response['slots'] = $tutor_slots;
        $response['disabled_slots'] = $disabled_slots;

        $response['success'] = true;
        $response['status'] = true;

        return response()->json($response);
    }


    public function add_student(Request $request)
    {

        $email = $request->input('email');
        $user = User::where('email', $email)->first();

        if ($user) {
            return back()->with('failed', 'this email already exist');
        }

        $user = new User();
        $user->first_name = ucfirst(strtolower($request->input('first_name')));
        $user->last_name = $request->input('last_name');
        $user->email = $request->input('email');
        $user->username = $request->input('last_name').rand ( 100 , 999 );
        $user->dob = '2000-01-01';
        $user->phone = '123456789';
        $user->password = Hash::make($request->password);
        $user->facebook_link = 'https://www.google.com';
        $user->linkedin_link = 'https://www.google.com';
        $user->twitter_link = 'https://www.google.com';
        $user->role_id = 4;
        $user->profile_description = 'demo';
        $user->image = 'pic.jpg';
        $user->status = 'Active';
        $user->address = 'test';
        $user->parent_id = Auth::id();
        $user->save();
        $data=['token' => $user->password, 'user' => $user];


        $wallet = new Wallet();
        $wallet->user_id = $user->id;
        $wallet->wallet_id = Str::uuid()->toString();
        $wallet->save();
        
        $environment = env('APP_ENV', 'local');
        if($environment == 'local'){
            Mail::send('email.emailVerificationEmail', ['token' => $user->password, 'user' => $user], function ($message) use ($user) {
                $message->to($user->email);
                $message->subject('Email Verification Mail');
            });
        }elseif($environment == 'production'){
            $view = \view('email.emailVerificationEmail',$data);
            $view = $view->render();
            $mail = new PHPMailer();
            $mail->CharSet = "UTF-8";
            $mail->setfrom('support@247tutors.com' , '247 Tutors');
            $mail->isHTML(true);
            $mail->Subject = 'Email verification';
            $mail->Body    = $view;
            $mail->AltBody = '';
            $mail->addaddress($user->email, $user->first_name.' '.$user->last_name);
              $mail->isHTML(true);
              $mail->msgHTML($view);

            if(!$mail->send()) throw new \Exception('Failed to send mail');
        }



        return back()->with('success', 'Successfully You Can Add Student');


    }



    public function delete_student(Request $request)
    {
        User::where('id', $request->id)->delete();
        return back()->with('success', 'Delete Successfully Student');
    }
    public function home()
    {
        $chats = [];
    
        $chatsUsers = Chat::where('sender_id',Auth::id())->where('status', 0)->pluck('reciver_id')->unique();
    
        $c_users = User::whereIn('id',$chatsUsers)->where('id','!=',Auth::id())->get();
        $j = 0;
        foreach($c_users as $i => $user){
    
            $chats[$i]['id'] = $user->id;
            $chats[$i]['username'] = $user->username;
            $chats[$i]['image'] = $user->image;
    
            $j++;
        }
    
        $chatsUsers = Chat::where('reciver_id',Auth::id())->where('status', 0)->pluck('sender_id')->unique();
    
        foreach(User::whereIn('id',$chatsUsers)->where('id','!=',Auth::id())->get() as $i => $user){
    
            $chats[$i]['id'] = $user->id;
            $chats[$i]['username'] = $user->username;
            $chats[$i]['image'] = $user->image;
    
            $j++;
        }
        
        $students = User::where('role_id', '4')->where('parent_id', Auth::id())->get();
        $tutors = Booking::where('parent_id', Auth::id())->with(['tutor', 'tutorSubjectOffer'])->get();
        return view('auth.StudentHome', compact('students', 'tutors', 'chats'));
    }
    
    
    
    
   public function AjaxFetchChatUnredList()
    {
        $chats = [];
        $j = 0;
        $chatsUsers = Chat::where('reciver_id',Auth::id())->where('status',0)->pluck('sender_id')->unique();
        foreach(User::whereIn('id',$chatsUsers)->where('id','!=',Auth::id())->get() as $i => $user){
    
            $chats[$i]['id'] = $user->id;
            $chats[$i]['username'] = $user->username;
            $chats[$i]['image'] = $user->image;
            $chats[$i]['taglink'] =$user->facebook_link;
    
            $j++;
        }
        
        $html = "";

        if (!empty($chats)) {
            $html .= '<div class="col-12 h-100">';
            $html .= '<div class="tab-content " id="ex1-content">';
            $html .= '<div class="tab-pane fade show active" id="ex1-tabs-1" role="tabpanel" aria-labelledby="ex1-tab-1">';
            $html .= '<ul style="list-style: none;padding-left: 10px;">';
        
            foreach ($chats as $tutor) {
                $html .= '<li class="d-flex align-items-center justify-content-between py-2 mb-2" style="border-bottom: 1px solid #e3e3e3;">';
                $html .= '<div class="d-flex gap-2 align-items-center">';
        
                // Receiver
        
                // Sender
                if (!empty($tutor['image']) && file_exists(public_path(!empty($tutor['image']) ? $tutor['image'] : ''))) {
                    $html .= '<img src="' . asset($tutor['image']) . '" style="width: 60px;height: 60px;border-radius: 50%;" alt="" srcset="">';
                } else {
                    $html .= '<img src="' . asset('assets/images/default.png') . '" style="width: 60px;height: 60px;border-radius: 50%;" alt="" srcset="">';
                }
        
                $html .= '<div class=" d-flex flex-column">';
                $html .= '<h5 class="mb-0 text-capitalize">' . $tutor['username'] . '</h5>';
                $html .= '<p class="mb-0">'. (!empty($tutor['taglink']) ? $tutor['taglink'] : '') . '</p>';
                $html .= '</div>';
                $html .= '</div>';
                $html .= '<div>';
                $html .= '<a href="' . url('chat') . '/' . $tutor['id'] . '" class="btn px-3 py-1 bg-primary text-white text-decoration-none">Let\'s Chat</a>';
                $html .= '</div>';
                $html .= '</li>';
            }
        
            $html .= '</ul>';
            $html .= '</div>';
            $html .= '</div>';
            $html .= '</div>';
        } else {
            $html .= '<div class="col-12 h-100" style="margin: 5rem auto;text-align: center;">';
            $html .= '<img src="https://cdn.mytutor.co.uk/images/dog-waiting-for-door.jpg?1699357221000" alt="Dog waiting for door" class="emptystate__icon">';
            $html .= '<h6>You’re all caught up. No unread messages</h6>';
            $html .= '</div>';
        }
        
        return $html;


    }
    
    
    public function chat()
    {
        return view('include.chattwo');
    }
    public function singlechat()
    {
        return view('include.singlechat');
    }

}
