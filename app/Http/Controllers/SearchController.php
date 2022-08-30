<?php

namespace App\Http\Controllers;

use App\Models\product as ModelsProduct;
use Illuminate\Http\Request;
use App\Models\product;


class SearchController extends Controller
{
    function productlistAjax()
    {
        $products = Product::select('product_name')->where('status', '0')->get();
        $data = [];

        foreach ($products as $product) {
            $data[] = $product['product_name'];
        }
        return $data;
    }
    function searchProduct(Request $request)
    {
        $searched_product = $request->products_name;
        if ($searched_product != "") {
            $product = Product::where('product_name', 'LIKE', '% $searched_product%')->first();
            if ($product) {
                // return redirect('product/details/' . $product->product->slug . '/' . $product->slug);

            } else {
                return redirect()->back()->with('status', 'No product match you search');
            }
        } else {
            return redirect()->back();
        }
    }
}
