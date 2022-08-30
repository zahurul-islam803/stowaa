@extends('layouts.starlight')
@section('category')
    active
@endsection
@section('title')
    Edit Category
@endsection
@section('content')
    <section>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 m-auto">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="text-center">Edit Category</h3>
                        </div>
                        @if (session('edit'))
                            <div class="alert alert-success">{{ session('edit') }}</div>
                        @endif
                        <div class="card-body">
                            <form action="{{ url('/category/update') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="" class="form-label">Category Name</label>
                                    <input type="hidden" name="id" value="{{ $edit_category->id }}">
                                    <input type="text" class="form-control" name="category_name"
                                        value="{{ $edit_category->category_name }}">
                                </div>
                                @error('category_name')
                                    <strong class="text-danger pt-2"> {{ $message }}</strong>
                                @enderror
                                <div class="form-group mt-3 text-center">
                                    <button type="submit" class="btn btn-primary">Update
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
