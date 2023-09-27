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

                <h3 class="mt-5">{{ __('showEvent.details') }}</h3>

                <h4 class="fw-bold mt-2">{{ ucwords($event->name) }}</h4>

                <p class="mt-5">{{ $event->description }}</p>

                <p class="text-dark font-weight-bold">** {{ __('showEvent.note') }} **</p>
                <p class="fs-3 ml-2">{{ __('showEvent.note_msg') }}</p>
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
                            <p class="col-10 text-dark">{{ $event->event_date }}</p>
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
                        {{-- {{ dd(\Carbon\Carbon::parse($event_date)->format('Y-m-d')>= date('Y-m-d')) }} --}}
                        {{-- @if (\Carbon\Carbon::parse($event_date)->format('Y-m-d') >= date('Y-m-d'))
                            @if (\Carbon\Carbon::parse($event_date)->format('Y-m-d') == date('Y-m-d') && $start_time > $currentDateTime && $currentDateTime->diffInMinutes($start_time) > 180)
                                <form id="form1" action="{{ route('book_ticket', ['event' => $event]) }}"
                                    class="booking" method="post">
                                    @csrf
                                    <div>
                                        <label class="form-label"
                                            for="form7Example2">{{ __('showEvent.quantity') }}</label>
                                        <input type="number" name="quantity" id="quantity" class="form-control" />
                                        @error('quantity')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                   
                                    <div class="modal-footer">
                                        <button id="bookTicket" class="btn btn-block btn-primary mt-2"
                                            data-dismiss="modal">{{ __('showEvent.book_ticket') }}</button>
                                    </div>
                                </form>
                            @elseif (
                                $start_time > \Carbon\Carbon::parse(date('H:i:s')) &&
                                    \Carbon\Carbon::parse(date('H:i:s'))->toTimeString()->diffInMinutes($start_time) < 180)
                                <div class="alert alert-danger" role="alert">
                                    <strong>Sorry!</strong> You have to book ticket before 3 hours of starting the event.
                                </div>
                            @elseif(\Carbon\Carbon::parse(date('H:i:s'))->toTimeString()->diffInMinutes($start_time) > 180)
                               
                                <div class="alert alert-success" role="alert">
                                    <strong>Congratulations!</strong> you can book the tickets.
                                </div>
                            @endif
                        @else
                            <div class="alert alert-danger" role="alert">
                                <strong>Sorry!</strong> but you cannot purchase tickets for the event because it occurred on
                                {{ $event->event_date }}.
                            </div>
                        @endif --}}

                        @if (\Carbon\Carbon::parse($event_date)->format('Y-m-d') >= date('Y-m-d') && $start_time > $currentDateTime)
                            <form id="form1" action="{{ route('book_ticket', ['event' => $event]) }}" class="booking"
                                method="post">
                                @csrf
                                <div>
                                    <label class="form-label" for="form7Example2">{{ __('showEvent.quantity') }}</label>
                                    <input type="number" name="quantity" id="quantity" class="form-control" />
                                    @error('quantity')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>


                                <div class="modal-footer">
                                    <button id="bookTicket" class="btn btn-block btn-primary mt-2"
                                        data-dismiss="modal">{{ __('showEvent.book_ticket') }}</button>
                                </div>
                            </form>
                      
                        @endif

                        {{-- {{$event->event_date}} --}}

                        </>
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
