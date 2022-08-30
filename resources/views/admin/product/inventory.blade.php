@extends('layouts.starlight')
@section('title')
    Inventory
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-8"></div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header text-center">
                    <h3>Add Inventory</h3>
                </div>
                @if (session('inventory'))
                    <div class="alert alert-success">{{ session('inventory') }}</div>
                @endif
                <div class="card-body">
                    <form action="{{ url('/inventory/insert') }}" method="POST">
                        @csrf
                        <div class="mt-2">
                            <label for="" class="form-label">Product Name</label>
                            <input type="text" readonly name="product_name" value="{{ $product_info->product_name }} "
                                class="form-control">
                            <input type="hidden" name="product_id" value="{{ $product_info->id }}" class="form-control">
                        </div>
                        <div class="mt-3">
                            <select name="color_id" class="form-control">
                                <option value="">-- Select Color --</option>
                                @foreach ($colors as $color)
                                    <option value="{{ $color->id }}">{{ $color->color_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mt-3">
                            <select name="size_id" class="form-control">
                                <option value="">-- Select Size --</option>
                                @foreach ($sizes as $size)
                                    <option value="{{ $size->id }}">{{ $size->size_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mt-3">
                            <label for="" class="form-label">Product Quantity</label>
                            <input type="number" class="form-control" name="quantity">
                        </div>
                        <div class="mt-3 text-center">
                            <button class="btn btn-primary">Add Inventory</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
