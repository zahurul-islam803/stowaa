<?php

namespace App\Http\Controllers;

use App\Models\CustomerLogin;
use App\Models\PassReset;
use App\Notifications\PassResetNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class PassResetController extends Controller
{
    function pass_reset()
    {
        return view('pass_reset');
    }

    function pass_reset_notification(Request $request)
    {
        $customer = CustomerLogin::where('email', $request->email)->firstOrFail();
        $delete_reset_info = PassReset::where('customer_id', $customer->id)->delete();
        $pass_reset = PassReset::create([
            'customer_id' => $customer->id,
            'reset_token' => uniqid(),
            'created_at' => Carbon::now(),
        ]);

        Notification::send($customer, new PassResetNotification($pass_reset));
        return back();
    }

    function pass_reset_form($reset_token)
    {
        return view('pass_reset_form', compact('reset_token'));
    }

    function pass_reset_update(Request $request)
    {
        $pass_reset = PassReset::where('reset_token', $request->reset_token)->firstOrFail();
        $customer = CustomerLogin::findOrFail($pass_reset->customer_id);

        $customer->update([
            'password' => bcrypt($request->password),
        ]);

        PassReset::where('reset_token', $request->reset_token)->delete();
        $customer_info = CustomerLogin::find($customer);

        if (Auth::guard('customerlogin')->attempt(['email' => $customer_info->first()->email, 'password' => $request->password])) {
            return redirect('/');
        }
    }
}
