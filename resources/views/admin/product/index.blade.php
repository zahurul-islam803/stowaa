@extends('layouts.starlight')
@section('product')
    active
@endsection
@section('title')
    Add Product
@endsection
@section('content')
    {{-- @can('show_product') --}}
    <div class="row">
        <div class="col-lg-7">
            <div class="card">
                <div class="card-header text-center">
                    <h3>Product List</h3>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <tr>
                            <th>SL</th>
                            <th>Product Name</th>
                            <th>Product Price</th>
                            <th>Discount %</th>
                            <th>Discount Price</th>
                            <th>Description</th>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>
                        @foreach ($products as $key => $product)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $product->product_name }}</td>
                                <td>{{ $product->product_price }}</td>
                                <td>{{ $product->discount }}</td>
                                <td>{{ $product->discount_price }}</td>
                                <td>{{ substr($product->description, 0, 25) . '...more' }}</td>
                                <td>
                                    <img width="50"
                                        src="{{ asset('uploads/products/preview') }}/{{ $product->product_image }}"
                                        alt="">
                                </td>
                                <td>
                                    <a href="{{ route('inventory', $product->id) }}" class="btn btn-info">Inventory</a>
                                    <a href="" class="btn btn-danger">Delete</a>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card">
                <div class="card-header text-center">
                    <h3>Add Product</h3>
                </div>
                @if (session('add_product'))
                    <div class="alert alert-success">{{ session('add_product') }}</div>
                @endif
                <div class="card-body">
                    <form action="{{ url('/product/insert') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mt-3">
                            <select name="category_id" class="form-control select_category">
                                <option value="">-- Select Category --</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mt-3">
                            <select name="subcategory_id" class="form-control" id="subcategory">
                                <option value="">-- Select Sub Category --</option>
                            </select>
                        </div>
                        <div class="mt-3">
                            <label for="" class="form-label">Product Name</label>
                            <input type="text" class="form-control" name="product_name">
                        </div>
                        <div class="mt-3">
                            <label for="" class="form-label">Product Price</label>
                            <input type="text" class="form-control" name="product_price">
                        </div>
                        <div class="mt-3">
                            <label for="" class="form-label">Discount %</label>
                            <input type="text" class="form-control" name="discount">
                        </div>
                        <div class="mt-3">
                            <label for="" class="form-label">Description</label>
                            <textarea name="description" id="summernote" class="form-control"></textarea>
                        </div>
                        <div class="mt-3">
                            <label for="" class="form-label">Product Image</label>
                            <input type="file" class="form-control" name="product_image">
                        </div>
                        <div class="mt-3">
                            <label for="" class="form-label">Product Thumbnails</label>
                            <input multiple type="file" class="form-control" name="product_thumb[]">
                        </div>
                        <div class="mt-3 text-center">
                            <button class="btn btn-primary">Add Product</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- @else
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="alert alert-warning">
                        <h5>Sorry as a gorib, We can not allow to show this page. U can apply for borolok here <a href=""
                                class="btn btn-primary">Apply Borolok</a></h5>
                    </div>
                </div>
            </div>
        </div> --}}
    {{-- @endcan --}}
@endsection
@section('footer_script')
    <script>
        $('.select_category').change(function() {
            var category_id = $(this).val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: 'POST',
                url: '/getsubcategory',
                data: {
                    category_id: category_id
                },
                success: function(data) {
                    $('#subcategory').html(data);
                }
            });
        });

        // In your Javascript (external .js resource or <script> tag)
        $(document).ready(function() {
            $('.select_category').select2();
        });

        $(document).ready(function() {
            $('#summernote').summernote();
        });
    </script>
@endsection
