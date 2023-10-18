@extends('frontend.master.layout')
@section('title', 'Change Password')
@section('auth-content')
    <div class="container">
        <h3 class="text-center mt-5" > {{__('changePassword.change_password')}} </h3>
        <form action="{{ route('user.change-password.update',['change_password'=>Auth::id()]) }}" method="POST" class="mt-5">
            @csrf
            @method('PATCH')
            <div class="form-group">
                <label class="form-label" for="form7Example2">{{__('changePassword.current_password')}}</label>
                <input type="password" id="password" name="password" class="form-control form-control-user"
                    placeholder="Current Password">
                @error('password')
                    <span class="text-danger"> {{ $message }} </span>
                @enderror
            </div>
            <div class="form-group">
                <label class="form-label" for="form7Example2"> {{__('changePassword.new_password')}} </label>
                <input type="password" id="new_password" name="new_password" class="form-control form-control-user"
                    placeholder="New Password">
                @error('new_password')
                    <span class="text-danger"> {{ $message }} </span>
                @enderror
            </div>
            <div class="form-group">
                <label class="form-label" for="form7Example2"> {{__('changePassword.confirm_new_password')}} </label>
                <input type="password" id="new_password_confirmation" name="new_password_confirmation"
                    class="form-control form-control-user" placeholder="Confirm New Password">
                @error('new_password_confirmation')
                    <span class="text-danger"> {{ $message }} </span>
                @enderror
            </div>
            <button type="submit" class="btn btn-block btn-primary" name="submit"> {{__('changePassword.update_password')}} </button>
        </form>

    </div>
@endsection
