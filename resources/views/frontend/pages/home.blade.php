@extends('frontend.master.layout')
@section('title', 'Events')
@section('content')
    <div class="container">
        <form action="{{ route('send.web-notification') }}" method="post">
            @csrf
            <input type="hidden" name="id" value="{{ Auth::id()}}" />

            <input class="btn btn-primary" type="submit" value="Send Push">
        </form>
        <div class="row ">
            <form action="{{ route('home') }}" method="get" class="mb-5 d-flex ">
                <select class="form-control col-3 ml-2  mr-4 " type="text" id="form3" name="city">
                    <option value="empty"> {{ __('home_select_default_city') }} </option>
                    @forelse ($cities as $city)
                        <option value="{{ $city->id }}" {{ $city_id == $city->id ? 'selected' : '' }}>
                            {{ $city->name }} </option>
                    @empty
                        <option>{{ __('home_no_cities') }}</option>
                    @endforelse
                </select>


                <input type="search" class="form-control col-3" id="form1" name="search"
                    value="{{ request('search') }}" placeholder="search" class="form-control" />

                <button type="submit" class="btn btn-primary ml-2 col-1">
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

@section('contentfooter')

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://www.gstatic.com/firebasejs/6.3.4/firebase.js"></script>
    <script>
        $(document).ready(function() {
            const config = {
                apiKey: "AIzaSyAu2dsRuu3ls4v5Mo9sYcjttjOnJ20PYkI",
                authDomain: "broadcast-notification-56381.firebaseapp.com",
                databaseURL: "https://broadcast-notification-56381.firebaseio.com",
                projectId: "broadcast-notification-56381",
                storageBucket: "broadcast-notification-56381.appspot.com",
                messagingSenderId: "268623408616",
                appId: "1:268623408616:web:fcca741062fec551afc85d"
            };

            firebase.initializeApp(config);
            const messaging = firebase.messaging();

            messaging
                .requestPermission()
                .then(function() {
                    return messaging.getToken()
                })
                .then(function(token) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: '{{ URL::to('/save-device-token') }}',
                        type: 'POST',
                        data: {
                            user_id: {!! json_encode($user_id ?? '') !!},
                            fcm_token: token
                        },
                        dataType: 'JSON',
                        success: function(response) {
                            console.log(response)
                        },
                        error: function(err) {
                            console.log(" Can't do because: " + err);
                        },
                    });
                })
                .catch(function(err) {
                    console.log("Unable to get permission to notify.", err);
                });

            messaging.onMessage(function(payload) {
                console.log('notificstion call');
                const noteTitle = payload.notification.title;
                const noteOptions = {
                    body: payload.notification.body,
                    icon: payload.notification.icon,
                };
                new Notification(noteTitle, noteOptions);
            });
        });
    </script>

@endsection
