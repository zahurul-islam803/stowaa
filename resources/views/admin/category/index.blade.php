@extends('layouts.starlight')
@section('category')
    active
@endsection
@section('title')
    Add Category
@endsection
@section('content')
    <section>
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header text-center">
                            <h3 class="text-center">Categories</h3>
                        </div>
                        @if (session('delete'))
                            <div class="alert alert-success">{{ session('delete') }}</div>
                        @endif
                        <div class="card-body">
                            <table class="table table-borderd">
                                <tr>
                                    <th>SL</th>
                                    <th>Category Name</th>
                                    <th>Added By</th>
                                    <th>Category Image</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                                @foreach ($categories as $category)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $category->category_name }}</td>
                                        @if (App\Models\User::where('id', $category->added_by)->exists())
                                            <td>{{ App\Models\User::where('id', $category->added_by)->first()->name }}</td>
                                        @endif
                                        <td>
                                            <img width="50"
                                                src="{{ asset('uploads/category/') }}/{{ $category->category_image }}"
                                                alt="">
                                        </td>
                                        <td>{{ $category->created_at->diffForHumans() }}</td>
                                        <td>
                                            <a href="{{ url('/category/edit') }}/{{ $category->id }}"
                                                class="btn btn-success">Edit</a>
                                            <a href="{{ url('/category/delete') }}/{{ $category->id }}"
                                                class="btn btn-danger">Delete</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h3>Add Category</h3>
                        </div>
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        <div class="card-body">
                            <form action="{{ url('/category/insert') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="" class="form-label">Category Name</label>
                                    <input type="text" class="form-control" name="category_name">
                                </div>
                                <div class="mt-3">
                                    <label for="" class="form-label">Category Image</label>
                                    <input type="file" class="form-control" name="category_image">
                                </div>
                                @error('category_name')
                                    <strong class="text-danger pt-2"> {{ $message }}</strong>
                                @enderror
                                <div class="form-group mt-3 text-center">
                                    <button type="submit" class="btn btn-primary">Add
                                        Category</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
