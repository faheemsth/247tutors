<?php

namespace App\Http\Controllers;

// use App\Mail\transaction;
use App\Models\Booking;
use App\Models\Transaction as ModelsTransaction;
use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Http\Request;
use App\Models\coupon as ModelsCoupon;
use App\Models\Subject;
use App\Models\Reschedule_meeting;
use App\Models\User;
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
use App\Models\Refound;
use App\Models\PendingPayment;

class BookingController extends Controller
{
    protected $zoomService;

    public function __construct(Zoom $zoomService)
    {
        $this->zoomService = $zoomService;
    }

    public function index(Request $request)
    {
        if (Auth::user()->role_id != 1) { return redirect('dashboard'); }
        $status = $request->input('status');
        $search = $request->input('search');
        $booking = Booking::join('transactions', 'bookings.id', '=', 'transactions.booking_id');
        if (!empty($status)) {
            $booking->where('status', $status);
        }
        $booking = $booking->with(['student', 'tutor', 'subjects']);
        if (!empty($search)) {
            $booking->whereHas('subjects', function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            });
        }

        $bookings = $booking->paginate(5, ['*'], 'page', $request->page);
        if ($request->ajax()) {
            return view('pages.dashboard.booking.ajaxbooking', compact('bookings'));
        }
        // dd($bookings);
        return view('pages.dashboard.booking.booking', compact('bookings'));
    }

    public function ActivityLog(Request $request)
    {
        if (Auth::user()->role_id != 1) { return redirect('dashboard'); }
        $ActivityLogs = ActivityLog::with('user');
        $search = $request->input('search');

        if (!empty($search)) {
            $ActivityLogs->whereHas('user', function ($query) use ($search) {
                $query->where(function ($subquery) use ($search) {
                    $subquery->where('first_name', 'like', '%' . $search . '%')
                        ->orWhere('last_name', 'like', '%' . $search . '%');
                });
            });

            $ActivityLogs->orWhere('description', 'like', '%' . $search . '%');
        }

        $ActivityLogs = $ActivityLogs->get();

        return view('pages.dashboard.ActivityLog.ActivityLog', compact('ActivityLogs'));
    }




    public function booking_update($id)
    {
        $bookings = ModelsTransaction::find($id);
        if ($bookings->status == "0") {
            $bookings->update(['status' => '1']);
        } elseif ($bookings->status == "1") {
            $bookings->update(['status' => '0']);
        }

        return back();
    }

    // For Stripe
    public function book_tutor_post(Request $request)
    {
        $imagePath = public_path('assets/images/247 NEW Logo 1.png');
        $amoutCredited = '';
        Stripe\Stripe::setApiKey('sk_test_51O4cl2Iml1HP3wz7vRShJNXP1OiyfMRMpsYvibX5FgvU9i1PVzhjNzyMKbzDXEbxYH6aEx9PbK76LjbJYvTP1Gii00RqJPF2Qu');
        $userId = $request->post('user_id') ? $request->post('user_id') : Auth::id();
        $user = User::find($userId);
        $check_booking = Booking::where('student_id', $userId);
        if (!empty($request->wallet)) {

            $Wallet = Wallet::where('user_id', Auth::id())->first();
            $student = Auth::user();
            $data = [
                'tutorMessage' => 'Your Booking Reschedule Request Accepted',
                'studentMessage' => 'Your Booking Reschedule Request Accepted',
                'student' => $student->first_name . ' ' . $student->last_name,
                'tutor' => '',
                'id' => '',
            ];


            $users = Auth::user();
            $view = \view('pages.mails.PayByWallet', $data);
            $view = $view->render();
            $mail = new PHPMailer();
            $mail->CharSet = "UTF-8";
            $mail->setfrom('support@247tutors.com', '247 Tutors');
            $mail->isHTML(true);
            $mail->Subject = 'Dear User - ' . ($Wallet->balance - $request->wallet) . ' £ Credit from Your Wallet';
            $mail->Body = $view;
            $mail->AltBody = '';
            $mail->addaddress($users->email, $users->first_name . ' ' . $users->last_name);
            $mail->isHTML(true);
            $mail->msgHTML($view);
            if (!$mail->send())
                throw new \Exception('Failed to send mail');


            $Withdrawal = $Wallet->balance - $request->wallet;
            $amoutCredited = $Withdrawal;
            $Wallet->balance = $request->wallet;
            $Wallet->withdrawn += $Withdrawal;
            $Wallet->save();
        }

        if (!empty($request->subject)) {
            $check_booking->where('subject_id', $request->subject);
        }
        $check_booking = $check_booking->where('tutor_id', $request->tutor_id)->where('booking_date', $request->date)->where('booking_time', $request->time)->first();
        if (empty($check_booking)) {
            if (empty($request->subject)) {
                $Transaction = new ModelsTransaction();
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
            if ($request->amount > 0) {

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
            }

            $firstCheck = ModelsCoupon::where('id', $request->copounid)
                ->where('usage_limit', '>', 0)
                ->whereIn('to_user', [Auth::id()])
                ->first();
            if (!empty($firstCheck)) {
                return redirect('student/profile')->with('failed', 'You Have Already Use This Coupon');
            }
            $Coupon = ModelsCoupon::where('id', $request->copounid)->where('usage_limit', '>', 0)->first();
            if (!empty($Coupon)) {
                $Coupon->update([
                    'usage_limit' => $Coupon->usage_limit - 1,
                    'used_count' => $Coupon->used_count + 1,
                ]);

                $Coupon->to_user = $Coupon->to_user . ',' . Auth::id();
                $Coupon->save();
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
            $booking->parent_id = $request->post('user_id') ? Auth::id() : null;
            $booking->subject_id = $request->subject;
            $booking->lessons_schedule = $request->lessons_schedule;
            $booking->booking_date = $request->date;
            $booking->booking_time = $request->time;
            $booking->status = 'Pending';
            $booking->uuid = $this->randomStringFormat();
            $booking->save();

            $ActivityLogs = new ActivityLog;
            $ActivityLogs->user_id = Auth::user()->id;
            $ActivityLogs->title = "New Booking";
            $ActivityLogs->description = "New Booking  " . Auth::user()->first_name . '   ' . Auth::user()->last_name . 'Book This' . $booking->uuid;
            $ActivityLogs->save();

            $Transaction = new ModelsTransaction();
            $Transaction->amount = $request->amount > 0 ? $request->amount : $amoutCredited;
            $Transaction->charge_id = $request->amount > 0 ? $ch['id'] : '';
            $Transaction->booking_id = $booking->id;
            $Transaction->cid = $request->copounid;
            $Transaction->country = $request->country;
            $Transaction->address1 = $request->address1;
            $Transaction->address2 = $request->address2;
            $Transaction->city = $request->city;
            $Transaction->postcode = $request->postcode;
            if ($request->card_number == 'on') {
                $Transaction->account_holder_name = $request->account_holder_name;
                $Transaction->card_number = $request->card_number;
                $Transaction->card_type = "Credit Card";
                $Transaction->exp_month = $request->exp_month;
                $Transaction->exp_year = $request->exp_year;
                $Transaction->cvc = $request->cvc;
            }
            $Transaction->save();
            $lastInsertedId = $Transaction->id;
            $tutor = User::find($request->tutor_id);
            $subject = Subject::find($request->subject);



            $url = URL::temporarySignedRoute(
                'booking-status-change',
                Carbon::now()->addMinutes(Config::get('auth.verification.expire', 1)),
                [
                    'id' => $booking->uuid,
                    'hash' => sha1($lastInsertedId),
                    'tutorId' => $request->tutor_id,
                ]
            );
            $data = [
                'url' => $url,
                'tutor' => $tutor->first_name . ' ' . $tutor->last_name,
                'student' => $user->first_name . ' ' . $user->last_name,
                'Scheduled' => 'Scheduled',
                'Cancelled' => 'Cancelled',
                'ScheduleTime' => $request->date . ' ' . $request->time,
            ];
            if ($tutor->status !== 'Pending' && $tutor->status !== 'InActive') {
                $environment = env('APP_ENV', 'local');
                if ($environment == 'local') {
                    Mail::send('pages.mails.tutorverifybooking', $data, function ($message) use ($tutor, $user, $subject) {
                        $message->to($tutor->email, $tutor->first_name . ' ' . $tutor->last_name)
                            ->subject($user->first_name . ' ' . $user->last_name . ' Hired You For ' . $subject->name);
                        $message->from($user->email, $user->first_name . ' ' . $user->last_name);
                    });
                } elseif ($environment == 'production') {

                    $view = \view('pages.mails.NewBooking', $data);
                    $view = $view->render();

                    $mail = new PHPMailer();
                    $mail->CharSet = "UTF-8";

                    $mail->setfrom('support@247tutors.com', '247 Tutors');

                    $mail->isHTML(true);
                    $mail->Subject = 'New Booking';
                    $mail->Body = $view;
                    $mail->AddEmbeddedImage($imagePath, 'logo');
                    $mail->AltBody = '';
                    $mail->addaddress($tutor->email, $data['tutor']);
                    $mail->isHTML(true);
                    $mail->msgHTML($view);

                    if (!$mail->send())
                        throw new \Exception('Failed to send mail');
                }
            }


            if (Auth::user()->role_id == 4) {
                return redirect('bookings')->with('success', 'Successfully You Have Booked It .');
            } elseif (Auth::user()->role_id == 5) {
                return redirect('bookings')->with('success', 'Successfully You Have Booked It.');
            } elseif (Auth::user()->role_id == 6) {
                return redirect('bookings')->with('success', 'Successfully You Have Booked It.');
            }
        } else {
            if (Auth::user()->role_id == 4) {
                return redirect('student/profile')->with('failed', 'You Have Already Booked It');
            } elseif (Auth::user()->role_id == 5) {
                return redirect('parent/profile')->with('failed', 'You Have Already Booked It');
            } elseif (Auth::user()->role_id == 6) {
                return redirect('parent/profile')->with('failed', 'You Have Already Booked It');
            }
        }
    }

    // For Wallet
    public function book_by_wallet_post(Request $request)
    {
        $imagePath = public_path('assets/images/247 NEW Logo 1.png');
        $amoutCredited = '';
        $userId = $request->post('user_id') ? $request->post('user_id') : Auth::id();
        $user = User::find($userId);
        $check_booking = Booking::where('student_id', $userId);
        $Wallet = Wallet::where('user_id', Auth::id())->first();
        if (!empty($Wallet)) {
            if($Wallet->net_income > 0 && $Wallet->net_income >= $request->amount){
            $student = Auth::user();
            $data = [
                'tutorMessage' => 'Your Booking Reschedule Request Accepted',
                'studentMessage' => 'Your Booking Reschedule Request Accepted',
                'student' => $student->first_name . ' ' . $student->last_name,
                'amount' => '$request->amount',
            ];

            $users = Auth::user();
            $view = \view('pages.mails.PayByWallet', $data);
            $view = $view->render();
            $mail = new PHPMailer();
            $mail->CharSet = "UTF-8";
            $mail->setfrom('support@247tutors.com', '247 Tutors');
            $mail->isHTML(true);
            $mail->Subject = 'Dear Student - ' . ($request->amount) . ' £ Credit from Your Wallet';
            $mail->Body = $view;
            $mail->AddEmbeddedImage($imagePath, 'logo');
            $mail->AltBody = '';
            $mail->addaddress($users->email, $users->first_name . ' ' . $users->last_name);
            $mail->isHTML(true);
            $mail->msgHTML($view);
            if (!$mail->send())
                throw new \Exception('Failed to send mail');

            $Wallet->net_income -= $request->amount;
            $Wallet->save();

            if (!empty($request->subject)) {
                $check_booking->where('subject_id', $request->subject);
            }
            $check_booking = $check_booking->where('tutor_id', $request->tutor_id)->where('booking_date', $request->date)->where('booking_time', $request->time)->first();
            if (empty($check_booking)) {
                if (empty($request->subject)) {
                    $Transaction = new ModelsTransaction();
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
                if ($request->amount > 0) {


                }

                $firstCheck = ModelsCoupon::where('id', $request->copounid)
                    ->where('usage_limit', '>', 0)
                    ->whereIn('to_user', [Auth::id()])
                    ->first();
                if (!empty($firstCheck)) {
                    return redirect('student/profile')->with('failed', 'You Have Already Use This Coupon');
                }
                $Coupon = ModelsCoupon::where('id', $request->copounid)->where('usage_limit', '>', 0)->first();
                if (!empty($Coupon)) {
                    $Coupon->update([
                        'usage_limit' => $Coupon->usage_limit - 1,
                        'used_count' => $Coupon->used_count + 1,
                    ]);

                    $Coupon->to_user = $Coupon->to_user . ',' . Auth::id();
                    $Coupon->save();
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
                $booking->parent_id = $request->post('user_id') ? Auth::id() : null;
                $booking->subject_id = $request->subject;
                $booking->lessons_schedule = $request->lessons_schedule;
                $booking->booking_date = $request->date;
                $booking->booking_time = $request->time;
                $booking->status = 'Pending';
                $booking->uuid = $this->randomStringFormat();
                $booking->save();

                $ActivityLogs = new ActivityLog;
                $ActivityLogs->user_id = Auth::user()->id;
                $ActivityLogs->title = "New Booking";
                $ActivityLogs->description = "New Booking  " . Auth::user()->first_name . '   ' . Auth::user()->last_name . 'Book This' . $booking->uuid;
                $ActivityLogs->save();

                $Transaction = new ModelsTransaction();
                $Transaction->amount = $request->amount > 0 ? $request->amount : $amoutCredited;
                $Transaction->charge_id = 'Wallet';
                $Transaction->booking_id = $booking->id;
                $Transaction->cid = $request->copounid;
                $Transaction->country = $request->country;
                $Transaction->address1 = $request->address1;
                $Transaction->address2 = $request->address2;
                $Transaction->city = $request->city;
                $Transaction->postcode = $request->postcode;
                $Transaction->account_holder_name = Auth::user()->first_name . '   ' . Auth::user()->last_name;
                $Transaction->card_type = "Wallet";
                $Transaction->save();
                $lastInsertedId = $Transaction->id;
                $tutor = User::find($request->tutor_id);
                $subject = Subject::find($request->subject);



                $url = URL::temporarySignedRoute(
                    'booking-status-change',
                    Carbon::now()->addMinutes(Config::get('auth.verification.expire', 1)),
                    [
                        'id' => $booking->uuid,
                        'hash' => sha1($lastInsertedId),
                        'tutorId' => $request->tutor_id,
                    ]
                );
                $data = [
                    'url' => $url,
                    'tutor' => $tutor->first_name . ' ' . $tutor->last_name,
                    'student' => $user->first_name . ' ' . $user->last_name,
                    'Scheduled' => 'Scheduled',
                    'Cancelled' => 'Cancelled',
                    'ScheduleTime' => $request->date . ' ' . $request->time,
                ];
                if ($tutor->status !== 'Pending' && $tutor->status !== 'InActive') {
                    $environment = env('APP_ENV', 'local');
                    if ($environment == 'local') {
                        Mail::send('pages.mails.tutorverifybooking', $data, function ($message) use ($tutor, $user, $subject) {
                            $message->to($tutor->email, $tutor->first_name . ' ' . $tutor->last_name)
                                ->subject($user->first_name . ' ' . $user->last_name . ' Hired You For ' . $subject->name);
                            $message->from($user->email, $user->first_name . ' ' . $user->last_name);
                        });
                    } elseif ($environment == 'production') {

                        $view = \view('pages.mails.NewBooking', $data);
                        $view = $view->render();

                        $mail = new PHPMailer();
                        $mail->CharSet = "UTF-8";

                        $mail->setfrom('support@247tutors.com', '247 Tutors');

                        $mail->isHTML(true);
                        $mail->Subject = 'New Booking';
                        $mail->Body = $view;
                        $mail->AddEmbeddedImage($imagePath, 'logo');
                        $mail->AltBody = '';
                        $mail->addaddress($tutor->email, $data['tutor']);
                        $mail->isHTML(true);
                        $mail->msgHTML($view);

                        if (!$mail->send())
                            throw new \Exception('Failed to send mail');
                    }
                }


                if (Auth::user()->role_id == 4) {
                    return redirect('bookings')->with('success', 'Successfully You Have Booked It .');
                } elseif (Auth::user()->role_id == 5) {
                    return redirect('bookings')->with('success', 'Successfully You Have Booked It.');
                } elseif (Auth::user()->role_id == 6) {
                    return redirect('bookings')->with('success', 'Successfully You Have Booked It.');
                }
            } else {
                if (Auth::user()->role_id == 4) {
                    return redirect('student/profile')->with('failed', 'You Have Already Booked It');
                } elseif (Auth::user()->role_id == 5) {
                    return redirect('parent/profile')->with('failed', 'You Have Already Booked It');
                } elseif (Auth::user()->role_id == 6) {
                    return redirect('parent/profile')->with('failed', 'You Have Already Booked It');
                }
            }
          }else{
              return redirect('parent/payments')->with('failed', 'Sorry, it appears that your wallet currently has insufficient funds.');
          }

        }


    }















    // ahsan
    public function book_free_lesson(Request $request)
    {
        $imagePath = public_path('assets/images/247 NEW Logo 1.png');
        $check = Booking::where('lessons_schedule', 'Demo Lesson')->where('tutor_id', $request->tutor_id)->first();

        if (!empty($check)) {
            return back()->with('failed', 'Sorry You Can Book Free Leason With This Tutor One Time');
        }
        $booking = new Booking();
        $booking->student_id = $request->post('student_id');
        $booking->tutor_id = $request->tutor_id;
        $booking->subject_id = $request->subject_id;
        $booking->lessons_schedule = 'Demo Lesson';
        $booking->booking_date = $request->date;
        $booking->duration = 10;
        $booking->booking_time = $request->time;
        $booking->status = 'Pending';
        $booking->uuid = $this->randomStringFormat();

        if (Auth::user()->role_id == 5) {
            $booking->parent_id = Auth::user()->id;
        }
        $booking->save();

        $lastInsertedId = $booking->id;
        $tutor = User::find($request->tutor_id);
        $user = User::find(Auth::id());
        $subject = Subject::find($request->subject);

        $url = URL::temporarySignedRoute(
            'booking-status-change',
            Carbon::now()->addMinutes(Config::get('auth.verification.expire', 1)),
            [
                'id' => $booking->uuid,
                'hash' => sha1($lastInsertedId),
                'tutorId' => $request->tutor_id,
            ]
        );
        $data = [
            'url' => $url,
            'tutor' => $tutor->first_name . ' ' . $tutor->last_name,
            'student' => $user->first_name . ' ' . $user->last_name,
            'Scheduled' => 'Scheduled',
            'Cancelled' => 'Cancelled By Tutor',
            'ScheduleTime' => $request->date . ' ' . $request->time,
        ];

        $environment = env('APP_ENV', 'local');
        if ($environment == 'local') {
            Mail::send('pages.mails.NewBooking', $data, function ($message) use ($tutor, $user, $subject) {
                $message->to($tutor->email, $tutor->first_name . ' ' . $tutor->last_name)
                    ->subject($user->first_name . ' ' . $user->last_name . ' Hired You For ' . optional($subject)->name);
                $message->from($user->email, $user->first_name . ' ' . $user->last_name);
            });
        } elseif ($environment == 'production') {

            $view = \view('pages.mails.NewBooking', $data);
            $view = $view->render();

            $mail = new PHPMailer();
            $mail->CharSet = "UTF-8";

            $mail->setfrom('support@247tutors.com', '247 Tutors');

            $mail->isHTML(true);
            $mail->Subject = 'New Booking';
            $mail->Body = $view;
            $mail->AddEmbeddedImage($imagePath, 'logo');
            $mail->AltBody = '';
            $mail->addaddress($tutor->email, $data['tutor']);
            $mail->isHTML(true);
            $mail->msgHTML($view);

            if (!$mail->send())
                throw new \Exception('Failed to send mail');
        }


        return redirect('bookings')->with('success', 'Successfully You Have Booked Free Lesson ');
    }

    public function bookings(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $subject = $request->input('subject');
        $date = $request->input('date');
        $level = $request->input('level');

        $user_id = Auth::id();
        $checkusers = User::where('parent_id', $user_id)->get();
        $levels = Level::all();
        $Subjects1 = \DB::table('tutor_subject_offers')
            ->select('subject_id')
            ->distinct()
            ->get();

        $query = Booking::when(!empty($subject), function ($query) use ($subject) {
            $query->where('subject_id', $subject);
        })
            ->when(!empty($date), function ($query) use ($date) {
                $query->where('booking_date', $date);
            });

        if (Auth::user()->role_id == 4) {
            $query->where('student_id', Auth::id());
        }

        if (Auth::user()->role_id == 5) {
            $query->where('parent_id', Auth::id());
        }

        if (Auth::user()->role_id == 3) {
            $query->where('tutor_id', Auth::id());
        }

        $bookings = $query->with(['student', 'tutor', 'subjects'])->get();

        if ($request->ajax()) {
            return view('pages.dashboard.bookajax', compact('bookings', 'levels', 'Subjects1'));
        }

        return view('pages.dashboard.bookings', compact('bookings', 'levels', 'Subjects1'));
    }








































    public function booking_status_change(Request $request)
    {
        $imagePath = public_path('assets/images/247 NEW Logo 1.png');
        $checkCancelled = Booking::where('uuid', $request->id)->where('tutor_id', $request->tutorId)->where('status', 'Cancelled')->first();
        if (!empty($checkCancelled)) {
            return redirect('bookings')->with('failed', 'Sorry You Have Cancelled This Booking.');
        }
        // Send  Scheduled
        if ($request->status == 'Scheduled') {

            $tutor = User::find($request->tutorId);
            $booking = Booking::where('uuid', $request->id)
                ->where('tutor_id', $request->tutorId)
                ->first();
            if ($booking) {
                if($booking->parent_id != null){
                     $student = User::find($booking->parent_id);
                }else{
                     $student = User::find($booking->student_id);
                }

            }

            $ActivityLogs = new ActivityLog;
            $ActivityLogs->user_id = Auth::user()->id;
            $ActivityLogs->title = "Scheduled Booking";
            $ActivityLogs->description = "Scheduled Booking  " . Auth::user()->first_name . '   ' . Auth::user()->last_name . 'Scheduled' . $request->id;
            $ActivityLogs->save();

            $data = [
                'tutorMessage' => 'Booking Is Scheduled',
                'student' => $student->first_name . ' ' . $student->last_name,
                'tutor' => $tutor->first_name . ' ' . $tutor->last_name,
                'ScheduleTime' => $booking->booking_date . ' ' . $booking->booking_time,
                'duration' => $booking->duration,
                'Subject' => optional(Subject::find($booking->subject_id))->name,
            ];

                if (Auth::user()->role_id == 4) {
                    dd(1);
                    $view = \view('pages.mails.ScheduledBookingStudent', $data);
                    $view = $view->render();

                    $mail = new PHPMailer();
                    $mail->CharSet = "UTF-8";

                    $mail->setfrom('support@247tutors.com', '247 Tutors');

                    $mail->isHTML(true);
                    $mail->Subject = 'Booking Scheduled';
                    $mail->Body = $view;
                    $mail->AddEmbeddedImage($imagePath, 'logo');
                    $mail->AltBody = '';
                    $mail->addaddress($tutor->email, $tutor->first_name . ' ' . $tutor->last_name);
                    $mail->isHTML(true);
                    $mail->msgHTML($view);

                    if (!$mail->send())
                        throw new \Exception('Failed to send mail');
                }

                if (Auth::user()->role_id == 3) {

                    $users = $student;
                    $view = \view('pages.mails.ScheduledBookingTutor', $data);
                    $view = $view->render();

                    $mail = new PHPMailer();
                    $mail->CharSet = "UTF-8";

                    $mail->setfrom('support@247tutors.com', '247 Tutors');

                    $mail->isHTML(true);
                    $mail->Subject = 'Booking Scheduled';
                    $mail->Body = $view;
                    $mail->AddEmbeddedImage($imagePath, 'logo');
                    $mail->AltBody = '';
                    $mail->addaddress($users->email, $users->first_name . ' ' . $users->last_name);
                    $mail->isHTML(true);
                    $mail->msgHTML($view);

                    if (!$mail->send())
                        throw new \Exception('Failed to send mail');
                }


            Booking::where('uuid', $request->id)->where('tutor_id', $request->tutorId)
                ->update([
                    'status' => $request->status,
                ]);
            return redirect('bookings')->with('success', 'Successfully Your Booking' . '  ' . $request->status);
        } else if ($request->status == 'Cancelled' || $request->status == 'Cancelled By Tutor') {

            $wallet = Wallet::where('user_id', Auth::id())->first();

            if ($wallet) {
                $transactionAmount = Transaction::join('bookings', 'transactions.booking_id', '=', 'bookings.id')
                    ->where('bookings.uuid', $request->id)
                    ->select('transactions.amount')
                    ->first();

                $amountToAdd = $transactionAmount ? $transactionAmount->amount : 0;

                $wallet->update([
                    'balance' => $wallet->balance + $amountToAdd
                ]);
            }



            $ActivityLogs = new ActivityLog;
            $ActivityLogs->user_id = Auth::id();
            $ActivityLogs->title = "Cancel by " . Auth::user()->username . " Booking";
            $ActivityLogs->description = "Booking ($request->id) cancellation amount is added into wallet of " . Auth::user()->first_name . " " . Auth::user()->last_name;
            $ActivityLogs->save();


            $tutor = User::find($request->tutorId);
            $booking = Booking::where('uuid', $request->id)
                ->where('tutor_id', $request->tutorId)
                ->first();
            if ($booking) {
                if($booking->parent_id != null){
                     $student = User::find($booking->parent_id);
                }else{
                     $student = User::find($booking->student_id);
                }

            }



            if ($student->booking_cancellation_count == 3) {
                return redirect('bookings')->with('failed', 'Your cancellation limit exceeded please contact admin.');
            }

            Booking::where('uuid', $request->id)->where('tutor_id', $request->tutorId)
                ->update([
                    'status' => $request->status,
                ]);
            $student->booking_cancellation_count += 1;
            $student->save();

            $data = [
                'tutorMessage' => 'Booking Is Cancelled',
                'student' => $student->first_name . ' ' . $student->last_name,
                'tutor' => $tutor->first_name . ' ' . $tutor->last_name,
            ];
            $view = \view('pages.mails.CancelledBooking', $data);
            $view = $view->render();

            $mail = new PHPMailer();
            $mail->CharSet = "UTF-8";

            $mail->setfrom('support@247tutors.com', '247 Tutors');

            $mail->isHTML(true);
            $mail->Subject = 'Booking Cancelled';
            $mail->Body = $view;
            $mail->AddEmbeddedImage($imagePath, 'logo');
            $mail->AltBody = '';
            $mail->addaddress($student->email, $student->first_name . ' ' . $student->last_name);
            $mail->isHTML(true);
            $mail->msgHTML($view);

                if (!$mail->send())
                    throw new \Exception('Failed to send mail');


            return redirect('bookings')->with('success', 'Successfully Your Bookong' . '  ' . $request->status);
        }
    }







































    public function booking_status_compeleted(Request $request)
    {
        Booking::where('uuid', $request->id)->where('tutor_id', $request->tutorId)
            ->update([
                'status' => $request->status,
            ]);


        $Booking=Booking::where('uuid', $request->id)->where('tutor_id', $request->tutorId)->first();

        $Transaction=Transaction::where('booking_id',$Booking->id)->first();
        if(empty(PendingPayment::where('booking_id',$Booking->id)->first())){
            $PendingPayment=new PendingPayment;
            $PendingPayment->tutor_id=$request->tutorId;
            $PendingPayment->amount=$Transaction->amount;
            $PendingPayment->booking_id=$Booking->id;
            $PendingPayment->save();
        }


        $tutor = User::find($request->tutorId);
        $student = User::find($Booking->student_id);


        $ActivityLogs = new ActivityLog;
        $ActivityLogs->user_id = Auth::id();
        $ActivityLogs->title = "Mark As Compeleted" . Auth::user()->username . " Booking";
        $ActivityLogs->description = "Booking ($request->id) Mark As Compeleted " . Auth::user()->first_name . " " . Auth::user()->last_name;
        $ActivityLogs->save();

        $data = [
            'tutorMessage' => 'Your Booking Successfully Completed',
            'studentMessage' => 'Your Booking Successfully Completed',
            'student' => $student->first_name . ' ' . $student->last_name,
            'tutor' => $tutor->first_name . ' ' . $tutor->last_name,
        ];
        $imagePath = public_path('assets/images/247 NEW Logo 1.png');

        // tutor
        $view = \view('pages.mails.CompletedBookingTutor', $data);
        $view = $view->render();
        $mail = new PHPMailer();
        $mail->CharSet = "UTF-8";
        $mail->setfrom('support@247tutors.com', '247 Tutors');
        $mail->isHTML(true);
        $mail->Subject = 'Your Booking Successfully Completed';
        $mail->Body = $view;
        $mail->AddEmbeddedImage($imagePath, 'logo');
        $mail->AltBody = '';
        $mail->addaddress($tutor->email, $tutor->first_name . ' ' . $tutor->last_name);
        $mail->isHTML(true);
        $mail->msgHTML($view);

        if (!$mail->send())
            throw new \Exception('Failed to send mail');


        // student
        $view = \view('pages.mails.CompletedBookingStudent', $data);
        $view = $view->render();
        $mail = new PHPMailer();
        $mail->CharSet = "UTF-8";
        $mail->setfrom('support@247tutors.com', '247 Tutors');
        $mail->isHTML(true);
        $mail->Subject = 'Your Booking Successfully Completed';
        $mail->Body = $view;
        $mail->AddEmbeddedImage($imagePath, 'logo');
        $mail->AltBody = '';
        $mail->addaddress($student->email, $student->first_name . ' ' . $student->last_name);
        $mail->isHTML(true);
        $mail->msgHTML($view);

        if (!$mail->send())
            throw new \Exception('Failed to send mail');




        return redirect('bookings')->with('success', 'Successfully Your Bookong' . '  ' . $request->status);
    }

































    public function request_refound(Request $request)
    {
        $imagePath = public_path('assets/images/247 NEW Logo 1.png');

        // if(Auth::user()->role_id == 3){
        //     return back()->with('error','401 Unauthorized Action');
        // }
        Booking::where('uuid', $request->id)->where('tutor_id', $request->tutorId)
            ->update([
                'request_refound' => '1',
            ]);


        $bookingId = $request->id;
        $existingRefound = Refound::where('bookingId', $bookingId)->first();

        if (!$existingRefound) {
            $Refound = new Refound();
            $Refound->reason = $request->reason;
            $Refound->tutorId = $request->tutorId;
            $Refound->bookingId = $bookingId;

            $image = $request->file('image');

            if ($image) {
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('images'), $imageName);
                $Refound->image = 'images/' . $imageName;
            } else {

                $Refound->image = null;
            }

            $Refound->save();
        }




        $ActivityLogs = new ActivityLog;
        $ActivityLogs->user_id = Auth::id();
        $ActivityLogs->title = "Refound Request" . Auth::user()->username . " Booking";
        $ActivityLogs->description = "Booking ($request->id) Refound Request Submited" . Auth::user()->first_name . " " . Auth::user()->last_name;
        $ActivityLogs->save();

        $tutor = User::find($request->tutorId);

        $booking = Booking::where('uuid', $request->id)
            ->where('tutor_id', $request->tutorId)
            ->first();

            if ($booking) {
                if($booking->parent_id != null){
                     $student = User::find($booking->parent_id);
                }else{
                     $student = User::find($booking->student_id);
                }

            }


        if (empty($student)) {
            return redirect('bookings')->with('success', 'Sorry You Not Have Any Student');
        }

        $data = [
            'tutorMessage' => 'Your Booking Successfully Completed',
            'studentMessage' => 'Your Booking Successfully Completed',
            'student' => $student->first_name . ' ' . $student->last_name,
            'tutor' => $tutor->first_name . ' ' . $tutor->last_name,
            'bookingId' => $request->id,
            'tutorname' => optional($booking->tutor)->username,
            'reason' => $request->reason,
            'bookingtime' => $booking->booking_date . ' ' .  $booking->booking_time,
        ];

        // student
        $view = \view('pages.mails.RefundBookingStudent', $data);
        $view = $view->render();
        $mail = new PHPMailer();
        $mail->CharSet = "UTF-8";
        $mail->setfrom('support@247tutors.com', '247 Tutors');
        $mail->isHTML(true);
        $mail->Subject = 'Refund Request for Tutor Booking - Action Required';
        $mail->Body = $view;
        $mail->AddEmbeddedImage($imagePath, 'logo');
        $mail->AltBody = '';
        $mail->addaddress($student->email, $student->first_name . ' ' . $student->last_name);
        $mail->isHTML(true);
        $mail->msgHTML($view);
        if (!$mail->send())
            throw new \Exception('Failed to send mail');


        // tutor
        $view = \view('pages.mails.RefundBookingTutor', $data);
        $view = $view->render();
        $mail = new PHPMailer();
        $mail->CharSet = "UTF-8";
        $mail->setfrom('support@247tutors.com', '247 Tutors');
        $mail->isHTML(true);
        $mail->Subject = 'Refund Request Submitted by Student';
        $mail->Body = $view;
        $mail->AddEmbeddedImage($imagePath, 'logo');
        $mail->AltBody = '';
        $mail->addaddress($tutor->email, $tutor->first_name . ' ' . $tutor->last_name);
        $mail->isHTML(true);
        $mail->msgHTML($view);
        if (!$mail->send())
            throw new \Exception('Failed to send mail');
        return redirect('bookings')->with('success', 'Your Request Refound Successfully' . '  ' . $request->status);
    }


    public function RefoundList(Request $request)
    {
        if (Auth::user()->role_id != 1) { return redirect('dashboard'); }
        $Refound = Refound::all();
        return view('super-admin.Refound.index', compact('Refound'));
    }


    // aleem

    public function rescheduled_meeting(Request $request)
    {
        $imagePath = public_path('assets/images/247 NEW Logo 1.png');
        $booking = Booking::where('uuid', $request->booking_id)->first();
        if ($booking) {
             if($booking->parent_id != null){
                   $student = User::find($booking->parent_id);
            }else{
                   $student = User::find($booking->student_id);
                }

            }

        $tutor = User::find($booking->tutor_id);
        $url = URL::temporarySignedRoute(
            'apperove_rescheduled_meeting',
            Carbon::now()->addMinutes(Config::get('auth.verification.expire', 1)),
            [
                'id' => $booking->id,
                'hash' => sha1($booking->id),
                'user_id' => $student->id,
            ]
        );
        $data = [
            'url' => $url,
            'tutorMessage' => 'Your Booking Reschedule Request Submited',
            'studentMessage' => 'Your Booking Reschedule Request Submited',
            'student' => $student->first_name . ' ' . $student->last_name,
            'tutor' => $tutor->first_name . ' ' . $tutor->last_name,
            'current_date' => $booking->booking_date,
            'current_time' => $booking->booking_time,
            'request_date' => $request->date,
            'request_time' => $request->time,
        ];

        if ($booking->booking_rescheduled_count == 3) {
            return redirect('bookings')->with('failed', 'Your Rescheduled limit exceeded please contact admin.');
        }

        $TutorWarning = User::where('id', Auth::id())->whereIn('role_id', [3, 4, 5])->first();
        if ($TutorWarning->tutor_reschedule_warning == 3) {
            return redirect('bookings')->with('failed', 'Your Rescheduled limit exceeded please contact admin.');
        }

        $booking->booking_rescheduled_count += 1;
        // $booking->booking_date = $request->date;
        // $booking->booking_time = $request->time;
        $booking->save();

        $ActivityLogs = new ActivityLog;
        $ActivityLogs->user_id = Auth::id();
        $ActivityLogs->title = "Rescheduled Meeting" . Auth::user()->username . " Booking";
        $ActivityLogs->description = "Booking ($request->id) Rescheduled Meeting Submited" . Auth::user()->first_name . " " . Auth::user()->last_name;
        $ActivityLogs->save();

        $TutorWarning = User::where('id', Auth::id())->whereIn('role_id', [3, 4, 5])->first();
        if ($TutorWarning->tutor_reschedule_warning == 3) {
            return redirect('bookings')->with('failed', 'Your Rescheduled limit exceeded please contact admin.');
        }
        $TutorWarning->tutor_reschedule_warning += 1;
        $TutorWarning->save();

        if ($booking) {
            $user = \Auth::user();

            if ($user->role_id == 3 && $booking->tutor_id == $user->id) {
                $this->rescheduleMeet($booking, $request->date, $request->time);
                // Send mail code
                $student = User::find($booking->student_id);
                $tutor = User::find($booking->tutor_id);

                $environment = env('APP_ENV', 'local');
                if ($environment == 'local') {
                    Mail::send('pages.mails.RescheduleMeeting', $data, function ($message) use ($student) {
                        $message->to($student->email, $student->first_name . ' ' . $student->last_name)
                            ->subject('Booking Reschedule Request');
                        $message->from(Auth::user()->email, Auth::user()->first_name . ' ' . Auth::user()->last_name);
                    });
                } elseif ($environment == 'production') {
                    $view = \view('pages.mails.RescheduleMeetingByTutor', $data);
                    $view = $view->render();

                    $mail = new PHPMailer();
                    $mail->CharSet = "UTF-8";

                    $mail->setfrom('support@247tutors.com', '247 Tutors');

                    $mail->isHTML(true);
                    $mail->Subject = 'Request to Reschedule Booking';
                    $mail->Body = $view;
                    $mail->AddEmbeddedImage($imagePath, 'logo');
                    $mail->AltBody = '';
                    $mail->addaddress($student->email, $student->first_name . ' ' . $student->last_name);
                    $mail->isHTML(true);
                    $mail->msgHTML($view);

                    if (!$mail->send())
                        throw new \Exception('Failed to send mail');
                }
            } elseif ($user->role_id == 5 || $user->role_id == 4 && $booking->student_id == $user->id) {

                $this->rescheduleMeet($booking, $request->date, $request->time);
                // Send mail code
                $student = User::find($booking->student_id);
                $tutor = User::find($booking->tutor_id);
                $url = URL::temporarySignedRoute(
                    'apperove_rescheduled_meeting',
                    Carbon::now()->addMinutes(Config::get('auth.verification.expire', 1)),
                    [
                        'id' => $booking->id,
                        'hash' => sha1($booking->id),
                        'user_id' => $tutor->id,
                    ]
                );


                $environment = env('APP_ENV', 'local');
                if ($environment == 'local') {
                    Mail::send('pages.mails.RescheduleMeetingByStudent', $data, function ($message) use ($tutor) {
                        $message->to($tutor->email, $tutor->first_name . ' ' . $tutor->last_name)
                            ->subject('Booking Reschedule Request');
                        $message->from(Auth::user()->email, Auth::user()->first_name . ' ' . Auth::user()->last_name);
                    });
                } elseif ($environment == 'production') {
                    $view = \view('pages.mails.RescheduleMeetingByStudent', $data);
                    $view = $view->render();

                    $mail = new PHPMailer();
                    $mail->CharSet = "UTF-8";

                    $mail->setfrom('support@247tutors.com', '247 Tutors');

                    $mail->isHTML(true);
                    $mail->Subject = 'Reschedule Meeting  ' . $request->booking_id . 'For This Booking ';
                    $mail->Body = $view;
                    $mail->AddEmbeddedImage($imagePath, 'logo');
                    $mail->AltBody = '';
                    $mail->addaddress($tutor->email, $tutor->first_name . ' ' . $tutor->last_name);
                    $mail->isHTML(true);
                    $mail->msgHTML($view);

                    if (!$mail->send())
                        throw new \Exception('Failed to send mail');
                }
            } elseif ($user->role_id == 5 && $booking->student_id == $user->id) {
                $this->rescheduleMeet($booking, $request->date, $request->time);
                // Send mail code
                $student = User::find($booking->student_id);
                $tutor = User::find($booking->tutor_id);
                $url = URL::temporarySignedRoute(
                    'apperove_rescheduled_meeting',
                    Carbon::now()->addMinutes(Config::get('auth.verification.expire', 1)),
                    [
                        'id' => $booking->id,
                        'hash' => sha1($booking->id),
                        'user_id' => $tutor->id,
                    ]
                );
                $data = [
                    'url' => $url,
                    'tutorMessage' => 'Your Booking Reschedule Request Submited',
                    'studentMessage' => 'Your Booking Reschedule Request Submited',
                    'student' => $student->first_name . ' ' . $student->last_name,
                    'tutor' => $tutor->first_name . ' ' . $tutor->last_name,
                    'current_date' => $booking->booking_date,
                    'current_time' => $booking->booking_time,
                    'request_date' => $request->date,
                    'request_time' => $request->time,
                ];

                $environment = env('APP_ENV', 'local');
                if ($environment == 'local') {
                    Mail::send('pages.mails.reschedule_meeting', $data, function ($message) use ($tutor) {
                        $message->to($tutor->email, $tutor->first_name . ' ' . $tutor->last_name)
                            ->subject('Booking Reschedule Request');
                        $message->from(Auth::user()->email, Auth::user()->first_name . ' ' . Auth::user()->last_name);
                    });
                } elseif ($environment == 'production') {
                    $view = \view('pages.mails.reschedule_meeting', $data);
                    $view = $view->render();

                    $mail = new PHPMailer();
                    $mail->CharSet = "UTF-8";

                    $mail->setfrom('support@247tutors.com', '247 Tutors');

                    $mail->isHTML(true);
                    $mail->Subject = 'Your Booking Successfully Completed';
                    $mail->Body = $view;
                    $mail->AltBody = '';
                    $mail->addaddress($tutor->email, $tutor->first_name . ' ' . $tutor->last_name);
                    $mail->isHTML(true);
                    $mail->msgHTML($view);

                    if (!$mail->send())
                        throw new \Exception('Failed to send mail');
                }
            } else {
                return redirect('bookings')->with('success', 'This booking does not belongs to you.');
            }
        }

        return redirect('bookings')->with('success', 'Your Booking Reschedule Request Submited #' . '' . $request->booking_id);
    }

    public function checkSlot(Request $request)
    {

        $slot = TempSlot::where('tutor_id', $request->tr)->where('date', $request->date)->where('slot', $request->slot)->first();
        if ($slot) {
            $response['message'] = " Slot already reserved ";
            $response['success'] = false;
            $response['status_code'] = 404;
            return response()->json($response);
        } else {

            $slot = new TempSlot;
            $slot->tutor_id = $request->tr;
            $slot->user_id = \Auth::user()->id;
            $slot->date = $request->date;
            $slot->slot = $request->slot;
            $slot->save();

            $response['message'] = " Slot reserved temporarily ";
            $response['success'] = true;
            $response['status_code'] = 200;
            return response()->json($response);
        }
    }

    private function rescheduleMeet($booking, $date, $time)
    {
        // Check if a rescheduled meeting already exists for this booking
        $existing_reschedule = Reschedule_meeting::where('booking_id', $booking->id)->first();

        if ($existing_reschedule) {
            // If a rescheduled meeting exists, delete it
            $existing_reschedule->delete();
        }

        // Create a new rescheduled meeting
        $booking_reschedule = new Reschedule_meeting();
        $booking_reschedule->tutor_id = $booking->tutor_id;
        $booking_reschedule->booking_id = $booking->id;
        $booking_reschedule->subject_id = $booking->subject_id;
        $booking_reschedule->booking_date = $date;
        $booking_reschedule->booking_time = $time;
        $booking_reschedule->save();

        return true;
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

    public function apperove_rescheduled_meeting(Request $request)
    {
        $imagePath = public_path('assets/images/247 NEW Logo 1.png');
        $booking_reschedule = Booking::where('id', request('id'))->first();

        if (request('status') == 'Accept') {
            $booking = Reschedule_meeting::where('booking_id', request('id'))
                ->first();
            if (empty($booking)) {
                return redirect('bookings')->with('error', 'Reschedule meeting not Create');
            }

            $ActivityLogs = new ActivityLog;
            $ActivityLogs->user_id = Auth::id();
            $ActivityLogs->title = "Apperoved Rescheduled Meeting" . Auth::user()->username . " Booking";
            $ActivityLogs->description = "Booking (" . request('id') . ") Apperoved Rescheduled Meeting Submited" . Auth::user()->first_name . " " . Auth::user()->last_name;
            $ActivityLogs->save();

            $findbooking = Booking::where('id', request('id'))->first();
            $student = User::find($findbooking->student_id);
            $tutor = User::find($findbooking->tutor_id);
            $data = [
                'tutorMessage' => 'Your Booking Reschedule Request Accepted',
                'studentMessage' => 'Your Booking Reschedule Request Accepted',
                'student' => $student->first_name . ' ' . $student->last_name,
                'tutor' => $tutor->first_name . ' ' . $tutor->last_name,
                'id' => $findbooking->id,
            ];
            if ($booking_reschedule) {
                if ($booking) {
                    $booking_reschedule->booking_date = $booking->booking_date;
                    $booking_reschedule->booking_time = $booking->booking_time;
                }
                $booking_reschedule->save();

                $environment = env('APP_ENV', 'local');
                $booking->delete();
                if ($environment == 'local') {
                    Mail::send('pages.mails.rescheduleAcceptReject', $data, function ($message) use ($student) {
                        $message->to($student->email, $student->first_name . ' ' . $student->last_name)
                            ->subject('Booking Reschedule Request');
                        $message->from(Auth::user()->email, Auth::user()->first_name . ' ' . Auth::user()->last_name);
                    });
                } elseif ($environment == 'production') {

                    $view = \view('pages.mails.rescheduleAccept', $data);
                    $view = $view->render();

                    $mail = new PHPMailer();
                    $mail->CharSet = "UTF-8";

                    $mail->setfrom('support@247tutors.com', '247 Tutors');

                    $mail->isHTML(true);
                    $mail->Subject = 'Accept Booking Reschedule Request';
                    $mail->Body = $view;
                    $mail->AddEmbeddedImage($imagePath, 'logo');
                    $mail->AltBody = '';
                    $mail->addaddress($student->email, $student->first_name . ' ' . $student->last_name);
                    $mail->isHTML(true);
                    $mail->msgHTML($view);

                    if (!$mail->send())
                        throw new \Exception('Failed to send mail');
                }
                return redirect('bookings')->with('success', 'Your Booking Rescheduled Successfully #' . $request->booking_id);
            } else {
                return redirect('bookings')->with('error', 'Booking not found');
            }
        } else {

            $booking = Reschedule_meeting::where('booking_id', $booking_reschedule->id)
                ->first();

            $findbooking = Booking::where('id', request('id'))->first();
            $student = User::find($findbooking->student_id);
            $tutor = User::find($findbooking->tutor_id);
            $data = [
                'tutorMessage' => 'Your Booking Reschedule Request Accepted',
                'studentMessage' => 'Your Booking Reschedule Request Accepted',
                'student' => $student->first_name . ' ' . $student->last_name,
                'tutor' => $tutor->first_name . ' ' . $tutor->last_name,
                'id' => $findbooking->id,
            ];

            $view = \view('pages.mails.rescheduleReject', $data);
            $view = $view->render();

            $mail = new PHPMailer();
            $mail->CharSet = "UTF-8";

            $mail->setfrom('support@247tutors.com', '247 Tutors');

            $mail->isHTML(true);
            $mail->Subject = 'Reject Booking Reschedule Request';
            $mail->Body = $view;
            $mail->AddEmbeddedImage($imagePath, 'logo');
            $mail->AltBody = '';
            $mail->addaddress($student->email, $student->first_name . ' ' . $student->last_name);
            $mail->isHTML(true);
            $mail->msgHTML($view);

            if (!$mail->send())
                throw new \Exception('Failed to send mail');

            $booking->delete();
            return redirect('bookings')->with('failed', 'Reschedule Request Rejected Successfully');
        }
    }
    public function endJitsiMeeting(Request $request)
    {
        // dd($request);
        $user = \Auth::user();
        $booking = Booking::where('uuid', $request->id)->first();
        if ($booking) {
            if ($user->role_id == 3) {
                if ($booking->tutor_id == $user->id) {
                    $booking->status = 'Completed';
                    $booking->tutor_feedback = $request->user_feedback;
                    $booking->tutor_rating = $request->rating;

                    $booking->save();

                    $response['message'] = " Booking finished ";
                    $response['success'] = true;
                    $response['status_code'] = 200;
                    return response()->json($response);
                } else {
                    $response['message'] = " Booking not found ";
                    $response['success'] = true;
                    $response['status_code'] = 404;
                    return response()->json($response);
                }
            } elseif ($user->role_id == 4) {
                if ($booking->student_id == $user->id) {
                    $booking->status = 'Completed';
                    $booking->student_feedback = $request->user_feedback;
                    $booking->student_rating = $request->rating;
                    $booking->save();

                    $response['message'] = " Booking finished ";

                    $response['success'] = true;
                    $response['status_code'] = 200;
                    return response()->json($response);
                } else {
                    $response['message'] = " Booking not found ";
                    $response['success'] = true;
                    $response['status_code'] = 404;
                    return response()->json($response);
                }
            } elseif ($user->role_id == 5) {
                if ($booking->parent_id == $user->id) {
                    $booking->status = 'Completed';
                    $booking->parent_feedback = $request->user_feedback;
                    $booking->parent_rating = $request->rating;
                    $booking->save();

                    $response['message'] = " Booking finished ";
                    $response['success'] = true;
                    $response['status_code'] = 200;
                    return response()->json($response);
                } else {
                    $response['message'] = " Booking not found ";
                    $response['success'] = true;
                    $response['status_code'] = 404;
                    return response()->json($response);
                }
            }
        } else {
            $response['message'] = " Booking not found ";
            $response['success'] = true;
            $response['status_code'] = 404;
            return response()->json($response);
        }
    }

    public function booking_details(Request $request)
    {

        $user = Auth::user();
        $booking = Booking::where('uuid', $request->id)->first();

        if ($booking) {

            if ($user->role_id == 3) {
                $feedback = $booking->student_feedback;
                $rating = $booking->student_rating;

                $response['message'] = " Booking found ";
                $response['success'] = true;
                $response['status_code'] = 200;
                $response['role'] = 'Student Feedback';
                $response['feedback'] = $feedback;
                $response['rating'] = $rating;

                return response()->json($response);
            } elseif ($user->role_id == 4) {
                $feedback = $booking->tutor_feedback;
                $rating = $booking->tutor_rating;

                $response['message'] = " Booking found ";
                $response['success'] = true;
                $response['status_code'] = 200;
                $response['role'] = 'Tutor Feedback';

                $response['feedback'] = $feedback;
                $response['rating'] = $rating;

                return response()->json($response);
            } elseif ($user->role_id == 5) {
                $feedback = $booking->tutor_feedback;
                $rating = $booking->tutor_rating;

                $response['message'] = " Booking found ";
                $response['success'] = true;
                $response['status_code'] = 200;
                $response['role'] = 'Tutor Feedback';

                $response['feedback'] = $feedback;
                $response['rating'] = $rating;
            }
        } else {
            $response['message'] = " Booking not found ";
            $response['success'] = true;
            $response['status_code'] = 404;
            return response()->json($response);
        }
    }

    public function BookingBeforThreeMinutesCron()
    {
        $Bookings = Booking::with('student', 'tutor', 'parent')->where('send_email', 0)->where('status', 'Scheduled')->get();

        foreach ($Bookings as $Booking) {
            if ($Booking->booking_date && $Booking->booking_time) {
                $data = [
                    'tutorMessage' => 'Dear ' . optional($Booking->tutor)->username . ' Join Interview Meeting With Admin',
                    'student' => optional($Booking->student)->first_name . ' ' . optional($Booking->student)->last_name,
                    'tutor' => optional($Booking->tutor)->first_name . ' ' . optional($Booking->tutor)->last_name,
                    'id' => $Booking->uuid,
                ];

                $timecheck = $Booking->booking_date . ' ' . $Booking->booking_time;
                $dbtimestamp = strtotime($timecheck);
                if (time() - $dbtimestamp > 5 * 60) {
                    $Booking->send_email = 1;
                    $Booking->save();

                    $recipientEmail = optional($Booking->student)->email;
                    $tutorEmail = optional($Booking->tutor)->email;
                    $environment = env('APP_ENV', 'local');
                    if ($environment == 'local') {
                        Mail::send('pages.mails.interview', $data, function ($message) use ($recipientEmail, $Booking) {
                            $message->to($recipientEmail, optional($Booking->student)->first_name . ' ' . optional($Booking->student)->last_name)
                                ->subject('Dear Student ' . optional($Booking->tutor)->username . ', Schedule an Meeting With You');
                            $message->from('support@247tutors.com', 'admin');
                        });
                    } elseif ($environment == 'production') {
                        // student
                        $view = \view('pages.mails.interview', $data);
                        $view = $view->render();

                        $mail = new PHPMailer();
                        $mail->CharSet = "UTF-8";

                        $mail->setfrom('support@247tutors.com', '247 Tutors');

                        $mail->isHTML(true);
                        $mail->Subject = 'Dear Student ' . optional($Booking->tutor)->username . ', Schedule an Meeting With You';
                        $mail->Body = $view;
                        $mail->AltBody = '';
                        $mail->addaddress($recipientEmail, optional($Booking->student)->first_name . ' ' . optional($Booking->student)->last_name);
                        $mail->isHTML(true);
                        $mail->msgHTML($view);

                        if (!$mail->send())
                            throw new \Exception('Failed to send mail');

                        // tutor
                        $view = \view('pages.mails.interview', $data);
                        $view = $view->render();

                        $mail = new PHPMailer();
                        $mail->CharSet = "UTF-8";

                        $mail->setfrom('support@247tutors.com', '247 Tutors');

                        $mail->isHTML(true);
                        $mail->Subject = 'Dear Student ' . optional($Booking->tutor)->username . ', Schedule an Meeting With You';
                        $mail->Body = $view;
                        $mail->AltBody = '';
                        $mail->addaddress($tutorEmail, optional($Booking->tutor)->first_name . ' ' . optional($Booking->tutor)->last_name);
                        $mail->isHTML(true);
                        $mail->msgHTML($view);

                        if (!$mail->send())
                            throw new \Exception('Failed to send mail');
                    }
                }
            }
        }
    }


    public function stripe_post_wallet(Request $request)
    {

        Stripe\Stripe::setApiKey('sk_test_51O4cl2Iml1HP3wz7vRShJNXP1OiyfMRMpsYvibX5FgvU9i1PVzhjNzyMKbzDXEbxYH6aEx9PbK76LjbJYvTP1Gii00RqJPF2Qu');
        $this->validate($request, [
            'user_id' => 'sometimes|numeric',
            'amount' => 'required|numeric|min:0',
        ]);
        $userId = $request->input('user_id', Auth::id());

        $user = Auth::user();
        $data = [
            'tutor' => $user->first_name . ' ' . $user->last_name,
        ];

        $imagePath = public_path('assets/images/247 NEW Logo 1.png');
        $view = \view('pages.mails.AddWalletAmount', $data);
        $view = $view->render();
        $mail = new PHPMailer();
        $mail->CharSet = "UTF-8";
        $mail->setfrom('support@247tutors.com', '247 Tutors');
        $mail->isHTML(true);
        $mail->Subject = 'Amount Added to Your Wallet on 247Tutors Platform';
        $mail->Body = $view;
        $mail->AddEmbeddedImage($imagePath, 'logo');
        $mail->AltBody = '';
        $mail->addaddress($user->email, $user->first_name . ' ' . $user->last_name);
        $mail->isHTML(true);
        $mail->msgHTML($view);

        if (!$mail->send())
            throw new \Exception('Failed to send mail');


        if ($request->amount > 0) {

            $wallet = Wallet::where('user_id', $userId)->first();

            if ($wallet) {
                // Wallet found, update balance
                $wallet->net_income += $request->amount;
            } else {
                // Wallet not found, create a new instance
                $wallet = new Wallet();
                $wallet->user_id = Auth::id();
                $wallet->net_income = $request->amount;
            }

            $wallet->save();



            $customer = Stripe\Customer::create([
                "address" => [
                    "line1" => $request->address1,
                    "postal_code" => $request->postcode,
                    "city" => $request->city,
                    "country" => $request->country,
                ],
                "email" => Auth::user()->email,
                "name" => $request->account_holder_name,
                "source" => $request->stripeToken,
            ]);

            $ch = Stripe\Charge::create([
                "amount" => $request->amount * 100,
                "currency" => "usd",
                "customer" => $customer->id,
                "description" => "",
            ]);
        }
        return back()->with('success', 'Add Amount In Wallet Successfully');
    }



    public function getrefund(Request $request)
    {
        $html = "";
        $complaint = Refound::where('bookingId', $request->id)->first();
        $Booking = Booking::where('uuid', $request->id)->first();

        $html .= '<tr>
                    <td class="pe-5">Refund No :</td>
                    <td>' . $complaint->id . '</td>
                </tr>';

        $html .= '<tr class="pb-3 m-4">
                    <td class="pe-5">Student Name :</td>
                    <td>' . optional(User::find($Booking->student_id))->username . '</td>
                </tr>';

        if (!empty(User::find(optional(Booking::where('uuid', $complaint->bookingId)->first())->tutor_id))) {

            $html .= '<tr class="pb-3 m-4">
                    <td class="pe-5">Tutor Name :</td>
                    <td>' . User::find(Booking::where('uuid', $complaint->bookingId)->first()->tutor_id)->username . '</td>
                </tr>';
        }
        $html .= '<tr class="pb-3 m-4">
                    <td class="pe-5">Booking Id :</td>
                   <td>' .  ($complaint->bookingId ?  $complaint->bookingId : 'N/A') . '</td>
                </tr>';

        $html .= '<tr class="pb-3 m-4">
                    <td class="pe-5">Status :</td>
                    <td>' . $complaint->status . '</td>
                </tr>';

        $html .= '<tr class="pb-3 m-4">
                    <td class="pe-5">Details :</td>
                   <td>' . $complaint->reason . '</td>
                </tr>';
        if (!empty($complaint->image) && file_exists(public_path($complaint->image))) {
            $html .= '<tr class="pb-3 m-4">
                                <td class="pe-5">Image :</td>
                                <td>
                                <a download="' . asset($complaint->image) . '" href="' . asset('images/' . $complaint->image) . '" target="_blank">
                                  <img src="' . asset($complaint->image) . '" width="100" height="50">
                                </a>
                                </td>
                            </tr>';
        }

        return $html;
    }



    public function refundUpdate(Request $request)
    {
        if (Auth::user()->role_id != 1) { return redirect('dashboard'); }
        $Refound = Refound::where('bookingId', $request->Tutorid)->first();

        $Booking = Booking::where('uuid', $request->Tutorid)->first();
        $PendingPayment=PendingPayment::where('tutor_id',$Booking->tutor_id)->where('booking_id',$Booking->id)->first();

     if($PendingPayment->amount > 0){

        $student = User::find($Booking->student_id);

        if($Booking->parent_id == null){
            $StudentWallet=Wallet::where('user_id',$Booking->student_id)->first();
        }else{
            $StudentWallet=Wallet::where('user_id',$Booking->parent_id)->first();
        }

        if (!$Refound) {
            return back()->with('error', 'Refund not found.');
        }



        if($Booking->parent_id == null){
            $student = User::find($Booking->student_id);
        }else{
            $student = User::find($Booking->parent_id);
        }
        $tutor = User::find($Booking->tutor_id);


        if (!$student) {
            return back()->with('error', 'Student not found.');
        }

        if (!$tutor) {
            return back()->with('error', 'Student not found.');
        }

        $data = [
            'tutorMessage' => 'Your Refund Has Successfully Has ' . $request->status,
            'student' => $student->first_name . ' ' . $student->last_name,
            'tutor' => $tutor->first_name . ' ' . $tutor->last_name,
        ];
        $imagePath = public_path('assets/images/247 NEW Logo 1.png');
        if($request->status == 'Paid'){
            if(!empty($StudentWallet)){
                if (!empty($PendingPayment) && isset($PendingPayment->amount)) {
                    $StudentWallet->net_income += $PendingPayment->amount;
                    $PendingPayment->amount = 0;
                    $StudentWallet->save();
                    $PendingPayment->save();
                    $Booking->request_refound= "2";
                    $Booking->save();



                    // student
                    $view = view('pages.mails.RefundPaidStudent', $data)->render();
                    $mail = new PHPMailer(true);
                    $mail->CharSet = 'UTF-8';
                    $mail->setFrom('support@247tutors.com', '247 Tutors');
                    $mail->isHTML(true);
                    $mail->Subject = "Refund Request Paid";
                    $mail->Body = $view;
                    $mail->AddEmbeddedImage($imagePath, 'logo');
                    $mail->AltBody = '';
                    $mail->addAddress($student->email, $student->first_name . ' ' . $student->last_name);
                    $mail->isHTML(true);
                    $mail->msgHTML($view);
                    $mail->send();

                    // tutor

                    $view = view('pages.mails.RefundPaidTutor', $data)->render();
                    $mail = new PHPMailer(true);
                    $mail->CharSet = 'UTF-8';
                    $mail->setFrom('support@247tutors.com', '247 Tutors');
                    $mail->isHTML(true);
                    $mail->Subject = "Refund Request Paid";
                    $mail->Body = $view;
                    $mail->AddEmbeddedImage($imagePath, 'logo');
                    $mail->AltBody = '';
                    $mail->addAddress($tutor->email, $tutor->first_name . ' ' . $tutor->last_name);
                    $mail->isHTML(true);
                    $mail->msgHTML($view);
                    $mail->send();

                    // update
                    $Refound->status = $request->status;
                    $Refound->save();
                    return back()->with('success', 'Refund updated and email sent successfully.');

                }

            }
            // end paid
        }elseif($request->status == 'Processing'){

                    // student
                    $view = view('pages.mails.RefundProcessingStudent', $data)->render();
                    $mail = new PHPMailer(true);
                    $mail->CharSet = 'UTF-8';
                    $mail->setFrom('support@247tutors.com', '247 Tutors');
                    $mail->isHTML(true);
                    $mail->Subject = "Refund Request Processing";
                    $mail->Body = $view;
                    $mail->AddEmbeddedImage($imagePath, 'logo');
                    $mail->AltBody = '';
                    $mail->addAddress($student->email, $student->first_name . ' ' . $student->last_name);
                    $mail->isHTML(true);
                    $mail->msgHTML($view);
                    $mail->send();

                    // tutor

                    $view = view('pages.mails.RefundProcessingTutor', $data)->render();
                    $mail = new PHPMailer(true);
                    $mail->CharSet = 'UTF-8';
                    $mail->setFrom('support@247tutors.com', '247 Tutors');
                    $mail->isHTML(true);
                    $mail->Subject = "Refund Request Processing";
                    $mail->Body = $view;
                    $mail->AddEmbeddedImage($imagePath, 'logo');
                    $mail->AltBody = '';
                    $mail->addAddress($tutor->email, $tutor->first_name . ' ' . $tutor->last_name);
                    $mail->isHTML(true);
                    $mail->msgHTML($view);
                    $mail->send();

                    $Refound->status = $request->status;
                    $Refound->save();
                    return back()->with('success', 'Refund updated and email sent successfully.');

        }else{
                    $Refound->status = $request->status;
                    $Refound->save();
                    return back()->with('success', 'Refund updated and email sent successfully.');
        }

     }else
     {
         return back()->with('error', 'This Booking Already Paid to Tutor.');
     }



    }

    public function startRecording()
    {
        if (Auth::check()) {

            // Generate a unique ID for the recording session
            $sessionId = \Illuminate\Support\Str::uuid()->toString();

            // Dispatch the job to run the recording script in the background
            \App\Jobs\StartRecordingJob::dispatch($sessionId);

            // Return the response
            return response()->json(['status' => 'success', 'message' => 'Recording started in the background.', 'sessionId' => $sessionId]);


        }else{
            return response()->json(['status' => 'error', 'message' => 'Recording started in the background.']);
        }

    }

    public function stopRecording()
    {
        // Path to the virtual environment's activate_this.py script
        //$activateScript = 'venv\Scripts\activate.bat';

        // Execute the activation script and capture both standard output and standard error
        //$output = exec("\"$activateScript\" 2>&1", $output, $returnVar);


        $sessionId = $_GET['uuid'];
        //        public_path('recordings/'.$sessionId.'/stop_recording.txt');

        // Directory where the file will be created
        $directory = public_path('recordings/' . $sessionId);

        // Ensure the directory exists, create it if not
        if (!file_exists($directory)) {
            mkdir($directory, 0777, true); // Recursive directory creation
        }

        // Path to the text file
        $filePath = $directory . '/stop_recording.txt';

        // Content to be written to the file
        $content = "Stop recording.";

        // Create the text file and write content to it
        file_put_contents($filePath, $content);
        return response()->json(['message' => 'Recording stopped.']);
    }
}
