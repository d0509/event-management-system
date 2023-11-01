@extends('backend.master.layout')
@section('title', 'Create Coupon Code')
@section('content')

    <body class="bg-gradient-primary">
        <div class="container">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="p-5">
                                <div class="text-center">
                                    @if (isset($coupon) == true)
                                        <h1 class="h4 text-gray-900 mb-4">Update Coupon</h1>
                                    @elseif(isset($coupon) == false)
                                        <h1 class="h4 text-gray-900 mb-4">Add Coupon</h1>
                                    @endif

                                </div>

                                @if (isset($coupon) == true)
                                    <form action="{{ route('company.coupon-code.update', ['coupon_code' => $coupon]) }}"
                                        method="post" enctype="multipart/form-data">
                                    @elseif(isset($coupon) == false)
                                        <form action="{{ route('company.coupon-code.store') }}" method="post"
                                            enctype="multipart/form-data">
                                @endif
                                @csrf
                                @if (isset($coupon) == true)
                                    @method('PATCH')
                                @endif

                                <input type="hidden" value="{{Auth::user()->company->id}}" id="company_id" name="company_id" >
                                @if (isset($coupon))
                                    <input type="hidden" name="coupon_id" id="coupon_id" value="{{$coupon->id}}" >
                                @endif
                                <div class="form-group">
                                    <label class="form-label" for="form7Example2">Coupon</label>
                                    <input type="text" id="name" name="name"
                                        class="form-control form-control-user rounded-pill" placeholder="Coupon Code"
                                        @if (isset($coupon)) value="{{ old('name', $coupon->name) }}">
                                        @else
                                        value="{{ old('name') }}"> @endif
                                        @error('name')
                                        <span class="text-danger"> {{ $message }} </span>
                                        @enderror
                                    
                                </div>


                                    <div class="form-group">
                                        <label class="form-label" for="form7Example2">Usable Count</label>
                                        <input type="number" id="usable_count" name="usable_count"
                                            class="form-control form-control-user rounded-pill" placeholder="Usable Count"
                                            @if (isset($coupon)) value="{{ old('usable_count', $coupon->usable_count) }}">
                                        @else
                                            
                                        value="{{ old('usable_count') }}"> @endif
                                            @error('usable_count')
                                        <span class="text-danger"> {{ $message }} </span>
                                    @enderror
                                            </div>
                                        <div class="form-group">
                                            <label class="form-label" for="form7Example2">Percentage</label>
                                            <input type="number" step="any" id="percentage" name="percentage"
                                                class="form-control form-control-user rounded-pill" placeholder="Percentage"
                                                @if (isset($coupon)) value="{{ old('percentage', $coupon->percentage) }}">
                                        @else
                                        value="{{ old('percentage') }}"> @endif
                                                @error('percentage')
                                        <span class="text-danger"> {{ $message }} </span>
                                    @enderror
                                                </div>

                                            <div class="form-group">
                                                <label class="form-label" for="form7Example2">Start Date</label>
                                                <input type="date" id="start_date" name="start_date"
                                                    class="form-control form-control-user rounded-pill"
                                                    placeholder="Company Address"
                                                    @if (isset($coupon)) value="{{ old('start_date', $coupon->start_date) }}"> 
                                        @else
                                            
                                        value="{{ old('start_date') }}"> @endif
                                                    @error('start_date')
                                        <span class="text-danger"> {{ $message }} </span>
                                    @enderror
                                                    </div>

                                                <div class="form-group">
                                                    <label class="form-label" for="form7Example2">End Date</label>
                                                    <input type="date" name="end_date" id="end_date"
                                                        class="form-control form-control-user rounded-pill"
                                                        @if (isset($coupon)) value="{{ old('end_date', $coupon->end_date) }}">
                                        @else
                                        value="{{ old('end_date') }}"> @endif
                                                        @error('end_date')
                                        <span class="text-danger"> {{ $message }} </span>
                                    @enderror
                                                        </div>


                                                    <div class="row d-flex justify-content-center">
                                                        <button type="submit"
                                                            class="btn btn-primary btn-user text-center rounded-pill">
                                                            @if (isset($coupon) == false)
                                                                Add Coupon
                                                            @elseif(isset($coupon) == true)
                                                                Update Coupon
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
