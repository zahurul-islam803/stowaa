@extends('layouts.starlight')
@section('order')
    active
@endsection
@section('title')
    View Order
@endsection
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 m-auto">
                <div class="card">
                    <div class="card-header text-center">
                        <h3>Order List</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <tr class="text-center">
                                <th>SL</th>
                                <th>Name</th>
                                <th>Sub Total</th>
                                <th>Discount</th>
                                <th>Delivery Charge</th>
                                <th>Total</th>
                            </tr>
                            @foreach ($orders as $key => $order)
                                <tr class="text-center">
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ App\Models\CustomerLogin::where('id', $order->user_id)->first()->name }}</td>
                                    <td>{{ $order->sub_total }}</td>
                                    <td>{{ $order->discount }}</td>
                                    <td>{{ $order->delivery_charge }}</td>
                                    <td>{{ $order->total }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
