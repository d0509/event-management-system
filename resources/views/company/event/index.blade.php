@extends('admin.pages.dashboard')
@section('title', 'Events')
@section('event.index')

{{-- {{dd($events->toArray())}} --}}
    {{-- {{dd($events->toArray())}} --}}
    <div class="container">
        <div class="row row-cols-3 g-3">
            {{-- {{dd($events->getAllMediaByTag())}} --}}
            @foreach ($events as $event)
                {{-- {{dd($event->toArray())}} --}}
                {{-- @foreach ($event->media as $item)
                    {{ dd($item['filename']) }}
                @endforeach --}}
                <div class="col">
                    <div class="card">
                        @foreach ($event->media as $item)
                            <img src="{{ asset('storage/banner/' . $item['filename'] . '.' . $item['extension']) }}"
                                class="card-img-top" alt="Hollywood Sign on The Hill" />
                        @endforeach

                        <div class="card-body">
                            <h5 class="card-title">{{ $event->name }}</h5>
                            <p class="card-text">
                                {{ ucwords($event->description) }}
                            </p>
                            <a href="{{route('event.edit',['event' => $event])}}" class="btn btn-primary">Edit</a>
                            {{-- <a href="#" class="btn btn-danger">Delete</a> --}}
                            <button type="button" class="btn btn-danger" data-target="#deleteModal"
                                data-toggle="modal">Delete</button>
                        </div>
                    </div>
                    <div class="modal fade" id="deleteModal">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Verify Deletion</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p>Are you sure you want to delete?</p>
                                </div>
                                <div class="modal-footer">
                                    <a type="button" class="btn btn-primary" id="close-modal" data-dismiss="modal">No</a>
                                    <form action="{{ route('event.destroy', ['event' => $event]) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Yes</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
    @endsection
    {{-- {{dd($events[0]->media->toArray())}} --}}
