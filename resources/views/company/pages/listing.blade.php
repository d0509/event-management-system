@extends('admin.pages.dashboard')
@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
    <div class="container-fluid">


        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Company Details</h1>
            <a href="{{ route('admin.company.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                    class="fa-solid fa-user-plus"></i>
                Add Company</a>
        </div>


        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Sr. No.</th>
                                <th>Company Name</th>
                                <th>Username</th>
                                <th>Description</th>
                                <th>Address</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            {{-- {{dd($companies->toArray())}} --}}
                            @if ($companies)
                                @foreach ($companies as $company)
                                    {{-- {{dd($loop->index )}} --}}
                                    <tr id="company{{ $company->id }}">
                                        <td>{{ $company->id }}</td>
                                        <td>{{ $company->name }}</td>
                                        <td>{{ $company->user->name }}</td>
                                        <td>{{ $company->description }}</td>
                                        <td>{{ $company->address }}</td>
                                        {{-- <td>{{ $company->user->status }}</td> --}}
                                        <td>
                                            <!-- Default switch -->
                                            <!-- Default checked -->
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" style="margin: 0 auto"
                                                    role="switch" id="flexSwitchCheckChecked"
                                                    {{ $company->user->status == 'approved' ? 'checked' : '' }}
                                                    data-id="{{ $company->id }}" value="{{ $company->user->status }}">
                                                <label class="form-check-label" for="flexSwitchCheckChecked"></label>
                                            </div>

                                        </td>
                                        <td>
                                            {{-- update --}}
                                            <a class="btn btn-success"
                                                href="{{ route('admin.company.edit', ['company' => $company]) }}">Update</a>
                                            {{-- delete --}}
                                            <button type="button" class="btn btn-danger"
                                                data-companyId="{{ $company->id }}" data-target="#deleteModal"
                                                data-toggle="modal" id="deleteCompany">Delete</button>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <h1> No Companies Available</h1>
                            @endif


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="modal fade" id="deleteModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Verify Deletion</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete?</p>
                    </div>
                    <div class="modal-footer">
                        <a type="button" class="btn btn-secondary" id="close-modal" data-dismiss="modal">No</a>
                        <a href="button" class="btn btn-danger finalDelete" data-dismiss="modal">Yes</a>

                    </div>
                </div>
            </div>
        </div>

        <script>
            $(document).ready(function() {
                
                $(document).on('click', '#deleteCompany', function(e) {
                    e.preventDefault();
                    // let myThis = this;
                    // alert($(this));
                    var id = $(this).attr("data-companyId");
                    // alert(id);
                    var url = "{{ route('admin.company.destroy', ':id') }}";
                    url = url.replace(':id', id);
                    // alert(url);
                    var token = "{{ csrf_token() }}";

                    $(document).on('click', '.finalDelete', function() {
                        // console.log(who);
                        $.ajax({
                            url: url,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },

                            type: 'DELETE',
                            dataType: "JSON",
                            data: {
                                id: id,
                                "_token": "{{ csrf_token() }}",

                            },
                            success: function() {
                                console.log('deleted successfully');
                                $("#company" + id).hide();
                                // toastr.success("Company deleted successfully!");
                            }
                        });


                    });
                    // session()->flash('danger', 'There are some issues in deleting event');

                });


                $(document).on('change', '#flexSwitchCheckChecked', function(e) {
                    e.preventDefault();
                    var company = $(this).attr('data-id');
                    var status = $(this).val();
                    console.log(company);
                    var url = "{{ route('admin.company.status') }}";
                    $.ajax({
                        url: url,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'POST',

                        data: {
                            company_id: company,
                            status: status,
                            "_token": "{{ csrf_token() }}",
                        },
                        success: function() {

                        }
                    });

                });
            });
        </script>
    </div>
@endsection
