<!-- ========== Left Sidebar Start ========== -->
<style>
    .logo {
        width: 200px !important;
        height: 66px !important;
    }
</style>
<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="{{ route('customer.dashboard') }}" class="logo logo-dark @yield('dashboard-page')">
                    <span class="logo-sm">
                        <img src="{{ asset('assets/logo/'.App\Helpers\AppHelper::dark_logo()) }}" class="logo">
                    </span>
            <span class="logo-lg">
                        <img src="{{ asset('assets/logo/'.App\Helpers\AppHelper::dark_logo()) }}" class="logo">
                    </span>
        </a>
        <!-- Light Logo-->
        <a href="{{ route('customer.dashboard') }}" class="logo logo-light @yield('dashboard-page')">
                    <span class="logo-sm">
                        <img src="{{ asset('assets/logo/'.App\Helpers\AppHelper::dark_logo()) }}" class="logo">
                    </span>
            <span class="logo-lg">
                        <img src="{{ asset('assets/logo/'.App\Helpers\AppHelper::dark_logo()) }}" class="logo">
                    </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link menu-link @yield('dashboard-page')" href="{{ route('customer.dashboard') }}">
                        <i class="las fs-20 la-house-damage"></i> <span data-key="t-dashboard">Dashboard</span>
                    </a>
                </li>


                <li class="nav-item">
                    <a class="nav-link menu-link @yield('invoices-dropdown')" href="{{ route('customer.invoices.index') }}" aria-expanded="false">
                        <i class="las fs-20 la-file-invoice"></i>
                        <span data-key="t-Invoices">Invoices</span>
                    </a>
                </li>


                <li class="nav-item">
                    <a class="nav-link menu-link @yield('transactions-page')" href="{{ route('customer.invoices.transactions') }}" aria-expanded="false">
                        <i class="las fs-20 la-money-check-alt"></i>
                        <span data-key="t-Transactions">Transactions</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link @yield('invoices-sales-page')" href="{{ route('customer.invoices.sales') }}" aria-expanded="false">
                        <i class="las fs-20 la-paste"></i>
                        <span data-key="t-Transactions">Sale Reports</span>
                    </a>
                </li>


            </ul>
        </div>
        <!-- Sidebar -->
    </div>

    <div class="sidebar-background"></div>
</div>
<!-- Left Sidebar End -->
