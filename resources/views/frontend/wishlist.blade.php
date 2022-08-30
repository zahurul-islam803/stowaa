@extends('frontend.master')

<!-- breadcrumb_section - start=========== -->
<div class="breadcrumb_section">
    <div class="container">
        <ul class="breadcrumb_nav ul_li">
            <li><a href="index.html">Home</a></li>
            <li>Wishlist</li>
        </ul>
    </div>
</div>
<!-- breadcrumb_section - end======== -->
@section('content')
    <!-- cart_section - start======== -->
    <section class="cart_section section_space">
        <div class="container">
            <div class="cart_table">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>PRODUCT</th>
                            <th class="text-center">PRICE</th>
                            <th class="text-center">REMOVE</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($whistlist as $wish)
                            <tr>
                                <td>
                                    <div class="cart_product">
                                        <a href=""><img
                                                src="{{ asset('uploads/products/preview') }}/{{ $wish->rel_to_product->product_image }}"
                                                alt="image_not_found" /></a>
                                        <a href="">
                                            <h3>{{ $wish->rel_to_product->product_name }}</h3>
                                        </a>
                                    </div>
                                </td>
                                <td class="text-center"><span
                                        class="price_text">{{ $wish->rel_to_product->product_price }}</span></td>
                                <td class="text-center">
                                    <a href="{{ route('wishlist.delete', $wish->id) }}" class="remove_btn"><i
                                            class="fal fa-trash-alt"></i></a>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </section>
    <!-- cart_section - end====== -->
@endsection
