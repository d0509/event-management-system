@extends('backend.master.layout')
@if (request()->route()->getName() == 'admin.dashboard')
    @section('title', 'Admin Dashboard')
@elseif(request()->route()->getName() == 'company.dashboard')
    @section('title', 'Company Dashboard')
@endif
@section('content')
    @if (request()->route()->getName() == 'admin.dashboard')
        <div class="container-fluid">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            </div>
            <div class="row">
                <!-- Earnings (Monthly) Card Example -->
                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Total Users</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"> {{ $userCount }} </div>
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
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $companyCount }}</div>
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
                                            <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ $totalEvent }}
                                            </div>
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

            <div class="row">
                <div class="col-xl-12 col-lg-8">
                    <div class="card shadow mb-4">
                        <!-- Card Header - Dropdown -->
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Monthly User Registration</h6>

                        </div>
                        <!-- Card Body -->
                        <div class="card-body">
                            <div class="chart-area" style="height:500px; width:1200px;">
                                <canvas id="lineChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-xl-12 col-lg-8">
                    <div class="card shadow mb-4">
                        <!-- Card Header - Dropdown -->
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Company Engagement</h6>

                        </div>
                        <!-- Card Body -->
                        <div class="card-body">
                            <div class="chart-area" style="height:500px; width:1200px;">
                                <canvas id="dayWiseBookings"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

            <script>
                var data = @json($data); // Convert PHP array to JSON
                var ctx = document.getElementById('lineChart').getContext('2d');
                var datasets = [];
                // Define an array to map month numbers to month names
                var monthNames = [
                    'January', 'February', 'March', 'April', 'May', 'June', 'July',
                    'August', 'September', 'October', 'November', 'December'
                ];

                const roleLabelMap = {
                    1: "Admin",
                    2: "Company",
                    3: "User",
                };

                // Define an array of colors for the lines
                const lineColors = ['rgb(255, 0, 0)', 'rgb(0, 255, 0)']; // Example: Red and Green

                // Loop through the data and create datasets for each role
                var colorIndex = 0; // Initialize color index
                for (var roleId in data) {
                    const label = roleLabelMap[roleId];
                    const lineColor = lineColors[colorIndex % lineColors.length]; // Assign a color from the array

                    const dataset = {
                        label: label,
                        data: Object.values(data[roleId]),
                        fill: false,
                        borderColor: lineColor, // Set the color based on the index
                    };

                    datasets.push(dataset);
                    colorIndex++; // Increment color index
                }

                // Convert month numbers to month names in the chart labels
                var chartLabels = Object.keys(data[Object.keys(data)[0]]).map(function(monthNumber) {
                    return monthNames[monthNumber - 1]; // Adjust for 0-based array
                });

                var chartData = {
                    labels: chartLabels,
                    datasets: datasets,
                };

                var lineChart = new Chart(ctx, {
                    type: 'line',
                    data: chartData,
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'No. Of Users Registered', // Add a title to the x-axis
                                },
                                ticks: {
                                    stepSize: 2, // Set the step size here
                                },
                            },
                            x: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Months',
                                },
                            }
                        }
                    },
                });


                // day wise booking chart

                var data = @json($bookingsData);

                var ctx = document.getElementById('dayWiseBookings').getContext('2d');

                // Create an object to store datasets
                var datasets = {};

                // Loop through the data and create datasets for each company
                data.forEach(function(item) {
                    var companyName = item.company_name;

                    if (!datasets[companyName]) {
                        datasets[companyName] = {
                            label: companyName,
                            data: [],
                            fill: false,
                            borderColor: getRandomColor(),
                        };
                    }

                    datasets[companyName].data.push(item.total_quantity);
                });

                // Create labels based on the booking days
                var labels = data.map(function(item) {
                    return item.booking_day;
                });

                // Convert datasets object to an array
                var chartData = {
                    labels: labels,
                    datasets: Object.values(datasets),
                };

                var lineChart = new Chart(ctx, {
                    type: 'line',
                    data: chartData,
                });

                // Function to get a random color for line colors
                function getRandomColor() {
                    var letters = '0123456789ABCDEF';
                    var color = '#';
                    for (var i = 0; i < 6; i++) {
                        color += letters[Math.floor(Math.random() * 16)];
                    }
                    return color;
                }
            </script>

            {{-- <script>
                var data = @json($data); // Convert PHP array to JSON
                var ctx = document.getElementById('lineChart').getContext('2d');
                var datasets = [];
                // Define an array to map month numbers to month names
                var monthNames = [
                    'January', 'February', 'March', 'April', 'May', 'June', 'July',
                    'August', 'September', 'October', 'November', 'December'
                ];
            
                const roleLabelMap = {
                    1: "Admin",
                    2: "Company",
                    3: "User",
                };
            
                // Define a static color (e.g., red) for the lines
                const lineColor = 'rgb(0, 0, 255)';
            
                // Loop through the data and create datasets for each role
                for (var roleId in data) {
                    const label = roleLabelMap[roleId];
            
                    const dataset = {
                        label: label,
                        data: Object.values(data[roleId]),
                        fill: false,
                        borderColor: lineColor, // Set the static color here
                    };
            
                    datasets.push(dataset);
                }
            
                // Convert month numbers to month names in the chart labels
                var chartLabels = Object.keys(data[Object.keys(data)[0]]).map(function(monthNumber) {
                    return monthNames[monthNumber - 1]; // Adjust for 0-based array
                });
            
                var chartData = {
                    labels: chartLabels,
                    datasets: datasets,
                };
            
                var lineChart = new Chart(ctx, {
                    type: 'line',
                    data: chartData,
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'No. Of Users Registered', // Add a title to the x-axis
                                },
                                ticks: {
                                    stepSize: 2, // Set the step size here
                                },
                            },
                            x: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Months', // Add a title to the x-axis
                                },
                            }
                        }
                    },
                });
            </script> --}}


        </div>
    @elseif(request()->route()->getName() == 'company.dashboard')
        <div class="container-fluid">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            </div>
            <div class="row">

                <!-- Earnings (Monthly) Card Example -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Total Event</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalEvent }} </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fa-solid fa-users fa-xl"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Earnings (Monthly) Card Example -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Today Event</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $todayEvent }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fa-regular fa-building fa-2xl"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Earnings (Monthly) Card Example -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Past Events
                                    </div>
                                    <div class="row no-gutters align-items-center">
                                        <div class="col-auto">
                                            <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                                {{ $pastEvent }}
                                            </div>
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

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        Upcoming Event </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"> {{ $upcomingEvent }} </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-comments fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
