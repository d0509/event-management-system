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
                        <li ><a href="{{ route('homepage') }}">{{__('dashboard.home')}}</a></li>
                        {{-- @if (request()->route()->getName() == 'companyDashboard' ||
                                request()->route()->getName() == 'company.event.create' ||
                                request()->route()->getName() == 'company.event.index' ||
                                request()->route()->getName() == 'company.event.edit')
                            <li><a href="{{ route('company.event.index') }}">Events</a>
                        @endif --}}
                        
                        </li>
                        {{-- @if (request()->route()->getName() == 'companyDashboard' ||
                                request()->route()->getName() == 'company.event.create' ||
                                request()->route()->getName() == 'company.event.index' || 
                                request()->route()->getName() == 'company.event.edit')
                            <li><a href="{{ route('company.event.create') }}">Add Event</a></li>
                        @endif --}}

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
    @if (request()->route()->getName() == 'homepage')        
    @yield('events')
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
    @endif
@endsection
{{-- header section --}}
