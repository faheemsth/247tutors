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

class OrgController extends Controller
{
    // public function index()
    // {
    //     if (Auth::user()->role_id == 1) {
    //         return redirect('dashboard');
    //     } elseif (Auth::user()->role_id == 2) {
    //         return redirect('admin_dashboard');
    //     } elseif (Auth::user()->role_id == 3) {
    //         return redirect('tutor/home');
    //     } elseif (Auth::user()->role_id == 4) {
    //         return redirect('/home');
    //     } elseif (Auth::user()->role_id == 5) {
    //         return redirect('parent/profile');
    //     } elseif (Auth::user()->role_id == 6) {
    //         $students = User::where('role_id', '4')->where('parent_id', Auth::id())->get();
    //         $tutors = Booking::where('parent_id',Auth::id())->with(['tutor','tutorSubjectOffer'])->get();
    //         return view('auth.verify_tutor');
    //         // return view('pages.dashboard.organizationdashboard', compact('students','tutors'));
    //     }

    // }

    public function organization_pending(){
        return view('auth.verify_org');
    }
}
