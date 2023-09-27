@extends('admin.pages.dashboard')
@section('title', 'Admin Dashboard')
@section('admin.dashboard')
    <!-- Page Heading -->
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            
        </div>
    
        <!-- Content Row -->
        @if (request()->route()->getName() == 'admin.dashboard')
        <div class="row">
    
            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Total Users</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"> {{$userCount}} </div>
                            </div>
                            <div class="col-auto">
                                <i class="fa-solid fa-users fa-xl"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    
            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                   Total Company</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{$companyCount}}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fa-regular fa-building fa-2xl"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    
            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Events
                                </div>
                                <div class="row no-gutters align-items-center">
                                    <div class="col-auto">
                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{$eventCount}}</div>
                                    </div>
                                    <div class="col">
                                        {{-- <div class="progress progress-sm mr-2">
                                            <div class="progress-bar bg-info" role="progressbar" style="width: 50%"
                                                aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fa-solid fa-calendar-days fa-2xl"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    
           
        </div>
        @elseif(request()->route()->getName() == 'company.dashboard')
        hi
        @endif

        
    </div>
   

@endsection
