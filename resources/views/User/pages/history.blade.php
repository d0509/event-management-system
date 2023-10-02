@extends('User.pages.dashboard')
{{-- @extends('layouts.userlayout') --}}
@section('title', 'User Booking History')
@section('user.booking.history')
    <div class="container mt-5">
        <table class="table table-primary" id="data-table">
            <thead>
                <tr>
                    <th>Sr. No</th>
                    <th>Event Name</th>
                    <th>Booking Number</th>
                    <th>Attended or not</th>
                    <th>Event Type</th>
                    <th>No. of tickets booked</th>
                    <th>Price per ticket</th>
                    <th>Sub total</th>
                    <th>Discount</th>
                    <th>Total</th>
                    <th>Type of Booking</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>

    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(document).ready(function() {
            var table = $('#data-table').DataTable({
               
                processing: true,
                serverSide: true,
                ajax: {
                    'type': 'GET',
                    url: "{{ route('user.booking.index') }}",
                    dataType: "JSON",
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'event_id',
                        name: 'event_id',
                        orderable: false,
                    },
                    {
                        data: 'booking_number',
                        name: 'booking_number'
                    },
                    {
                        data: 'is_attended',
                        name: 'is_attended',
                        render: function(data, type, full, meta) {
                            return data ? "Attended" : "Not Attended";
                        },
                        orderable: false,
                    },
                    {
                        data: 'is_free_event',
                        name: 'is_free_event',
                        render: function(data, type, full, meta) {
                            return data ? "Free" : "Paid";
                        }
                    },
                    {
                        data: 'quantity',
                        name: 'quantity',
                    },
                    {
                        data: 'ticket_price',
                        name: 'ticket_price'
                    },
                    {
                        data: 'sub_total',
                        name: 'sub_total'
                    },
                    {
                        data: 'discount',
                        name: 'discount'
                    },
                    {
                        data: 'total',
                        name: 'total'
                    },
                    {
                        data: 'type',
                        name: 'type',
                        orderable: false,
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],

            });

        });
    </script>

@endsection
