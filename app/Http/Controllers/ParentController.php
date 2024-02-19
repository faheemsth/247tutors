<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Transaction;
use App\Models\TutorSubjectOffer;
use App\Models\User;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;

class ParentController extends Controller
{

    public function index()
    {
        if (Auth::user()->role_id == 1) {
            return redirect('dashboard');
        } elseif (Auth::user()->role_id == 2) {
            return redirect('admin_dashboard');
        } elseif (Auth::user()->role_id == 3) {
            return redirect('tutor/home');
        } elseif (Auth::user()->role_id == 4) {
            return redirect('student/profile');
        } elseif (Auth::user()->role_id == 5) {
            $students = User::where('role_id', '4')->where('parent_id', Auth::id())->get();
            $tutors = Booking::where('parent_id',Auth::id())->with(['tutor','tutorSubjectOffer'])->get();

            return view('pages.dashboard.parentdashboard', compact('students','tutors'));
        } elseif (Auth::user()->role_id == 6) {
            return redirect('organization/home');
        }

    }
    public function parent_profile()
    {
        return view('pages.dashboard.profileparent');
    }


    public function show_student($id)
    {
        $student_profile = User::where('id', $id)->first();
        return view('pages.dashboard.profilestudents', compact('student_profile'));
    }

    public function your_students()
    {
        $students = User::where('parent_id',Auth::id())->get();
        return view('pages.dashboard.addstudents',compact('students'));
    }

    public function book_lessons()
    {
        $tutors=Transaction::where('user_id',Auth::id())->with(['tutor'])->get();
        $students=User::where('parent_id',Auth::id())->get();
        return view('pages.dashboard.booklessons',compact('tutors','students'));
    }
    public function get_subject(Request $request)
    {
        $offers = TutorSubjectOffer::where('tutor_id', $request->get('tutor_id'))->with(['level', 'tutor', 'subject'])->get();
        $html = '';
        $input = '';
        $fee = '';
        if (!$offers->isEmpty()) {
            $fee= $offers['0']->fee;
            foreach ($offers as $value) {
                $html .= '<option value="' . $value->subject->id . '" data-fee="'.$value->fee.'">' . $value->subject->name . ' - ' . $value->level->level . '-  $' . $value->fee . '/hr</option>';
            }
            $input .= '<input type="hidden" name="amount" id="amount" value="' . $offers['0']->fee . '" placeholder="CB1 0GN" class="w-100 p-3">';
        }
        $transaction = Transaction::where('tutor_id', $request->get('tutor_id'))->first();
        if ($transaction) {
            $input .= '
            <input type="hidden" name="country" value="' . $transaction->country . '" placeholder="CB1 0GN" class="w-100 p-3">
            <input type="hidden" name="address1" value="' . $transaction->address1 . '" class="w-100 p-3">
            <input type="hidden" name="address2" value="' . $transaction->address2 . '" class="w-100 p-3">
            <input type="hidden" name="city" value="' . $transaction->city . '" placeholder="Cambridge" class="w-100 p-3">
            <input type="hidden" name="postcode" value="' . $transaction->postcode . '" placeholder="CB1 0GN" class="w-100 p-3">
            ';
        }
        $data = ['html' => $html, 'input' => $input, 'fee' => $fee];
        return $data;
    }


    public function parent_payments(Request $request){

        $bookings = Booking::with(['student', 'tutor', 'subjects'])
            ->where('parent_id',Auth::id())
            ->get();

        return view('pages.parent.payments',get_defined_vars());
    }


}
