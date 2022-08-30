<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>A simple, clean, and responsive HTML invoice template</title>

    <style>
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            font-size: 16px;
            line-height: 24px;
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color: #555;
        }

        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
        }

        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }

        .invoice-box table tr td:nth-child(2) {
            text-align: right;
        }

        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.top table td.title {
            font-size: 45px;
            line-height: 45px;
            color: #333;
        }

        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }

        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }

        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
        }

        .invoice-box table tr.item.last td {
            border-bottom: none;
        }

        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }

        @media only screen and (max-width: 600px) {
            .invoice-box table tr.top table td {
                width: 100%;
                display: block;
                text-align: center;
            }

            .invoice-box table tr.information table td {
                width: 100%;
                display: block;
                text-align: center;
            }
        }

        /** RTL **/
        .invoice-box.rtl {
            direction: rtl;
            font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        }

        .invoice-box.rtl table {
            text-align: right;
        }

        .invoice-box.rtl table tr td:nth-child(2) {
            text-align: left;
        }
    </style>
</head>

<body>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="4">
                    <table>
                        <tr>
                            <td class="title">
                                <img src="https://i.postimg.cc/cCh8Q7KG/logo-1x.png"
                                    style="width: 100%; max-width: 300px" />
                            </td>
                            <td>
                                Invoice #: {{ $billing_details->first()->order_id }}<br />
                                Created:{{ $billing->created_at->format('d-M-Y') }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="information">
                <td colspan="4">
                    <table>
                        <tr>
                            <td>
                                {{ $billing->address }}
                            </td>
                            <td>
                                {{ $billing->company }}<br />
                                {{ $billing->name }}<br />
                                {{ $billing->email }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="heading">
                <td>Payment Method</td>

                <td colspan="4">
                    @php
                        if ($orders->payment_method == 1) {
                            echo 'COD';
                        } elseif ($orders->payment_method == 2) {
                            echo 'SSLCommerz';
                        } else {
                            echo 'Stripe';
                        }
                    @endphp
                </td>
            </tr>
            <tr>
                <td height="20"></td>
            </tr>
            <tr class="heading">
                <td>Product</td>
                <td>Price</td>
                <td>Quantity</td>
                <td>Subtotal</td>
            </tr>
            @php
                $total = 0;
            @endphp
            @foreach ($products as $product)
                <tr class="item">
                    <td>{{ $product->rel_to_product->product_name }}</td>
                    <td>{{ $product->product_price }}</td>
                    <td>{{ $product->quantity }}</td>
                    <td>{{ $product->quantity * $product->product_price }}</td>
                </tr>
                @php
                    $total += $product->quantity * $product->product_price;
                @endphp
            @endforeach
            <tr>
                <td></td>
                <td height="20"></td>
            </tr>
            <tr class="total">
                <td></td>
                <td colspan="3">Discount:{{ $orders->discount }}</td>
            </tr>
            <tr class="total">
                <td></td>
                <td colspan="3">Delivery Charge:{{ $orders->delivery_charge }}</td>
            </tr>
            <tr class="total">
                <td></td>
                <td colspan="3">Total: {{ $total - $orders->discount + $orders->delivery_charge }}</td>
            </tr>
        </table>
    </div>
</body>

</html>
