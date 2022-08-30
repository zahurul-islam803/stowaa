@extends('layouts.starlight')
@section('title')
    Profile Edit
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h3>Change Password</h3>
                </div>
                @if (session('pass_update'))
                    <div class="alert alert-success">{{ session('pass_update') }}</div>
                @endif
                @if (session('old_pass'))
                    <div class="alert alert-warning">{{ session('old_pass') }}</div>
                @endif
                <div class="card-body">
                    <form action="{{ url('/password/update') }}" method="POST">
                        @csrf
                        <div class="mt-3">
                            <label for="" class="form-label">Password</label>
                            <input type="password" class="form-control" name="old_password">
                        </div>
                        <div class="mt-3">
                            <label for="" class="form-label">New Password</label>
                            <input type="password" class="form-control" name="password">
                            @error('password')
                                <div class="alert alert-warning">{{ $message }}</div>
                            @enderror
                            <span>Password must be 8 character,1 upper case,1 lower case,special
                                character</span>
                        </div>
                        <div class="mt-3">
                            <label for="" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" name="password_confirmation">
                        </div>
                        <div class="mt-3 text-center">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h3>Change Name</h3>
                </div>
                <div class="card-body">
                    <form action="{{ url('/profile/update') }}" method="POST">
                        @csrf
                        <div class="mt-3">
                            <label for="" class="form-label">Name</label>
                            <input type="text" class="form-control" name="name" value="{{ Auth::user()->name }}">
                        </div>
                        <div class="mt-3 text-center">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h3>Change photo</h3>
                </div>
                @if (session('photo'))
                    <div class="alert alert-success">{{ session('photo') }}</div>
                @endif
                <div class="card-body">
                    <form action="{{ url('/photo/change') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mt-3">
                            <label for="" class="form-label">Profile Photo</label>
                            <input type="file" class="form-control" name="photo">
                            @error('photo')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                        <div class="mt-3 text-center">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
