    <header class="header-section">
        <div class="container">
            <div class="logo">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('user_assets/img/logo.png') }}" alt="">
                </a>
            </div>
            <div class="row mt-5 ml-0">
                <div class="col-md-2 col-md-offset-6 text-right">
                    <strong> {{__('header_select_lang')}} </strong>
                </div>
                <div class="col-md-4">
                    <select class="form-control changeLang">
                        <option value="en" {{ session()->get('locale') == 'en' ? 'selected' : '' }}>
                            {{__('lang_en')}}
                        </option>
                        <option value="gu" {{ session()->get('locale') == 'gu' ? 'selected' : '' }}>
                            {{__('lang_gu')}}
                        </option>

                    </select>
                </div>
            </div>
            <div class="nav-menu">
                <nav class="mainmenu mobile-menu">
                    <ul>
                        <li>
                            {{-- <div class="flex justify-center pt-8 sm:justify-start sm:pt-0">
                                @foreach ($available_locales as $locale_name => $available_locale)
                                    @php

                                        $current_locale = session(['locale']);
                                    @endphp

                                    @if ($available_locale === $current_locale)
                                        <span class="ml-2 mr-2 text-gray-700">{{ $locale_name }}</span>
                                    @else
                                        <a class="ml-1 underline ml-2 mr-2" href="{{ $available_locale }}">
                                            <span>{{ $locale_name }}</span>
                                        </a>
                                    @endif
                                @endforeach
                            </div> --}}

                        </li>
                        @auth
                            <li><a href="{{ route('user.contact-us.index') }}">{{ __('header_contact_us') }}</a></li>


                            <li> <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span
                                        class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->name }}</span>
                                    @foreach (Auth::user()->media as $item)
                                        <img class="img-profile rounded-circle" width="40px" style="border-radius: 50%"
                                            height="40px"
                                            src="{{ asset('storage/profile/' . $item['filename'] . '.' . $item['extension']) }}">
                                    @endforeach
                                </a>

                                <ul class="dropdown">
                                    <li><a href="{{ route('user.profile.index') }}">{{ __('header_my_profile') }}</a>
                                    </li>
                                    <li><a
                                            href="{{ route('user.change-password.edit', ['change_password' => Auth::id()]) }}">{{ __('header_change_password') }}</a>
                                    </li>
                                    <li> <a href="{{ route('user.booking.index') }}">
                                            {{ __('header_booking_history') }}
                                        </a> </li>

                                    <li><a data-toggle="modal" data-target="#logoutModal"> {{ __('header_logout') }} </a>
                                    </li>

                                </ul>
                            </li>
                        @endauth
                        @guest
                            <a style="padding: 12px" href="{{ route('login') }}" class="primary-btn top-btn"><i
                                    class="fa fa-ticket"></i> {{__('header_login')}} </a>
                        @endguest
                    </ul>

            </div>

            <!-- Logout Modal-->
            <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel"> {{__('dashboard_logout_modal_header')}}  </h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body"> {{__('dashboard_logout_modal_body')}}
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal"> {{__('dashboard_logout_modal_cancel')}} </button>
                            <a class="btn btn-primary" href="{{ route('logout') }}">  {{__('dashboard_logout_modal_logout')}}</a>
                        </div>
                    </div>
                </div>
            </div>
            <div id="mobile-menu-wrap"></div>
        </div>
        </nav>

        <script type="text/javascript">
            var url = "{{ route('changeLang') }}";
            $(".changeLang").change(function() {
                window.location.href = url + "?lang=" + $(this).val();
            });
        </script>
    </header>
