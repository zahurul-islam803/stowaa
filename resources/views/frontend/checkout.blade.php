@extends('frontend.master')
@section('content')
    <!-- breadcrumb_section - start=========== -->
    <div class="breadcrumb_section">
        <div class="container">
            <ul class="breadcrumb_nav ul_li">
                <li><a href="index.html">Home</a></li>
                <li>Check Out</li>
            </ul>
        </div>
    </div>
    <!-- breadcrumb_section - end============ -->

    <!-- checkout-section - start========== -->
    <section class="checkout-section section_space">
        <div class="container">
            <div class="row">
                <div class="col col-xs-12">
                    <div class="woocommerce bg-light p-3">
                        <form method="POST" class="checkout woocommerce-checkout" action="{{ url('/order/insert') }}">
                            @csrf
                            <div class="col2-set" id="customer_details">
                                <div class="coll-1">
                                    <div class="woocommerce-billing-fields">
                                        <h3>Billing Details</h3>
                                        <p class="form-row form-row form-row-first validate-required"
                                            id="billing_first_name_field">
                                            <label for="billing_first_name" class=""> Name <abbr class="required"
                                                    title="required">*</abbr></label>
                                            <input type="text" class="input-text " name="name" id="billing_first_name"
                                                placeholder="" autocomplete="given-name"
                                                value="{{ Auth::guard('customerlogin')->user()->name }}" />
                                        </p>
                                        <p class="form-row form-row form-row-last validate-required validate-email"
                                            id="billing_email_field">
                                            <label for="billing_email" class="">Email Address <abbr class="required"
                                                    title="required">*</abbr></label>
                                            <input type="email" class="input-text " name="email" id="billing_email"
                                                placeholder="" autocomplete="email"
                                                value="{{ Auth::guard('customerlogin')->user()->email }}" />
                                        </p>
                                        <div class="clear"></div>
                                        <p class="form-row form-row form-row-first" id="billing_company_field">
                                            <label for="billing_company" class="">Company Name</label>
                                            <input type="text" class="input-text " name="company" id="billing_company"
                                                placeholder="" autocomplete="organization" value="" />
                                        </p>

                                        <p class="form-row form-row form-row-last validate-required validate-phone"
                                            id="billing_phone_field">
                                            <label for="billing_phone" class="">Phone <abbr class="required"
                                                    title="required">*</abbr></label>
                                            <input type="tel" class="input-text " name="phone" id="billing_phone"
                                                placeholder="" autocomplete="tel" value="" />
                                        </p>
                                        <div class="clear"></div>
                                        <p class="form-row form-row form-row-first address-field update_totals_on_change validate-required"
                                            id="billing_country_field">
                                            <label for="billing_country" class="">Country <abbr class="required"
                                                    title="required">*</abbr></label>
                                            <select name="country_id" id="country">
                                                <option>Select a Country</option>
                                                @foreach ($countries as $country)
                                                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                                                @endforeach
                                            </select>
                                        </p>
                                        <p class="form-row form-row form-row-last address-field update_totals_on_change validate-required"
                                            id="billing_country_field">
                                            <label for="billing_country" class="">City <abbr class="required"
                                                    title="required">*</abbr></label>
                                            <select name="city_id" id="cities" class="city">
                                                <option>Select A City</option>
                                            </select>
                                        </p>
                                        <p class="form-row form-row form-row-wide address-field validate-required"
                                            id="billing_address_1_field">
                                            <label for="billing_address_1" class="">Address <abbr class="required"
                                                    title="required">*</abbr></label>
                                            <input type="text" class="input-text " name="address" id="billing_address_1"
                                                placeholder="Street address" autocomplete="address-line1" value="" />
                                        </p>
                                    </div>
                                    <p class="form-row form-row notes" id="order_comments_field">
                                        <label for="order_comments" class="">Order Notes</label>
                                        <textarea name="notes" class="input-text " id="order_comments"
                                            placeholder="Notes about your order, e.g. special notes for delivery." rows="2" cols="5"></textarea>
                                    </p>
                                </div>
                            </div>
                            <h3 id="order_review_heading">Your order</h3>
                            <div id="order_review" class="woocommerce-checkout-review-order">
                                <table class="shop_table woocommerce-checkout-review-order-table">

                                    @php
                                        $total = 0;
                                    @endphp
                                    @foreach ($carts as $cart)
                                        @php
                                            $total += $cart->rel_to_product->discount_price * $cart->quantity;
                                        @endphp
                                    @endforeach
                                    @php
                                        $discount = session('discount');
                                    @endphp
                                    <input type="hidden" name="discount" data-index="0" value="{{ $discount }}"
                                        class="discount" />
                                    <tr class="cart-subtotal">
                                        <th>Subtotal</th>
                                        <td>
                                            <span class="woocommerce-Price-amount amount"><span
                                                    class="woocommerce-Price-currencySymbol">TK </span>
                                                {{ $total - $discount }}</span>
                                        </td>
                                    </tr>
                                    <tr class="shipping">
                                        <th>Delivery Charge</th>
                                        <td data-title="Shipping">
                                            <span id="charge" class="woocommerce-Price-currencySymbol">TK
                                            </span></span>
                                            <input type="hidden" name="sub_total" data-index="0" id="shipping_method_0"
                                                value="{{ $total }}" class="shipping_method" />
                                        </td>
                                    </tr>
                                    <tr class="order-total">
                                        <th>Total</th>
                                        <input type="hidden" id="total" value="{{ $total - $discount }}">
                                        <td><strong><span id="grand_total" class="woocommerce-Price-amount amount">TK
                                                    {{ $total - $discount }}</span></strong>
                                        </td>
                                    </tr>
                                </table>
                                <div class="calculate_shipping">
                                    <h3 class="wrap_title">Calculate Shipping <span class="icon"><i
                                                class="far fa-arrow-up"></i></span>
                                    </h3>
                                    <div class="select_option clearfix">
                                        <select class="charge" name="delivery_charge">
                                            <option>Select Your Option</option>
                                            <option value="60">Inside City</option>
                                            <option value="100">Outside City</option>
                                        </select>
                                    </div>
                                </div>
                                <div id="payment" class="woocommerce-checkout-payment py-3 mt-5">
                                    <ul class="wc_payment_methods payment_methods methods">
                                        <li class="wc_payment_method payment_method_cheque mb-2">
                                            <input id="payment_method_cheque" type="radio" class="input-radio"
                                                name="payment_method" value="1" checked='checked'
                                                data-order_button_text="" />
                                            <!--grop add span for radio button style-->
                                            <span class='grop-woo-radio-style'></span>
                                            <!--custom change-->
                                            <label for="payment_method_cheque">Cash On Delivery</label>
                                        </li>
                                        <li class="wc_payment_method payment_method_paypal mb-2">
                                            <input id="payment_method_ssl" type="radio" class="input-radio"
                                                name="payment_method" value="2"
                                                data-order_button_text="Proceed to SSL Commerz" />
                                            <!--grop add span for radio button style-->
                                            <span class='grop-woo-radio-style'></span>
                                            <!--custom change-->
                                            <label for="payment_method_ssl">SSL Commerz</label>
                                        </li>
                                        <li class="wc_payment_method payment_method_paypal">
                                            <input id="payment_method_stripe" type="radio" class="input-radio"
                                                name="payment_method" value="3"
                                                data-order_button_text="Proceed to SSL Commerz" />
                                            <!--grop add span for radio button style-->
                                            <span class='grop-woo-radio-style'></span>
                                            <!--custom change-->
                                            <label for="payment_method_stripe">Stripe Payment</label>
                                        </li>
                                    </ul>
                                    <div class="form-row place-order">
                                        <noscript>
                                            Since your browser does not support JavaScript, or it is disabled, please
                                            ensure
                                            you click the <em>Update Totals</em> button before placing your order. You
                                            may
                                            be charged more than the amount stated above if you fail to do so.
                                            <br />
                                            <input type="submit" class="button alt"
                                                name="woocommerce_checkout_update_totals" value="Update totals" />
                                        </noscript>
                                        <input type="submit" class="button alt" name="woocommerce_checkout_place_order"
                                            id="place_order" value="Place order" data-value="Place order" />
                                        <input type="hidden" id="_wpnonce5" name="_wpnonce" value="783c1934b0" />
                                        <input type="hidden" name="_wp_http_referer" value="/wp/?page_id=6" />
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- checkout-section - end=========== -->
@endsection

@section('footer_script')
    <script>
        $('#country').select2();
        $('#country').change(function() {
            var country_id = $(this).val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: 'POST',
                url: '/getCity',
                data: {
                    'country_id': country_id
                },
                success: function(data) {
                    $('#cities').select2();
                    $('.city').html(data);

                }
            });


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
