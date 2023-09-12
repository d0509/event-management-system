@extends('User.pages.dashboard')
@section('title', 'Add Event')
@section('createEvent')
    <div class="container">
        {{-- {{ dd($event->toArray()) }} --}}
        <h1 class="text-center fw-bold  ">Add Event</h1>
        {{-- {{dd(67)}} --}}
        @if (request()->route()->getName() == 'event.create')
            <form action="{{ route('event.store') }}" method="post" enctype="multipart/form-data" class="mt-5 mb-5">
            @elseif(request()->route()->getName() == 'event.edit')
                <form action="{{ route('event.update', ['event' => $event]) }}" method="post" enctype="multipart/form-data"
                    class="mt-5 mb-5">
        @endif
        @csrf
        @if (request()->route()->getName() == 'event.edit')
            @method('PATCH')
        @endif
        <!-- Name input -->
        <div class="form-outline mb-4">
            <label class="form-label" for="form7Example1">Event Name</label>
            <input type="text" name="name" id="name" class="form-control" placeholder="Enter event name"
                @if (isset($event)) value="{{ old('name', $event->name) }}">
                 @else
                value="{{ old('name') }}"> @endif
                @error('name')
                <span class="text-danger">{{ $message }}</span>
            @enderror
                </div>

            <div class="form-outline mb-4">
                <label class="form-label" for="form7Example2">Description</label>
                <textarea {{ old('description') }} name="description" id="description" class="form-control" placeholder="Description">
                @if (isset($event))
{{ old('name', $event->description) }}
@else
{{ old('description') }}
@endif
            
            </textarea>
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
                    @if (isset($event)) value="{{ old('available_seat', $event->available_seat) }}" >
                    {{-- {{ dd($event->toArray()) }} --}}
                 @else
                    value="{{ old('available_seat') }}" > @endif
                    @error('available_seat')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
                    </div>


                <div class="form-outline mb-4">
                    <label class="form-label" for="form7Example2">Event Address</label>
                    <input type="text" name="venue" id="venue" class="form-control" placeholder="Event Address"
                        @if (isset($event)) value="{{ old('venue', $event->venue) }}"
                 @else
               value="{{ old('venue') }}" @endif>
                    @error('venue')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                {{-- categories --}}
                <div class="form-outline mb-4">
                    <label class="form-label" for="form7Example2">Event Category</label>
                    <select name="category_id" id="category_id" value="{{ old('category_id') }}"
                        class="form-control form-select-lg">
                        <option selected>Please select a Category</option>
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
                        <option>Please select a city</option>
                        @foreach ($cities as $city)
                            <option
                                @if (isset($event)) {{ $city->id == $event->city_id ? 'selected' : '' }} @endif
                                class="">{{ $city->name }}</option>
                        @endforeach
                    </select>
                    @error('city_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-outline mb-4">
                    <label class="form-label" for="form7Example2">Starting Time of Event</label>
                    <input type="date" name="event_date" id="event_date" class="form-control"
                        placeholder="Starting Time of Event"
                        @if (isset($event)) value="{{ old('event_date', $event->event_date) }}">
                    @else
                   value="{{ old('event_date') }}"> @endif
                        @error('event_date')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
                        </div>

                    {{-- start_time --}}
                    <div class="form-outline mb-4">
                        <label class="form-label" for="form7Example2">Starting Time of Event</label>
                        <input type="time" name="start_time" id="start_time" class="form-control"
                            placeholder="Starting Time of Event"
                            @if (isset($event)) value="{{ old('start_time', $event->start_time) }}">
                    @else
                   value="{{ old('start_time') }}"> @endif
                            @error('start_time')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
                            </div>

                        <div class="form-outline mb-4">
                            <label class="form-label" for="form7Example2">Ending Time of Event</label>
                            <input type="time" name="end_time" id="end_time" class="form-control"
                                placeholder="Ending Time of Event"
                                @if (isset($event)) value="{{ old('end_time', $event->end_time) }}">
                    @else
                   value="{{ old('end_time') }}"> @endif
                                @error('end_time')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
                                </div>

                            <div class="form-outline mb-4">
                                <label class="form-label" for="form7Example2">Ticket Amount</label>
                                <input type="number" step="any" name="ticket" id="ticket" class="form-control"
                                    placeholder="Ticket Amount" value="{{isset($event) ? old('ticket', $event->ticket) :  old('ticket')}}">
                                    
                                    @error('ticket')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
                                    </div>

                                <div class="form-outline mb-4">
                                    <label class="form-label" for="form7Example2">Event Banner</label>
                                    <input type="file" accept="image/png, image/jpeg, image/jpg" width="48"
                                        height="48" name="banner" id="banner" class="form-control" />
                                    @error('banner')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>



                                <button type="submit" class="btn btn-primary mb-5">Add Event</button>

                                </form>

                                @if (request()->route()->getName() == 'event.edit')
                                    @foreach ($event->media as $item)
                                        <label class="form-label" for="form7Example2">Event Banner</label>
                                        <img src="{{ asset('storage/banner/' . $item['filename'] . '.' . $item['extension']) }}"
                                            class="card-img-top mb-5" alt="Hollywood Sign on The Hill" />
                                    @endforeach
                                @endif
                            </div>

                        @endsection
