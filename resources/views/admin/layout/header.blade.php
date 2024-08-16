<header id="page-topbar">
    <div class="layout-width">
        <div class="navbar-header">
            <div class="d-flex">

                <!-- LOGO -->
{{--                <div class="navbar-brand-box horizontal-logo">--}}
{{--                    <a href="index.html" class="logo logo-dark">--}}
{{--                        <span class="logo-sm">--}}
{{--                            <img src="assets/images/logo-sm.png" alt="" height="22">--}}
{{--                        </span>--}}
{{--                        <span class="logo-lg">--}}
{{--                            <img src="assets/images/logo-dark.png" alt="" height="21">--}}
{{--                        </span>--}}
{{--                    </a>--}}

{{--                    <a href="index.html" class="logo logo-light">--}}
{{--                        <span class="logo-sm">--}}
{{--                            <img src="assets/images/logo-sm.png" alt="" height="22">--}}
{{--                        </span>--}}
{{--                        <span class="logo-lg">--}}
{{--                            <img src="assets/images/logo-light.png" alt="" height="21">--}}
{{--                        </span>--}}
{{--                    </a>--}}
{{--                </div>--}}

                <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger" id="topnav-hamburger-icon">
                    <span class="hamburger-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </button>

                <!-- App Search-->
                <form class="app-search  ms-2">
                    <div class="position-relative">
                            <div class="mt-1">
                                <a href="{{ route('admin.invoices.create') }}" class="btn btn-primary">Send Invoice</a>
                            </div>
                    </div>
                </form>

            </div>

            <div class="d-flex align-items-center">



                <div class="ms-1 header-item d-none d-sm-flex">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-primary rounded-circle" data-toggle="fullscreen">
                        <i class='las la-expand fs-24'></i>
                    </button>
                </div>

                <div class="ms-1 header-item d-none d-sm-flex">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-primary rounded-circle light-dark-mode">
                        <i class='las la-moon fs-24'></i>
                    </button>
                </div>

                <div class="dropdown header-item">
                    <button type="button" class="btn" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="d-flex align-items-center">
                            <img class="rounded-circle header-profile-user" src="{{ asset('assets/images/users/avatar-4.jpg') }}" alt="Header Avatar">
                            <span class="text-start ms-xl-2">
                                <span class="d-none d-xl-inline-block fw-medium user-name-text fs-16">
                                    {{Sentinel::getUser()->first_name}}  {{Sentinel::getUser()->last_name}}
                                    <i class="las la-angle-down fs-12 ms-1"></i>
                                </span>
                            </span>
                        </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <!-- item-->
                        <a class="dropdown-item" href="{{ route('profile.setting') }}"><i class="bx bx-user fs-15 align-middle me-1"></i> <span key="t-profile">Profile</span></a>
                        <a class="dropdown-item d-block" href="{{ route('site_setting') }}">
                            <i class="bx bx-wrench fs-15 align-middle me-1"></i>
                            <span key="t-settings">Site Settings</span></a>
                        <a class="dropdown-item d-block" href="{{ route('activity-logs') }}">
                            <i class="bx bx-list-ul fs-15 align-middle me-1"></i>
                            <span key="t-settings">Activity Logs</span></a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item text-danger" href="{{ url('logout') }}">
                            <i class="bx bx-power-off fs-15 align-middle me-1 text-danger"></i>
                            <span key="t-logout">Logout</span></a>

                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
