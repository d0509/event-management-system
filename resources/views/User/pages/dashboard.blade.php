@extends('layouts.userlayout')
@section('dashboard')
    <header class="header-section">
        <div class="container">
            <div class="logo">
                <a href="index-2.html">
                    <img src="{{ asset('user_assets/img/logo.png') }}" alt="">
                </a>
            </div>
            <div class="nav-menu">
                <nav class="mainmenu mobile-menu">
                    <ul>
                        <li><a href="{{ route('homepage') }}">{{ __('dashboard.home') }}</a></li>






                        @auth
                            <li><a href="{{ route('logout') }}">Logout</a></li>
                        @endauth

                        @auth
                            <li> <a style="padding: 12px " class="primary-btn top-btn text-light"></i>
                                    Welcome,{{ auth()->user()->name }}</a>

                                <ul class="dropdown">
                                    <li><a href="{{ route('user.profile.edit', ['profile' => Auth::id()]) }}">User Profile</a>
                                    </li>
                                    <li><a href="{{route('user.password.edit')}}">Change Password</a></li>
                                </ul>
                            </li>
                        @endauth
                        @guest
                            <a style="padding: 12px" href="{{ route('login') }}" class="primary-btn top-btn"><i
                                    class="fa fa-ticket"></i> Login </a>
                        @endguest
                    </ul>

            </div>
            <div id="mobile-menu-wrap"></div>
        </div>
        </nav>
    </header>
    @if (request()->route()->getName() == 'homepage')
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
    @elseif(request()->route()->getName() == 'user.password.edit')
        @yield('user.password.edit')
    @endif
@endsection
{{-- header section --}}
