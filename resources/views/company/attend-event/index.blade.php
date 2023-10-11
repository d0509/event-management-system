@extends('admin.pages.dashboard')
@section('title', 'Attended events listing')
@section('company.attend-event.index')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Attended Event</h1>
        </div>

        <table class="table" id="data-table">
            <thead>
                <tr>
                    <th>Sr. No</th>
                    <th>Event Name</th>
                    <th>Booking Number</th>
                    <th>Name of the user</th>
                    <th>No. of Bookings</th>
                    <th>No. of Attendees</th>
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
                    url: "{{ route('company.attend-event.index') }}",
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
                    },
                    {
                        data: 'booking_number',
                        name: 'booking_number'
                    },
                    {
                        data: 'user_id',
                        name: 'user_id',
                        orderable: false,
                    },
                    {
                        data:'quantity',
                        name:'quantity',
                        orderable:false,
                    },
                    {
                        data: 'no_of_attendees',
                        name: 'no_of_attendees',
                    },

                ],

            });

        });
    </script>
@endsection
