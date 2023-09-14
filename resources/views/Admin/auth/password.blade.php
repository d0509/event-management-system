@extends('admin.pages.dashboard')
@section('title', 'Change Password')
@section('password.edit')
    <div class="container">
        <h1 class="text-center" >Change Password</h1>
        <form method="POST" action="{{route('password.update')}}" >
            @csrf
            @method('PATCH')
            <!-- Email input -->
            <div class="form-outline mb-4">
                <label class="form-label" for="form1Example1">Old Password</label>
                <input type="password" value="{{old('password')}}" name="password" id="password" class="form-control" />
                @error('password')
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>

            <!-- Password input -->
            <div class="form-outline mb-4">
                <label class="form-label" for="form1Example2">New Password</label>
                <input type="password" name="new_password" id="new_password" class="form-control" value="{{old('new_password')}}" />
                @error('new_password')
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>

            <div class="form-outline mb-4">
                <label class="form-label" for="form1Example2">Confirm New Password</label>
                <input type="password" name="new_password_confirmation" id="new_password_confirmation" value="{{old('new_password_confirmation')}}" class="form-control" />
                @error('new_password_confirmation')
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>

            
            
            <button type="submit" class="btn btn-primary btn-block">Update Password</button>
        </form>
    </div>

@endsection
