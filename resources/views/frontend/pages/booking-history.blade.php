@extends('frontend.master.layout')
{{-- @extends('layouts.userlayout') --}}
@section('title', 'User Booking History')
@section('content')
<div class="container mt-5">
        <h3 class="text-center mb-5" > {{__('booking_history_title')}} </h3>
        <table class="table" id="data-table">
            <thead>
                <tr>
                    <th> {{__('sr_no')}} </th>
                    <th> {{__('booking_history_event_name')}} </th>
                    <th> {{__('booking_history_booking_number')}} </th>
                    <th> {{__('booking_history_attendance')}} </th>
                    <th> {{__('booking_history_event_type')}} </th>
                    <th> {{__('booking_history_no_of_tickets_booked')}} </th>
                    <th> {{__('booking_history_price_per_ticket')}} </th>
                    <th> {{__('booking_history_sub_total')}} </th>
                    <th> {{__('booking_history_discount')}} </th>
                    <th> {{__('booking_history_total')}} </th>
                    <th> {{__('booking_history_type_of_booking')}} </th>
                    <th> {{__('booking_history_action')}} </th>
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
                order: [
                    [1, 'desc']
                ],
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
