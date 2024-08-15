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
        <a href="{{ route('accountant.dashboard') }}" class="logo logo-dark @yield('dashboard-page')">
                    <span class="logo-sm">
                        <img src="{{ asset('assets/logo/'.App\Helpers\AppHelper::dark_logo()) }}" class="logo">
                    </span>
            <span class="logo-lg">
                        <img src="{{ asset('assets/logo/'.App\Helpers\AppHelper::dark_logo()) }}" class="logo">
                    </span>
        </a>
        <!-- Light Logo-->
        <a href="{{ route('accountant.dashboard') }}" class="logo logo-light @yield('dashboard-page')">
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
                    <a class="nav-link menu-link @yield('dashboard-page')" href="{{ route('accountant.dashboard') }}">
                        <i class="las fs-20 la-house-damage"></i> <span data-key="t-dashboard">Dashboard</span>
                    </a>
                </li>


                <li class="nav-item">
                    <a class="nav-link menu-link collapsed @yield('taxes-discounts-dropdown')" href="#taxes-discounts" data-bs-toggle="collapse" role="button" aria-expanded="true" aria-controls="taxes-discounts">
                        <i class="las fs-20 la-percent"></i>
                        <span data-key="t-products">
                            Tax/Charges
                        </span>
                    </a>
                    <div class="collapse menu-dropdown @yield('taxes-discounts-dropdown-show')" id="taxes-discounts">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('accountant.taxes.index') }}" class="nav-link @yield('taxes-page')" data-key="t-taxes"> Taxes </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('accountant.discounts.index') }}" class="nav-link  @yield('discounts-page')" data-key="t-discounts"> Discounts </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('accountant.shipping-charges.index') }}" class="nav-link @yield('shipping-charges-page')" data-key="t-shipping-charges">Shipping Charges </a>
                            </li>

                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link collapsed @yield('products-dropdown')" href="#sidebarProducts" data-bs-toggle="collapse" role="button" aria-expanded="true" aria-controls="sidebarProducts">
                        <i class="las fs-20 la-shopping-bag"></i>
                        <span data-key="t-products">
                             Products
                        </span>
                    </a>
                    <div class="collapse menu-dropdown @yield('products-dropdown-show')" id="sidebarProducts">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('accountant.products.index') }}" class="nav-link @yield('product-list-page')" data-key="t-product-list"> Product List </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('accountant.products.create') }}" class="nav-link @yield('product-create-page')" data-key="t-add-product"> Add Product </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('accountant.brands.index') }}" class="nav-link @yield('brands-page')" data-key="t-brands"> Brand List </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('accountant.categories.index') }}" class="nav-link @yield('categories-page')" data-key="t-categories">Category List </a>
                            </li>

                        </ul>
                    </div>
                </li>





                <div class="help-box text-center">
                    <p class="mb-2 text-muted">Create Product</p>
                    <div class="mt-1">
                        <a href="{{ route('accountant.products.create') }}" class="btn btn-primary"> Create Now</a>
                    </div>
                </div>

            </ul>
        </div>
        <!-- Sidebar -->
    </div>

    <div class="sidebar-background"></div>
</div>
<!-- Left Sidebar End -->
