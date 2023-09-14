@extends('admin.pages.dashboard')
@section('title', 'Edit Profile')
@section('profile.edit')
    <div class="container">
        <h1 class="mt-5 mb-5 text-center">Update Profile </h1>
        <form method="POST" action="{{ route('profile.update', ['profile' => Auth::user()]) }}">
            @csrf
            @method('PATCH')
            <!-- Email input -->
            <div class="form-outline mb-4">
                <label class="form-label" for="form2Example1">Name</label>
                {{-- {{dd($user->toArray())}} --}}
                <input type="text" name="name" id="name" class="form-control" value="{{ isset($user) ? old('name', $user->name) : old('name') }}" />
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password input -->
            <div class="form-outline mb-4">
                <label class="form-label" for="form2Example2">Email </label>
                <input type="email" name="email" id="email" class="form-control"
                value="{{ isset($user) ? old('email', $user->email) : old('email') }}" />
                @error('email')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-outline mb-4">
                <label class="form-label" for="form2Example2">Mobile Number </label>
                <input type="tel" name="mobile_no" id="mobile_no" class="form-control"
                value="{{ isset($user) ? old('mobile_no', $user->mobile_no) : old('mobile_no') }}" />
                    @error('mobile_no')
                <div class="text-danger">{{ $message }}</div>
            @enderror
            </div>

            <div class="form-outline mb-4">
                <label class="form-label" for="form2Example2">City </label>
                <select class="form-control form-select-lg" aria-label="Default select example" name="city_id"
                    id="city_id">

                    @foreach ($cities as $city)
                        <option value="{{ $city->id }}" {{ Auth::user()->city->name == $city->name ? 'selected' : '' }}>
                            {{ $city->name }}
                        </option>
                    @endforeach
                </select>
                @error('city_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary btn-block mb-4">Update Profile</button>

            <!-- Register buttons -->

        </form>
    </div>

@endsection
