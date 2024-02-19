<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Level;
use App\Models\Subject;
use App\Models\TutorSubjectOffer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubjectOfferController extends Controller
{
    public function store(Request $request)
    {
       $subject= new TutorSubjectOffer();
       $subject->tutor_id=Auth::id();
       $subject->level_id= 1;
       $subject->levelstring= $request->level_id;
       $subject->subject_id= $request->subject_id;
       $subject->fee= $request->fee;
       $subject->save();

       $subjectID=Subject::find($request->subject_id);
       $ActivityLogs = new ActivityLog;
       $ActivityLogs->user_id = Auth::id();
       $ActivityLogs->title = "Tutor Add New Subject ".Auth::user()->username;
       $ActivityLogs->description = "Tutor Add New Subject ".Auth::user()->username." (".$subjectID->name.") " . Auth::user()->first_name . " " . Auth::user()->last_name;
       $ActivityLogs->save();

       return back();
    }

    public function delete($id)
    {
       $subject=TutorSubjectOffer::find($id);
       $subject->delete();

       $subjectID=Subject::find($subject->subject_id);
       $ActivityLogs = new ActivityLog;
       $ActivityLogs->user_id = Auth::id();
       $ActivityLogs->title = "Tutor Delete Subject ".Auth::user()->username;
       $ActivityLogs->description = "Tutor Delete Subject ".Auth::user()->username." (".$subjectID->name.") " . Auth::user()->first_name . " " . Auth::user()->last_name;
       $ActivityLogs->save();

       return back();

    }
    public function update(Request $request,$id)
    {
       $subject=TutorSubjectOffer::find($id);
       $subject->tutor_id=Auth::id();
       $subject->level_id= 1;
       $subject->levelstring= $request->level_id;
       $subject->subject_id= $request->subject_id;
       $subject->fee= $request->fee;
       $subject->save();

       $subjectID=Subject::find($request->subject_id);
       $ActivityLogs = new ActivityLog;
       $ActivityLogs->user_id = Auth::id();
       $ActivityLogs->title = "Tutor Update Subject ".Auth::user()->username;
       $ActivityLogs->description = "Tutor Update Subject ".Auth::user()->username." (".$subjectID->name.") " . Auth::user()->first_name . " " . Auth::user()->last_name;
       $ActivityLogs->save();

       return back();
    }



}
