<?php

namespace App\Http\Controllers;

use App\Models\CustomerEmailVerify;
use App\Models\CustomerLogin;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Intervention\Image\Facades\Image;

class ProfileController extends Controller
{

    function profile()
    {
        return view('admin.profile.edit');
    }
    function update(Request $request)
    {
        User::find(Auth::id())->update([
            'name' => $request->name,
        ]);
        return back();
    }
    function password_update(Request $request)
    {
        $request->validate([
            'password' => 'required',
            'password' => 'confirmed',
            'password' => Password::min(8)
                ->letters()
                ->mixedCase()
                ->numbers()
                ->symbols(),
        ]);

        if (Hash::check($request->old_password, Auth::user()->password)) {
            User::find(Auth::id())->update([
                'password' => bcrypt($request->password),
            ]);
            return back()->with('pass_update', 'Password Updated!');
        } else {
            return back()->with('old_pass', 'Old Password Incorrect!');
        }
    }
    function photo_change(Request $request)
    {
        $request->validate([
            'photo' => 'image',
            'photo' => 'file|max:1024',
        ]);
        $new_profile_photo = $request->photo;
        $extension = $new_profile_photo->getClientOriginalExtension();
        $new_name = Auth::id() . '.' . $extension;
        if (Auth::user()->photo != 'default.png') {
            $path = public_path() . '/uploads/users/' . Auth::user()->photo;
            unlink($path);
        }
        Image::make($new_profile_photo)->resize(800, 800)->save(base_path('public/uploads/users/' . $new_name));
        User::find(Auth::id())->update([
            'photo' => $new_name,
        ]);
        return back()->with('photo', 'Profile Photo Updated!');
    }

    function email_verity($verify_token)
    {
        $verify_email = CustomerEmailVerify::where('verify_token', $verify_token)->firstOrFail();
        $customer_id = CustomerLogin::findOrFail($verify_email->customer_id);

        $customer_id->update([
            'email_verified_at' => Carbon::now(),
        ]);
        CustomerEmailVerify::where('id', $verify_email->id)->delete();
        return redirect('/verify/email/success')->with('verify', 'Your Account Has Been Verified!');
    }
    function email_verity_success()
    {
        return view('frontend.verify');
    }
}
