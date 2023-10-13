@extends('layouts.user-layout')
{{-- @extends('User.pages.footer') --}}
@section('dashboard')
    <header class="header-section">
        <div class="container">
            <div class="logo">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('user_assets/img/logo.png') }}" alt="">
                </a>
            </div>
            <div class="nav-menu">
                <nav class="mainmenu mobile-menu">
                    <ul>
                        {{-- <li><a href="{{ route('home') }}">{{ __('dashboard.home') }}</a></li>                        --}}
                        @auth
                            <li><a href="{{ route('user.contact-us.index') }}">{{ __('dashboard.contact_us') }}</a></li>
                            {{-- <li><a href="{{ route('user.attend-event.index') }}">{{ __('dashboard.attend_event') }}</a></li> --}}
                            <li> <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->name }}</span>
                                    @foreach (Auth::user()->media as $item)
                                        <img class="img-profile rounded-circle" width="40px" style="border-radius: 50%"
                                            height="40px"
                                            src="{{ asset('storage/profile/' . $item['filename'] . '.' . $item['extension']) }}">
                                    @endforeach
                                </a>

                                <ul class="dropdown">
                                    <li><a
                                            href="{{ route('user.profile.edit', ['profile' => Auth::id()]) }}">{{ __('dashboard.user_profile') }}</a>
                                    </li>
                                    <li><a
                                            href="{{ route('user.change-password.edit', ['change_password' => Auth::id()]) }}">{{ __('dashboard.change_password') }}</a>
                                    </li>
                                    <li> <a href="{{ route('user.booking.index') }}"> {{ __('dashboard.booking_history') }}
                                        </a> </li>

                                    <li><a data-toggle="modal" data-target="#logoutModal">Logout</a></li>

                                </ul>
                            </li>
                        @endauth
                        @guest
                            <a style="padding: 12px" href="{{ route('login') }}" class="primary-btn top-btn"><i
                                    class="fa fa-ticket"></i> Login </a>
                        @endguest
                    </ul>

            </div>

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
            <div id="mobile-menu-wrap"></div>
        </div>
        </nav>
    </header>
    @if (request()->route()->getName() == 'home')
        @yield('events')
    @elseif(request()->route()->getName() == 'user.profile.edit')
        @yield('user.profile')
    @endif
    {{-- @if (request()->route()->getName() == 'companyDashboard')
        @yield('hero')
    @elseif(request()->route()->getName() == 'company.event.create' || request()->route()->getName() == 'company.event.edit' )
        @yield('createEvent')
    @elseif(request()->route()->getName() == 'company.event.index')
        @yield('company.event.index')
    @endif --}}

    @if (request()->route()->getName() == 'user.event.show')
        @yield('showEvent')
    @elseif(request()->route()->getName() == 'book_ticket')
        @yield('book_ticket')
    @elseif(request()->route()->getName() == 'user.change-password.edit')
        @yield('user.password.edit')
    @elseif(request()->route()->getName() == 'user.booking.index')
        @yield('user.booking.history')
    @elseif(request()->route()->getName() == 'user.booking.show')
        @yield('user.booking.show')
    @elseif(request()->route()->getName() == 'user.contact-us.index')
        @yield('user.contact_us.create')
    @endif
    @yield('footer')
@endsection

