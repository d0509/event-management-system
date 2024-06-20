@extends('backend.master.layout')
@section('title', 'User Information')
@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">User</h1>
        </div>
        <div class="card col-4 mb-5" style="margin: 0 auto">
            @foreach ($user->media as $item)
                <img class="img-profile" src="{{ asset('storage/profile/' . $item['filename'] . '.' . $item['extension']) }}">
            @endforeach
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <p class="text-dark"> Name</p>
                    <p class="text-dark">{{ ucwords($user->name) }} </p>
                </div>

                <div class="d-flex justify-content-between">
                    <p class="text-dark"> Email</p>
                    <p class="text-dark">{{ $user->email }} </p>
                </div>
                <div class="d-flex justify-content-between">
                    <p class="text-dark"> Mobile No.</p>
                    <p class="text-dark">{{ $user->mobile_no }}</p>
                </div>
                <div class="d-flex justify-content-between">
                    <p class="text-dark"> City</p>
                    <p class="text-dark">{{ $user->city->name }}</p>
                </div>
                <div class="d-flex justify-content-between">
                    <p class="text-dark"> Status</p>
                    <p class="text-dark">{{ $user->status }}</p>
                </div>

                <a href="{{url()->previous()}}" class="btn btn-primary" >Back</a>
            </div>
        </div>

    </div>

@endsection
