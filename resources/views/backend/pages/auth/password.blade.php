@extends('backend.master.layout')
@section('title', 'Change Password')
@section('content')
    <div class="container">
        <h1 class="text-center">Change Password</h1>

        <form action="{{route('admin.change-password.update',['change_password' => Auth::id()])}}" method="POST" class="mt-5">
            @csrf
            @method('PATCH')
            <div class="form-group">
                <label class="form-label" for="form7Example2">Current Password</label>
                <input type="password" id="password" name="password" class="form-control form-control-user"
                    placeholder="Current Password">
                @error('password')
                    <span class="text-danger"> {{ $message }} </span>
                @enderror
            </div>
            <div class="form-group">
                <label class="form-label" for="form7Example2">New Password</label>
                <input type="password" id="new_password" name="new_password" class="form-control form-control-user"
                    placeholder="New Password">
                @error('new_password')
                    <span class="text-danger"> {{ $message }} </span>
                @enderror
            </div>
            <div class="form-group">
                <label class="form-label" for="form7Example2">Confirm New Password</label>
                <input type="password" id="new_password_confirmation" name="new_password_confirmation" class="form-control form-control-user"
                    placeholder="Confirm New Password">
                @error('new_password_confirmation')
                    <span class="text-danger"> {{ $message }} </span>
                @enderror
            </div>
            <input type="submit" class="btn btn-block btn-primary" name="submit">
        </form>
    </div>

@endsection
