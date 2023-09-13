@section('title', 'Register')

<x-layout>

    <body class="bg-gradient-primary">
        <div class="container mt-5 ">
            <h1 class="fw-bold text-center mb-5">Register</h1>
            <form action="" method="post" enctype="multipart/form-data">
                @csrf
                <div class="mb-3 row">
                    <label for="name" class="col-sm-2 col-form-label">Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="name" name="name">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="email" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control" id="email" name="email">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="mobile_no" class="col-sm-2 col-form-label">Mobile no.</label>
                    <div class="col-sm-10">
                        <input type="tel" class="form-control" id="mobile_no" name="mobile_no">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="country" class="col-sm-2 col-form-label">Country</label>
                    <div class="col-sm-10">
                        <select class="form-select" name="country" id="country">
                            
                            @foreach ($countries as $country)
                                <option value="{{ $country['id'] }}"> {{ $country['name'] }} </option>
                            @endforeach
                        </select>
                    </div>
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
            </form>
        </div>

    </body>


</x-layout>
