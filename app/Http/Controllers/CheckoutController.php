<?php

namespace App\Http\Controllers;

use App\Mail\InvoiceMail;
use App\Models\BillingDetails;
use App\Models\Cart;
use App\Models\City;
use App\Models\Country;
use App\Models\Inventory;
use App\Models\Order;
use App\Models\OrderProduct;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class CheckoutController extends Controller
{
    function checkout()
    {
        $carts = Cart::where('user_id', Auth::guard('customerlogin')->id())->get();
        $countries = Country::all();
        return view('frontend.checkout', [
            'countries' => $countries,
            'carts' => $carts,
        ]);
    }

    function getCity(Request $request)
    {
        $cities = City::where('country_id', $request->country_id)->get();
        $str_to_send = '<option>Select A City</option>';
        foreach ($cities as $city) {
            $str_to_send .= '<option value="' . $city->id . '">' . $city->name . '</option>';
        }
        echo $str_to_send;
    }

    function order_insert(Request $request)
    {
        if ($request->payment_method == 1) {
            $order_id = Order::insertGetId([
                'user_id' => Auth::guard('customerlogin')->id(),
                'sub_total' => $request->sub_total,
                'delivery_charge' => $request->delivery_charge,
                'total' => $request->sub_total + $request->delivery_charge,
                'payment_method' => $request->payment_method,
                'created_at' => Carbon::now(),
            ]);

            BillingDetails::insert([
                'order_id' => $order_id,
                'user_id' => Auth::guard('customerlogin')->id(),
                'name' => $request->name,
                'email' => $request->email,
                'company' => $request->company,
                'phone' => $request->phone,
                'country_id' => $request->country_id,
                'city_id' => $request->city_id,
                'address' => $request->address,
                'notes' => $request->notes,
                'created_at' => Carbon::now(),
            ]);

            $carts = Cart::where('user_id', Auth::guard('customerlogin')->id())->get();
            foreach ($carts as $cart) {
                OrderProduct::insert([
                    'user_id' => Auth::guard('customerlogin')->id(),
                    'order_id' => $order_id,
                    'product_id' => $cart->product_id,
                    'product_price' => $cart->rel_to_product->discount_price,
                    'color_id' => $cart->color_id,
                    'size_id' => $cart->size_id,
                    'quantity' => $cart->quantity,
                    'created_at' => Carbon::now(),
                ]);
            }

            $total_amount = $request->sub_total + $request->delivery_charge;
            Mail::to($request->email)->send(new InvoiceMail($order_id));

            //SMS SEND
            $url = "http://66.45.237.70/api.php";
            $number = $request->phone;
            $text = "Thank you for purchasing our products, your total amount is: " . $total_amount;
            $data = array(
                'username' => "zahurul",
                'password' => "5NEBVRGA",
                'number' => "$number",
                'message' => "$text"
            );

            $ch = curl_init(); // Initialize cURL
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $smsresult = curl_exec($ch);
            $p = explode("|", $smsresult);
            $sendstatus = $p[0];
            foreach ($carts as $cart) {
                Inventory::where('product_id', $cart->product_id)->where('color_id', $cart->color_id)->where('size_id', $cart->size_id)->decrement('quantity', $cart->quantity);

                Cart::find($cart->id)->delete();
            }
            return redirect()->route('order.success')->with('success', 'Your Order Has Been Placed!');
        } else if ($request->payment_method == 2) {
            $data = $request->all();
            return view('sslpayment', [
                'data' => $data,
            ]);
        } else {
            $data = $request->all();
            return view('stripe', compact('data'));
        }
        return back();
    }


    function order_success()
    {
        return view('frontend.order_success');
    }
}
