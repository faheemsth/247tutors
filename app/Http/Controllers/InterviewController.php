<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Transaction as ModelsTransaction;
use App\Models\Transaction;
use App\Models\Wallet;
use App\Models\coupon as ModelsCoupon;
use App\Models\Subject;
use App\Models\Reschedule_meeting;
use App\Models\Level;
use App\Models\TempSlot;
use App\Models\ActivityLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use PHPMailer\PHPMailer\PHPMailer;
use Stripe;
use Session;
use Stripe\Coupon;
use App\Services\Zoom;

class InterviewController extends Controller
{

    protected $zoomService;

    public function __construct(Zoom $zoomService)
    {
        $this->zoomService = $zoomService;
    }

    public function index()
    {
        if (Auth::user()->role_id != 1) {
            return redirect('dashboard');
        }
        $Interviewer = User::query();

        if (request()->has('search')) {
            $Interviewer->where(function ($query) {
                $query->Where('email', 'like', '%' . request('search') . '%')
                    ->orWhere('username', 'like', '%' . request('search') . '%');
            });
        }
        $Interviewer = $Interviewer->where('role_id', 3)->where('status', 'Pending')->paginate(10);
        return view('super-admin.Pages.Interview.index', compact('Interviewer'));
    }






































    public function save(Request $request)
    {
        $imagePath = public_path('assets/images/247 NEW Logo 1.png');

        $Tutor = User::find($request->id);
        $Tutor->meeting_Interview_time = $request->time;
        $Tutor->meeting_Interview_date = $request->date;
        $Tutor->Interview_meeting_id = $this->randomStringFormat();
        $Tutor->is_Interviewed = 1;
        $Tutor->save();


        $ActivityLogs = new ActivityLog;
        $ActivityLogs->user_id = Auth::id();
        $ActivityLogs->title = "Generate Interview Meeting ";
        $ActivityLogs->description = "For " . $Tutor->first_name . '   ' . $Tutor->last_name . "Generate Interview Meeting time By  " . Auth::user()->first_name . "  " . Auth::user()->last_name;
        $ActivityLogs->save();

        $Admin = User::where('role_id', 1)->first();

        $data = [
            'tutorMessage' => 'Dear ' . $Admin->first_name . ' ' . $Admin->last_name . ' Join Intverview Meeting With Admin',
            'student' => $Admin->first_name . ' ' . $Admin->last_name,
            'tutor' => $Tutor->first_name . ' ' . $Tutor->last_name,
            'id' => $Tutor->Interview_meeting_id,
            'time' => $request->time,
            'date' => $request->date,
        ];

        $view = \view('pages.mails.InterviewMailToTutor', $data);
        $view = $view->render();

        $mail = new PHPMailer();
        $mail->CharSet = "UTF-8";

        $mail->setFrom('support@247tutors.com', '247 Tutors');

        $mail->isHTML(true);
        $mail->Subject = 'Interview Scheduled for Tutor Position';
        $mail->Body = $view;
        $mail->AddEmbeddedImage($imagePath, 'logo');
        $mail->AltBody = '';
        $mail->addAddress($Tutor->email, $Tutor->first_name . ' ' . $Tutor->last_name);
        $mail->isHTML(true);
        $mail->msgHTML($view);

        if (!$mail->send()) {
            throw new \Exception('Failed to send mail');
        }


        $view = \view('pages.mails.InterviewMailToAdmin', $data);
        $view = $view->render();

        $mail = new PHPMailer();
        $mail->CharSet = "UTF-8";

        $mail->setFrom('support@247tutors.com', '247 Tutors');

        $mail->isHTML(true);
        $mail->Subject = 'Dear Admin ' . $Admin->first_name . ' ' . $Admin->last_name . '  Schedule an New Interview Meeting With ' . $Tutor->first_name . ' ' . $Tutor->last_name;
        $mail->Body = $view;
        $mail->AddEmbeddedImage($imagePath, 'logo');
        $mail->AltBody = '';
        $mail->addAddress($Admin->email, $Admin->first_name . ' ' . $Admin->last_name);
        $mail->isHTML(true);
        $mail->msgHTML($view);

        if (!$mail->send()) {
            throw new \Exception('Failed to send mail');
        }
        // }


        return back();
    }

    public function randomStringFormat()
    {
        $format = 'XXX-999-9999';
        $k = strlen($format);
        $sernum = '';
        for ($i = 0; $i < $k; $i++) {
            switch ($format[$i]) {
                case 'X':
                    $sernum .= chr(rand(65, 90));
                    break;
                case '9':
                    $sernum .= rand(0, 9);
                    break;
                case '-':
                    $sernum .= '-';
                    break;
            }
        }
        return $sernum;
    }









    public function UnderHoureReminder()
    {
        $users = User::where('is_Interviewed', 1)->where('send_email', 0)->get();
        $imagePath = public_path('assets/images/247 NEW Logo 1.png');


        foreach ($users as $user) {
            if ($user->meeting_Interview_date && $user->meeting_Interview_time) {
                $data = [
                    'tutorMessage' => 'Dear ' . $user->username . ' Join Interview Meeting With Admin',
                    'student' => $user->first_name . ' ' . $user->last_name,
                    'tutor' => $user->first_name . ' ' . $user->last_name,
                    'id' => $user->Interview_meeting_id,
                    'time' => $user->meeting_Interview_date . ' ' . $user->meeting_Interview_time
                ];

                $timecheck = $user->meeting_Interview_date . ' ' . $user->meeting_Interview_time;
                $meeting_time = strtotime($timecheck);
                $reminder_time = $meeting_time - (1 * 60);

                if (time() >= $reminder_time) {
                    $user->send_email = 2;
                    $user->save();
                    createNotification($user->role_id, $user->id, 'Meeting Reminder', 'Join Meeting To' . $user->username . ' For Profile Verification');

                    $environment = env('APP_ENV', 'local');
                    $view = \view('pages.mails.interview', $data);
                    $view = $view->render();

                    $mail = new PHPMailer();
                    $mail->CharSet = "UTF-8";

                    $mail->setfrom('support@247tutors.com', '247 Tutors');

                    $mail->isHTML(true);
                    $mail->Subject = 'Reminder: Your Interview Will Start in Few Minutes';
                    $mail->Body = $view;
                    $mail->AddEmbeddedImage($imagePath, 'logo');
                    $mail->AltBody = '';
                    $mail->addaddress($user->email, $user->first_name . ' ' . $user->last_name);
                    $mail->isHTML(true);
                    $mail->msgHTML($view);

                    if (!$mail->send())
                        throw new \Exception('Failed to send mail');


                    $Admin = User::where('role_id', 1)->first();
                    $view = \view('pages.mails.interview', $data);
                    $view = $view->render();

                    $mail = new PHPMailer();
                    $mail->CharSet = "UTF-8";

                    $mail->setfrom('support@247tutors.com', '247 Tutors');

                    $mail->isHTML(true);
                    $mail->Subject = 'Reminder: Your Interview Will Start in 1 Hour';
                    $mail->Body = $view;
                    $mail->AddEmbeddedImage($imagePath, 'logo');
                    $mail->AltBody = '';
                    $mail->addaddress($Admin->email, $Admin->first_name . ' ' . $Admin->last_name);
                    $mail->isHTML(true);
                    $mail->msgHTML($view);

                    if (!$mail->send())
                        throw new \Exception('Failed to send mail');
                    // }
                }
            }
        }
    }
    



    public function SixteenMinutesInterviewReminder()
    {
        $users = User::where('is_Interviewed', 1)->where('send_email', 1)->get();
        $imagePath = public_path('assets/images/247 NEW Logo 1.png');


        foreach ($users as $user) {
            if ($user->meeting_Interview_date && $user->meeting_Interview_time) {
                $data = [
                    'tutorMessage' => 'Dear ' . $user->username . ' Join Interview Meeting With Admin',
                    'student' => $user->first_name . ' ' . $user->last_name,
                    'tutor' => $user->first_name . ' ' . $user->last_name,
                    'id' => $user->Interview_meeting_id,
                    'time' => $user->meeting_Interview_date . ' ' . $user->meeting_Interview_time
                ];

                $timecheck = $user->meeting_Interview_date . ' ' . $user->meeting_Interview_time;
                $meeting_time = strtotime($timecheck);
                $reminder_time = $meeting_time - (1 * 3600);

                if (time() >= $reminder_time) {
                    $user->send_email = 2;
                    $user->save();
                    createNotification($user->role_id, $user->id, 'Meeting Reminder', 'Join Meeting To' . $user->username . ' For Profile Verification');

                    $environment = env('APP_ENV', 'local');
                    $view = \view('pages.mails.interview', $data);
                    $view = $view->render();

                    $mail = new PHPMailer();
                    $mail->CharSet = "UTF-8";

                    $mail->setfrom('support@247tutors.com', '247 Tutors');

                    $mail->isHTML(true);
                    $mail->Subject = 'Reminder: Your Interview Will Start in 1 Hour';
                    $mail->Body = $view;
                    $mail->AddEmbeddedImage($imagePath, 'logo');
                    $mail->AltBody = '';
                    $mail->addaddress($user->email, $user->first_name . ' ' . $user->last_name);
                    $mail->isHTML(true);
                    $mail->msgHTML($view);

                    if (!$mail->send())
                        throw new \Exception('Failed to send mail');


                    $Admin = User::where('role_id', 1)->first();
                    $view = \view('pages.mails.interview', $data);
                    $view = $view->render();

                    $mail = new PHPMailer();
                    $mail->CharSet = "UTF-8";

                    $mail->setfrom('support@247tutors.com', '247 Tutors');

                    $mail->isHTML(true);
                    $mail->Subject = 'Reminder: Your Interview Will Start in 1 Hour';
                    $mail->Body = $view;
                    $mail->AddEmbeddedImage($imagePath, 'logo');
                    $mail->AltBody = '';
                    $mail->addaddress($Admin->email, $Admin->first_name . ' ' . $Admin->last_name);
                    $mail->isHTML(true);
                    $mail->msgHTML($view);

                    if (!$mail->send())
                        throw new \Exception('Failed to send mail');
                    // }
                }
            }
        }
    }



























    // sth

    public function TwentyFourInterviewReminder()
    {
        $imagePath = public_path('assets/images/247 NEW Logo 1.png');
        $users = User::where('is_Interviewed', 1)->where('send_email', 0)->get();

        foreach ($users as $user) {
            if ($user->meeting_Interview_date && $user->meeting_Interview_time) {
                $data = [
                    'tutorMessage' => 'Dear ' . $user->username . ' Join Interview Meeting With Admin',
                    'student' => $user->first_name . ' ' . $user->last_name,
                    'tutor' => $user->first_name . ' ' . $user->last_name,
                    'id' => $user->Interview_meeting_id,
                    'time' => $user->meeting_Interview_date . ' ' . $user->meeting_Interview_time
                ];

                $timecheck = $user->meeting_Interview_date . ' ' . $user->meeting_Interview_time;

                $meeting_time = strtotime($timecheck);
                $reminder_time = $meeting_time - (24 * 3600);

                if (time() >= $reminder_time) {

                    $user->send_email = 1;
                    $user->save();
                    createNotification($user->role_id, $user->id, 'Meeting Reminder', 'Join Meeting To' . $user->username . ' For Profile Verification');

                    $environment = env('APP_ENV', 'local');

                    $view = \view('pages.mails.ReminderInterviewTutor24', $data);
                    $view = $view->render();

                    $mail = new PHPMailer();
                    $mail->CharSet = "UTF-8";

                    $mail->setfrom('support@247tutors.com', '247 Tutors');

                    $mail->isHTML(true);
                    $mail->Subject = 'Interview Scheduled for Tutor Position on ' . $user->meeting_Interview_date . ' ' . $user->meeting_Interview_time;
                    $mail->Body = $view;
                    $mail->AddEmbeddedImage($imagePath, 'logo');
                    $mail->AltBody = '';
                    $mail->addaddress($user->email, $user->first_name . ' ' . $user->last_name);
                    $mail->isHTML(true);
                    $mail->msgHTML($view);

                    if (!$mail->send())
                        throw new \Exception('Failed to send mail');


                    $Admin = User::where('role_id', 1)->first();
                    $view = \view('pages.mails.ReminderInterviewAdmin24', $data);
                    $view = $view->render();

                    $mail = new PHPMailer();
                    $mail->CharSet = "UTF-8";

                    $mail->setfrom('support@247tutors.com', '247 Tutors');

                    $mail->isHTML(true);
                    $mail->Subject = 'Dear Admin, 15 minutes left for the interview with' . $user->first_name . ' ' . $user->last_name;
                    $mail->Body = $view;
                    $mail->AddEmbeddedImage($imagePath, 'logo');
                    $mail->AltBody = '';
                    $mail->addaddress($Admin->email, $Admin->first_name . ' ' . $Admin->last_name);
                    $mail->isHTML(true);
                    $mail->msgHTML($view);

                    if (!$mail->send())
                        throw new \Exception('Failed to send mail');
                }
            }
        }
    }

    public function BookingSlotRelease()
    {
        $tempSlots = TempSlot::all();

        foreach ($tempSlots as $tempSlot) {
            $booking = Booking::where('booking_date', $tempSlot->date)
                ->where('booking_time', $tempSlot->slot)
                ->where('status', 'Completed')
                ->where(function ($query) use ($tempSlot) {
                    $query->where('student_id', $tempSlot->user_id)
                        ->orWhere('parent_id', $tempSlot->user_id)
                        ->orWhere('parent_id', $tempSlot->parent_id);
                })->first();

            if ($booking) {
                $tempSlot->delete();
            } else {
                if ($tempSlot->created_at < Carbon::now()->subMinutes(5)) {
                    $tempSlot->delete();
                }
            }
        }
    }
}
