@extends('admin.pages.dashboard')
@section('title', 'Attend Event')
@section('company.attend-event.create')

    <div class="container">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">{{ __('dashboard.attend_event') }}</h1>
        </div>

        <form action="{{ route('company.attend-event.store') }}" method="post">
            @csrf
            {{-- {{dd($todayEvents)}} --}}
            <div class="form-outline mb-4">
                <label for="exampleFormControlInput1" class="form-label">Event Name</label>
                <select class="form-control" name="event_id" aria-label="Default select example">
                    <option value="default"> Please select an event </option>
                    @foreach ($todayEvents as $todayEvent)
                        <option value="{{ $todayEvent->id }}">{{ $todayEvent->name }}</option>
                    @endforeach
                </select>
                @error('event_id')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-outline mb-4">
                <label class="form-label" for="form7Example2">Booking Number</label>
                <input type="text" name="booking_number" id="booking_number" class="form-control"
                    placeholder="Booking number" value="{{ old('booking_number') }}" />
                @error('booking_number')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>


            <div class="form-outline mb-4">
                <label for="exampleFormControlInput1" class="form-label">No. of Attendee</label>
                <input type="number" name="no_of_attendee" class="form-control" placeholder="No. of attendee">
                @error('no_of_attendee')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary btn-block mt-5 ">Attend</button>
        </form>
    </div>
@endsection
