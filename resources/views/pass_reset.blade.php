@extends('frontend.master')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-6 m-auto">
                <div class="card my-5">
                    <div class="card-header text-center">
                        <h3>Send Password Reset Link</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ url('/pass/reset/notification') }}" method="POST">
                            @csrf
                            <div class="mt-3">
                                <label for="" class="form-label">Email Address</label>
                                <input type="email" name="email" class="form-controll">
                            </div>
                            <div class="mt-3 text-center">
                                <button type="submit" class="btn btn-primary">Send Link</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
