@extends('backend.master.layout')
@section('title', 'Events')
@section('content')

<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Events</h1>
    </div>
        <table class="table " id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>Sr. No.</th>
                    <th>Status</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Company</th>
                    <th>City</th>
                    <th>Description</th>
                    <th>Available Seat</th>
                    <th>Venue</th>
                    <th>Date</th>
                    <th>Start time</th>
                    <th>Is Free?</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
            </tbody>
        </table>

    </div>

    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
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
                            data: 'category.name',
                            name: 'category.name',
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
                            data: 'is_free',
                            name: 'is_free',
                            render: function(data, type, full, meta) {
                                return data ? "Yes" : "No";
                            }
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

            $(document).on('click', '#flexSwitchCheckChecked', function(e) {
                e.preventDefault();
                var id = $(this).attr('data-eventId');
                var url = "{{ route('admin.event.status') }}";
                // url = url.replace(':id', id);
                var token = "{{ csrf_token() }}";

                $.ajax({
                    url: url,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    data: {
                        id: id,
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function() {
                        console.log('updated successfuly');
                        $('#dataTable').DataTable().ajax.reload();
                    }
                });

            });
        });
    </script>
@endsection
