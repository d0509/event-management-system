@extends('backend.master.layout')
@section('title', 'Profile')
@section('content')
    <div class="container">
        <div class="row row-cols-3 g-3">
            <div class="col">
                <div class="card">
                    <div class="bg-image hover-overlay ripple" data-mdb-ripple-color="light">
                        @if (Auth::user()->media('profile'))
                            @foreach (Auth::user()->media as $item)
                                <img src="{{ asset('storage/profile/' . $item['filename'] . '.' . $item['extension']) }}"
                                    class="img-fluid" alt="">
                            @endforeach
                        @else
                            <img src="https://mdbcdn.b-cdn.net/img/new/standard/nature/111.webp" class="img-fluid" />
                        @endif

                        <a href="#!">
                            <div class="mask" style="background-color: rgba(251, 251, 251, 0.15);"></div>
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <p class="text-dark"> Name</p>
                            <p class="text-dark">{{ ucwords(Auth::user()->name) }} </p>
                        </div>

                        <div class="d-flex justify-content-between">
                            <p class="text-dark"> Email</p>
                            <p class="text-dark">{{ Auth::user()->email }} </p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <p class="text-dark"> Mobile No.</p>
                            <p class="text-dark">{{ Auth::user()->mobile_no }}</p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <p class="text-dark"> City</p>
                            <p class="text-dark">{{ Auth::user()->city->name }}</p>
                        </div>
                        </p>
                        {{-- <a href="{{route('profile.edit')}}" class="btn btn-primary">Edit Profile</a> --}}
                        @if (Auth::user()->role_id == config('site.roles.admin'))
                            <a href="{{ route('admin.profile.edit', ['profile' => Auth::user()]) }}"
                                class="btn btn-primary">Edit Profile</a>
                                @else
                                <a href="{{ route('company.profile.edit', ['profile' => Auth::user()]) }}"
                                    class="btn btn-primary">Edit Profile</a> 
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
