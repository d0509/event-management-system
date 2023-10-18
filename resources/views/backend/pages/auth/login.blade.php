@extends('backend.includes.head')
@section('title', 'Login page')
{{-- {{dd('im afetr title')}} --}}
@section('content')
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
                                                <h1 class="h4 text-gray-900 mb-4">{{ __('auth.welcome') }}</h1>
                                            </div>
                                            @if (request()->route()->getName() == 'admin.login')
                                                <form action="{{ route('signIn') }}" class="user" method="POST">
                                                @elseif(request()->route()->getName() == 'login')
                                                    <form action="{{ route('signIn') }}" class="user" method="POST">
                                            @endif
                                            @csrf
                                            <div class="form-group">
                                                <label class="form-label" for="form7Example2">{{ __('auth.email') }}</label>
                                                <input type="email" name="email" class="form-control form-control-user"
                                                    id="exampleInputEmail" aria-describedby="emailHelp"
                                                    placeholder="Enter Email Address..." value="admin@mailinator.com">
                                                @error('email')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror

                                            </div>
                                            <div class="form-group">
                                                <label class="form-label" for="form7Example2">{{ __('auth.password') }}</label>
                                                <input type="password" name="password" class="form-control form-control-user"
                                                    id="exampleInputPassword" placeholder="Password" value='74108520'>
                                                @error('password')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox small">
                                                    <input type="checkbox" class="custom-control-input" id="customCheck">
                                                    <label class="custom-control-label"
                                                        for="customCheck">{{ __('auth.remember') }}</label>
                                                </div>
                                            </div>
                                            <button type="submit" name="submit" class="btn btn-primary btn-user btn-block">
                                                {{ __('auth.login') }}
                                            </button>


                                            </form>
                                            <hr>
                                            <div class="text-center">
                                                <a class="small"
                                                    href="{{ route('forgot-password.create') }}">{{ __('auth.forgot') }}</a>
                                            </div>
                                            <div class="text-center">
                                                <a class="small"
                                                    href="{{ route('guest.company.create') }}">{{ __('auth.company_create') }}</a>
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