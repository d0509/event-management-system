@extends('backend.master.layout')
@section('title', 'Bookings')
@section('content')

    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Bookings</h1>
        </div>


        <table class="table" id="data-table">
            <thead>
                <tr>
                    <th>Sr. No</th>
                    <th>User Name</th>
                    <th>Event Name</th>
                    <th>Booking Number</th>
                    <th>Attended or not</th>
                    <th>Free event?</th>
                    <th>No. of tickets booked</th>
                    <th>Price per ticket</th>
                    <th>Sub total</th>
                    <th>Discount</th>
                    <th>Total</th>
                    <th>Type of Booking</th>
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
            var table = $('.table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    'type': 'GET',
                    url: "{{ route('company.booking.index') }}",
                    dataType: "JSON",
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'user.name',
                        name: 'user.name'
                    },
                    {
                        data: 'event.name',
                        name: 'event.name'
                    },
                    {
                        data: 'booking_number',
                        name: 'booking_number'
                    },
                    {
                        data: 'is_attended',
                        name: 'is_attended',
                        render: function(data, type, full, meta) {
                            return data ? "Yes" : "No";
                        }
                    },
                    {
                        data: 'is_free_event',
                        name: 'is_free_event',
                        render: function(data, type, full, meta) {
                            return data ? "Yes" : "No";
                        }
                    },
                    {
                        data: 'quantity',
                        name: 'quantity'
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
                        name: 'type'
                    },
                ],
            });

        });

    </script>
@endsection
@push('myScript')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.17/dist/sweetalert2.all.min.js"></script>
@endpush