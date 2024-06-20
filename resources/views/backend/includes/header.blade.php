@if (Auth::user())

    <body id="page-top">

        <!-- Page Wrapper -->
        <div id="wrapper">

            <!-- Sidebar -->
            <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

                @if (Auth::user()->role_id == config('site.roles.company'))
                    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route('company.dashboard')}}">
                        <div class="sidebar-brand-icon rotate-n-15">
                            <i class="fas fa-laugh-wink"></i>
                        </div>
                        <div class="sidebar-brand-text mx-3">Company Dashboard</div>
                    </a>
                @elseif(Auth::user()->role_id == config('site.roles.admin'))
                <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route('admin.dashboard')}}">
                    <div class="sidebar-brand-icon rotate-n-15">
                        <i class="fas fa-laugh-wink"></i>
                    </div>
                    <div class="sidebar-brand-text mx-3">Admin Dashboard</div>
                </a>
                @endif

                @if (Auth::user()->role_id == config('site.roles.admin'))
                    <li class="nav-item {{ Route::currentRouteName() == 'admin.dashboard' ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.dashboard') }}">
                            <i class="fas fa-fw fa-tachometer-alt"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item {{ Route::currentRouteName() == 'admin.company.index' ? 'active' : '' }}">
                        <a class="nav-link "
                            href="{{ route('admin.company.index') }}">
                            <i class="fa-solid fa-building"></i>
                            <span>Company</span>
                        </a>

                    </li>

                    <!-- Nav Item - Utilities Collapse Menu -->
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() == 'admin.event.index' ? 'active' : '' }} "
                            href="{{ route('admin.event.index') }}" aria-expanded="true"
                            aria-controls="collapseUtilities">
                            <i class="fa-solid fa-face-smile"></i>
                            <span>Events</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() == 'admin.user.index' ? 'active' : '' }} "
                            href="{{ route('admin.user.index') }}" aria-expanded="true"
                            aria-controls="collapseUtilities">
                            <i class="fa-solid fa-user"></i>
                            <span>Users</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() == 'admin.contact-us.index' ? 'active' : '' }}"
                            href="{{ route('admin.contact-us.index') }}" aria-expanded="true"
                            aria-controls="collapseUtilities">
                            <i class="fa-solid fa-question"></i>
                            <span>Inquiries</span>
                        </a>
                    </li>
                @endif



                @if (Auth::user()->role_id == config('site.roles.company'))
                    <li class="nav-item {{ Route::currentRouteName() == 'company.dashboard' ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('company.dashboard') }}">
                            <i class="fas fa-fw fa-tachometer-alt"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>

                    <li class="nav-item {{ Route::currentRouteName() == 'company.attend-event.create' ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('company.attend-event.create') }}">
                            <i class="fas fa-user-plus"></i>
                            <span>Attend Event</span>
                        </a>
                    </li>

                    <li class="nav-item {{ Route::currentRouteName() == 'company.event.index' ? 'active' : '' }}">
                        <a class="nav-link collapsed" href="{{ route('company.event.index') }}">
                            <i class="fas fa-music"></i>
                            <span>Events</span>
                        </a>
                    </li>

                    <li class="nav-item {{ Route::currentRouteName() == 'company.booking.index' ? 'active' : '' }}">
                        <a class="nav-link collapsed" href="{{ route('company.booking.index') }}">
                            <i class="fas fa-ticket-alt"></i>
                            <span>Bookings</span>
                        </a>
                    </li>

                    <li class="nav-item {{ Route::currentRouteName() == 'company.coupon-code.index' ? 'active' : '' }}">
                        <a class="nav-link collapsed" href="{{ route('company.coupon-code.index') }}">
                            <i class="fa fa-gift mr-2"  aria-hidden="true"></i>
                            <span>Coupon Code</span>
                        </a>
                    </li>
                @endif
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
                                    @if (Auth::user()->role_id == config('site.roles.admin'))
                                        <a class="dropdown-item" href="{{ route('admin.profile.index') }}">
                                        @elseif(Auth::user()->role_id == config('site.roles.company'))
                                            <a class="dropdown-item" href="{{ route('company.profile.index') }}">
                                    @endif
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    My Profile
                                    </a>
                                    <a class="dropdown-item"
                                        href="{{ route('admin.change-password.edit', ['change_password' => Auth::id()]) }}">
                                        <i class="fa-solid fa-lock fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Change Password
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" data-toggle="modal" data-target="#logoutModal">
                                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Logout
                                    </a>
                                </div>
                            </li>



                        </ul>

                    </nav>

                    @yield('content')

                </div>


                <footer class="sticky-footer bg-white">
                    <div class="container my-auto">
                        <div class="copyright text-center my-auto">
                            <span>Copyright &copy; Your Website 2021</span>
                        </div>
                    </div>
                </footer>

            </div>


        </div>

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
