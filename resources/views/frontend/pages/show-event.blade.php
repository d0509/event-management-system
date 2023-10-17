@extends('user.pages.dashboard')
@section('title', $event->name)
@section('showEvent')

    <div class="container">
        <div class="row">
            <div class="col-8">
                @foreach ($event->media as $item)
                    <img src="{{ asset('storage/banner/' . $item['filename'] . '.' . $item['extension']) }}"
                        style="border-radius: 15px; height: 500px; " class="img-fluid text-center" alt="Event fvv" />
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
                            <p class="col-10 text-dark">
                                {{ Carbon\Carbon::parse($event->event_date)->format(config('site.date_format')) }}</p>
                        </div>
                        <div class="row">
                            <p class="col-1 text-dark"><i class="fa-regular fa-clock"></i> </p>
                            <p class="col-10 text-dark">{{ $event->start_time }} - {{ $event->end_time }} </p>
                        </div>
                        @php
                            $event_date = $event->event_date;
                            $start_time = $event->start_time;
                            $currentTime = \Carbon\Carbon::now()->toTimeString();
                        @endphp
                        @if (\Carbon\Carbon::parse($event_date)->format('Y-m-d') == date('Y-m-d') && $start_time < $currentTime)
                        @else
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
                                @auth
                                    <button class="btn btn-primary show mt-2"
                                        type="submit">{{ __('showEvent.book_ticket') }}</button>
                                @endauth
                                @guest
                                Please <a href="{{route('login')}}"> Login </a>,after you are able to book the event.
                                @endguest

                            </form>
                        @endif



                        {{-- {{$event->event_date}} --}}


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
