<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function profile_setting()
    {
        if(Auth::user()->role_id != 5){
                return  redirect('/dashboard');
        }
        
        return view('pages.dashboard.profiledetailparent');
    }
    public function upload_profile_img(Request $request){
        $image = $request->file('image');
        $imageName = time() . '_' . $image->getClientOriginalName();

        // Move the uploaded image to the 'public/images' directory
        $image->move(public_path('images'), $imageName);

        // Create or retrieve the current user
        $user = User::find(Auth::id());


        $user->update([
            'image' => 'images/' . $imageName, // Store the image path
    ]);


    if (Auth::user()->role_id == 5) {
        return redirect('parent/profile')->with('success','Successfully You Can Update Profile');
    } elseif (Auth::user()->role_id == 6) {
        return redirect('organization/home')->with('success','Successfully You Can Update Profile');
    }
    }

    public function profile_setting_post(Request $request)
    {

        // Create or retrieve the current user
        $user = User::find(Auth::id());

        // Update user attributes
        $user->update([
            'first_name' => ucfirst(strtolower($request->input('first_name'))),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'phone' => $request->input('phone'),
            'gender' => $request->input('gender'),
            'dob' => $request->input('dob'),
            'facebook_link' => $request->input('facebook_link'),
            // 'linkedin_link' => $request->input('linkedin_link'),
            // 'twitter_link' => $request->input('twitter_link'),
            'profile_description' => $request->input('profile_description'),
            'address' => $request->input('address'),
            'zipcode' => $request->zipcode,
            
        ]);
        if (Auth::user()->role_id == 5) {
            return redirect('parent/profile')->with('success','Successfully You Can Update Profile');
        } elseif (Auth::user()->role_id == 6) {
            return redirect('organization/home')->with('success','Successfully You Can Update Profile');
        }
    }
}
