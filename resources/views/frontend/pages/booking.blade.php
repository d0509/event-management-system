@extends('frontend.master.layout')
@section('title', 'Booking History')
@section('content')
    <div class="container">
        <div class="card card-cascade narrower">
            <div class="view view-cascade overlay">
                <div class="mask rgba-white-slight"></div>
            </div>
            <div class="card-body card-body-cascade">
                <h4 class="font-weight-bold card-title">{{ $booking->booking_number }}</h4>
                <div class="row">
                    <p class="col-2 text-dark"> {{ __('booking_event') }} </p>
                    <p class="col-10 text-dark">{{ ucwords($booking->event->name) }}</p>
                </div>
                <div class="row">
                    <p class="col-2 text-dark"> {{ __('booking_event_date') }} </p>
                    <p class="col-10 text-dark">
                        {{ Carbon\Carbon::parse($booking->event->event_date)->format(config('site.date_format')) }}</p>
                </div>
                <div class="row">
                    <p class="col-2 text-dark"> {{ __('booking_price_per_ticket') }} </p>
                    <p class="col-10 text-dark">{{ $booking->ticket_price }}</p>
                </div>
                <div class="row">
                    <p class="col-2 text-dark"> {{ __('booking_no_of_ticket') }} </p>
                    <p class="col-10 text-dark">{{ $booking->quantity }}</p>
                </div>
                <div class="row">
                    <p class="col-2 text-dark"> {{ __('booking_amount') }} </p>
                    <p class="col-10 text-dark">{{ $booking->total }}</p>
                </div>
            </div>
            <!-- Card footer -->
            <a href="{{ url()->previous() }}" class="card-footer text-muted text-center">
                {{ __('booking_back') }}
            </a>
        </div>
    </div>
@endsection
