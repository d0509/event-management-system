@extends('user.pages.dashboard')
@section('title', 'Booking History')
@section('user.booking.show')


    <div class="container">
        <div class="card card-cascade narrower">

            <div class="view view-cascade overlay">
                {{-- {{ dd($booking->event->event_date) }} --}}
                {{-- {{dd($booking->event)}} --}}
                <div class="mask rgba-white-slight"></div>
                </a>
            </div>

            <div class="card-body card-body-cascade">


                <h4 class="font-weight-bold card-title">{{ $booking->booking_number }}</h4>
                <div class="row">
                    <p class="col-2 text-dark">Event</p>
                    <p class="col-10 text-dark">{{ $booking->event->name}}</p>
                </div>
                <div class="row">
                    <p class="col-2 text-dark">Event Date</p>
                    <p class="col-10 text-dark">{{ Carbon\Carbon::parse($booking->event->event_date)->format(config('site.date_format')) }}</p>
                </div>
                <div class="row">
                    <p class="col-2 text-dark">Price / Ticket</p>
                    <p class="col-10 text-dark">{{ $booking->ticket_price}}</p>
                </div>
                <div class="row">
                    <p class="col-2 text-dark">No. of ticket</p>
                    <p class="col-10 text-dark">{{ $booking->quantity}}</p>
                </div>
                <div class="row">
                    <p class="col-2 text-dark">Amount</p>
                    <p class="col-10 text-dark">{{ $booking->total}}</p>
                </div>
               
            </div>

            <!-- Card footer -->
            <a href="{{url()->previous()}}" class="card-footer text-muted text-center">
               Back
            </a>

        </div>
    </div>

@endsection
