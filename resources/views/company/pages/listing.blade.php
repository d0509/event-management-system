@extends('admin.pages.dashboard')
@section('title', 'Companies')
@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Company Details</h1>
            <a href="{{route('admin.company.create')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fa-solid fa-user-plus mr-2"></i>Create Company</a>
        </div>

        <!-- DataTales Example -->
        {{-- <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive"> --}}
                    <table class="table" id="dataTable" width="100%" >
                        <thead>
                            <tr>
                                <th>Sr. No.</th>
                                <th>Status</th>
                                <th>Company Name</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Address</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                        </tbody>
                    </table>
                {{-- </div>
            </div> --}}

        {{-- </div> --}}


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
                            url: "{{ route('admin.company.index') }}",
                            dataType: "JSON",
                        },
                        columns: [{
                                data: 'DT_RowIndex',
                                name: 'DT_RowIndex',
                                orderable: false,
                                searchable: false
                            },
                            {
                                data: 'user_id',
                                name: 'user_id',
                            },
                            {
                                data: 'name',
                                name: 'name',
                            },
                            {
                                data: 'user.name',
                                name: 'user_id'
                            },
                            {
                                data: 'description',
                                name: 'description',
                                orderable: false,
                            },
                            {
                                data: 'address',
                                name: 'address',
                                searchable: true,
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

                // status 
                $(document).on('click', '#flexSwitchCheckChecked', function(e) {
                    e.preventDefault();
                    var id = $(this).attr('data-companyId');
                    // alert(id);
                    var url = "{{ route('admin.company.status') }}";
                    // alert(url);
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

            function deleteCompany(id) {
                var id = id;
                // alert(id);
                var url = "{{ route('admin.company.destroy', ':id') }}";
                url = url.replace(':id', id);
                // alert(url);
                var token = "{{ csrf_token() }}";
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to delete this company?",
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
                                console.log('status changed successfully');
                                // $('#dataTable').DataTable().ajax.reload();
                            }
                        });
                    }

                })
            }
        </script>
    @endsection
    @push('myScript')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.17/dist/sweetalert2.all.min.js"></script>
    @endpush
