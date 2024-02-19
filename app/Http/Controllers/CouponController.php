<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\coupon as ModelsCoupon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use PHPMailer\PHPMailer\PHPMailer;
use Stripe\Coupon;

class CouponController extends Controller
{

    public function index()
    {
        if (Auth::user()->role_id != 1) { return redirect('dashboard'); }
        $coupons = ModelsCoupon::with('user')->get();

        $currentDate = now();
        foreach ($coupons as $coupon) {
            if ($coupon->valid_to < $currentDate) {
                $coupon->isExpired = true;
            } else {
                $coupon->isExpired = false;
            }
        }
        return view('super-admin.coupon.index', compact('coupons'));
    }
    public function create_coupon(Request $request)
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $couponCode = '';
        $length = 8;
        for ($i = 0; $i < $length; $i++) {
            $couponCode .= $characters[rand(0, strlen($characters) - 1)];
        }

        ModelsCoupon::create([
            'code' => $couponCode,
            'description' => $request->post('description'),
            'discount_type' => $request->post('discount_type'),
            'price' => $request->post('price'),
            'valid_from' => $request->post('valid_from'),
            'valid_to' => $request->post('valid_to'),
            'from_user' => Auth::id(),
            'to_user' => null,
            'usage_limit' => $request->post('usage_limit'),
        ]);
        $student = User::find($request->id);

        $ActivityLogs = new ActivityLog;
        $ActivityLogs->user_id = Auth::id();
        $ActivityLogs->title = "Create Coupon";
        $ActivityLogs->description = "Create Coupon By ".Auth::user()->first_name."  ".Auth::user()->last_name;
        $ActivityLogs->save();

        $data = [
            'student' => $student,
            'copoun' => $couponCode,
        ];
        if (!empty($student)) {
            Mail::send('pages.mails.copoun', $data, function ($message) use ($student, $couponCode) {
                $message->to($student->email, $student->first_name . ' ' . $student->last_name)
                    ->subject(Auth::user()->first_name . ' ' . Auth::user()->last_name . ' Assign Token ' . $couponCode);
                $message->from(Auth::user()->email, Auth::user()->first_name . ' ' . Auth::user()->last_name);
            });



            // $view = \view('pages.mails.copoun',$data);
            // $view = $view->render();
            // $mail = new PHPMailer();
            // $mail->CharSet = "UTF-8";
            // $mail->setfrom('support@247tutors.com' , '247 Tutors');
            // $mail->isHTML(true);
            // $mail->Subject = 'asdasd';
            // $mail->Body    = $view;
            // $mail->AltBody = '';
            // $mail->addaddress('muhammadkashif70000@gmail.com', 'Kashif');
            // // dd($mail);
            //   $mail->isHTML(true);
            //   $mail->msgHTML($view);
            // if(!$mail->send()) throw new \Exception('Failed to send mail');


        }

        return back()->with('success', 'Successfully created the coupon: ' . $couponCode);
    }


    public function get_coupon(Request $request)
    {
        $coupon = ModelsCoupon::where('code', $request->post('coupon'))
            ->first();
        if (!$coupon) {
            throw ValidationException::withMessages(['coupon' => 'Coupon not found.']);
        }

        if ($coupon->usage_limit <= 0) {
            throw ValidationException::withMessages(['coupon' => 'Coupon has reached its usage limit.']);
        }

        if ($coupon->valid_to < now()) {
            throw ValidationException::withMessages(['coupon' => 'Coupon has expired.']);
        }

        return $coupon;
    }

}
