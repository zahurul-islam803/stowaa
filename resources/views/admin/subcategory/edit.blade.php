@extends('layouts.starlight')
@section('subcategory')
    active
@endsection
@section('title')
    Edit SubCategory
@endsection
@section('content')
    <section>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 m-auto">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="text-center">Edit SubCategory</h3>
                        </div>
                        @if (session('edit'))
                            <div class="alert alert-success">{{ session('edit') }}</div>
                        @endif
                        @if (session('exist'))
                            <div class="alert alert-warning">{{ session('exist') }}</div>
                        @endif
                        <div class="card-body">
                            <form action="{{ url('/subcategory/update') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <select name="category_id" class="form-control">
                                        <option value="">-- Select Category --</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ $category->id == $subcategories->category_id ? 'selected' : '' }}>
                                                {{ $category->category_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <strong class="text-danger pt-2">{{ $message }}</strong>
                                    @enderror
                                </div>
                                <div class="form-group mt-3">
                                    <label for="" class="form-label">SubCategory Name</label>
                                    <input type="text" class="form-control" name="subcategory_name"
                                        value="{{ $subcategories->subcategory_name }}">
                                    @error('subcategory_name')
                                        <strong class="text-danger pt-2">{{ $message }}</strong>
                                    @enderror
                                </div>
                                <div class="form-group mt-3 text-center">
                                    <button type="submit" class="btn btn-primary">Update SubCategory</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
