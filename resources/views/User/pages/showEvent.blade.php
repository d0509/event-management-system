@extends('user.pages.dashboard')
@section('title', $event->name)
@section('showEvent')
    <div class="container">
        <div class="row">
            <div class="col-8">
                @foreach ($event->media as $item)
                    <img src="{{ asset('storage/banner/' . $item['filename'] . '.' . $item['extension']) }}"
                        style="border-top-left-radius: 15px; border-top-right-radius: 15px;" class="img-fluid text-center"
                        alt="Event fvv" />
                @endforeach

                <h3 class="mt-5">Details</h3>

                <h4 class="fw-bold mt-2">{{ ucwords($event->name) }}</h4>

                <p class="mt-5">{{ $event->description }}</p>

                <p class="text-dark font-weight-bold">**NOTE**</p>
                <p class="fs-3 ml-2">Kindly be informed that to participate in the event, a ticket purchase is required.
                    Please note that clicking on the RSVP button alone will not confirm your attendance.</p>
            </div>
            <div class="col-4">
                <div class="card">
                    <div class="card-body">

                        < class="card-text">
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
                            <p class="col-10 text-dark">{{ $event->event_date }}</p>
                        </div>
                        <div class="row">
                            <p class="col-1 text-dark"><i class="fa-regular fa-clock"></i> </p>
                            <p class="col-10 text-dark">{{ $event->start_time }} - {{ $event->end_time }} </p>
                        </div>
                        
                        <button type="button" class="btn btn-primary">Book A Ticket</button>
                    </div>
                </div>
                <div class="google-map">
                    {{-- {{dd($event->location)}} --}}
                    <iframe class="mt-5" src="{{ $event->location }}" width="450" height="450" style="border:0;"
                        allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>
    </div>

@endsection
