@extends('User.pages.dashboard')
@section('title', 'Add Event')
@section('createEvent')
    <div class="container">
        <h1 class="text-center fw-bold  ">Add Event</h1>
        {{-- {{dd(67)}} --}}
        <form action="{{route('event.store')}}" method="post" enctype="multipart/form-data" class="mt-5 mb-5">
            @csrf
            <!-- Name input -->
            <div class="form-outline mb-4">
                <label class="form-label" for="form7Example1">Event Name</label>
                <input type="text" value="{{ old('name') }}" name="name" id="name" class="form-control" placeholder="Enter event name" />
                @error('name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-outline mb-4">
                <label class="form-label" for="form7Example2">Description</label>
                <textarea {{old('description')}}   name="description" id="description" class="form-control" placeholder="Description">{{old('description')}}</textarea>
                @error('description')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            {{-- available seat --}}

            <div class="form-outline mb-4">
                <label class="form-label" for="form7Example2">Available Seat</label>
                <input type="number" name="available_seat" value="{{old('seat')}}" id="available_seat" class="form-control" placeholder="Available Seat" />
                @error('available_seat')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-outline mb-4">
                <label class="form-label" for="form7Example2">Event Address</label>
                <input type="text" name="venue" id="venue" value="{{old('venue')}}" class="form-control" placeholder="Event Address" />
                @error('venue')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-outline mb-4">
                <label class="form-label" for="form7Example2">Event City</label>
                <select name="city_id" id="city_id" value="{{old('city_id')}}" class="form-control form-select-lg">
                    <option>Please select a city</option>
                    @foreach ($cities as $city)
                        <option value="{{ $city->id }}" class="">{{ $city->name }}</option>
                    @endforeach
                </select>
                @error('city_id')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-outline mb-4">
                <label class="form-label" for="form7Example2">Starting Time of Event</label>
                <input type="date" name="event_date" id="event_date" value="{{old('start_time')}}" class="form-control"
                    placeholder="Starting Time of Event"  />
                @error('event_date')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            {{-- start_time --}}
            <div class="form-outline mb-4">
                <label class="form-label" for="form7Example2">Starting Time of Event</label>
                <input type="time" name="start_time" id="start_time" value="{{old('start_time')}}" class="form-control"
                    placeholder="Starting Time of Event"  />
                @error('start_time')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-outline mb-4">
                <label class="form-label" for="form7Example2">Ending Time of Event</label>
                <input type="time" name="end_time" id="end_time" value="{{old('end_time')}}" class="form-control"
                    placeholder="Ending Time of Event" />
                @error('end_time')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-outline mb-4">
                <label class="form-label" for="form7Example2">Ticket Amount</label>
                <input type="number" step="any" name="ticket" id="ticket" value="{{old('ticket')}}" class="form-control"
                    placeholder="Ticket Amount" />
                @error('ticket')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-outline mb-4">
                <label class="form-label" for="form7Example2">Event Banner</label>
                <input type="file" accept="image/png, image/jpeg, image/jpg" width="48" height="48" name="banner" id="banner" class="form-control" />
                @error('banner')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary mb-5">Add Event</button>

        </form>
    </div>

@endsection
