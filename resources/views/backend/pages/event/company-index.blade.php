@extends('backend.master.layout')
@section('title', 'Events')
@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')

    <body>
        <div class="container-fluid">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Events</h1>
                @if (Auth::user()->role_id == config('site.roles.company'))
                    <a href="{{ route('company.event.create') }}"
                        class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                            class="fa-solid fa-user-plus mr-2"></i>Create Event</a>
                @endif

            </div>
            <table class="table" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Sr. No.</th>
                        @if (Auth::user()->role_id == config('site.roles.admin'))
                            <th>Status</th>
                        @endif
                        <th> Name</th>
                        @if (Auth::user()->role_id == config('site.roles.admin'))
                            <th>Company</th>
                        @endif
                        <th>City</th>
                        <th>Category</th>
                        {{-- <th>Description</th> --}}
                        <th>Available Seat</th>
                        <th>Venue</th>
                        <th>Date</th>
                        <th>From</th>
                        <th>To</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
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

                var currentURL = window.location.href;

                var companyURL = "{{ route('company.event.index') }}";
                if (currentURL == companyURL) {
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
                            // {
                            //     data: 'description',
                            //     name: "description",
                            //     orderable: false,
                            // },
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
                                orderable: false,
                            },
                            {
                                data: 'start_time',
                                name: 'start_time',
                                orderable: false,
                            },
                            {
                                data: 'end_time',
                                name: 'end_time',
                                orderable: false,
                            },
                            {
                                data: 'action',
                                name: 'action',
                                searchable: false,
                                orderable: false,
                            }
                        ],

                    });


                } else {


                    $(function() {
                        var table = $('#dataTable').DataTable({
                            processing: true,
                            serverSide: true,
                            ajax: "{{ route('admin.event.index') }}",
                            order: [
                                [1, 'desc']
                            ],
                            columns: [{
                                    data: 'DT_RowIndex',
                                    name: 'DT_RowIndex',
                                    orderable: false,
                                    searchable: false
                                },
                                {
                                    data: 'is_approved',
                                    name: 'is_approved',
                                    orderable: true,
                                },
                                {
                                    data: 'name',
                                    name: 'name',
                                    orderable: true,
                                },
                                {
                                    data: 'company.name',
                                    name: 'company.name',
                                    orderable: true,
                                    searchable: true,
                                },
                                {
                                    data: 'city.name',
                                    name: 'city.name',
                                    orderable: true,
                                },
                                {
                                    data: 'category.name',
                                    name: 'category.name',
                                    orderable: true,
                                },
                                {
                                    data: 'description',
                                    name: 'description',
                                    orderable: false,
                                    searchable: true,
                                },
                                {
                                    data: 'available_seat',
                                    name: 'available_seat',
                                    orderable: true,
                                },
                                {
                                    data: 'venue',
                                    name: 'venue',
                                    orderable: true,
                                },
                                {
                                    data: 'event_date',
                                    name: 'event_date',
                                    orderable: false,
                                    searchable: false,
                                },
                                {
                                    data: 'start_time',
                                    name: 'start_time',
                                    orderable: false,
                                },
                                {
                                    data: 'end_time',
                                    name: 'end_time',
                                    orderable: false,
                                },
                                {
                                    data: 'action',
                                    name: 'action',
                                    searchable: false,
                                    orderable: false
                                }
                            ]

                        });
                        table.columns([3]).search('').draw();
                    });

                }

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
            });
        </script>

    </body>


@endsection
@push('myScript')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.17/dist/sweetalert2.all.min.js"></script>
@endpush
