@extends('backend.includes.head')
@section('title', 'Reset Password')
@section('auth-content')
    {{-- {{dd('im inside reset password link')}} --}}

    <body class="bg-gradient-primary">
        <div class="container">
            <!-- Outer Row -->
            <div class="row justify-content-center">
                <div class="col-xl-10 col-lg-12 col-md-9">
                    <div class="card o-hidden border-0 shadow-lg my-5">
                        <div class="card-body p-0">
                            <!-- Nested Row within Card Body -->
                            <div class="row">
                                {{-- <div class="col-lg-6 d-none d-lg-block bg-password-image"></div> --}}
                                <div class="col-lg-12">
                                    <div class="p-5">

                                        <form method="POST" action="{{ route('reset.password.post') }}">
                                            @csrf
                                            <input type="hidden" name="token" value="{{ $token }}">

                                            <div class="form-outline mb-4">
                                                <label class="form-label" for="form1Example2">
                                                    {{ __('forget_password_link_new_password') }} </label>
                                                <input type="password" name="password" id="password"
                                                    value="{{ old('password') }}" class="form-control" />
                                                @error('password')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <!-- Password input -->
                                            <div class="form-outline mb-4">
                                                <label class="form-label" for="form1Example2">
                                                    {{ __('forget_password_link_confirm_password') }} </label>
                                                <input type="password" name="password_confirmation"
                                                    id="password_confirmation" class="form-control"
                                                    value="{{ old('password_confirmation') }}" />
                                                @error('new_password')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <button type="submit" class="btn btn-primary btn-block">
                                                {{ __('forget_password_link_update_password') }} </button>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
@endsection
