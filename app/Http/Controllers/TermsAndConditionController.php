<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TermsAndCondition;
use Auth;

class TermsAndConditionController extends Controller
{
    public function index(){
        if (Auth::user()->role_id != 1) { return redirect('dashboard'); }
      $TermsAndCondition=TermsAndCondition::where('status','terms_condition')->get();
      return view('pages.dashboard.terms.index',compact('TermsAndCondition'));
    }

    public function submit(Request $request){
        if (Auth::user()->role_id != 1) { return redirect('dashboard'); }
        if (empty($request->id)) {
            $termsAndCondition = new TermsAndCondition;
        } else {
            $termsAndCondition = TermsAndCondition::find($request->id);
        }
    
        $termsAndCondition->type = $request->type;
        $termsAndCondition->content = $request->content;
        $termsAndCondition->status = 'terms_condition';
        $termsAndCondition->save();
    
        return redirect('admin/terms_condition');
    }


    public function form(){
        if (Auth::user()->role_id != 1) { return redirect('dashboard'); }
        return view('pages.dashboard.terms.form');
    }
    
    public function delete($id){
        if (Auth::user()->role_id != 1) { return redirect('dashboard'); }
        TermsAndCondition::find($id)->delete();
        return back();
    }
    
    public function updateform($id){
        if (Auth::user()->role_id != 1) { return redirect('dashboard'); }
        $TermsAndCondition=TermsAndCondition::find($id);
        return view('pages.dashboard.terms.formupdate',compact('TermsAndCondition'));
    }
    
    public function index_privacy_policy(){
        if (Auth::user()->role_id != 1) { return redirect('dashboard'); }
      $TermsAndCondition=TermsAndCondition::where('status','privacy_policy')->get();
      return view('pages.dashboard.privacy.index',compact('TermsAndCondition'));
    }

    public function submit_privacy_policy(Request $request){
        if (Auth::user()->role_id != 1) { return redirect('dashboard'); }
        if (empty($request->id)) {
            $termsAndCondition = new TermsAndCondition;
        } else {
            $termsAndCondition = TermsAndCondition::find($request->id);
        }
    
        $termsAndCondition->type = $request->type;
        $termsAndCondition->content = $request->content;
        $termsAndCondition->status = 'privacy_policy';
        $termsAndCondition->save();
    
        return redirect('admin/privacy_policy');
    }


    public function form_privacy_policy(){
        if (Auth::user()->role_id != 1) { return redirect('dashboard'); }
        return view('pages.dashboard.privacy.form');
    }
    
    public function delete_privacy_policy($id){
        if (Auth::user()->role_id != 1) { return redirect('dashboard'); }
        TermsAndCondition::find($id)->delete();
        return back();
    }
    
    public function updateform_privacy_policy($id){
        if (Auth::user()->role_id != 1) { return redirect('dashboard'); }
        $TermsAndCondition=TermsAndCondition::find($id);
        return view('pages.dashboard.privacy.formupdate',compact('TermsAndCondition'));
    }
    
    


}
