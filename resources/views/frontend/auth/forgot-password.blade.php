@extends('backend.includes.head')
@section('title','Forgot Password')

@section('auth-content')

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
                                        <div class="text-center">
                                            <h1 class="h4 text-gray-900 mb-2">Forgot Your Password?</h1>
                                            <p class="mb-4"> Just enter your email address below
                                                and we'll send you a link to reset your password!</p>
                                        </div>
                                        <form class="user" action="{{route('forgot-password.store')}}" method="POST">
                                            @csrf
                                            <div class="form-group">
                                                <input type="email" class="form-control form-control-user"
                                                    id="email" name="email" aria-describedby="emailHelp"
                                                    placeholder="Enter Email Address...">
                                            </div>
                                            @error('email')
                                                <span class="text-danger">{{$message}}</span>
                                            @enderror
                                            <button type="submit" name="submit" id="submit"  class="btn btn-primary btn-user btn-block">
                                                Reset Password
                                            </button>
                                        </form>
                                        <hr>
                                        <div class="text-center">
                                            <a class="small" href="{{route('register')}}">Create an Account!</a>
                                        </div>
                                        <div class="text-center">
                                            <a class="small" href="{{route('signIn')}}">Already have an account? Login!</a>
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
@endsection
