@extends('frontend.master.layout')
@section('title','User Profile')
@section('content')
    {{-- {{dd($user->toArray())}} --}}
    {{-- name,email,contact_no,city_id,status --}}
    <div class="container">
        <h3 class="text-center mt-2 mb-2 " > User Profile </h3>
        <form action="{{route('user.profile.update',['profile' => Auth::id()])}}" method="post" enctype="multipart/form-data" >
            @csrf
    @method('PATCH')
            <div class="form-group">
                <label class="form-label" for="form7Example2">{{ __('auth.name') }}</label>
                <input type="text" id="name" name="name"
                    class="form-control form-control-user" id="exampleFirstName" placeholder=" Name"
                    value="{{ $user->name }}">
    
                @error('name')
                    <span class="text-danger"> {{ $message }} </span>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="form7Example2">{{ __('auth.email') }}</label>
                <input type="email" name="email" id="email"
                    class="form-control form-control-user" id="exampleLastName"
                    placeholder="Email Address" value="{{ $user->email }}">

                @error('email')
                    <span class="text-danger"> {{ $message }} </span>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="form7Example2">{{ __('auth.mobile_no') }}</label>
                <input type="tel" name="mobile_no" id="mobile_no"
                    class="form-control form-control-user" id="exampleInputEmail"
                    placeholder="Contact Number" value="{{ $user->mobile_no }}">
                @error('mobile_no')
                    <span class="text-danger"> {{ $message }} </span>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="form7Example2">{{ __('auth.city_id') }}</label>
                <select class="form-control form-select-lg"
                    aria-label="Default select example" name="city_id" id="city_id">

                    @foreach ($cities as $city)
                        <option value="{{ $city->id }}"
                            {{($user->city_id ==  $city->id ? 'selected' : '' )}}
                            > {{ $city->name }}
                        </option>
                    @endforeach
                </select>
                @error('city_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-outline mb-4">
                <label class="form-label" for="form2Example2">{{__('auth.profile_picture')}}</label>
                <input type="file" accept="image/png, image/jpeg, image/jpg" name="profile" id="profile" class="form-control"
                value="{{ isset($user) ? old('profile', $user->profile) : old('profile') }}" />
                    @error('profile')
                <div class="text-danger">{{ $message }}</div>
            @enderror
            </div>

           
            {{-- {{dd(Auth::user()->media)}} --}}

            @if(isset(Auth::user()->media ))
            {{-- {{dd(Auth::user()->media)}} --}}
            {{-- {{dd(Auth::user()->media->toArray())}} --}}
            @foreach (Auth::user()->media as $item)                
            Profile Picture: <img  src="{{ asset('storage/profile/' .$item['filename'] . '.' . $item['extension']) }}" alt="" class="mt-5 mb-5"  width="250" >
            @endforeach
        @endif

            <div class="row d-flex justify-content-center">
                <button type="submit" class="btn btn-primary btn-block  mb-5">
                    {{ __('auth.update_profile') }}
                </button>
            </div>


        </form>
    </div>
    
@endsection