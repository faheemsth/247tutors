<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Level;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SubjectController extends Controller
{
    function index(){
        if (Auth::user()->role_id != 1) { return redirect('dashboard'); }
        $subjects=Subject::with('level')->get();
        $levels=Level::all();
        return view('super-admin.subjects.index',compact('subjects','levels'));
    }
    public function store(Request $request)
    {
        if (Auth::user()->role_id != 1) { return redirect('dashboard'); }
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', 'unique:subjects'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $subject = new Subject();
        $subject->name = $request->name;
        $subject->save();

        $ActivityLogs = new ActivityLog;
        $ActivityLogs->user_id = Auth::id();
        $ActivityLogs->title = "Subject Created ";
        $ActivityLogs->description = $subject->name." Subject Created By  ".Auth::user()->first_name."  ".Auth::user()->last_name;
        $ActivityLogs->save();

        return redirect()->back()->with('success', 'Your Subject has been successfully created.');
    }


    public function delete($id)
    {
        if (Auth::user()->role_id != 1) { return redirect('dashboard'); }
       $subject = Subject::find($id);

       $ActivityLogs = new ActivityLog;
       $ActivityLogs->user_id = Auth::id();
       $ActivityLogs->title = "Deleted Subject ";
       $ActivityLogs->description = $subject->name." Deleted Subject By  ".Auth::user()->first_name."  ".Auth::user()->last_name;
       $ActivityLogs->save();

       $subject->bookings()->delete();
       if ($subject->delete()) {
          return back()->with('success', 'Your Subject has been successfully Deleted.');
       } else {
          return back()->with('failed', 'Failed to delete the subject.');
       }
    }
    public function update_post(Request $request,$id)
    {
        if (Auth::user()->role_id != 1) { return redirect('dashboard'); }
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:subjects,name,'.$id
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
       $subject=Subject::find($id);
       $subject->name=$request->name;
       $subject->save();


       $ActivityLogs = new ActivityLog;
       $ActivityLogs->user_id = Auth::id();
       $ActivityLogs->title = "Updated Subject ";
       $ActivityLogs->description = $subject->name." Updated Subject By  ".Auth::user()->first_name."  ".Auth::user()->last_name;
       $ActivityLogs->save();

       return back()->with('success', 'Your Subject has been successfully updated.');
    }



}
