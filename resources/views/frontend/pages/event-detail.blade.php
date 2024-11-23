@extends('frontend.master.layout')
@section('title', $event->name)
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-8">
                @foreach ($event->media as $item)
                    <img src="{{ asset('storage/banner/' . $item['filename'] . '.' . $item['extension']) }}"
                        style="border-top-left-radius: 15px; border-top-right-radius: 15px;" class="img-fluid text-center"
                        alt="Event fvv" />
                @endforeach

                <h3 class="mt-5">{{ __('event_detail_details') }}</h3>

                <h4 class="fw-bold mt-2">{{ ucwords($event->name) }}</h4>

                <p class="mt-5">{{ $event->description }}</p>

                <p class="text-dark font-weight-bold">** {{ __('event_detail_note') }} **</p>
                <p class="fs-3 ml-2">{{ __('event_detail_note_msg') }}</p>
            </div>
            <div class="col-4">
                <div class="card">
                    <div class="card-body">
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
                            <p class="col-10 text-dark">{{Carbon\Carbon::parse($event->event_date)->format(config('site.date_format'))  }}</p>
                        </div>
                        <div class="row">
                            <p class="col-1 text-dark"><i class="fa-regular fa-clock"></i> </p>
                            <p class="col-10 text-dark">{{ $event->start_time }} - {{ $event->end_time }} </p>
                        </div>
                        @php
                            $event_date = $event->event_date;
                            $start_time = $event->start_time;
                            $currentDateTime = \Carbon\Carbon::now();
                        @endphp
                        @if (\Carbon\Carbon::parse($event_date)->format('Y-m-d') > date('Y-m-d'))
                            <form id="form1" action="{{ route('user.book_ticket', ['event' => $event]) }}" class="booking"
                                method="post">
                                @csrf
                                <div>
                                    <label class="form-label" for="form7Example2">{{ __('event_detail_quantity') }}</label>
                                    <input type="number" name="quantity" id="quantity" class="form-control" />
                                    @error('quantity')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <button class="btn btn-primary mt-2" type="submit">{{ __('event_detail_book_ticket') }}</button>

                            </form>
                        @elseif (\Carbon\Carbon::parse($event_date)->format('Y-m-d') == date('Y-m-d') && $start_time > $currentDateTime)
                            <form id="form1" action="{{ route('user.book_ticket', ['event' => $event]) }}" class="booking"
                                method="post">
                                @csrf
                                <div>
                                    <label class="form-label" for="form7Example2">{{ __('event_detail_quantity') }}</label>
                                    <input type="number" name="quantity" id="quantity" class="form-control" />
                                    @error('quantity')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <button class="btn btn-primary show" type="submit">{{ __('showEvent.book_ticket') }}</button>

                            </form>
                        @endif
                    </div>

                </div>
                <div class="google-map">
                    <iframe class="mt-5" src="{{ $event->location }}" width="450" height="450" style="border:0;"
                        allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>
    </div>

    @endsection
