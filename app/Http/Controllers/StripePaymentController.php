<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Stripe;
use Illuminate\Support\Facades\Mail;
use App\Models\Inventory;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Mail\InvoiceMail;
use App\Models\BillingDetails;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use App\Models\Cart;

class StripePaymentController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripe()
    {
        return view('stripe');
    }

    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripePost(Request $request)
    {
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        Stripe\Charge::create([
            "amount" => $request->total * 100,
            "currency" => "bdt",
            "source" => $request->stripeToken,
            "description" => "Test payment from itsolutionstuff.com."
        ]);

        Session::flash('success', 'Payment successful!');

        $order_info = session('data');
        $order_id = Order::insertGetId([
            'user_id' => Auth::guard('customerlogin')->id(),
            'sub_total' => $order_info['sub_total'],
            'discount' => $order_info['discount'],
            'delivery_charge' => $order_info['delivery_charge'],
            'total' => $order_info['sub_total'] + $order_info['delivery_charge'],
            'payment_method' => $order_info['payment_method'],
            'created_at' => Carbon::now(),
        ]);
        BillingDetails::insert([
            'order_id' => $order_id,
            'user_id' => Auth::guard('customerlogin')->id(),
            'name' => $order_info['name'],
            'email' => $order_info['email'],
            'company' => $order_info['company'],
            'phone' => $order_info['phone'],
            'country_id' => $order_info['country_id'],
            'city_id' => $order_info['city_id'],
            'address' => $order_info['address'],
            'notes' => $order_info['notes'],
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

        Mail::to($order_info['email'])->send(new InvoiceMail($order_id));

        foreach ($carts as $cart) {
            Inventory::where('product_id', $cart->product_id)->where('color_id', $cart->color_id)->where('size_id', $cart->size_id)->decrement('quantity', $cart->quantity);
            Cart::find($cart->id)->delete();
        }

        return redirect()->route('order.success')->with('success', 'Your Order Has Been Placed!');
    }
}
