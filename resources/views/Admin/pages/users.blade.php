@extends('admin.pages.dashboard')
@section('title', 'Users')
@section('admin.users.index')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Users</h1>
        </div>

        <table class="table align-middle mb-0 bg-white" id="data-table">
            <thead class="bg-light">
                <tr>
                    <th>Sr. No</th>
                    <th> Name</th>
                    <th>Email</th>  
                    <th>Mobile No.</th>
                    <th>City</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>

    <script>
        $(document).ready(function() {
            var table = $('#data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    'type': 'GET',
                    url: "{{ route('admin.user.index') }}",
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
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'mobile_no',
                        name: 'mobile_no',
                    },
                    {
                        data: 'city_id',
                        name: 'city_id',
                    },
                    {
                        data: 'status',
                        name: 'status',
                        orderable:false,
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
