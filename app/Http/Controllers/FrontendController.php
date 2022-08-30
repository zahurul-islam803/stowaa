<?php

namespace App\Http\Controllers;

use App\Models\BillingDetails;
use App\Models\category;
use App\Models\CustomerLogin;
use App\Models\Inventory;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\product;
use App\Models\Size;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF;
use Share;

class FrontendController extends Controller
{
    function welcome()
    {
        return view('welcome');
    }


    function index()
    {
        $all_categories = category::all();
        $all_products = product::all();
        $new_products = product::latest()->take(4)->get();

        $shareComponent = Share::currentPage()
            ->facebook()
            ->twitter()
            ->linkedin()
            ->telegram()
            ->whatsapp()
            ->reddit();

        return view('frontend.index', [
            'all_categories' => $all_categories,
            'all_products' => $all_products,
            'new_products' => $new_products,
            'shareComponent' => $shareComponent,
        ]);
    }

    function product_details($product_slug)
    {
        $product_info = product::where('slug', $product_slug)->first();
        $related_product = product::where('category_id', $product_info->category_id)->where('slug', '!=', $product_slug)->get();
        $all_colors = Inventory::where('product_id', $product_info->id)->groupBy('color_id')->selectRaw('count(*) as total, color_id')->get();

        $review = OrderProduct::where('product_id', $product_info->id)->whereNotNull('review')->get();
        $rating_sum =  OrderProduct::where('product_id', $product_info->id)->whereNotNull('review')->sum('star');
        if ($review->count() > 0) {
            $rating_value = $rating_sum / $review->count();
        } else {
            $rating_value = 0;
        }
        return view('frontend.product_details', [
            'product_info' => $product_info,
            'all_colors' => $all_colors,
            'related_product' => $related_product,
            'review' => $review,
            'rating_value' => $rating_value,
        ]);
    }
    function getsize(Request $request)
    {
        $sizes = Inventory::where('product_id', $request->product_id)->where('color_id', $request->color_id)->select('size_id')->get();
        $str_to_send = '<option>--Choose A Option--</option>';

        foreach ($sizes as $size) {
            $size_name = Size::find($size->size_id)->size_name;
            $str_to_send .= '<option class="size_id" value="' . $size->size_id . '" >' . $size_name . '</option>';
        }
        echo $str_to_send;
    }


    function profile()
    {
        $orders = Order::where('user_id', Auth::guard('customerlogin')->id())->get();
        return view('frontend.profile', [
            'orders' => $orders,
        ]);
    }

    function account_update(Request $request)
    {
        CustomerLogin::find(Auth::guard('customerlogin')->id())->update([
            'name' => $request->name,
            'password' => bcrypt($request->password),
        ]);
        return back();
    }

    function order()
    {
        $orders = Order::all();
        return view('admin.order.order', [
            'orders' => $orders,
        ]);
    }

    function invoice_download($invoice_id)
    {
        $billing_details = BillingDetails::where('order_id', $invoice_id)->get();
        $billing = BillingDetails::find($invoice_id);
        $orders = Order::find($invoice_id);
        $products = OrderProduct::where('order_id', $invoice_id)->get();
        $users = User::get();
        $data = [
            'billing_details' => $billing_details,
            'billing' => $billing,
            'orders' => $orders,
            'products' => $products,
        ];

        $pdf = PDF::loadView('frontend.invoice.invoice', [
            'billing_details' => $billing_details,
            'billing' => $billing,
            'orders' => $orders,
            'products' => $products,
        ]);

        return $pdf->download('stowaa.pdf');
    }

    function review_insert(Request $request)
    {
        OrderProduct::where('user_id', Auth::guard('customerlogin')->id())->where('product_id', $request->product_id)->update([
            'review' => $request->review,
            'star' => $request->star,
        ]);
        return back();
    }
}
