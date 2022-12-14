@extends('layouts.starlight')
@section('color.size')
    active
@endsection
@section('title')
    Add Color And Size
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header text-center">
                        <h3>Colors List</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <tr>
                                <th>SL</th>
                                <th>Color Name</th>
                                <th>Color</th>
                                <th>Created At</th>
                            </tr>
                            @foreach ($colors as $key => $color)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $color->color_name }}</td>
                                    <td>
                                        <i
                                            style="width: 30px;height:30px;background:{{ $color->color_code }};display:inline-block;border-radius:50%"></i>
                                    </td>
                                    <td>{{ $color->created_at->diffForHumans() }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
                <div class="card mt-5">
                    <div class="card-header text-center">
                        <h3>Size List</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <tr>
                                <th>SL</th>
                                <th>Size Name</th>
                                <th>Created At</th>
                            </tr>
                            @foreach ($sizes as $key => $size)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $size->size_name }}</td>
                                    <td>{{ $size->created_at->diffForHumans() }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header text-center">
                        <h3>Add Color</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ url('/color/insert') }}" method="POST">
                            @csrf
                            <div class="mt-3">
                                <label for="" class="form-label">Color Name</label>
                                <input type="text" name="color_name" class="form-control">
                            </div>
                            <div class="mt-3">
                                <label for="" class="form-label">Color Code</label>
                                <input type="text" name="color_code" class="form-control">
                            </div>
                            <div class="mt-3 text-center">
                                <button class="btn btn-primary">Add Color</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card mt-5">
                    <div class="card-header text-center">
                        <h3>Add Size</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ url('/size/insert') }}" method="POST">
                            @csrf
                            <div class="mt-3">
                                <label for="" class="form-label">Size Name</label>
                                <input type="text" name="size_name" class="form-control">
                            </div>
                            <div class="mt-3 text-center">
                                <button class="btn btn-primary">Add Size</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
