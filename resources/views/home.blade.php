@extends('layouts.starlight')
@section('home')
    active
@endsection
@section('title')
    Home
@endsection
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3>Welcome To, {{ $logged_user }} <span class="float-right">Total User:
                                {{ $total_user }}</span></h3>
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <table class="table table-striped">
                            <tr>
                                <th>SL</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Created_at</th>
                            </tr>
                            @foreach ($all_users as $index => $users)
                                <tr>
                                    <td>{{ $all_users->firstitem() + $index }}</td>
                                    <td>{{ $users->name }}</td>
                                    <td>{{ $users->email }}</td>
                                    <td>{{ $users->created_at->diffInHours() > 24 ? $users->created_at->format('d/m/y h:i:s A') : $users->created_at->diffForHumans() }}
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                        {{ $all_users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
