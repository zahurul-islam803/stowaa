@extends('layouts.starlight')
@section('subcategory')
    active
@endsection
@section('title')
   Add Subcategory
@endsection
@section('content')
    <section>
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="text-center">SubCategories</h3>
                        </div>
                        @if (session('delete'))
                            <div class="alert alert-success">{{ session('delete') }}</div>
                        @endif
                        <div class="card-body">
                            <table class="table table-borderd">
                                <tr>
                                    <th>SL</th>
                                    <th>Category Name</th>
                                    <th>SubCategory Name</th>
                                    <th>Created_at</th>
                                    <th>Action</th>
                                </tr>
                                @foreach ($subcategories as $subcategory)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ App\Models\Category::find($subcategory->category_id)->category_name }}</td>
                                        <td>{{ $subcategory->subcategory_name }}</td>
                                        <td>{{ $subcategory->created_at->diffForHumans() }}</td>
                                        <td>
                                            <a href="{{ url('/subcategory/edit') }}/{{ $subcategory->id }}"
                                                class="btn btn-success">Edit</a>
                                            <a href="{{ url('/subcategory/delete/') }}/{{ $subcategory->id }}"
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
                            <h3>Add SubCategory</h3>
                        </div>
                        @if (session('subcategory'))
                            <div class="alert alert-success">{{ session('subcategory') }}</div>
                        @endif
                        @if (session('exists'))
                            <div class="alert alert-warning">{{ session('exists') }}</div>
                        @endif
                        <div class="card-body">
                            <form action="{{ url('/subcategory/insert') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <select name="category_id" class="form-control">
                                        <option value="">-- Select Category --</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->category_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <strong class="text-danger pt-2">{{ $message }}</strong>
                                    @enderror
                                </div>
                                <div class="form-group mt-3">
                                    <label for="" class="form-label">SubCategory Name</label>
                                    <input type="text" class="form-control" name="subcategory_name">
                                    @error('subcategory_name')
                                        <strong class="text-danger pt-2">{{ $message }}</strong>
                                    @enderror
                                </div>
                                <div class="form-group mt-3 text-center">
                                    <button type="submit" class="btn btn-primary">Add SubCategory</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
