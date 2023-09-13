@extends('admin.pages.dashboard')
@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Company Details</h1>
            <a href="{{route('company.create')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                    class="fa-solid fa-user-plus"></i> Add Company</a>
        </div>


        <!-- DataTales Example -->
        <div class="card shadow mb-4"  >
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
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
                            @foreach ($companies as $company)
                                <tr>
                                    <td>{{ $company->name }}</td>
                                    <td>{{ $company->user->name }}</td>
                                    <td>{{ $company->description }}</td>
                                    <td>{{ $company->address }}</td>

                                    <td>{{ $company->user->status }}</td>
                                    <td>
                                        {{-- update --}}
                                        <a class="btn btn-success"
                                            href="{{ route('editCompany', ['company' => $company]) }}">Update</a>
                                        {{-- delete --}}
                                        <button type="button" class="btn btn-danger" data-target="#deleteModal"
                                            data-toggle="modal">Delete</button>
                                    </td>
                                </tr>
                            @endforeach

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
                        <form action="{{ route('destroyCompany', ['company' => $company]) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Yes</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
