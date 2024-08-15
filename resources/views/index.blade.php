<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="light" data-sidebar-size="lg"
      data-sidebar-image="none" data-preloader="disable">

<head>
    <meta charset="utf-8">
    <title>{{ App\Helpers\AppHelper::site_name() }} | @yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="{{ App\Helpers\AppHelper::site_name() }}">
    <meta content="{{ App\Helpers\AppHelper::site_name() }}">
    <!-- App favicon -->
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
                        <div class="d-flex flex-column h-100 py-0 py-xl-4">

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
                                                               required="" placeholder="example@gmail.com">
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
                                                                   placeholder="Enter password" id="password-input" required>
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
                                                                    <h5 class="fs-20 text-white mb-0">“Comprehensive Client Details”</h5>
                                                                    <p class="fs-17 text-white mt-2 mb-0">
                                                                        Manage your client information with ease. Our system allows you to store detailed billing and shipping addresses, ensuring accurate and professional invoices every time.
                                                                    </p>
                                                                </div>
                                                            </div>

                                                            <div class="carousel-item">
                                                                <div class="testi-contain text-center">
                                                                    <h5 class="fs-20 text-white mb-0">“Integrated Stripe Payments”</h5>
                                                                    <p class="fs-17 text-white mt-2 mb-0">
                                                                        Simplify payments with Stripe integration. Send invoices with payment links directly to clients' emails, enabling them to pay securely online through a seamless and user-friendly interface.
                                                                    </p>
                                                                </div>
                                                            </div>

                                                            <div class="carousel-item">
                                                                <div class="testi-contain text-center">
                                                                    <h5 class="fs-20 text-white mb-0">“Dynamic Tax and Discount Management”</h5>
                                                                    <p class="fs-17 text-white mt-2 mb-0">
                                                                        Our system provides dynamic management of taxes and discounts, tailored to different countries and regions. Easily configure and apply rates to ensure compliance and optimize your pricing strategies.
                                                                    </p>
                                                                </div>
                                                            </div>

                                                            <div class="carousel-item">
                                                                <div class="testi-contain text-center">
                                                                    <h5 class="fs-20 text-white mb-0">“Real-time Stock Management”</h5>
                                                                    <p class="fs-17 text-white mt-2 mb-0">
                                                                        Stay updated with real-time stock management. Track product availability, manage out-of-stock items, and ensure your inventory is always accurate and up-to-date.
                                                                    </p>
                                                                </div>
                                                            </div>

                                                            <div class="carousel-item">
                                                                <div class="testi-contain text-center">
                                                                    <h5 class="fs-20 text-white mb-0">“User-friendly Dashboards”</h5>
                                                                    <p class="fs-17 text-white mt-2 mb-0">
                                                                        Both admin and client dashboards are designed for ease of use, providing a comprehensive overview of invoices, payments, and client details. Navigate effortlessly through your data and manage your operations efficiently.
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
