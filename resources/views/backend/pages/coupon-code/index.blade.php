@extends('backend.master.layout')
@section('title', 'Coupon Codes')
@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Coupon Codes</h1>
            <a href="{{ route('company.coupon-code.create') }}"
                class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fa fa-gift mr-2"
                    aria-hidden="true"></i>Create Coupon Code</a>
        </div>

        <table class="table" id="dataTable">
            <thead>
                <tr>
                    <th>Sr. No.</th>
                    <th>Status</th>
                    <th>Code</th>
                    <th>Company</th>
                    <th>Usable Count</th>
                    <th>Percentage</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>

    </div>
@endsection

@section('contentfooter')
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var table = $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                order: [
                    [1, 'desc']
                ],
                ajax: {
                    'type': 'GET',
                    url: "{{ route('company.coupon-code.index') }}",
                    dataType: "JSON",
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        searchable: false,
                        orderable: false,
                    },
                    {
                        data: "is_active",
                        name: 'is_active',
                        searchable: false,
                        orderable: false,
                    },
                    {
                        data: 'name',
                        name: 'name',
                        orderable: false,
                    },
                    {
                        data: 'company.name',
                        name: 'company.name',
                    },

                    {
                        data: 'usable_count',
                        name: 'usable_count',
                    },
                    {
                        data: 'percentage',
                        name: 'percentage',
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
            });

            $(document).on('change', '#flexSwitchCheckChecked', function(e) {
                e.preventDefault();
                var id = $(this).attr('data-couponId');
                // alert(id);
                var url = "{{ route('company.coupon-code.status') }}";
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

        function deleteCoupons(id) {
            var id = id;
            // alert(id);
            var url = "{{ route('company.coupon-code.destroy', ':id') }}";
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
                            console.log('coupon deleted successfully');
                            $('#dataTable').DataTable().ajax.reload();
                        }
                    });
                }
            })
        }
    </script>
@endsection
