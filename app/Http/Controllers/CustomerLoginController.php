<?php

namespace App\Http\Controllers;

use App\Models\CustomerLogin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerLoginController extends Controller
{
    function customer_register_login()
    {
        return view('frontend.customer_register');
    }

    function customer_login(Request $request)
    {
        if (CustomerLogin::where('email', $request->email)->where('email_verified_at', '!=', NULL)->exists()) {
            if (Auth::guard('customerlogin')->attempt(['email' => $request->email, 'password' => $request->password])) {
                return redirect('/');
            } else {
                return redirect('/customer/login/register');
            }
        } else {
            return redirect('/customer/login/register')->with('message', 'You need to verify your email!');
        }
    }

    function customer_logout(Request $request)
    {
        Auth::guard('customerlogin')->logout();
        return redirect('/');
    }
}
