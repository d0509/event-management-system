@extends('layouts.adminlayout')
@section('title', 'Register')
@section('register')

    <body class="bg-gradient-primary">

        <div class="container">

            <div class="container">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                                    </div>
                                    @if (request()->is('company-register'))
                                        <form class="user" action="{{ route('guest.company.store') }}" method="POST">
                                        @elseif(request()->is('register'))
                                            <form class="user" action="{{ route('signup') }}" method="POST">
                                    @endif

                                    @csrf
                                    <div class="form-group">

                                        <input type="text" id="name" name="name"
                                            class="form-control form-control-user" id="exampleFirstName" placeholder=" Name"
                                            value="{{ old('name') }}">

                                        @error('name')
                                            <span class="text-danger"> {{ $message }} </span>
                                        @enderror
                                    </div>

                                    @if (request()->is('company-register'))

                                    

                                    <div class="form-group">

                                        <input type="text" id="company_name" name="company_name"
                                            class="form-control form-control-user" id="exampleFirstName"
                                            placeholder="Company name" value="{{ old('company_name') }}">

                                        @error('company_name')
                                            <span class="text-danger"> {{ $message }} </span>
                                        @enderror
                                    </div>
                                        <div class="form-group">

                                            <input type="text" id="description" name="description"
                                                class="form-control form-control-user" id="exampleFirstName"
                                                placeholder="Company description" value="{{ old('description') }}">

                                            @error('description')
                                                <span class="text-danger"> {{ $message }} </span>
                                            @enderror
                                        </div>

                                        <div class="form-group">

                                            <input type="text" id="address" name="address"
                                                class="form-control form-control-user" id="exampleFirstName"
                                                placeholder="Company Address" value="{{ old('address') }}">

                                            @error('address')
                                                <span class="text-danger"> {{ $message }} </span>
                                            @enderror
                                        </div>

                                    @endif
                                    <div class="form-group">

                                        <input type="email" name="email" id="email"
                                            class="form-control form-control-user" id="exampleLastName"
                                            placeholder="Email Address" value="{{ old('email') }}">

                                        @error('email')
                                            <span class="text-danger"> {{ $message }} </span>
                                        @enderror
                                    </div>


                                    <div class="form-group">
                                        <input type="tel" name="mobile_no" id="mobile_no"
                                            class="form-control form-control-user" id="exampleInputEmail"
                                            placeholder="Contact Number" value="{{ old('mobile_no') }}">
                                        @error('mobile_no')
                                            <span class="text-danger"> {{ $message }} </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">

                                        <select class="form-control rounded-pill form-select-lg"
                                            aria-label="Default select example" name="city_id" id="city_id">
                                            
                                            @foreach ($cities as $city)
                                                <option value="{{ $city->id }}"> {{ $city->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('city_id')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">

                                        <input type="password" name="password" id="password"
                                            class="form-control form-control-user" id="exampleInputPassword"
                                            placeholder="Password" value="{{ old('password') }}">

                                        @error('password')
                                            <div class="text-danger"> {{ $message }} </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">

                                        <input type="password" name="password_confirmation" id="password_confirmation"
                                            class="form-control form-control-user" id="exampleInputPassword"
                                            placeholder="Confirm Password" value="{{ old('password') }}">

                                        @error('password_confirmation')
                                            <div class="text-danger"> {{ $message }} </div>
                                        @enderror
                                    </div>


                                </div>
                                <div class="row d-flex justify-content-center">
                                    <button type="submit" class="btn btn-primary btn-user text-center rounded-pill">
                                        Register Account
                                    </button>
                                </div>


                                </form>
                                <hr>
                                <div class="text-center">
                                    {{-- <a class="small" href="{{ route('forgotPassword') }}">Forgot Password?</a> --}}
                                </div>
                                <div class="text-center">
                                    <a class="small" href="{{ route('login') }}">Already have an account?
                                        Login!</a>
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
