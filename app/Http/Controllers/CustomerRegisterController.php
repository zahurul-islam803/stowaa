<?php

namespace App\Http\Controllers;

use App\Models\CustomerEmailVerify;
use App\Models\CustomerLogin;
use App\Notifications\CustomerEmailVerifyNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Notification;
use Send;

class CustomerRegisterController extends Controller
{
    function customer_register(Request $request)
    {
        CustomerLogin::insert([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'created_at' => Carbon::now(),
        ]);

        $customer = CustomerLogin::where('email', $request->email)->firstOrFail();
        $remove_info = CustomerEmailVerify::where('customer_id', $customer->id)->delete();

        $email_verify = CustomerEmailVerify::create([
            'customer_id' => $customer->id,
            'verify_token' => uniqid(),
        ]);

        Notification::send($customer, new CustomerEmailVerifyNotification($email_verify));

        return back()->with('customer', 'Register Successfully, We have sent a verification email, please check your email and verify!');
    }
}
