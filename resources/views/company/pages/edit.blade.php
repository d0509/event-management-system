{{-- @extends('layouts.admin-layout') --}}
@extends('backend.master.layout')
@if (request()->route()->getName() == 'admin.company.edit')
    @section('title', 'Edit Company')
@elseif(request()->route()->getName() == 'admin.company.create')
    @section('title', 'Add Company')
@endif


@section('title', 'Edit Company')
@section('content')

    <body class="bg-gradient-primary">
        <div class="container">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="p-5">
                                <div class="text-center">
                                    @if (request()->route()->getName() == 'admin.company.edit')
                                        <h1 class="h4 text-gray-900 mb-4">Update Company!</h1>
                                    @elseif(request()->route()->getName() == 'admin.company.create')
                                        <h1 class="h4 text-gray-900 mb-4">Add Company</h1>
                                    @endif

                                </div>

                                @if (request()->route()->getName() == 'admin.company.edit')
                                    <form action="{{ route('admin.company.update', ['company' => $company]) }}"
                                        method="post" enctype="multipart/form-data">
                                    @elseif(request()->route()->getName() == 'admin.company.create')
                                        <form action="{{ route('admin.company.store') }}" method="post"
                                            enctype="multipart/form-data">
                                @endif
                                @csrf
                                @if (request()->route()->getName() == 'admin.company.edit')
                                    @method('PATCH')
                                @endif

                                <div class="form-group">
                                    <label class="form-label" for="form7Example2">User Name</label>
                                    <input type="text" id="name" name="name"
                                        class="form-control form-control-user rounded-pill" placeholder="User Name"
                                        @if (isset($company)) value="{{ old('name', $company->user->name) }}">
                                            @else
                                            value="{{ old('name') }}"> @endif
                                        @error('name')
                                            <span class="text-danger"> {{ $message }} </span>
                                        @enderror
                                        </div>


                                    <div class="form-group">
                                        <label class="form-label" for="form7Example2">Company Name</label>
                                        <input type="text" id="company_name" name="company_name"
                                            class="form-control form-control-user rounded-pill" placeholder="Company name"
                                            @if (isset($company)) value="{{ old('company_name', $company->name) }}">
                                            @else
                                                
                                            value="{{ old('company_name') }}"> @endif
                                            @error('company_name')
                                            <span class="text-danger"> {{ $message }} </span>
                                        @enderror
                                            </div>
                                        <div class="form-group">
                                            <label class="form-label" for="form7Example2">Description</label>
                                            <input type="text" id="description" name="description"
                                                class="form-control form-control-user rounded-pill"
                                                placeholder="Company description"
                                                @if (isset($company)) value="{{ old('description', $company->description) }}">
                                            @else
                                            value="{{ old('description') }}"> @endif
                                                @error('description')
                                            <span class="text-danger"> {{ $message }} </span>
                                        @enderror
                                                </div>

                                            <div class="form-group">
                                                <label class="form-label" for="form7Example2">Company Address</label>
                                                <input type="text" id="address" name="address"
                                                    class="form-control form-control-user rounded-pill"
                                                    placeholder="Company Address"
                                                    @if (isset($company)) value="{{ old('address', $company->address) }}"> 
                                            @else
                                                
                                            value="{{ old('address') }}"> @endif
                                                    @error('address')
                                            <span class="text-danger"> {{ $message }} </span>
                                        @enderror
                                                    </div>

                                                <div class="form-group">
                                                    <label class="form-label" for="form7Example2">Email</label>
                                                    <input type="email" name="email" id="email"
                                                        class="form-control form-control-user rounded-pill"
                                                        placeholder="Email Address"
                                                        @if (isset($company)) value="{{ old('email', $company->user->email) }}">
                                            @else
                                            value="{{ old('email') }}"> @endif
                                                        @error('email')
                                            <span class="text-danger"> {{ $message }} </span>
                                        @enderror
                                                        </div>


                                                    <div class="form-group">
                                                        <label class="form-label" for="form7Example2">Mobile No.</label>
                                                        <input type="tel" name="mobile_no" id="mobile_no"
                                                            class="form-control form-control-user rounded-pill"
                                                            placeholder="Contact Number"
                                                            @if (isset($company)) value="{{ old('mobile_no', $company->user->mobile_no) }}">
                                                            @else
                                            value="{{ old('mobile_no') }}"> @endif
                                                            @error('mobile_no')
                                            <span class="text-danger"> {{ $message }} </span>
                                        @enderror
                                                            </div>

                                                        <div class="form-group">
                                                            <label class="form-label" for="form7Example2">City</label>
                                                            {{-- {{dd($cities)}} --}}
                                                            {{-- {{dd($company->toArray())}} --}}
                                                            <select style="color: black"
                                                                class="form-control rounded-pill form-select-lg"
                                                                aria-label="Default select example" name="city_id"
                                                                id="city_id">


                                                                @foreach ($cities as $city)
                                                                    <option value="{{ $city->id }}"
                                                                        @if (isset($company)) {{ $city->id == $company->user->city_id ? 'selected' : '' }} @endif>
                                                                        {{ $city->name }} </option>
                                                                @endforeach
                                                            </select>
                                                            @error('city_id')
                                                                <div class="text-danger">{{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                        <div class="form-outline mb-4">
                                                            <label class="form-label" for="form7Example2">Profile
                                                                Picture</label>
                                                            <input type="file" accept="image/png, image/jpeg, image/jpg"
                                                                name="profile" id="profile" class="form-control" />
                                                            @error('profile')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>

                                                        @if (request()->route()->getName() == 'admin.company.create')
                                                            <div class="form-group">
                                                                <label class="form-label"
                                                                    for="form7Example2">Password</label>
                                                                <input type="password" name="password" id="password"
                                                                    class="form-control form-control-user rounded-pill"
                                                                    id="exampleInputPassword" placeholder="Password"
                                                                    value="{{ old('password') }}">

                                                                @error('password')
                                                                    <div class="text-danger"> {{ $message }} </div>
                                                                @enderror
                                                            </div>

                                                            <div class="form-group">
                                                                <label class="form-label" for="form7Example2">Confirm
                                                                    Password</label>
                                                                <input type="password" name="password_confirmation"
                                                                    id="password_confirmation"
                                                                    class="form-control form-control-user rounded-pill"
                                                                    id="exampleInputPassword"
                                                                    placeholder="Confirm Password"
                                                                    value="{{ old('password') }}">

                                                                @error('password_confirmation')
                                                                    <div class="text-danger"> {{ $message }} </div>
                                                                @enderror
                                                            </div>
                                                        @endif
                                                        <div class="form-group">
                                                            <label class="form-label" for="form7Example2">Status</label>
                                                            <select class="form-control rounded-pill form-select-lg"
                                                                aria-label="Default select example" name="status"
                                                                id="status">

                                                                {{-- {{dd($cities)}} --}}

                                                                <option value="pending"
                                                                    @if (isset($company)) {{ $company->user->status == 'Pending ' ? 'selected' : '' }} @endif>
                                                                    Pending
                                                                </option>
                                                                <option value="approved"
                                                                    @if (isset($company)) {{ $company->user->status == 'approved' ? 'selected' : '' }} @endif>
                                                                    Approved</option>
                                                            </select>
                                                            @error('status')
                                                                <div class="text-danger">{{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                        <div class="row d-flex justify-content-center">
                                                            <button type="submit"
                                                                class="btn btn-primary btn-user text-center rounded-pill">
                                                                @if (request()->route()->getName() == 'admin.company.create')
                                                                    Add Company
                                                                @elseif(request()->route()->getName() == 'admin.company.edit')
                                                                    Update Company
                                                                @endif
                                                            </button>
                                                        </div>


                                                        </form>


                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
    </body>
@endsection
