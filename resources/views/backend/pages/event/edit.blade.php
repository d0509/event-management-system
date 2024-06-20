@extends('backend.master.layout')
@section('title', 'View Event')
@section('content')
    <section style="background-color: #eee;">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-8 col-xl-8">
                    <div class="card" style="border-radius: 15px;">
                        <div class="bg-image hover-overlay ripple ripple-surface ripple-surface-light"
                            data-mdb-ripple-color="light">
                            @foreach ($event->media as $item)
                                <img src="{{ asset('storage/banner/' . $item['filename'] . '.' . $item['extension']) }}"
                                    style="border-top-left-radius: 15px; border-top-right-radius: 15px;" class="img-fluid text-center"
                                    alt="Laptop" />
                            @endforeach
                            <a href="#!">
                                <div class="mask"></div>
                            </a>
                        </div>
                      <div class="card-body pb-0">
                            <div class="d-flex justify-content-between">
                                <p class="text-dark">Event Name</p>
                                <p class="text-dark">{{ ucwords($event->name) }}</p>
                            </div>
                            <div class="d-flex justify-content-between">
                                <p class="text-dark">Event Description</p>
                                <p class="text-dark">{{ ucwords($event->description) }}</p>
                            </div>
                            <div class="d-flex justify-content-between">
                                <p class="text-dark">Total Seat</p>
                                <p class="text-dark">{{ $event->available_seat }}</p>
                            </div>
                            <div class="d-flex justify-content-between">
                                <p class="text-dark"> Address</p>
                                <p class="text-dark">{{ $event->venue }}</p>
                            </div>
                            <div class="d-flex justify-content-between">
                                <p class="text-dark"> Date</p>
                                <p class="text-dark">{{ Carbon\Carbon::parse($event->event_date)->format(config('site.date_format'))  }}</p>
                            </div>
                            <div class="d-flex justify-content-between">
                                <p class="text-dark">Start Time</p>
                                <p class="text-dark">{{ $event->start_time }}</p>
                            </div>
                            <div class="d-flex justify-content-between">
                                <p class="text-dark">End Time</p>
                                <p class="text-dark">{{ $event->end_time }}</p>
                            </div>
                            <div class="d-flex justify-content-between">
                                <p class="text-dark"> Ticket</p>
                                <p class="text-dark">{{ $event->ticket }}&#8377;</p>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center pb-2 mb-1">
                                <p class="text-dark fw-bold">Change Event Status</p>
                                <form action="{{route('admin.event.update', ['event' => $event])}}" method="post">
                                    @csrf
                                    @method('PATCH')
                                    <select name="is_approved" id="is_approved" class="form-control ">
                                        <option value="0" {{ $event->is_approved == 0 ? 'selected' : '' }}>
                                            Pending
                                        </option>
                                        <option value="1" {{$event->is_approved == 1 ? ' selected' : ''}} >
                                            Approve
                                        </option>
                                    </select>

                                    <button type="submit" class="btn btn-primary mt-5" >Change Status</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
