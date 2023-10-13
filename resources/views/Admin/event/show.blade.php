@extends('admin.pages.dashboard')
@section('title', 'Event Show')
@section('admin.event.show')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Event</h1>
        </div>

        <div class="card mb-3 mx-auto" style="max-width: 1080px;">
            <div class="row g-0">
                <div class="col-md-7">
                    {{-- {{dd($event)}} --}}
                    @forelse ($event->media as $media)
                        <img src="{{ asset('storage/banner/' . $media['filename'] . '.' . $media['extension']) }}"
                            alt="Event Banner" width="540px">
                    @empty
                        <p>No banner exists for the event</p>
                    @endforelse

                </div>
                <div class="col-md-5 ">
                    <div class="card-body">
                        <h5 class="card-title">{{ $event->name }}</h5>
                        <div class="row">
                            <p class="col-1 text-dark"><i class="fas fa-city"></i></p>
                            <p class="col-10 text-dark">{{ $event->city->name }}</p>
                        </div>
                        <div class="row">
                            <p class="col-1 text-dark"><i class="fas fa-briefcase"></i></p>
                            <p class="col-10 text-dark">{{ $event->company->name }}</p>
                        </div>
                        <div class="row">
                            <p class="col-1 text-dark"><i class="fas fa-tags"></i></p>
                            <p class="col-10 text-dark">{{ ucwords($event->category->name) }}</p>
                        </div>
                        <div class="row">
                            <p class="col-1 text-dark"><i class="fas fa-book-open"></i></p>
                            <p class="col-10 text-dark">{{ ucwords($event->description) }}</p>
                        </div>

                        <div class="row">
                            <p class="col-1 text-dark"><i class="fas fa-map-marker-alt"></i></p>
                            <p class="col-10 text-dark">{{ ucwords($event->venue) }}</p>
                        </div>
                        <div class="row">
                            <p class="col-1 text-dark"><i class="fas fa-calendar"></i></p>
                            <p class="col-10 text-dark">
                                {{ Carbon\Carbon::parse($event->event_date)->format(config('site.date_format')) }}</p>
                        </div>
                        <div class="row">
                            <p class="col-1 text-dark"><i class="fas fa-stopwatch"></i></p>
                            <p class="col-10 text-dark">
                                {{ Carbon\Carbon::parse($event->start_time)->format(config('site.time_format')) }} -
                                {{ Carbon\Carbon::parse($event->end_time)->format(config('site.time_format')) }} </p>
                        </div>
                        <div class="row">
                            <p class="col-1 text-dark"><i class="fas fa-film"></i></p>
                            <p class="col-10 text-dark">
                                {{ $event->ticket }} <i class="fas fa-indian-rupee-sign"></i> </p>
                        </div>
                        <div class="row">
                            <p class="col-1 text-dark"><i class="fa-solid fa-check"></i></p>
                            <p class="col-10 text-dark">
                                {{ $event->is_approved == 1 ? 'Approved' : 'Pending' }} </p>
                        </div>
                        <a class="btn btn-primary btn-block" href="{{ url()->previous() }}"> Back </a>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
