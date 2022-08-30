@extends('layouts.starlight')
@section('title')
    Edit Role
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header text-center">
                        <h3>Edit Permission</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('role.update') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <input type="hidden" name="user_id" value="{{ $role_info->id }}" class="form-control">
                                <input type="text" readonly value="{{ $role_info->name }}" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="" class="form-label">Assign Permission</label>
                                @foreach ($permissions as $permission)
                                    <br>
                                    <input type="checkbox"
                                        {{ $role_info->hasPermissionTo($permission->name) ? 'checked' : '' }}
                                        value="{{ $permission->name }}" name="permission[]">{{ $permission->name }}
                                @endforeach
                            </div>
                            <div class="form-group mt-2 text-center">
                                <button type="submit" class="btn btn-success">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
