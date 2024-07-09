<div class="topheader ">
    <div class="container">
        <div class="row">
            <div class="col-3 col-md-1">
                <div class="logo py-2">
                    <a href="{{ route('home') }}"><img
                            src="{{ getImageUrl(setting('logo') ? setting('logo') : 'assets/images/assets/logo.png') }}"
                            alt="NSN Hotels Logo"></a>
                </div>
            </div>
            <div class="col-6 col-md-11 text-right bg-white">
                <div class="mobilebtn mt-1 mt-md-0">
                    <span class="fas fa-bars"></span>
                </div>
                <nav class="sidebar topnavi">
                    <div class="logo">
                        <a href="{{ route('home') }}">
                            <img src="{{ getImageUrl(setting('logo') ? setting('logo') : 'assets/images/assets/logo.png') }}"
                                alt="NSN Hotels Logo"></a>
                    </div>
                    <ul class="d-md-flex align-items-center justify-content-end">

                        <li class="nav-item custom-fs-16 custom-fw-700 mx-md-3 ">
                            <a href="/" class="nav-link" title="Sign in"><i class="fas fa-home"></i>
                                <span>Home</span></a>
                        </li>
                        @guest

                            <li class="nav-item custom-fs-16 custom-fw-700 mx-md-3 ">
                                <a href="{{ route('user_login') }}" class="nav-link" title="Sign in"><i
                                        class="fas fa-user"></i> <span>Sign in</span></a>
                            </li>

                            <li class="nav-item custom-fs-16 custom-fw-700 mx-md-3 ">
                                <a href="{{ route('user_register') }}" class="nav-link" title="Sign in"><i
                                        class="fas fa-user"></i> <span>Sign up</span></a>
                            </li>
                            <li class="nav-item custom-fs-16 custom-fw-700 mx-md-3 ">
                                <a href="/refer"class="nav-link" title="Refer &amp; Earn Money"><i
                                        class="fas fa-user-plus"></i> <span>Refer &amp; Earn Money</span></a>
                            </li>
                            <li class="nav-item custom-fs-16 custom-fw-700 mx-md-3 ">
                                <a href="{{ route('corporate') }}"class="nav-link " title="Corporate Offer"><i
                                        class="fas fa-handshake"></i> <span>Corporate Offer</span></a>
                            </li>
                            <li class="nav-item custom-fs-16 custom-fw-700 mx-md-3">
                                <span>
                                    <a href="https://nsnwedding.in/"
                                        class="custom-bg-primary custom-border-radius-20  text-white py-2 px-3">
                                        <i class="fas fa-briefcase"></i> <span class="profilename">Book Your Events</span>
                                    </a>
                                </span>
                            </li>
                            <li class="nav-item custom-fs-16 custom-fw-700 mx-md-3 d-none d-md-inline-block">
                                <a href="{{ route('become_a_partner') }}"
                                    class="nav-link bg-purple custom-border-radius-20  text-white py-2 px-3"
                                    title="Become A Partner"><i class="fas fa-money-check"></i>
                                    <span>{{ __('List Your Property') }}</span></a>
                            </li>
                        @else
                            @if (Auth::user()->is_corporate == 1)
                                <li class="nav-item custom-fs-16 custom-fw-700 mx-md-3">
                                    <span>
                                        <a href="#" title="{{ Auth::user()->name }}">
                                            <i class="fas fa-handshake"></i> <span class="profilename"
                                                class="color_primary">Corporate Account </span>
                                        </a>
                                    </span>
                                </li>
                            @endif
                            <li class="nav-item custom-fs-16 custom-fw-700 mx-md-3">
                                <span>
                                    <a href="{{ route('user_my_place') }}" title="{{ Auth::user()->name }}">
                                        <i class="fas fa-user-tie"></i> Profile</span>
                                </a>
                                </span>
                            </li>


                            <li class="nav-item custom-fs-16 custom-fw-700 mx-md-3"><a href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                                        class="fas fa-sign-out-alt"></i> {{ __('Logout') }}</a>
                                <form class="d-none" id="logout-form" action="{{ route('logout') }}" method="POST">
                                    @csrf
                                </form>
                            </li>
                            @if (Auth::id())
                                <li class="nav-item custom-fs-16 custom-fw-700  mx-md-3">
                                    <a href="/refer"class="nav-link" title="Refer &amp; Earn Money"><i
                                            class="fas fa-user-plus"></i> <span>Refer &amp; Earn Money</span></a>
                                </li>
                                <li class="nav-item custom-fs-16 custom-fw-700 mx-md-3">
                                    <a href="{{ route('corporate') }}"class="nav-link" title="Corporate Offer"><i
                                            class="fas fa-handshake"></i> <span>Corporate Offer</span></a>
                                </li>
                            @endif

                            <li class="nav-item custom-fs-16 custom-fw-700 mx-md-3">
                                <span>
                                    <a href="https://nsnwedding.in/"
                                        class="custom-bg-secondary custom-border-radius-20  text-white py-2 px-3">
                                        <i class="fas fa-briefcase"></i> <span class="profilename">Book Your Events</span>
                                    </a>
                                </span>
                            </li>
                            <li class="nav-item custom-fs-16 custom-fw-700 mx-md-3">
                                <a href="{{ route('become_a_partner') }}"
                                    class="nav-link bg-purple custom-border-radius-20  text-white py-2 px-3 nav-link"
                                    title="Become A Partner"><i class="fas fa-money-check"></i>
                                    <span>{{ __('List Your Property') }}</span></a>
                            </li>
                        @endguest

                        <li class="desktopnone nav-item custom-fs-16 custom-fw-700 pl-3">
                            <a href="{{ url('post/about-us-10') }}" target="_blank">
                                <p><i class="fas fa-info"></i> About</p>
                            </a>
                        </li>
                        <li class="desktopnone nav-item custom-fs-16 custom-fw-700 pl-3">
                            <a href="{{ url('post/faqs-11') }}" target="_blank">
                                <p><i class="fas fa-question"></i> FAQ</p>
                            </a>
                        </li>
                        <li class="desktopnone nav-item custom-fs-16 custom-fw-700 pl-3">
                            <a href="https://nsnhotels.in" target="_blank">
                                <p><i class="fas fa-box"></i> Packages</p>
                            </a>
                        </li>
                        <!--	<li class="desktopnone">
           <a href="{{ route('post_list_all') }}" target="_blank">
            <p><i class="fas fa-newspaper"></i> Newspaper</p>
           </a>
          </li>-->
                        <li class="desktopnone nav-item custom-fs-16 custom-fw-700 pl-3">
                            <a href="{{ route('page_contact') }}" target="_blank">
                                <p><i class="fas fa-phone"></i> Contact</p>
                            </a>
                        </li>



                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
