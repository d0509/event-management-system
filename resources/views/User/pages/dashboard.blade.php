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
                        <li ><a href="{{ route('companyDashboard') }}">Home</a></li>
                        @if (request()->route()->getName() == 'companyDashboard' ||
                                request()->route()->getName() == 'event.create' ||
                                request()->route()->getName() == 'event.index' ||
                                request()->route()->getName() == 'event.edit')
                            <li><a href="{{ route('event.index') }}">Events</a>
                        @endif
                        
                        </li>
                        @if (request()->route()->getName() == 'companyDashboard' ||
                                request()->route()->getName() == 'event.create' ||
                                request()->route()->getName() == 'event.index' || 
                                request()->route()->getName() == 'event.edit')
                            <li><a href="{{ route('event.create') }}">Add Event</a></li>
                        @endif

                        {{-- <li><a href="blog.html">Blog</a></li>
                        <li><a href="contact.html">Contacts</a></li> --}}
                        @auth
                            <li><a href="{{ route('logout') }}">Logout</a></li>
                        @endauth
                    </ul>
                </nav>
                @auth
                    <a class="primary-btn top-btn text-light"><i class="fa fa-ticket"></i> Welcome,
                        {{ auth()->user()->name }}</a>
                @endauth
                @guest
                    <a href="{{ route('login') }}" class="primary-btn top-btn"><i class="fa fa-ticket"></i> Login </a>
                @endguest
            </div>
            <div id="mobile-menu-wrap"></div>
        </div>
    </header>
    @yield('events')
    @if (request()->route()->getName() == 'companyDashboard')
        @yield('hero')
    @elseif(request()->route()->getName() == 'event.create' || request()->route()->getName() == 'event.edit' )
        @yield('createEvent')
    @elseif(request()->route()->getName() == 'event.index')
        @yield('event.index')
    @endif
@endsection
{{-- header section --}}
