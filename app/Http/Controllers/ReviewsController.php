<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Auth;
class ReviewsController extends Controller
{

    public function ReviewStudent()
    {
        if (Auth::user()->role_id != 1) { return redirect('dashboard'); }
        $reviewStudents = Booking::with('student')->whereNotNull('student_rating')->get();
        return view('super-admin.Pages.reviews.student',compact('reviewStudents'));

    }

    public function ReviewTutor()
    {
        if (Auth::user()->role_id != 1) { return redirect('dashboard'); }
        $ReviewTutor = Booking::with('tutor')->whereNotNull('tutor_rating')->get();
        return view('super-admin.Pages.reviews.tutor',compact('ReviewTutor'));
    }

    public function ReviewParent()
    {
        if (Auth::user()->role_id != 1) { return redirect('dashboard'); }
        $reviewParents = Booking::with('parent')->whereNotNull('parent_rating')->get();
        return view('super-admin.Pages.reviews.parent',compact('reviewParents'));
    }
}
