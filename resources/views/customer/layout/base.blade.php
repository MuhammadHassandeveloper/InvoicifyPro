<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="light" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">

<head>

    <meta charset="utf-8">
    <title>{{ App\Helpers\AppHelper::site_name() }} | @yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="{{ App\Helpers\AppHelper::site_name() }}">
    <link rel="shortcut icon" style="height: 80px; width: 120px;" href="{{ asset('assets/logo/'.App\Helpers\AppHelper::fav_icon()) }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link href="{{ asset('assets/libs/jsvectormap/css/jsvectormap.min.css') }}" rel="stylesheet" type="text/css">
    <script src="{{ asset('assets/js/layout.js') }}"></script>
    <link  href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css">

    <!--datatable css-->
    <link href="{{ asset('assets/datatables/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/datatables/css/buttons.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/datatables/css/responsive.bootstrap.min.css') }}" rel="stylesheet" type="text/css" / />
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css">

    <style>
        .fs-17 {
            font-size: 15px !important;
        }
        @media screen and (min-width: 768px) {
            .dataTables_wrapper .dataTables_length,
            .dataTables_wrapper .dataTables_filter {
                display: inline-block !important;
                margin-right: 10px !important;
                vertical-align: middle;
                width: auto;
            }

            .dataTables_wrapper .dataTables_filter {
                margin-bottom: 0 !important;
            }

            .dataTables_wrapper .dataTables_length {
                margin-bottom: 0 !important;
            }
        }

        @media screen and (max-width: 767px) {
            .dataTables_wrapper .dataTables_length,
            .dataTables_wrapper .dataTables_filter {
                display: inline;!important;
                margin-bottom: 10px !important;
            }

            .dataTables_wrapper .dataTables_filter {
                margin-left: 0 !important;
            }

            .dataTables_wrapper .dataTables_length {
                margin-left: 0 !important;
                margin-left: 10px;
            }
        }

        .dataTables_wrapper .dataTables_filter {
            margin-bottom: 0 !important;
            float: inline-end;
            min-height: 20px !important;
            width: auto;
        }

        div.dt-buttons {
            display: inline-block !important;
            margin-left: 15px;
            margin-top: 10px;
        }

        .dataTables_wrapper .dt-buttons .buttons-excel,
        .dataTables_wrapper .dt-buttons .buttons-pdf,
        .dataTables_wrapper .dt-buttons .buttons-print {
            background-color: #fa9812 !important;
            color: #fff !important;
            border: none;
            margin-top: 6px;
            padding: 4px 12px !important;
        }
        .dataTables_wrapper .dt-buttons .buttons-csv:hover,
        .dataTables_wrapper .dt-buttons .buttons-excel:hover,
        .dataTables_wrapper .dt-buttons .buttons-pdf:hover,
        .dataTables_wrapper .dt-buttons .buttons-print:hover {
            background-color: #ffaa33FF !important;
        }

        .dataTables_wrapper .dt-buttons .buttons-csv span,
        .dataTables_wrapper .dt-buttons .buttons-excel span,
        .dataTables_wrapper .dt-buttons .buttons-pdf span,
        .dataTables_wrapper .dt-buttons .buttons-print span {
            color: #fff !important;
        }

        div.dataTables_wrapper div.dataTables_length select {
            width: auto;
            display: inline-block;
        }

        .table-card .dataTables_paginate {
            display: inline;
            float: inline-end;
            width: auto;
        }

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


        .dataTable {
             width: 100% !important;
         }
        .dataTables_filter {
            width: auto;
            float: right;
        }
        .dataTables_info {
            display: inline-block;
        }
        td {
            font-size: 14px !important;
        }

        .bg-primary {
            --in-bg-opacity: 1;
            background-color: #ffaa33 !important;
        }
    </style>

    @yield('style')
</head>
<body>
<!-- Begin page -->
<div id="layout-wrapper">
    @include('customer.layout.header')
    @include('customer.layout.sidebar')
    <div class="vertical-overlay"></div>
    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">
        @yield('content')
        @include('customer.layout.footer')
    </div>
    <!-- end main content-->
</div>
<!-- END layout-wrapper -->
@include('customer.layout.theme_customize')

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
<script src="{{ asset('assets/libs/feather-icons/feather.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins.js') }}"></script>
<script src="{{ asset('assets/libs/apexcharts/apexcharts.min.js') }}"></script>
<script src="{{ asset('assets/libs/jsvectormap/js/jsvectormap.min.js') }}"></script>
<script src="{{ asset('assets/libs/jsvectormap/maps/world-merc.js') }}"></script>
<script src="{{ asset('assets/js/pages/dashboard.init.js') }}"></script>
<script src="{{ asset('assets/libs/prismjs/prism.js')}}"></script>
<script src="{{ asset('assets/js/pages/modal.init.js')}}"></script>
<script src="{{ asset('assets/js/app.js') }}"></script>


{{--datatables--}}


<script src="{{asset('assets/vendors/js/tables/datatable/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/vendors/js/tables/datatable/dataTables.bootstrap5.min.js')}}"></script>
<script src="{{asset('assets/vendors/js/tables/datatable/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('assets/vendors/js/tables/datatable/responsive.bootstrap5.js')}}"></script>
<script src="{{asset('assets/vendors/js/tables/datatable/datatables.buttons.min.js')}}"></script>
<script src="{{asset('assets/vendors/js/tables/datatable/buttons.bootstrap5.min.js')}}"></script>
<script src="{{asset('assets/vendors/js/tables/datatable/datatables.checkboxes.min.js')}}"></script>
<script src="{{asset('assets/vendors/js/tables/datatable/jszip.min.js')}}"></script>
<script src="{{asset('assets/vendors/js/tables/datatable/pdfmake.min.js')}}"></script>
<script src="{{asset('assets/vendors/js/tables/datatable/vfs_fonts.js')}}"></script>
<script src="{{asset('assets/vendors/js/tables/datatable/buttons.html5.min.js')}}"></script>
<script src="{{asset('assets/vendors/js/tables/datatable/buttons.print.min.js')}}"></script>
<script src="{{asset('assets/vendors/js/tables/datatable/dataTables.rowGroup.min.js')}}"></script>


<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        $('#DataTables_Table_0').DataTable({
            responsive: {
                details: {
                    display: $.fn.dataTable.Responsive.display.childRowImmediate,
                    type: ''
                }
            },
            ordering: false, // Disable sorting
            dom: 'lBfrtip',
            buttons: [
                {
                    extend: 'excel',
                    exportOptions: {
                        columns: ':not(:last-child)'
                    }
                },
                {
                    extend: 'pdf',
                    exportOptions: {
                        columns: ':not(:last-child)'
                    }
                },
                {
                    extend: 'print',
                    exportOptions: {
                        columns: ':not(:last-child)'
                    }
                }
            ],
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            pageLength: 10,
            language: {
                paginate: {
                    previous: '<i class="las la-angle-left"></i>',  // Previous button icon
                    next: '<i class="las la-angle-right"></i>'      // Next button icon
                }
            }
        });
    });
</script>


<script>
    function signupas(){
        var url = jQuery('#signup_as').val();
        window.location.href = url;
    }
    $(function(){
        setTimeout(function(){
            $(".error_messages").hide(true);
        },10000);
    });

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


@yield('script')
</body>
</html>
