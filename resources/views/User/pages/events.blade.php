@extends('User.pages.dashboard')
@section('title', 'Events')
@section('events')
    <div class="container">

        <div class="row d-flex">
            <form action="{{ route('home') }}" method="get" class="mb-5 d-flex ">
                <select class="form-control col-3 ml-2  mr-4 " type="text" id="form3" name="city">
                    <option>  </option>
                    @forelse ($cities as $city)
                        <option value="{{ $city->id }}" {{ ( $city_id == $city->id ? 'selected' : '') }} > {{ $city->name }} </option>
                    @empty
                        <option>No cities to show!</option>
                    @endforelse
                </select>

                
                    <input type="search" class="form-control col-3" id="form1" name="search"
                        value="{{ request('search') }}" placeholder="search" class="form-control" />

                    <button type="submit" class="btn btn-primary ml-2">
                        Search
                    </button>
                
            </form>

            {{-- <label class="form-label select-label col-4">Example label</label> --}}
            {{-- <select class="select col-3 border border-primary mb-5 ">
                <option>Please select a city</option>
                @forelse ($cities as $city)
                    <option value="{{ $city->id }}"> {{ $city->name }} </option>
                @empty
                    <option>No cities to show!</option>
                @endforelse
            </select> --}}

        </div>



        <div class="row row-cols-3 g-3">

            @forelse ($events as $event)
                <div class="col">
                    <div class="card">
                        @foreach ($event->media as $item)
                            <img src="{{ asset('storage/banner/' . $item['filename'] . '.' . $item['extension']) }}"
                                class="card-img-top" alt="Hollywood Sign on The Hill" height="233px" />
                        @endforeach

                        <div class="card-body">
                            <u><a href="{{ route('user.event.show', ['event' => $event]) }}"
                                    class="card-title fs-3 text-dark">{{ ucwords($event->name) }}</a></u>
                            <p class="card-text">
                            <div class="row">
                                <p class="col-1 text-dark"><i class="fa-solid fa-city"></i></p>
                                <p class="col-10 text-dark">{{ $event->city->name }}</p>
                            </div>
                            <div class="row">
                                <p class="col-1 text-dark"><i class="fas fa-industry"></i></p>
                                <p class="col-10 text-dark">{{ $event->company->name }}</p>
                            </div>
                            {{-- {{dd((Carbon\Carbon::parse($event->event_date)->toDateString())> ('2023-10-19'))}}
                            {{dd(Carbon\Carbon::parse($event->event_date)->toDateString())}} --}}
                            {{-- <div class="d-flex justify-content-between">
                            <p class="text-dark">Category</p>
                            <p class="text-dark">{{ $event->category->name}}</p>
                        </div> --}}
                            {{-- <div class="d-flex justify-content-between">
                            <p class="text-dark">Description:</p>
                            <p class="text-dark">{{ $event->description}}</p>
                        </div> --}}

                            {{-- company relation not working --}}
                            <div class="row">
                                <p class="col-1 text-dark"><i class="fas fa-chair"></i></p>
                                <p class="col-10 text-dark">{{ $event->available_seat }}</p>
                            </div>
                            <div class="row">
                                <p class="col-1 text-dark"><i class="fa-solid fa-location-dot"></i></p>
                                <p class="col-10 text-dark">{{ $event->venue }}</p>
                            </div>
                            <div class="row">
                                <p class="col-1 text-dark"><i class="fa-solid fa-calendar-days"></i></p>
                                <p class="col-10 text-dark">{{ Carbon\Carbon::parse($event->event_date)->format(config('site.date_format')) }}</p>
                            </div>
                            <div class="row">
                                <p class="col-1 text-dark"><i class="fa-regular fa-clock"></i> </p>
                                <p class="col-10 text-dark">{{ Carbon\Carbon::parse($event->start_time)->format(config('site.time_format')) }} - {{ Carbon\Carbon::parse($event->end_time)->format(config('site.time_format')) }} </p>
                            </div>
                        </div>


                    </div>

                </div>
            @empty
                <p class="fs-3 text-center">No events to show!</p>
            @endforelse
            {{-- {{dd($events[0]->toArray())}} --}}

        </div>
    </div>

@endsection
