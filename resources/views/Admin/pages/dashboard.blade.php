@extends('layouts.adminlayout')
@section('admindashboard')
    @if (Auth::user())

        <body id="page-top">

            <!-- Page Wrapper -->
            <div id="wrapper">

                <!-- Sidebar -->
                <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

                    @if (request()->route()->getName() == 'company.dashboard' ||
                            request()->route()->getName() == 'company.event.index' ||
                            request()->route()->getName() == 'company.event.create' ||
                            request()->route()->getName() == 'company.event.store' ||
                            request()->route()->getName() == 'company.event.edit' ||
                            request()->route()->getName() == 'company.event.update' ||
                            request()->route()->getName() == 'company.event.destroy' ||
                            request()->route()->getName() == 'company.booking.index' ||
                            request()->route()->getName() == 'company.attend-event.create' ||
                            request()->route()->getName() == 'company.attend-event.index')
                        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                            <div class="sidebar-brand-icon rotate-n-15">
                                <i class="fas fa-laugh-wink"></i>
                            </div>
                            <div class="sidebar-brand-text mx-3">Company Dashboard</div>
                        </a>
                    @elseif(request()->route()->getName() == 'admin.dashboard' ||
                            request()->route()->getName() == 'admin.company.index' ||
                            request()->route()->getName() == 'admin.company.create' ||
                            request()->route()->getName() == 'admin.company.store' ||
                            request()->route()->getName() == 'admin.company.edit' ||
                            request()->route()->getName() == 'admin.company.update' ||
                            request()->route()->getName() == 'admin.company.destroy' ||
                            request()->route()->getName() == 'admin.event.index' ||
                            request()->route()->getName() == 'admin.event.edit' ||
                            request()->route()->getName() == 'admin.event.update' ||
                            request()->route()->getName() == 'admin.user.index')
                        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                            <div class="sidebar-brand-icon rotate-n-15">
                                <i class="fas fa-laugh-wink"></i>
                            </div>
                            <a href="{{ route('admin.dashboard') }}" class="sidebar-brand-text mx-3 text-light">Admin
                                Dashboard</a>
                        </a>
                    @endif


                    <!-- Divider -->
                    <hr class="sidebar-divider my-0">

                    <!-- Nav Item - Dashboard -->


                    <!-- Divider -->

                    <!-- Nav Item - Pages Collapse Menu -->
                    {{-- {{dd(Auth::user()->role->name == config('site.role_names.admin'))}} --}}

                    @if (Auth::user()->role->name == config('site.role_names.admin'))
                        <li class="nav-item {{ request()->route()->getName() == 'admin.dashboard'? 'active': '' }}">
                            <a class="nav-link" href="{{ route('admin.dashboard') }}">
                                <i class="fas fa-fw fa-tachometer-alt"></i>
                                <span>{{ __('dashboard.dashboard') }}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->route()->getName() == 'admin.company.index'? 'active': '' }} "
                                href="{{ route('admin.company.index') }}">
                                <i class="fa-solid fa-building"></i>
                                <span>Company</span>
                            </a>

                        </li>

                        <!-- Nav Item - Utilities Collapse Menu -->
                        <li class="nav-item">
                            <a class="nav-link {{ request()->route()->getName() == 'admin.event.index'? 'active': '' }} "
                                href="{{ route('admin.event.index') }}" aria-expanded="true"
                                aria-controls="collapseUtilities">
                                <i class="fa-solid fa-face-smile"></i>
                                <span>Events</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->route()->getName() == 'admin.user.index'? 'active': '' }} "
                                href="{{ route('admin.user.index') }}" aria-expanded="true"
                                aria-controls="collapseUtilities">
                                <i class="fa-solid fa-user"></i>
                                <span>Users</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->route()->getName() == 'admin.contact-us.index'? 'active': '' }} "
                                href="{{ route('admin.contact-us.index') }}" aria-expanded="true"
                                aria-controls="collapseUtilities">
                                <i class="fa-solid fa-question"></i>
                                <span>{{ __('dashboard.inquiries') }}</span>
                            </a>
                        </li>
                    @endif



                    @if (Auth::user()->role->name == config('site.role_names.company'))
                        <li class="nav-item {{ request()->route()->getName() == 'company.dashboard'? 'active': '' }}">
                            <a class="nav-link" href="{{ route('company.dashboard') }}">
                                <i class="fas fa-fw fa-tachometer-alt"></i>
                                <span>{{ __('dashboard.dashboard') }}</span>
                            </a>
                        </li>



                        <li class="nav-item {{ request()->route()->getName() == 'company.event.create'? 'active': '' }}">
                            <a class="nav-link collapsed" href="{{ route('company.event.create') }}" aria-expanded="true"
                                aria-controls="collapseTwo">
                                <i class="fas fa-fw fa-cog"></i>
                                <span>{{ __('dashboard.add_event') }}</span>
                            </a>

                        </li>

                        <li class="nav-item {{ request()->route()->getName() == 'company.event.index'? 'active': '' }}">
                            <a class="nav-link collapsed" href="{{ route('company.event.index') }}">
                                <i class="fas fa-fw fa-wrench"></i>
                                <span>{{ __('dashboard.events') }}</span>
                            </a>
                        </li>

                        <li class="nav-item {{ request()->route()->getName() == 'company.booking.index'? 'active': '' }}">
                            <a class="nav-link collapsed" href="{{ route('company.booking.index') }}">
                                <i class="fas fa-fw fa-wrench"></i>
                                <span>{{ __('dashboard.bookings') }}</span>
                            </a>
                        </li>

                        <li class="nav-item {{ request()->route()->getName() == 'company.booking.index'? 'active': '' }}">
                            <a class="nav-link collapsed" href="{{ route('company.attend-event.index') }}">
                                <i class="fas fa-fw fa-wrench"></i>
                                <span>{{ __('dashboard.attend_event') }}</span>
                            </a>
                        </li>
                    @endif


                    <!-- Divider -->
                    <hr class="sidebar-divider">

                    <!-- Heading -->


                    <!-- Nav Item - Pages Collapse Menu -->



                </ul>
                <!-- End of Sidebar -->

                <!-- Content Wrapper -->
                <div id="content-wrapper" class="d-flex flex-column">

                    <!-- Main Content -->
                    <div id="content">

                        <!-- Topbar -->
                        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                            <!-- Sidebar Toggle (Topbar) -->
                            <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                                <i class="fa fa-bars"></i>
                            </button>



                            <!-- Topbar Navbar -->
                            <ul class="navbar-nav ml-auto">

                                <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                                <li class="nav-item dropdown no-arrow d-sm-none">
                                    <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-search fa-fw"></i>
                                    </a>
                                    <!-- Dropdown - Messages -->
                                    <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                        aria-labelledby="searchDropdown">
                                        <form class="form-inline mr-auto w-100 navbar-search">
                                            <div class="input-group">
                                                <input type="text" class="form-control bg-light border-0 small"
                                                    placeholder="Search for..." aria-label="Search"
                                                    aria-describedby="basic-addon2">
                                                <div class="input-group-append">
                                                    <button class="btn btn-primary" type="button">
                                                        <i class="fas fa-search fa-sm"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </li>

                                <!-- Nav Item - Alerts -->
                                <li class="nav-item dropdown no-arrow mx-1">

                                    <!-- Dropdown - Alerts -->
                                    <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                        aria-labelledby="alertsDropdown">
                                        <h6 class="dropdown-header">
                                            Alerts Center
                                        </h6>
                                        <a class="dropdown-item d-flex align-items-center" href="#">
                                            <div class="mr-3">
                                                <div class="icon-circle bg-primary">
                                                    <i class="fas fa-file-alt text-white"></i>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="small text-gray-500">December 12, 2019</div>
                                                <span class="font-weight-bold">A new monthly report is ready to
                                                    download!</span>
                                            </div>
                                        </a>
                                        <a class="dropdown-item d-flex align-items-center" href="#">
                                            <div class="mr-3">
                                                <div class="icon-circle bg-success">
                                                    <i class="fas fa-donate text-white"></i>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="small text-gray-500">December 7, 2019</div>
                                                $290.29 has been deposited into your account!
                                            </div>
                                        </a>
                                        <a class="dropdown-item d-flex align-items-center" href="#">
                                            <div class="mr-3">
                                                <div class="icon-circle bg-warning">
                                                    <i class="fas fa-exclamation-triangle text-white"></i>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="small text-gray-500">December 2, 2019</div>
                                                Spending Alert: We've noticed unusually high spending for your account.
                                            </div>
                                        </a>
                                        <a class="dropdown-item text-center small text-gray-500" href="#">Show All
                                            Alerts</a>
                                    </div>
                                </li>

                                <!-- Nav Item - Messages -->


                                <div class="topbar-divider d-none d-sm-block"></div>

                                <li class="nav-item dropdown no-arrow">
                                    <a class="nav-link dropdown-toggle notworking" href="#" id="userDropdown"
                                        role="button" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        <span
                                            class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->name }}</span>
                                        @foreach (Auth::user()->media as $item)
                                            <img class="img-profile rounded-circle"
                                                src="{{ asset('storage/profile/' . $item['filename'] . '.' . $item['extension']) }}">
                                        @endforeach
                                    </a>
                                    <!-- Dropdown - User Information -->
                                    <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                        aria-labelledby="userDropdown" id="profileoptions">
                                        <a class="dropdown-item" href="{{ route('profile.index') }}">
                                            <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                            {{ __('dashboard.profile') }}
                                        </a>
                                        <a class="dropdown-item"
                                            href="{{ route('admin.change-password.edit', ['change_password' => Auth::id()]) }}">
                                            <i class="fa-solid fa-lock fa-sm fa-fw mr-2 text-gray-400"></i>
                                            {{ __('dashboard.change_password') }}
                                        </a>
                                        {{-- <a class="dropdown-item" href="#">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Settings
                                </a> --}}
                                        {{-- <a class="dropdown-item" href="#">
                                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Activity Log
                                </a> --}}
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" data-toggle="modal" data-target="#logoutModal">
                                            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                            {{ __('dashboard.logout') }}
                                        </a>
                                    </div>
                                </li>



                            </ul>

                        </nav>

                        @if (request()->route()->getName() == 'admin.dashboard' ||
                                request()->route()->getName() == 'company.dashboard')
                            @yield('admin.dashboard')
                        @endif
                        @if (request()->route()->getName() == 'admin.change-password.edit')
                            @yield('password.edit')
                        @endif
                        @if (request()->route()->getName() == 'company.event.index')
                            @yield('company.event.index')
                        @endif
                        @if (request()->route()->getName() == 'profile.index')
                            @yield('profile')
                        @endif
                        @if (request()->route()->getName() == 'profile.edit')
                            @yield('profile.edit')
                        @endif
                        @if (request()->route()->getName() == 'admin.event.index')
                            @yield('admin.event.index')
                        @endif
                        @if (request()->route()->getName() == 'admin.event.edit')
                            @yield('admin.event.edit')
                        @endif
                        @if (request()->route()->getName() == 'company.event.edit' ||
                                request()->route()->getName() == 'company.event.create')
                            @yield('company.event.create')
                        @endif
                        @if (request()->route()->getName() == 'adminDashboard')
                            @yield('event')
                        @endif
                        @if (request()->route()->getName() == 'reset.password.get')
                            @yield('forgetPasswordLink')
                        @endif
                        @if (request()->route()->getName() == 'admin.company.index')
                            @yield('content')
                        @endif
                        @if (request()->route()->getName() == 'admin.company.create' || 'admin.company.edit')
                            @yield('edit')
                        @endif
                        @if (request()->route()->getName() == 'forgot-password')
                            @yield('forgotPassword')
                        @endif
                        @if (request()->route()->getName() == 'admin.contact-us.index')
                            @yield('admin.contact-us.index')
                        @endif
                        @if (request()->route()->getName() == 'company.booking.index')
                            {{-- {{dd(3)}} --}}
                            @yield('company')
                        @endif

                        @if (request()->route()->getName() == 'admin.user.index')
                            @yield('admin.users.index')
                        @endif
                        @if (request()->route()->getName() == 'company.attend-event.create')
                            @yield('company.attend-event.create')
                        @elseif(request()->route()->getName() == 'company.attend-event.index')
                            @yield('company.attend-event.index')
                        @endif
                        @if (request()->route()->getName() == 'admin.user.index')
                            @yield('admin.user.show')
                        @endif

                        @if (request()->route()->getName() == 'admin.user.show')
                            @yield('admin.user.show-single')
                        @endif
                    </div>


                    <footer class="sticky-footer bg-white">
                        <div class="container my-auto">
                            <div class="copyright text-center my-auto">
                                <span>Copyright &copy; Your Website 2021</span>
                            </div>
                        </div>
                    </footer>
                    <!-- End of Footer -->

                </div>
                <!-- End of Content Wrapper -->

            </div>
            <!-- End of Page Wrapper -->

            <!-- Scroll to Top Button-->
            <a class="scroll-to-top rounded" href="#page-top">
                <i class="fas fa-angle-up"></i>
            </a>

            <!-- Logout Modal-->
            <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                            <a class="btn btn-primary" href="{{ route('logout') }}">Logout</a>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                $(document).ready(function() {

                    $(document).on('click', '#userDropdown', function(e) {
                        e.preventDefault;
                        $("#profileoptions").toggleClass("show");
                    });
                });
            </script>

        </body>
    @endif
@endsection
