@extends('backend.master.layout')
@if (request()->route()->getName() == 'company.event.create')
    @section('title', 'Add Event')
@else
    @section('title', 'Update Event')
@endif

@section('content')
    <div class="container">
        {{-- {{ dd($event->toArray()) }} --}}
        <h1 class="text-center fw-bold  ">Add Event</h1>
        {{-- {{dd(67)}} --}}
        @if (request()->route()->getName() == 'company.event.create')
            <form action="{{ route('company.event.store') }}" method="post" enctype="multipart/form-data" class="mt-5 mb-5">
            @elseif(request()->route()->getName() == 'company.event.edit')
                <form action="{{ route('company.event.update', ['event' => $event]) }}" method="post" enctype="multipart/form-data"
                    class="mt-5 mb-5 ">
        @endif
        @csrf
        @if (request()->route()->getName() == 'company.event.edit')
            @method('PATCH')
        @endif
        <!-- Name input -->
        <div class="form-outline mb-4">
            <label class="form-label" for="form7Example1">Event Name</label>
            <input type="text" name="name" id="name" class="form-control " placeholder="Enter event name"
                value="{{ isset($event) ? old('name', $event->name) : old('name') }}" />
            @error('name')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-outline mb-4">
            <label class="form-label" for="form7Example2">Description</label>
            <textarea {{ old('description') }} name="description" id="description" class="form-control " placeholder="Description">@if (isset($event)){{ old('description', $event->description) }}@else{{ old('description') }}@endif</textarea>
            @error('description')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        {{-- available seat --}}
        <div class="form-outline mb-4">
            <label class="form-label" for="form7Example2">Available Seat</label>
            {{-- {{ dd($event->toArray()) }} --}}
            <input type="number" name="available_seat" id="available_seat" class="form-control"
                placeholder="Available Seat"
                value="{{ isset($event) ? old('available_seat', $event->available_seat) : old('available_seat') }}" />
            @error('available_seat')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>


        <div class="form-outline mb-4">
            <label class="form-label" for="form7Example2">Event Address</label>
            <input type="text" name="venue" id="venue" class="form-control" placeholder="Event Address"
                value="{{ isset($event) ? old('venue', $event->venue) : old('venue') }}" />
            @error('venue')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-outline mb-4">
            <label class="form-label" for="form7Example2">Location URL </label>
            <input type="text" name="location" id="location" class="form-control" placeholder="location "
                value="{{ isset($event) ? old('location', $event->location) : old('location') }}" />
            @error('location')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        {{-- categories --}}
        <div class="form-outline mb-4">
            <label class="form-label" for="form7Example2">Event Category</label>
            <select name="category_id" id="category_id" value="{{ old('category_id') }}"
                class="form-control form-select-lg">

                @foreach ($categories as $category)
                    <option value="{{ $category->id }}"
                        @if (isset($event)) {{ $category->id == $event->category_id ? 'selected' : '' }} @endif>
                        {{ $category->name }}</option>
                @endforeach
            </select>
            @error('category_id')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        {{-- city --}}
        <div class="form-outline mb-4">
            <label class="form-label" for="form7Example2">Event City</label>
            <select name="city_id" id="city_id" class="form-control form-select-lg">

                @foreach ($cities as $city)
                    <option value={{ $city->id }}
                        @if (isset($event)) {{ $city->id == $event->city_id ? 'selected' : '' }} @endif>
                        {{ $city->name }}</option>
                @endforeach
            </select>
            @error('city_id')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-outline mb-4">
            <label class="form-label" for="form7Example2">Event Date</label>
            <input type="date" name="event_date" id="event_date" class="form-control"
                placeholder="Starting Time of Event"
                value="{{ isset($event) ? old('event_date', $event->event_date) : old('event_date') }}" />
            @error('event_date')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        {{-- start_time --}}
        <div class="form-outline mb-4">
            <label class="form-label" for="form7Example2">Starting Time of Event</label>
            <input type="time" name="start_time" id="start_time" class="form-control"
                placeholder="Starting Time of Event"
                value="{{ isset($event) ? old('start_time', $event->start_time) : old('start_time') }}" />
            @error('start_time')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-outline mb-4">
            <label class="form-label" for="form7Example2">Ending Time of Event</label>
            <input type="time" name="end_time" id="end_time" class="form-control" placeholder="Ending Time of Event"
                value="{{ isset($event) ? old('end_time', $event->end_time) : old('end_time') }}">
            @error('end_time')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-outline mb-4">
            <label class="form-label" for="form7Example2">Ticket Amount</label>
            <input type="number" step="any" name="ticket" id="ticket" class="form-control"
                placeholder="Ticket Amount" value="{{ isset($event) ? old('ticket', $event->ticket) : old('ticket') }}">

            @error('ticket')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-outline mb-4">
            <label class="form-label" for="form7Example2">Event Banner</label>
            <input type="file" accept="image/png, image/jpeg, image/jpg" width="48" height="48"
                name="banner" id="banner" class="form-control" />
            @error('banner')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        {{-- status --}}
        {{-- {{dd($event->toArray())}} --}}
        @if (request()->route()->getName() == 'admin.event.edit')
            <div class="form-group">
                <label class="form-label" for="form7Example2">Event Status</label>
                <select class="form-control form-select-lg" aria-label="Default select example" name="is_approved"
                    id="is_approved">

                    {{-- {{dd($cities)}} --}}

                    <option value="0"
                        @if (isset($event)) {{ $event->is_approved == '0 ' ? 'selected' : '' }} @endif>
                        Pending
                    </option>
                    <option value="1"
                        @if (isset($event)) {{ $event->is_approved == '1' ? 'selected' : '' }} @endif>
                        Approved</option>
                </select>
                @error('is_approved')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        @endif

        @if (request()->route()->getName() == 'company.event.edit')
        @foreach ($event->media as $item)
            <label class="form-label" for="form7Example2">Event Banner</label>
            <img src="{{ asset('storage/banner/' . $item['filename'] . '.' . $item['extension']) }}"
                class="card-img-top mb-5" alt="Hollywood Sign on The Hill" height="233px" />
        @endforeach
    @endif

        @if (request()->route()->getName() == 'company.event.create')
            <button type="submit" class="btn btn-primary mb-5">Add Event</button>
        @else
            <button type="submit" class="btn btn-primary mb-5">Update Event</button>
        @endif

       

        </form>

        
    </div>

@endsection
