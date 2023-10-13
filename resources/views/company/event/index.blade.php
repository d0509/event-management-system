@extends('admin.pages.dashboard')
@section('title', 'Events')
@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('company.event.index')

    <body>
        <div class="container-fluid">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Events</h1>
            <a href="{{route('company.event.create')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fa-solid fa-user-plus mr-2"></i>Create Event</a>

            </div>
            <table class="table" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Sr. No.</th>
                        <th> Name</th>
                        <th>City</th>
                        <th>Category</th>
                        <th>Description</th>
                        <th>Available Seat</th>
                        <th>Venue</th>
                        <th>Date</th>
                        <th>From</th>
                        <th>To</th>
                        {{-- <th>Free Event?</th> --}}
                        {{-- <th>Ticket</th> --}}
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>

            {{-- <div class="row row-cols-3 g-3">

                @foreach ($events as $event)
                    <div class="col">
                        <div class="card" id="event{{ $event->id }}">
                            @foreach ($event->media as $item)
                                <img src="{{ asset('storage/banner/' . $item['filename'] . '.' . $item['extension']) }}"
                                    class="card-img-top" alt="Hollywood Sign on The Hill" height="233px" />
                            @endforeach

                            <div class="card-body">
                                
                                <h5 class="card-title">{{ $event->name }}</h5>
                                <p class="card-text">
                                    {{ ucwords($event->description) }}
                                </p>
                                <a href="{{ route('company.event.edit', ['event' => $event]) }}" class="btn btn-primary">Edit</a>

                                <button type="button" class="btn btn-danger deleteEvent" data-eventId="{{ $event->id }}"
                                    data-target="#deleteModal" data-toggle="modal">Delete</button>
                            </div>
                        </div>

                    </div>
                @endforeach

            </div> --}}
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
             

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $(document).ready(function() {
                    var table = $('#dataTable').DataTable({

                        processing: true,
                        serverSide: true,
                        order: [
                            [1, 'desc']
                        ],
                        ajax: {
                            'type': 'GET',
                            url: "{{ route('company.event.index') }}",
                            dataType: "JSON",
                        },
                        columns: [{
                                data: 'DT_RowIndex',
                                name: 'DT_RowIndex',
                                orderable: false,
                                searchable: false
                            },
                            {
                                data: 'name',
                                name: 'name'
                            },
                            {
                                data: 'city.name',
                                name: 'city.name',
                               
                            },
                            {
                                data: 'category.name',
                                name: 'category.name',
                            },
                            {
                                data: 'description',
                                name: "description",
                                orderable: false,
                            },
                            {
                                data: 'available_seat',
                                name: 'available_seat',
                            },
                            {
                                data: 'venue',
                                name: 'venue',
                            },
                            {
                                data: 'event_date',
                                name: 'event_date',
                                orderable:false,
                            },
                            {
                                data: 'start_time',
                                name: 'start_time',
                                orderable:false,
                            },
                            {
                                data: 'end_time',
                                name: 'end_time',
                                orderable:false,
                            },
                            // {
                            //     data: 'is_free',
                            //     name: 'is_free',
                            //     render: function(data, type, full, meta) {
                            //         return data ? "Yes" : "No";
                            //     }
                            // },
                            // {
                            //     data: 'ticket',
                            //     name: 'ticket'
                            // },
                            {
                                data: 'action',
                                name:'action',
                                searchable:false,
                                orderable:false,
                            }
                        ],

                    });

                });

            });

            function deleteEvent(id) {
                var id = id;
                // alert(id);
                var url = "{{ route('company.event.destroy', ':id') }}";
                url = url.replace(':id', id);
                // alert(url);
                var token = "{{ csrf_token() }}";
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to delete this inquiry?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: url,
                            type: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            dataType: "JSON",
                            data: {
                                id: id,
                                "_token": "{{ csrf_token() }}",

                            },
                            success: function() {
                                console.log('deleted successfully');

                                $('#dataTable').DataTable().ajax.reload();
                            }
                        });
                    }

                })
            }

 
        </script>

    </body>


@endsection
@push('myScript')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.17/dist/sweetalert2.all.min.js"></script>
@endpush