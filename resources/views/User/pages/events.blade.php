@extends('User.pages.dashboard')
@section('title', 'Events')
@section('events')
    <div class="container">
        <div class="card-columns">
            @if ($events)
                @foreach ($events as $event)
                    {{-- {{ dd($event->company->name) }} --}}
                    {{-- {{dd($event->toArray())}} --}}
                    {{-- {{ dd($event->media->toArray()) }} --}}
                    <div class="card">

                        @foreach ($event->media as $item)
                            <img src="{{ asset('storage/banner/' . $item['filename'] . '.' . $item['extension']) }}"
                                class="card-img-top" alt="Hollywood Sign on The Hill" />
                        @endforeach
                        <div class="card-body">
                            <u><a href="{{route('user.event.show',['event' => $event])}}" class="card-title display-5 text-dark">{{ ucwords($event->name) }}</a></u>
                            <p class="card-text">
                            <div class="d-flex justify-content-between">
                                <p class="text-dark"><i class="fa-solid fa-city"></i></p>
                                <p class="text-dark">{{ $event->city->name }}</p>   
                            </div>
                            <div class="d-flex justify-content-between">
                                <p class="text-dark"><i class="fas fa-industry"></i></p>
                                <p class="text-dark">{{ $event->company->name }}</p>
                            </div>
                            {{-- <div class="d-flex justify-content-between">
                            <p class="text-dark">Category</p>
                            <p class="text-dark">{{ $event->category->name}}</p>
                        </div> --}}
                            {{-- <div class="d-flex justify-content-between">
                            <p class="text-dark">Description:</p>
                            <p class="text-dark">{{ $event->description}}</p>
                        </div> --}}

                            {{-- company relation not working --}}
                            <div class="d-flex justify-content-between">
                                <p class="text-dark"><i class="fas fa-chair"></i></p>
                                <p class="text-dark">{{ $event->available_seat }}</p>
                            </div>
                            <div class="d-flex justify-content-between">
                                <p class="text-dark"><i class="fa-solid fa-location-dot"></i></p>
                                <p class="text-dark">{{ $event->venue }}</p>
                            </div>
                            <div class="d-flex justify-content-between">
                                <p class="text-dark"><i class="fa-solid fa-calendar-days"></i></p>
                                <p class="text-dark">{{ $event->event_date }}</p>
                            </div>
                            <div class="d-flex justify-content-between">
                                <p class="text-dark"><i class="fa-regular fa-clock"></i> </p>
                                <p class="text-dark">{{ $event->start_time }} - {{ $event->end_time }} </p>
                            </div>

                            {{-- <a href="" class="btn btn-primary text-center">Buy Ticket</a> --}}
                            </p>
                        </div>
                    </div>
                @endforeach
            @else
                <h1>Sorry, No events found at this moment!</h1>
            @endif


        </div>
    </div>

@endsection
