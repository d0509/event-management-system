@extends('layouts.adminlayout')
@section('title', 'dashboard')
@section('container')
    <div id="page-top">
        <!-- Page Wrapper -->
        <div id="wrapper">

            <!-- Sidebar -->
            <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

                <!-- Sidebar - Brand -->
                <a class="sidebar-brand d-flex align-items-center justify-content-center"
                    @if (request()->route()->getName() == 'adminDashboard') href="{{ route('adminDashboard') }}"
                    >
                    <div class="sidebar-brand-icon rotate-n-15">
                        {{-- <i class="fas fa-laugh-wink"> </i> --}}
                        <div class="sidebar-brand-text mx-3">Admin Dashboard </div>
                    @elseif(request()->route()->getName() == 'companyDashboard')
                    href="{{ route('companyDashboard') }}">
                    <div class="sidebar-brand-icon rotate-n-15">
                        {{-- <i class="fas fa-laugh-wink"> </i> --}}
                        <div class="sidebar-brand-text mx-3">Company Dashboard </div>
                    @endif
                   
                </a>

                <!-- Divider -->
                {{-- {{dd(auth()->user()->role)}} --}}
                @auth
                    @foreach (auth()->user()->role as $role)
                        @if ($role['name'] === 'company')
                            <li class="nav-item active">
                                <a class="nav-link" href="{{ route('companyDashboard') }}">
                                    <i class="fas fa-fw fa-tachometer-alt"></i>
                                    <span>{{ __('dashboard.dashboard') }}</span>
                                </a>
                            </li>

                            <div class="sidebar-heading">
                                Interface
                            </div>

                            <li class="nav-item">
                                <a class="nav-link collapsed" href="{{ route('event.create') }}" aria-expanded="true"
                                    aria-controls="collapseTwo">
                                    <i class="fas fa-fw fa-cog"></i>
                                    <span>{{ __('dashboard.add_event') }}</span>
                                </a>

                            </li>

                            <li class="nav-item">
                                <a class="nav-link collapsed" href="{{ route('event.index') }}">
                                    <i class="fas fa-fw fa-wrench"></i>
                                    <span>{{ __('dashboard.events') }}</span>
                                </a>

                            </li>
                        @endif
                    @endforeach
                    {{-- @if (Auth::user()->role == 'admin') --}}
                    @foreach (auth()->user()->role as $role)
                        @if ($role['name'] == 'admin')
                            <li class="nav-item active">
                                <a class="nav-link" href="{{ route('adminDashboard') }}">
                                    <i class="fas fa-fw fa-tachometer-alt"></i>
                                    <span>{{ __('dashboard.dashboard') }}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link collapsed" href="{{ route('admin.event.index') }}" aria-expanded="true"
                                    aria-controls="collapseTwo">
                                    <i class="fas fa-fw fa-cog"></i>
                                    <span>{{ __('dashboard.events') }}</span>
                                </a>

                            </li>
                            <li class="nav-item">
                                <a class="nav-link collapsed" href="{{ route('admin.company.index') }}">
                                    <i class="fas fa-fw fa-wrench"></i>
                                    <span>{{ __('dashboard.company') }}</span>
                                </a>
                            </li>
                        @endif
                    @endforeach
                @endauth


                {{-- <div class="sidebar-heading">
                    Addons
                </div>

                <!-- Nav Item - Pages Collapse Menu -->
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
                        aria-expanded="true" aria-controls="collapsePages">
                        <i class="fas fa-fw fa-folder"></i>
                        <span>Pages</span>
                    </a>
                    <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <h6 class="collapse-header">Login Screens:</h6>
                            <a class="collapse-item" href="login.html">Login</a>
                            <a class="collapse-item" href="register.html">Register</a>
                            <a class="collapse-item" href="forgot-password.html">Forgot Password</a>
                            <div class="collapse-divider"></div>
                            <h6 class="collapse-header">Other Pages:</h6>
                            <a class="collapse-item" href="404.html">404 Page</a>
                            <a class="collapse-item" href="blank.html">Blank Page</a>
                        </div>
                    </div>
                </li>

                <!-- Nav Item - Charts -->
                <li class="nav-item">
                    <a class="nav-link" href="charts.html">
                        <i class="fas fa-fw fa-chart-area"></i>
                        <span>Charts</span></a>
                </li>

                <!-- Nav Item - Tables -->
                <li class="nav-item">
                    <a class="nav-link" href="tables.html">
                        <i class="fas fa-fw fa-table"></i>
                        <span>Tables</span></a>
                </li> --}}

                <!-- Divider -->

                <!-- Sidebar Toggler (Sidebar) -->
                {{-- <div class="text-center d-none d-md-inline">
                    <button class="rounded-circle border-0" id="sidebarToggle"></button>
                </div> --}}

                <!-- Sidebar Message -->
                {{-- <div class="sidebar-card d-none d-lg-flex">
                    <img class="sidebar-card-illustration mb-2" src="https://i.pravatar.cc/150?img=12" alt="...">
                    <p class="text-center mb-2"><strong>SB Admin Pro</strong> is packed with premium features,
                        components, and more!</p>
                    <a class="btn btn-success btn-sm" href="https://startbootstrap.com/theme/sb-admin-pro">Upgrade to
                        Pro!</a>
                </div> --}}

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

                        <!-- Topbar Search -->
                        <form
                            class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                            {{-- <div class="input-group">
                                <input type="text" class="form-control bg-light border-0 small"
                                    placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="button">
                                        <i class="fas fa-search fa-sm"></i>
                                    </button>
                                </div>
                            </div> --}}
                        </form>

                        <!-- Topbar Navbar -->
                        <ul class="navbar-nav ml-auto">

                            <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                            {{-- <li class="nav-item dropdown no-arrow d-sm-none">
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
                            </li> --}}

                            <!-- Nav Item - Alerts -->
                            {{-- <li class="nav-item dropdown no-arrow mx-1">
                                <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-bell fa-fw"></i>
                                    <!-- Counter - Alerts -->
                                    <span class="badge badge-danger badge-counter">3+</span>
                                </a>
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
                            </li> --}}

                            <!-- Nav Item - Messages -->
                            {{-- <li class="nav-item dropdown no-arrow mx-1">
                                <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-envelope fa-fw"></i>
                                    <!-- Counter - Messages -->
                                    <span class="badge badge-danger badge-counter">7</span>
                                </a>
                                <!-- Dropdown - Messages -->
                                <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                    aria-labelledby="messagesDropdown">
                                    <h6 class="dropdown-header">
                                        Message Center
                                    </h6>
                                    <a class="dropdown-item d-flex align-items-center" href="#">
                                        <div class="dropdown-list-image mr-3">
                                            <img class="rounded-circle" src="img/undraw_profile_1.svg" alt="...">
                                            <div class="status-indicator bg-success"></div>
                                        </div>
                                        <div class="font-weight-bold">
                                            <div class="text-truncate">Hi there! I am wondering if you can help me with
                                                a
                                                problem I've been having.</div>
                                            <div class="small text-gray-500">Emily Fowler · 58m</div>
                                        </div>
                                    </a>
                                    <a class="dropdown-item d-flex align-items-center" href="#">
                                        <div class="dropdown-list-image mr-3">
                                            <img class="rounded-circle" src="img/undraw_profile_2.svg" alt="...">
                                            <div class="status-indicator"></div>
                                        </div>
                                        <div>
                                            <div class="text-truncate">I have the photos that you ordered last month,
                                                how
                                                would you like them sent to you?</div>
                                            <div class="small text-gray-500">Jae Chun · 1d</div>
                                        </div>
                                    </a>
                                    <a class="dropdown-item d-flex align-items-center" href="#">
                                        <div class="dropdown-list-image mr-3">
                                            <img class="rounded-circle" src="img/undraw_profile_3.svg" alt="...">
                                            <div class="status-indicator bg-warning"></div>
                                        </div>
                                        <div>
                                            <div class="text-truncate">Last month's report looks great, I am very happy
                                                with
                                                the progress so far, keep up the good work!</div>
                                            <div class="small text-gray-500">Morgan Alvarez · 2d</div>
                                        </div>
                                    </a>
                                    <a class="dropdown-item d-flex align-items-center" href="#">
                                        <div class="dropdown-list-image mr-3">
                                            <img class="rounded-circle"
                                                src="https://source.unsplash.com/Mv9hjnEUHR4/60x60" alt="...">
                                            <div class="status-indicator bg-success"></div>
                                        </div>
                                        <div>
                                            <div class="text-truncate">Am I a good boy? The reason I ask is because
                                                someone
                                                told me that people say this to all dogs, even if they aren't good...
                                            </div>
                                            <div class="small text-gray-500">Chicken the Dog · 2w</div>
                                        </div>
                                    </a>
                                    <a class="dropdown-item text-center small text-gray-500" href="#">Read More
                                        Messages</a>
                                </div>
                            </li> --}}

                            <div class="topbar-divider d-none d-sm-block"></div>

                            <!-- Nav Item - User Information -->
                            @auth
                                <li class="nav-item dropdown no-arrow">
                                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span
                                            class="mr-2 d-none d-lg-inline text-gray-600 small">{{ auth()->user()->name }}</span>
                                        @foreach (Auth::user()->media as $item)
                                            <img class="img-profile rounded-circle"
                                                src="{{ asset('storage/profile/' . $item['filename'] . '.' . $item['extension']) }}">
                                        @endforeach
                                    </a>
                                    <!-- Dropdown - User Information -->
                                    <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                        aria-labelledby="userDropdown">
                                        <a class="dropdown-item" href="{{ route('profile') }}">
                                            <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                            {{ __('dashboard.profile') }}
                                        </a>
                                        <a class="dropdown-item" href="#">
                                            <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                            {{ __('dashboard.settings') }}
                                        </a>
                                        <a class="dropdown-item" href="{{ route('password.edit') }}">
                                            <i class="fa-solid fa-lock fa-sm fa-fw mr-2 text-gray-400"></i>
                                            {{ __('dashboard.change_password') }}
                                        </a>
                                        <a class="dropdown-item" href="#">
                                            <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                            {{ __('dashboard.activity_log') }}
                                        </a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="{{ route('logout') }}" data-toggle="modal"
                                            data-target="#logoutModal">
                                            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                            {{ __('dashboard.logout') }}
                                        </a>
                                    </div>
                                </li>
                            @endauth


                        </ul>

                    </nav>
                    <!-- End of Topbar -->
                    @if (request()->route()->getName() == 'password.edit')
                        @yield('password.edit')
                    @endif
                    @if (request()->route()->getName() == 'event.index')
                        @yield('event.index')
                    @endif
                    @if (request()->route()->getName() == 'profile')
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
                    @if (request()->route()->getName() == 'event.edit' ||
                            request()->route()->getName() == 'event.create')
                        @yield('event.create')
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


                </div>


                {{-- @if (request()->route()->getName() == 'admin.company.edit')
                    @yield('edit')
                @endif --}}
                <!-- End of Main Content -->

                <!-- Footer -->
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
    </div>


@endsection
