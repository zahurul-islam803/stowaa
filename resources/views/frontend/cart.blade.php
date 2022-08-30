@extends('frontend.master')
@section('bredcrumb')
    <!-- breadcrumb_section - start============== -->
    <div class="breadcrumb_section">
        <div class="container">
            <ul class="breadcrumb_nav ul_li">
                <li><a href="index.html">Home</a></li>
                <li>Cart</li>
            </ul>
        </div>
    </div>
    <!-- breadcrumb_section - end========== -->
@endsection

@section('content')
    <!-- cart_section - start============= -->
    <section class="cart_section section_space">
        <div class="container">
            <form action="{{ url('/cart/update') }}" method="POST">
                @csrf
                <div class="cart_table">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th class="text-center">Price</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-center">Total</th>
                                <th class="text-center">Remove</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $total = 0;
                            @endphp
                            @foreach ($carts as $cart)
                                <tr>
                                    <td>
                                        <div class="cart_product">
                                            <img src="{{ asset('uploads/products/preview') }}/{{ $cart->rel_to_product->product_image }}"
                                                alt="image_not_found">
                                            <h3><a
                                                    href="{{ route('product.details', $cart->rel_to_product->id) }}">{{ $cart->rel_to_product->product_name }}</a>
                                            </h3>
                                        </div>
                                    </td>
                                    <td class="text-center"><span class="price_text">TK
                                            {{ $cart->rel_to_product->discount_price }}</span></td>
                                    <td class="text-center">

                                        <div class="cart-plus-minus">
                                            {{-- <button type="button" class="input_number_decrement">
                                                <i class="fal fa-minus"></i>
                                            </button> --}}
                                            <input class="cart-plus-minus-box" name="qtybutton[{{ $cart->id }}]"
                                                type="text" value="{{ $cart->quantity }}" />
                                            {{-- <button type="button" class="input_number_increment">
                                                <i class="fal fa-plus"></i>
                                            </button> --}}
                                        </div>

                                    </td>
                                    <td class="text-center"><span class="price_text">TK
                                            {{ $cart->rel_to_product->discount_price * $cart->quantity }}</span></td>
                                    <td class="text-center"><a href="{{ route('cart.delete', $cart->id) }}"
                                            class="remove_btn"><i class="fal fa-trash-alt"></i></a></td>
                                </tr>
                                @php
                                    $total += $cart->rel_to_product->discount_price * $cart->quantity;
                                @endphp
                            @endforeach

                        </tbody>
                    </table>
                </div>

                <div class="cart_btns_wrap">
                    <div class="row">
                        <div class="col col-lg-6">
                            <ul class="btns_group ul_li_right">
                                <li><button type="submit" class="btn border_black">Update Cart</button></li>
                                <li><a class="btn btn_dark" href="{{ route('checkout') }}">Proceed To Checkout</a></li>
                            </ul>
                        </div>
            </form>
            <div class="col col-lg-6">
                @if ($message)
                    <div class="alert alert-warning">{{ $message }}</div>
                @endif

                <form action="{{ url('/cart') }}" method="GET">
                    <div class="coupon_form form_item mb-0">
                        <input type="text" id="coupon_code" name="coupon_code" value="{{ @$_GET['coupon_code'] }}"
                            placeholder="Coupon Code...">
                        <button type="submit" id="coupon_btn" class="btn btn_dark">Apply Coupon</button>
                        <div class="info_icon">
                            <i class="fas fa-info-circle" data-bs-toggle="tooltip" data-bs-placement="top"
                                title="Your Info Here"></i>
                        </div>
                    </div>
                </form>
            </div>


        </div>
        </div>

        <div class="row">
            <div class="col col-lg-6">
                <div class="calculate_shipping">
                    <h3 class="wrap_title">Calculate Shipping <span class="icon"><i class="far fa-arrow-up"></i></span>
                    </h3>

                    <div class="select_option clearfix">
                        <select class="charge">
                            <option value="">Select Your Option</option>
                            <option value="60">Inside City</option>
                            <option value="100">Outside City</option>
                        </select>
                    </div>
                    <br>
                    <button type="submit" class="btn btn_primary rounded-pill">Update Total</button>

                </div>
            </div>

            <div class="col col-lg-6">
                <div class="cart_total_table">
                    <h3 class="wrap_title">Cart Totals</h3>
                    <ul class="ul_li_block">

                        @php
                            $total_discount = ($total * $discount) / 100;
                        @endphp
                        <li>
                            <span>Cart Subtotal</span>
                            <span>TK {{ $total }}</span>
                        </li>
                        <li>
                            <span>Discount Amount</span>
                            <span>TK {{ ($total * $discount) / 100 }}</span>
                        </li>
                        <li>
                            <span>Grand Total</span>
                            <span class="total_price">TK {{ $total - $total_discount }} </span>
                        </li>
                        @php
                            session([
                                'discount' => ($total * $discount) / 100,
                            ]);
                        @endphp
                    </ul>
                </div>
            </div>
        </div>
        </div>

    </section>
    <!-- cart_section - end========== -->
@endsection

@section('footer_script')
    <script>
        $('#coupon_btn').click(function() {
            var coupon_code = $('#coupon_code').val();
            var current_link = '{{ url('/cart') }}';
            var link_to_go = current_link + '/' + coupon_code;
            window.location.href = link_to_go;
        })
    </script>
    <script>
        $('.charge').change(function() {
            var charge = $(this).val();
            $('#charge').html(charge);
            var total = $('#total').val();
            var grand_total = parseInt(total) + parseInt(charge);
            $('#grand_total').html(grand_total);
        })
    </script>
@endsection
