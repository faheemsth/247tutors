<?php

namespace App\Http\Controllers;

use App\Models\Level;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LevelController extends Controller
{
    public function index()
    {
        $users = Level::get();

        return view('pages.dashboard.levels.level', ['users' => $users]);
    }

    public function create()
    {
        return view('pages.dashboard.levels.createlevel');
    }
    public function store(Request $request)
    {
        $level= new Level;
        $level->level=$request->level;
        $level->created_by=Auth::id();
        $level->save();
        return back();
    }
    public function level_delete($id)
    {
        $level=Level::find($id);
        $level->delete();
        return back();
    }
    public function level_update($id)
    {
        $level=Level::find($id);
        return view('pages.dashboard.levels.updatelevel',compact('level'));
    }
    public function level_update_post(Request $request,$id)
    {
        $level=Level::find($id);
        $level->level=$request->level;
        $level->created_by=Auth::id();
        $level->save();
        return back();
    }




}
