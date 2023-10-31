@extends('backend.includes.head')
@section('title', 'Login page')
{{-- {{dd('im afetr title')}} --}}
@section('auth-content')

    @auth

        <script>
            window.location.href = '{{ url()->previous() }}';
        </script>
    @endauth
    @guest

        <body class="bg-gradient-primary">
            <div class="container ">

                <!-- Outer Row -->
                <div class="row justify-content-center">

                    <div class="col-xl-10 col-lg-12 col-md-9">

                        <div class="card o-hidden border-0 shadow-lg my-5">
                            <div class="card-body p-0">
                                <!-- Nested Row within Card Body -->
                                <div class="row">
                                    {{-- <div class="col-lg-6 d-none d-lg-block bg-login-image"></div> --}}
                                    <div class="col-lg-12">
                                        <div class="p-5">
                                            <div class="text-center">
                                                @if (session('error'))
                                                    <div class="text-danger text-center">{{ session('error') }}</div>
                                                @endif
                                                @if (session('success'))
                                                    <div class="text-success text-center">{{ session('success') }}</div>
                                                @endif
                                                <h1 class="h4 text-gray-900 mb-4">{{ __('login_welcome') }}</h1>
                                            </div>
                                            <form action="{{ route('signIn') }}" class="user" method="POST">
                                                @csrf
                                                <div class="form-group">
                                                    <label class="form-label" for="form7Example2">{{ __('login_email') }}</label>
                                                    <input type="email" name="email" class="form-control form-control-user"
                                                        id="exampleInputEmail" aria-describedby="emailHelp"
                                                        placeholder="Enter Email Address...">
                                                    @error('email')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror

                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label"
                                                        for="form7Example2">{{ __('login_password') }}</label>
                                                    <input type="password" name="password"
                                                        class="form-control form-control-user" id="exampleInputPassword"
                                                        placeholder="Password">
                                                    @error('password')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                {{-- <div class="form-group">
                                                    <div class="custom-control custom-checkbox small">
                                                        <input type="checkbox" class="custom-control-input" id="customCheck">
                                                        <label class="custom-control-label"
                                                            for="customCheck">{{ __('login_remember') }}</label>
                                                    </div>
                                                </div> --}}
                                                <button type="submit" name="submit"
                                                    class="btn btn-primary btn-user btn-block">
                                                    {{ __('login_login') }}
                                                </button>


                                            </form>
                                            <hr>
                                            <div class="text-center">
                                                <a class="small"
                                                    href="{{ route('forgot-password.create') }}">{{ __('login_forgot') }}</a>
                                            </div>
                                            <div class="text-center">
                                                <a class="small"
                                                    href="{{ route('register') }}">{{ __('login_user_create') }}</a>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

            </div>
        </body>
    @endguest



@endsection
