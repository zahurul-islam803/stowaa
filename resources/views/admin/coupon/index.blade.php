@extends('layouts.starlight')
@section('coupon')
    active
@endsection
@section('title')
    Add Coupon
@endsection
@section('content')
    <section>
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header text-center">
                            <h3 class="text-center">Coupons List</h3>
                        </div>
                        @if (session('delete'))
                            <div class="alert alert-success">{{ session('delete') }}</div>
                        @endif
                        <div class="card-body">
                            <table class="table table-borderd">
                                <tr>
                                    <th>SL</th>
                                    <th>Coupon Name</th>
                                    <th>Validity</th>
                                    <th>Discount %</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                                @foreach ($coupons as $coupon)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $coupon->coupon_name }}</td>
                                        <td>{{ $coupon->validity }}</td>
                                        <td>{{ $coupon->discount }}</td>
                                        <td>{{ $coupon->created_at->diffForHumans() }}</td>
                                        <td>
                                            <a href="" class="btn btn-success">Edit</a>
                                            <a href="" class="btn btn-danger">Delete</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header text-center">
                            <h3>Add Coupon</h3>
                        </div>
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        <div class="card-body">
                            <form action="{{ url('/coupon/insert') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="" class="form-label">Coupon Name</label>
                                    <input type="text" class="form-control" name="coupon_name">
                                </div>
                                <div class="form-group">
                                    <label for="" class="form-label">Coupon Validity</label>
                                    <input type="date" class="form-control" name="validity">
                                </div>
                                <div class="form-group">
                                    <label for="" class="form-label">Coupon Discount %</label>
                                    <input type="number" class="form-control" name="discount">
                                </div>
                                <div class="form-group mt-3 text-center">
                                    <button type="submit" class="btn btn-primary">Add
                                        Coupon</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
