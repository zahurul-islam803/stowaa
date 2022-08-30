<?php

namespace App\Http\Controllers;

use App\Models\WishList;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishListController extends Controller
{
    function wishlist_show($product_id)
    {

        $wish = WishList::where('product_id', $product_id)->where('user_id', Auth::guard('customerlogin')->id())->first();
        if (isset($wish)) {
            return back()->with('wishlist1', 'WishList Allready Exists!');
        } else {
            WishList::insert([
                'user_id' => Auth::guard('customerlogin')->id(),
                'product_id' => $product_id,
                'created_at' => Carbon::now(),
            ]);
            return back()->with('wishlist', 'WishList Added Successfully!');
        }
    }

    function wishlist(Request $request)
    {
        $whistlist = WishList::where('user_id', Auth::guard('customerlogin')->id())->get();

        return view('frontend.wishlist', [
            'whistlist' => $whistlist,
        ]);
    }


    function wishlist_delete($wishlist_id)
    {
        WishList::find($wishlist_id)->delete();
        return back();
    }
}
