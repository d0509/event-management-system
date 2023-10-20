@extends('frontend.master.layout')
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
                       
                        @auth
                            <li><a href="{{ route('user.contact-us.index') }}">{{ __('dashboard_contact_us') }}</a></li>
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
                                            href="{{ route('user.profile.edit', ['profile' => Auth::id()]) }}">{{ __('dashboard_user_profile') }}</a>
                                    </li>
                                    <li><a
                                            href="{{ route('user.change-password.edit', ['change_password' => Auth::id()]) }}">{{ __('dashboard_change_password') }}</a>
                                    </li>
                                    <li> <a href="{{ route('user.booking.index') }}"> {{ __('dashboard.booking_history') }}
                                        </a> </li>

                                    <li><a data-toggle="modal" data-target="#logoutModal"> {{__('dashboard.logout')}} </a></li>

                                </ul>
                            </li>
                        @endauth
                        @guest
                            <a style="padding: 12px" href="{{ route('login') }}" class="primary-btn top-btn"><i
                                    class="fa fa-ticket"></i> {{__('dashboard.login')}} </a>
                        @endguest
                    </ul>

            </div>

            <!-- Logout Modal-->
            <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel"> {{__('dashboard_logout_modal_header')}} </h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body"> {{__('dashboard_logout_modal_body')}} </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal"> {{__('dashboard_logout_modal_cancel')}} </button>
                            <a class="btn btn-primary" href="{{ route('logout') }}"> {{__('dashboard_logout_modal_logout')}} </a>
                        </div>
                    </div>
                </div>
            </div>
            <div id="mobile-menu-wrap"></div>
        </div>
        </nav>
    </header>
    
@endsection
