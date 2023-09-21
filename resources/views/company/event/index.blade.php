@extends('admin.pages.dashboard')
@section('title', 'Events')
@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('event.index')

    <body>
        <div class="container">
            <div class="row row-cols-3 g-3">

                @foreach ($events as $event)
                    <div class="col">
                        <div class="card" id="event{{ $event->id }}">
                            @foreach ($event->media as $item)
                                <img src="{{ asset('storage/banner/' . $item['filename'] . '.' . $item['extension']) }}"
                                    class="card-img-top" alt="Hollywood Sign on The Hill" />
                            @endforeach

                            <div class="card-body">
                                {{ $event->id }}
                                <h5 class="card-title">{{ $event->name }}</h5>
                                <p class="card-text">
                                    {{ ucwords($event->description) }}
                                </p>
                                <a href="{{ route('event.edit', ['event' => $event]) }}" class="btn btn-primary">Edit</a>

                                <button type="button" class="btn btn-danger deleteEvent" data-eventId="{{ $event->id }}"
                                    data-target="#deleteModal" data-toggle="modal">Delete</button>
                            </div>
                        </div>

                    </div>
                @endforeach

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
                        <button type="submit" data-dismiss="modal" class="btn btn-danger deletefinal">Yes</button>

                    </div>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function() {
                $(document).on('click', '.deleteEvent', function(e) {

                    e.preventDefault();

                    var id = $(this).attr("data-eventId");
                    console.log(id);
                    var url = "{{ route('event.destroy', ':id') }}";
                    url = url.replace(':id', id);
                    var token = "{{ csrf_token() }}";
                    $(document).on('click', ".deletefinal", function() {
                        $.ajax({
                            url: url,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },

                            type: 'DELETE',
                            dataType: "JSON",
                            data: {
                                id: id,
                                "_token": "{{ csrf_token() }}",
                                // "id": id,
                                // "_method": 'DELETE',
                                // "_token": token,
                            },
                            success: function() {
                                console.log('event deleted successfully');
                                $("#event" + id).parent().addClass("d-none");
                                // window.location.href = "{{ route('event.index') }}";
                            }
                        });
                    });
                    // session() - > flash('danger', 'There are some issues in deleting event');

                });
            });
        </script>

    </body>

@endsection
