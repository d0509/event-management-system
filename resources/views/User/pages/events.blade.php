@extends('User.pages.dashboard')
@section('title', 'Events')
@section('events')
    <div class="container">
        <div class="card-columns">
            @foreach ($events as $event)
            {{-- {{dd($event->company)}} --}}
            {{-- {{dd($event->toArray())}} --}}
                {{-- {{ dd($event->media->toArray()) }} --}}
                <div class="card">
                    @foreach ($event->media as $item)
                        <img src="{{ asset('storage/banner/' . $item['filename'] . '.' . $item['extension']) }}"
                            class="card-img-top" alt="Hollywood Sign on The Hill" />
                    @endforeach
                    <div class="card-body">
                        <h5 class="card-title">{{ucwords($event->name)}}</h5>
                        <p class="card-text">
                            <div class="d-flex justify-content-between">
                                <p class="text-dark">City</p>
                                <p class="text-dark">{{ $event->city['name']}}</p>
                            </div>
                            <div class="d-flex justify-content-between">
                                <p class="text-dark">Hosted By</p>
                                <p class="text-dark">{{ $event->company}}</p>
                            </div>
                            <div class="d-flex justify-content-between">
                                <p class="text-dark">Category</p>
                                <p class="text-dark">{{ $event->category['name']}}</p>
                            </div>
                            <div class="d-flex justify-content-between">
                                <p class="text-dark">Description:</p>
                                <p class="text-dark">{{ $event->description}}</p>
                            </div>
                            <div class="d-flex justify-content-between">
                                <p class="text-dark">Total Seat</p>
                                <p class="text-dark">{{ $event->available_seat}}</p>
                            </div>
                            <div class="d-flex justify-content-between">
                                <p class="text-dark">Address:</p>
                                <p class="text-dark">{{ $event->venue}}</p>
                            </div>
                            <div class="d-flex justify-content-between">
                                <p class="text-dark">Date:</p>
                                <p class="text-dark">{{ $event->event_date}}</p>
                            </div>
                            <div class="d-flex justify-content-between">
                                <p class="text-dark">Start Time</p>
                                <p class="text-dark">{{ $event->start_time}}</p>
                            </div>
                            <div class="d-flex justify-content-between">
                                <p class="text-dark">End Time</p>
                                <p class="text-dark">{{ $event->end_time}}</p>
                            </div>
                            <a href="" class="btn btn-primary text-center" >Buy Ticket</a>
                        </p>
                    </div>
                </div>
            @endforeach

        </div>
    </div>

@endsection
