<?php

namespace App\Http\Controllers;

use App\Models\coupon as ModelsCoupon;
use App\Models\Subject;
use App\Models\Transaction;
use App\Models\Booking;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use PHPMailer\PHPMailer\PHPMailer;
use Stripe;
use Session;
use Stripe\Coupon;
use App\Services\Zoom;

class TransactionController extends Controller
{
    protected $zoomService;

    public function __construct(Zoom $zoomService)
    {
        $this->zoomService = $zoomService;
    }

    public function book_tutor_post(Request $request)
    {
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        $userId = $request->post('user_id') ? $request->post('user_id') : Auth::id();
        $user = User::find($userId);
        $check_booking = Booking::where('student_id', $userId);
        if (!empty($request->subject)) {
            $check_booking->where('subject_id', $request->subject);
        }
        $check_booking = $check_booking->where('tutor_id', $request->tutor_id)->first();
        if (empty($check_booking)) {
            if (empty($request->subject)) {

                $Transaction = new Transaction();
                $Transaction->user_id = Auth::id();
                $Transaction->tutor_id = $request->tutor_id;
                $Transaction->duration = $request->duration;
                $Transaction->country = $request->country;
                $Transaction->address1 = $request->address1;
                $Transaction->address2 = $request->address2;
                $Transaction->city = $request->city;
                $Transaction->postcode = $request->postcode;
                $Transaction->save();
                return redirect('parent/profile')->with('success', 'You Have Booked This Tutor');
            }
            $customer = Stripe\Customer::create(
                array(
                    "address" => [
                        "line1" => $request->address1,
                        "postal_code" => $request->postcode,
                        "city" => $request->city,
                        "country" => $request->country,
                    ],
                    "email" => Auth::user()->email,
                    "name" => $request->account_holder_name,
                    "source" => $request->stripeToken,
                )
            );

            $ch = Stripe\Charge::create([
                "amount" => $request->amount * 100,
                "currency" => "usd",
                "customer" => $customer->id,
                "description" => "",
            ]);

            $Coupon = ModelsCoupon::where('id', $request->copounid)->where('usage_limit', '>', 0)->first();
            if (!empty($Coupon)) {
                ModelsCoupon::where('id', $request->copounid)
                    ->update([
                        'usage_limit' => $Coupon->usage_limit - 1,
                        'used_count' => $Coupon->used_count + 1,
                    ]);
            } else {
                if (Auth::user()->role_id == 4 && !empty($request->copounid)) {
                    return redirect('student/profile')->with('failed', 'You Coupon Limit Is Expire');
                } elseif (Auth::user()->role_id == 5 && !empty($request->copounid)) {
                    return redirect('parent/profile')->with('failed', 'You Coupon Limit Is Expire');
                }
            }

            $booking = new Booking();
            $booking->student_id = $request->post('user_id') ? $request->post('user_id') : Auth::id();
            $booking->tutor_id = $request->tutor_id;
            $booking->subject_id = $request->subject;
            $booking->lessons_schedule = $request->lessons_schedule;
            $booking->booking_date = $request->date;
            $booking->booking_time = $request->time;
            $booking->status = 'Scheduled';
            $booking->save();

            $meeting = $this->zoomService->createMeeting([
                "agenda" => 'your agenda',
                "topic" => 'your topic',
                "type" => 2, // 1 => instant, 2 => scheduled, 3 => recurring with no fixed time, 8 => recurring with fixed time
                "duration" => 60, // in minutes
                "timezone" => 'Asia/Dhaka', // set your timezone
                // "password" => 'set your password',
                "start_time" => 'set your start time', // set your start time
                "template_id" => 'set your template id', // set your template id  Ex: "Dv4YdINdTk+Z5RToadh5ug==" from https://marketplace.zoom.us/docs/api-reference/zoom-api/meetings/meetingtemplates
                // "pre_schedule" => false,  // set true if you want to create a pre-scheduled meeting
                // "schedule_for" => 'a@gmail.com', // set your schedule for
                "settings" => [

                    'join_before_host' => true, // if you want to join before host set true otherwise set false
                    'host_video' => false, // if you want to start video when host join set true otherwise set false
                    'participant_video' => false, // if you want to start video when participants join set true otherwise set false
                    'mute_upon_entry' => false, // if you want to mute participants when they join the meeting set true otherwise set false
                    'waiting_room' => false, // if you want to use waiting room for participants set true otherwise set false
                    'audio' => 'both', // values are 'both', 'telephony', 'voip'. default is both.
                    'auto_recording' => 'local', // values are 'none', 'local', 'cloud'. default is none.
                    'approval_type' => 0, // 0 => Automatically Approve, 1 => Manually Approve, 2 => No Registration Required
                    'record' => true,
                ],

            ]);

            $booking = Booking::where('id', $booking->id)->first();
            $booking->meeting_id = $meeting['data']['id'];
            $booking->meet_start_url = $meeting['data']['start_url'];
            $booking->meet_join_url = $meeting['data']['join_url'];
            $booking->meet_pass = $meeting['data']['password'];
            $booking->save();

            $Transaction = new Transaction();
            // $Transaction->user_id = $request->post('user_id') ? $request->post('user_id') : Auth::id();
            $Transaction->amount = $request->amount;
            $Transaction->charge_id = $ch['id'];
            $Transaction->booking_id = $booking->id;
            $Transaction->cid = $request->copounid;
            // $Transaction->subject = $request->subject;
            // $Transaction->duration = $request->duration;
            $Transaction->country = $request->country;
            $Transaction->address1 = $request->address1;
            $Transaction->address2 = $request->address2;
            $Transaction->city = $request->city;
            $Transaction->postcode = $request->postcode;
            $Transaction->account_holder_name = $request->account_holder_name;
            $Transaction->card_number = $request->card_number;
            $Transaction->card_type = "Visa credit card";
            $Transaction->exp_month = $request->exp_month;
            $Transaction->exp_year = $request->exp_year;
            $Transaction->cvc = $request->cvc;
            // $Transaction->date = $request->date;
            // $Transaction->time = $request->time;
            $Transaction->save();
            $lastInsertedId = $Transaction->id;
            $tutor = User::find($request->tutor_id);
            $subject = Subject::find($request->subject);



            $url = URL::temporarySignedRoute(
                'apperove-subject',
                Carbon::now()->addMinutes(Config::get('auth.verification.expire', 1)),
                [
                    'id' => $request->tutor_id,
                    'hash' => sha1($lastInsertedId),
                ]
            );
            $data = [
                'url' => $url,
                'tutor' => $tutor->first_name . ' ' . $tutor->last_name,
                'student' => $user->first_name . ' ' . $user->last_name,
            ];
            if ($tutor->status !== 'Pending' && $tutor->status !== 'InActive') {

                $environment = env('APP_ENV', 'local');
                if($environment == 'local'){
                    Mail::send('pages.mails.tutorverifybooking', $data, function ($message) use ($tutor, $user, $subject) {
                        $message->to($tutor->email, $tutor->first_name . ' ' . $tutor->last_name)
                            ->subject($user->first_name . ' ' . $user->last_name . ' Hired You For ' . $subject->name);
                        $message->from($user->email, $user->first_name . ' ' . $user->last_name);
                    });
                }elseif($environment == 'production'){

                }


                // $view = \view('pages.mails.tutorverifybooking', $data);
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



            }


            if (Auth::user()->role_id == 4) {
                $chargeId = $ch['id'];
                $refund = Stripe\Refund::create([
                    'charge' => $chargeId,
                ]);

                $refundId = $refund->id;
                if ($refund->status === 'succeeded') {
                    return redirect('student/profile')->with('success', 'Successfully You Have Booked It Refund:ID' . $refundId);
                }
            } elseif (Auth::user()->role_id == 5) {
                $chargeId = $ch['id'];
                $refund = Stripe\Refund::create([
                    'charge' => $chargeId,
                ]);
                $refundId = $refund->id;
                if ($refund->status === 'succeeded') {
                    return redirect('parent/profile')->with('success', 'Successfully You Have Booked It Refund:ID' . $refundId);
                }
            }
        } else {
            if (Auth::user()->role_id == 4) {
                return redirect('student/profile')->with('failed', 'You Have Already Booked It');
            } elseif (Auth::user()->role_id == 5) {
                return redirect('parent/profile')->with('failed', 'You Have Already Booked It');
            }
        }
    }

    public function transaction(){
        if (Auth::user()->role_id != 1) { return redirect('dashboard'); }
        $transaction = Transaction::query();
        if (!empty($_GET['search'])) {
            $transaction->where(function ($query) {
                $query->Where('charge_id', 'like', '%' . $_GET['search'] . '%')
                    ->orWhere('address1', 'like', '%' . $_GET['search'] . '%')
                    ->orWhere('account_holder_name', 'like', '%' . $_GET['search'] . '%')
                    ->orWhere('booking_id', 'like', '%' . $_GET['search'] . '%');
            });
        }
        $transaction = $transaction->paginate(10);

        return view('pages.dashboard.transactions.transactionlog',compact('transaction'));
    }
}
