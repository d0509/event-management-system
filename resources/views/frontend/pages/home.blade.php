@extends('frontend.master.layout')
@section('title', 'Events')
@section('content')
    <div class="container">

        <div class="row d-flex">
            <form action="{{ route('home') }}" method="get" class="mb-5 d-flex ">
                <select class="form-control col-3 ml-2  mr-4 " type="text" id="form3" name="city">
                    <option> </option>
                    @forelse ($cities as $city)
                        <option value="{{ $city->id }}" {{ $city_id == $city->id ? 'selected' : '' }}>
                            {{ $city->name }} </option>
                    @empty
                        <option>{{ __('home_no_cities') }}</option>
                    @endforelse
                </select>


                <input type="search" class="form-control col-3" id="form1" name="search"
                    value="{{ request('search') }}" placeholder="search" class="form-control" />

                <button type="submit" class="btn btn-primary">
                    {{ __('home_search') }}
                </button>
            </form>
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
                                <p class="col-10 text-dark">
                                    {{ Carbon\Carbon::parse($event->event_date)->format(config('site.date_format')) }}</p>
                            </div>
                            <div class="row">
                                <p class="col-1 text-dark"><i class="fa-regular fa-clock"></i> </p>
                                <p class="col-10 text-dark">{{ $event->start_time }} - {{ $event->end_time }} </p>
                            </div>
                        </div>


                    </div>

                </div>
            @empty
                <p class="fs-3 text-center"> {{ __('home_no_events') }} </p>
            @endforelse
        </div>
    </div>

@endsection
