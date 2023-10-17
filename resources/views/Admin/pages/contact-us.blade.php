@extends('backend.master.layout')
@section('title', 'Contact Us')
@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">{{ __('dashboard.inquiries') }}</h1>
        </div>

        <table class="table table-primary" id="data-table">
            <thead>
                <tr>
                    <th>Sr. No</th>
                    <th>Email</th>
                    <th>Name</th>
                    <th>Contact Number</th>
                    <th>Message</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>

        <script>
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
                        url: "{{ route('admin.contact-us.index') }}",
                        dataType: "JSON",
                    },
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'email',
                            name: 'email'
                        },
                        {
                            data: 'name',
                            name: 'name',
                        },
                        {
                            data: 'phone',
                            name: 'phone',
                            orderable: false,
                        },
                        {
                            data: 'message',
                            name: 'message',
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        },
                    ],

                });

                $(document).on('click','.delete_contact',function(){
                    alert('Delete button clicked');
                });

            });
        </script>

    </div>
@endsection
