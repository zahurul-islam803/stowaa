@extends('frontend.master')
@section('bredcrumb')
    <!-- breadcrumb_section - start============== -->
    <div class="breadcrumb_section">
        <div class="container">
            <ul class="breadcrumb_nav ul_li">
                <li><a href="index.html">Home</a></li>
                <li>Cart</li>
            </ul>
        </div>
    </div>
    <!-- breadcrumb_section - end========== -->
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-8 m-auto">
                <div class="my-5">
                    @if (session('success'))
                        <div class="alert alert-success">
                            <h3>{{ session('success') }}</h3>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endsection
