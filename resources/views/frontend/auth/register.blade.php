@extends('backend.includes.head')
@section('title', 'Register')
@section('auth-content')

    @auth
        {{-- <h1>You are not allowed to visit this page as you are already logged in. Please click below to go  <a href="{{ url()->previous() }}">Back</a></h1> --}}
        <script>
            // document.write('You are already logged in. Please logout to register your self');
            window.location.href = '{{ url()->previous() }}';
        </script>
    @endauth
    @guest

        <body class="bg-primary">

            <div class="container">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">{{ __('register_create') }}</h1>
                                    </div>
                                    @if (request()->is('company-register'))
                                        <form class="user" action="{{ route('guest.company.store') }}" method="POST"
                                            enctype="multipart/form-data">
                                        @elseif(request()->is('register'))
                                            <form class="user" action="{{ route('signup') }}" method="POST"
                                                enctype="multipart/form-data">
                                    @endif

                                    @csrf
                                    <div class="form-group">
                                        <label class="form-label" for="form7Example2">{{ __('register_name') }}</label>
                                        <input type="text" id="name" name="name"
                                            class="form-control form-control-user" id="exampleFirstName" placeholder=" Name"
                                            value="{{ old('name') }}">

                                        @error('name')
                                            <span class="text-danger"> {{ $message }} </span>
                                        @enderror
                                    </div>

                                    @if (request()->is('company-register'))
                                        <div class="form-group">
                                            <label class="form-label" for="form7Example2">{{ __('register_company_name') }}</label>
                                            <input type="text" id="company_name" name="company_name"
                                                class="form-control form-control-user" id="exampleFirstName"
                                                placeholder="Company name" value="{{ old('company_name') }}">

                                            @error('company_name')
                                                <span class="text-danger"> {{ $message }} </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="form7Example2">{{ __('register_description') }}</label>
                                            <input type="text" id="description" name="description"
                                                class="form-control form-control-user" id="exampleFirstName"
                                                placeholder="Company description" value="{{ old('description') }}">

                                            @error('description')
                                                <span class="text-danger"> {{ $message }} </span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label" for="form7Example2">{{ __('register_address') }}</label>
                                            <input type="text" id="address" name="address"
                                                class="form-control form-control-user" id="exampleFirstName"
                                                placeholder="Company Address" value="{{ old('address') }}">

                                            @error('address')
                                                <span class="text-danger"> {{ $message }} </span>
                                            @enderror
                                        </div>
                                    @endif
                                    <div class="form-group">
                                        <label class="form-label" for="form7Example2">{{ __('register_email') }}</label>
                                        <input type="email" name="email" id="email"
                                            class="form-control form-control-user" id="exampleLastName"
                                            placeholder="Email Address" value="{{ old('email') }}">

                                        @error('email')
                                            <span class="text-danger"> {{ $message }} </span>
                                        @enderror
                                    </div>


                                    <div class="form-group">
                                        <label class="form-label" for="form7Example2">{{ __('register_mobile_no') }}</label>
                                        <input type="tel" name="mobile_no" id="mobile_no"
                                            class="form-control form-control-user" id="exampleInputEmail"
                                            placeholder="Contact Number" value="{{ old('mobile_no') }}">
                                        @error('mobile_no')
                                            <span class="text-danger"> {{ $message }} </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label" for="form7Example2">{{ __('register_city') }}</label>
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
                                    <div class="form-outline mb-4">
                                        <label class="form-label" for="form7Example2">Profile Picture</label>
                                        <input type="file" accept="image/png, image/jpeg, image/jpg" name="profile"
                                            id="profile" class="form-control rounded-pill" />
                                        @error('profile')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="form7Example2">{{ __('register_password') }}</label>
                                        <input type="password" name="password" id="password"
                                            class="form-control form-control-user" id="exampleInputPassword"
                                            placeholder="Password" value="{{ old('password') }}">

                                        @error('password')
                                            <div class="text-danger"> {{ $message }} </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label"
                                            for="form7Example2">{{ __('register_password_confirmation') }}</label>
                                        <input type="password" name="password_confirmation" id="password_confirmation"
                                            class="form-control form-control-user" id="exampleInputPassword"
                                            placeholder="Confirm Password" value="{{ old('password') }}">

                                        @error('password_confirmation')
                                            <div class="text-danger"> {{ $message }} </div>
                                        @enderror
                                    </div>

                                <div class="container">
                                    <div class="row d-flex justify-content-center">
                                        <button type="submit" class=" btn btn-primary btn-block text-center rounded-pill">
                                            {{ __('register_register') }}
                                        </button>
                                    </div>
                                </div>
                                </form>
                                <hr>

                                <div class="text-center">
                                    <a class="small" href="{{ route('login') }}">{{ __('register_already_account') }}</a>
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
