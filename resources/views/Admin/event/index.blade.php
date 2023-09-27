@extends('admin.pages.dashboard')
@section('title', 'Events')
@section('admin.event.index')

    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Events</h1>
            
        </div>
        <div class="row row-cols-3 g-3">

            @foreach ($events as $event)
                <div class="col">
                    <div class="card">
                        @foreach ($event->media as $item)
                            <img src="{{ asset('storage/banner/' . $item['filename'] . '.' . $item['extension']) }}"
                                class="card-img-top" alt="Hollywood Sign on The Hill" height="233px" />
                        @endforeach

                        <div class="card-body">
                            <h5 class="card-title">{{ ucwords($event->name) }}</h5>
                            <p class="card-text">
                            <p>{{ ucwords($event->description) }}</p>
                            <p>Event Status: {{ $event->is_approved == 1 ? 'Approved' : 'Pending' }}</p>
                            </p>
                            <a href="{{ route('admin.event.edit', ['event' => $event]) }}" class="btn btn-primary">View</a>

                            {{-- <button type="button" class="btn btn-danger" data-target="#deleteModal"
                            data-toggle="modal">Delete</button> --}}
                        </div>


                    </div>

                </div>
            @endforeach
            {{-- {{dd($events[0]->toArray())}} --}}

        </div>

    </div>
@endsection
