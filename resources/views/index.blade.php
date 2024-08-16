<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="light" data-sidebar-size="lg"
      data-sidebar-image="none" data-preloader="disable">

<head>
    <meta charset="utf-8">
    <title>{{ App\Helpers\AppHelper::site_name() }} | @yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="{{ App\Helpers\AppHelper::site_name() }}">
    <!-- App favicon -->
    <link rel="shortcut icon" style="height: 80px; width: 120px;" href="{{ asset('assets/logo/'.App\Helpers\AppHelper::fav_icon()) }}">
    <link href="{{ asset('assets/libs/jsvectormap/css/jsvectormap.min.css') }}" rel="stylesheet" type="text/css">
    <script src="{{ asset('assets/js/layout.js') }}"></script>
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css">
<style>
    div:where(.swal2-container) button:where(.swal2-styled):where(.swal2-confirm) {
        border: 0;
        border-radius: .25em;
        background-color: #ffaa33 !important;
        color: #fff;
        font-size: 1em;
    }
    .swal2-icon.swal2-success .swal2-success-ring {
        border-color: #ffaa33 !important;
    }
    .bg-primary {
        --in-bg-opacity: 1;
        background-color: rgb(255 191 104) !important;
    }
</style>
</head>
<body class="auth-bg 100-vh">
<div class="bg-overlay bg-light"></div>

<div class="account-pages">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-11">
                <div class="auth-full-page-content d-flex min-vh-100 py-sm-5 py-4">
                    <div class="w-100">
                        <div class="d-flex flex-column h-100 py-0">
                            <div class="text-center mb-2">
                                <a href="{{ url('/') }}">
                                    <span class="logo-lg">
                                        <img src="{{ asset('assets/logo/'.App\Helpers\AppHelper::dark_logo()) }}" alt="" height="66">
                                    </span>
                                </a>
                            </div>
                            <div class="card my-auto overflow-hidden">
                                <div class="row g-0">
                                    <div class="col-lg-6">

                                        <div class="p-lg-5 p-4">

                                            <div class="text-center">
                                                <h5 class="mb-0">Welcome Back !</h5>
                                                <p class="text-muted mt-2">Sign in to continue to {{ App\Helpers\AppHelper::site_name() }}.</p>
                                            </div>

                                            <div class="mt-4">
                                                <form action="{{ route('post.login') }}" method="post"
                                                      class="auth-input">
                                                    @csrf
                                                    <div class="mb-3">
                                                        <label for="email" class="form-label">Email</label>
                                                        <input class="form-control" name="email" type="email" id="email"
                                                               required="" placeholder="admin@admin.com" value="admin@admin.com">
                                                        @if ($errors->has('email'))
                                                            <span
                                                                class="text-danger mt-1 error invalid-tooltip">{{ $errors->first('email') }}</span>
                                                        @endif
                                                    </div>

                                                    <div class="mb-2">
                                                        <label for="userpassword" class="form-label">Password</label>
                                                        <div class="position-relative auth-pass-inputgroup mb-3">
                                                            <input name="password" type="password"
                                                                   class="form-control pe-5 password-input"
                                                                   placeholder="Enter password" id="password-input" required value="12345678" >
                                                            @if ($errors->has('password'))
                                                                <span
                                                                    class="text-danger mt-1 error invalid-tooltip">{{ $errors->first('password') }}</span>
                                                            @endif
                                                            <button
                                                                class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon"
                                                                type="button" id="password-addon">
                                                                <i class="las la-eye align-middle fs-18"></i>
                                                            </button>
                                                        </div>
                                                    </div>


                                                    <div class="mt-2">
                                                        <button class="btn btn-primary w-100" type="submit">Log In
                                                        </button>
                                                    </div>

                                                </form>
                                            </div>

                                        </div>
                                    </div>


                                    <div class="col-lg-6">
                                        <div class="d-flex h-100 bg-auth align-items-end">
                                            <div class="p-lg-5 p-4">
                                                <div class="bg-overlay bg-primary"></div>
                                                <div class="p-0 p-sm-4 px-xl-0 py-5">
                                                    <div id="reviewcarouselIndicators" class="carousel slide auth-carousel" data-bs-ride="carousel">
                                                        <div class="carousel-indicators carousel-indicators-rounded">
                                                            <button type="button" data-bs-target="#reviewcarouselIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                                                            <button type="button" data-bs-target="#reviewcarouselIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                                                            <button type="button" data-bs-target="#reviewcarouselIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                                                            <button type="button" data-bs-target="#reviewcarouselIndicators" data-bs-slide-to="3" aria-label="Slide 4"></button>
                                                            <button type="button" data-bs-target="#reviewcarouselIndicators" data-bs-slide-to="4" aria-label="Slide 5"></button>
                                                            <button type="button" data-bs-target="#reviewcarouselIndicators" data-bs-slide-to="5" aria-label="Slide 6"></button>
                                                            <button type="button" data-bs-target="#reviewcarouselIndicators" data-bs-slide-to="6" aria-label="Slide 7"></button>
                                                            <button type="button" data-bs-target="#reviewcarouselIndicators" data-bs-slide-to="7" aria-label="Slide 8"></button>
                                                        </div>

                                                        <!-- end carouselIndicators -->
                                                        <div class="carousel-inner mx-auto">
                                                            <div class="carousel-item active">
                                                                <div class="testi-contain text-center">
                                                                    <h5 class="fs-20 text-white mb-0">“Effortless Invoice Management”</h5>
                                                                    <p class="fs-17 text-white mt-2 mb-0">
                                                                        Our system simplifies invoice creation and management. With intuitive interfaces and powerful features, you can handle invoicing tasks effortlessly, ensuring timely payments and accurate records.
                                                                    </p>
                                                                </div>
                                                            </div>

                                                            <div class="carousel-item">
                                                                <div class="testi-contain text-center">
                                                                    <h5 class="fs-20 text-white mb-0">“Comprehensive Client Management”</h5>
                                                                    <p class="fs-17 text-white mt-2 mb-0">
                                                                        Store detailed client information with ease. Manage billing and shipping addresses efficiently for accurate and professional invoices.
                                                                    </p>
                                                                </div>
                                                            </div>

                                                            <div class="carousel-item">
                                                                <div class="testi-contain text-center">
                                                                    <h5 class="fs-20 text-white mb-0">“Integrated Stripe Payments”</h5>
                                                                    <p class="fs-17 text-white mt-2 mb-0">
                                                                        Simplify payments with Stripe integration. Send invoices with secure payment links directly to clients' emails for a seamless payment experience.
                                                                    </p>
                                                                </div>
                                                            </div>

                                                            <div class="carousel-item">
                                                                <div class="testi-contain text-center">
                                                                    <h5 class="fs-20 text-white mb-0">“Dynamic Tax & Discount Management”</h5>
                                                                    <p class="fs-17 text-white mt-2 mb-0">
                                                                        Manage taxes and discounts dynamically, tailored to different regions. Easily configure rates for compliance and pricing strategies.
                                                                    </p>
                                                                </div>
                                                            </div>

                                                            <div class="carousel-item">
                                                                <div class="testi-contain text-center">
                                                                    <h5 class="fs-20 text-white mb-0">“Real-time Stock Management”</h5>
                                                                    <p class="fs-17 text-white mt-2 mb-0">
                                                                        Track product availability and manage out-of-stock items with real-time updates, ensuring accurate and up-to-date inventory.
                                                                    </p>
                                                                </div>
                                                            </div>

                                                            <div class="carousel-item">
                                                                <div class="testi-contain text-center">
                                                                    <h5 class="fs-20 text-white mb-0">“User-friendly Dashboards”</h5>
                                                                    <p class="fs-17 text-white mt-2 mb-0">
                                                                        Navigate effortlessly through admin and client dashboards, providing a comprehensive overview of invoices, payments, and client details.
                                                                    </p>
                                                                </div>
                                                            </div>

                                                            <div class="carousel-item">
                                                                <div class="testi-contain text-center">
                                                                    <h5 class="fs-20 text-white mb-0">“Efficient Accountant Features”</h5>
                                                                    <p class="fs-17 text-white mt-2 mb-0">
                                                                        Manage transactions, track payments, and generate financial reports with comprehensive accounting tools.
                                                                    </p>
                                                                </div>
                                                            </div>

                                                            <div class="carousel-item">
                                                                <div class="testi-contain text-center">
                                                                    <h5 class="fs-20 text-white mb-0">“Comprehensive Product Management”</h5>
                                                                    <p class="fs-17 text-white mt-2 mb-0">
                                                                        Manage products, categories, and brands with ease. Create detailed invoices including selected products for accuracy and professionalism.
                                                                    </p>
                                                                </div>
                                                            </div>

                                                            <div class="carousel-item">
                                                                <div class="testi-contain text-center">
                                                                    <h5 class="fs-20 text-white mb-0">“Flexible Invoice Creation”</h5>
                                                                    <p class="fs-17 text-white mt-2 mb-0">
                                                                        Customize invoices with control over product selection, quantities, prices, and additional charges. Generate and send invoices with all necessary details.
                                                                    </p>
                                                                </div>
                                                            </div>

                                                            <div class="carousel-item">
                                                                <div class="testi-contain text-center">
                                                                    <h5 class="fs-20 text-white mb-0">“Payment Link Sharing & Reporting”</h5>
                                                                    <p class="fs-17 text-white mt-2 mb-0">
                                                                        Admins can copy and share payment links via email or social platforms. Download invoices, client details, products, sales reports, and transactions in PDF, Excel, or print formats.
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- end carousel-inner -->
                                                    </div>
                                                    <!-- end review carousel -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                            </div>
                            <!-- end card -->


                        </div>
                    </div>
                </div>
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->
    </div>
    <!-- end container -->
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
<script src="{{ asset('assets/libs/feather-icons/feather.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins.js') }}"></script>
<script src="{{ asset('assets/js/pages/password-addon.init.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    var forms = document.querySelectorAll('form');
    forms.forEach(function(form) {
        form.addEventListener('submit', function(event) {
            event.preventDefault();
            var submitButton = form.querySelector('button[type="submit"]');
            var originalText = submitButton.innerText; // Store the original text
            var $button = $(submitButton);
            $($button).html(`
                    <span class="text-light">processing...</span>
                    <span class="text-end text-light spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>`
            );
            submitButton.disabled = true;
            setTimeout(function() {
                form.submit();
            }, 1000);
            setTimeout(function() {
                $($button).html(originalText);
                submitButton.disabled = false;
            }, 3000);
        });
    });

</script>
<script>
    @if ($errors->any())
        Swal.fire({
        icon: 'error',
        html: '<ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>',
        });
    @endif

    @if (session('message'))
        Swal.fire({
        icon: 'success',
        text: '{{ session('message') }}',
        });
    @endif

    @if (session('error'))
        Swal.fire({
        icon: '',
        text: '{{ session('error') }}',
        });
    @endif

    @if (session('success'))
        Swal.fire({
        icon: 'success',
        text: '{{ session('success') }}',
        });
        @endif
    </script>

</body>
</html>
