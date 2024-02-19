<?php

namespace App\Http\Controllers;

use App\Models\disclaimer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DisclaimerController extends Controller
{
    public function disclaimer_request(Request $request){
        $disclaimer= new disclaimer();
        $disclaimer->disclaimer=!empty($request->disclaimer)?$request->disclaimer: 0;
        $disclaimer->user_id=Auth::id();
        $disclaimer->save();
        return back();
    }
}
