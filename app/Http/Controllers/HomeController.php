<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user_id = Auth::id();
        $all_users = User::where('id', '!=', $user_id)->orderBy('id', 'desc')->paginate(3);
        $total_user = User::count();
        $logged_user = Auth::User()->name;
        return view('home', compact('all_users', 'total_user', 'logged_user'));
    }
}
