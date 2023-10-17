@extends('backend.master.layout')
@section('title', 'Contact Us')
@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">{{ __('dashboard.inquiries') }}</h1>
           
        </div>

        <table class="table" id="data-table">
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
                // $(document).on("click", ".delete_contact", function() {

                // });
                // $(document).on('click', '.delete_contact', function() {

                //     var id = $(this).attr('data-id');

                //     var url = "{{ route('admin.contact-us.destroy', ':id') }}";
                //     url = url.replace(':id', id);

                //     var token = "{{ csrf_token() }}";

                //     $.ajax({
                //         url: url,
                //         headers: {
                //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                //         },

                //         type: 'DELETE',
                //         dataType: "JSON",
                //         data: {
                //             id: id,
                //             "_token": "{{ csrf_token() }}",

                //         },
                //         success: function() {
                //             console.log('deleted successfully');

                //             $('#data-table').DataTable().ajax.reload();
                //         }



                //     });
                // });

            });

            function deleteInquiries(id) {
                var id = id;
                var url = "{{ route('admin.contact-us.destroy', ':id') }}";
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

                                $('#data-table').DataTable().ajax.reload();
                            }
                        });
                    }

                })
            }
        </script>

    </div>
@endsection
@push('myScript')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.17/dist/sweetalert2.all.min.js"></script>
@endpush
