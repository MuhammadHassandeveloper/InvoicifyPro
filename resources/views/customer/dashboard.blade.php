@extends('customer.layout.base')
@section('title',$title)
@section('dashboard-page','active')

@section('style')

@endsection
@section('content')
    <!-- Start Page-content -->
    <div class="page-content">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="ml-3"><b>{{ $title }}</b></h4>
            </div>

                <div class="row">
                    <div class="col-xl-3 col-md-6">
                        <!-- Invoice Sent card -->
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <h4 class="fs-22 fw-semibold ff-secondary mb-2">
                                            {{ App\Helpers\AppHelper::appCurrencySign() }}<span  data-target="{{ number_format($totalSentAmount, 2) }}">{{ number_format($totalSentAmount, 2) }}</span>
                                        </h4>
                                        <p class="text-uppercase fw-medium fs-14 text-muted mb-0">
                                            Invoice Sent Sum
                                        </p>
                                    </div>
                                    <div class="avatar-sm flex-shrink-0">
                                <span class="avatar-title bg-light rounded-circle fs-3">
                                    <i class="las la-file-alt fs-24 text-primary"></i>
                                </span>
                                    </div>
                                </div>
                                <div class="d-flex align-items-end justify-content-between mt-4">
                                    <div>
                                        <span class="badge bg-primary me-1">{{ $totalSentCount }}</span> <span
                                            class="text-muted">Invoice Sent</span>
                                    </div>
                                </div>
                            </div><!-- end card body -->
                        </div><!-- end card -->
                    </div><!-- end col -->

                    <div class="col-xl-3 col-md-6">
                        <!-- Paid Invoice card -->
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <h4 class="fs-22 fw-semibold ff-secondary mb-2">
                                            {{ App\Helpers\AppHelper::appCurrencySign() }} <span  data-target="{{ number_format($totalPaidAmount, 2) }}">{{ number_format($totalPaidAmount, 2) }}</span>
                                        </h4>
                                        <p class="text-uppercase fw-medium fs-14 text-muted mb-0">
                                            Paid Invoice Sum
                                        </p>
                                    </div>
                                    <div class="avatar-sm flex-shrink-0">
                                <span class="avatar-title bg-light rounded-circle fs-3">
                                    <i class="las la-check-square fs-24 text-primary"></i>
                                </span>
                                    </div>
                                </div>
                                <div class="d-flex align-items-end justify-content-between mt-4">
                                    <div>
                                        <span class="badge bg-primary me-1">{{ $totalPaidCount }}</span> <span
                                            class="text-muted">Paid by clients</span>
                                    </div>
                                </div>
                            </div><!-- end card body -->
                        </div><!-- end card -->
                    </div><!-- end col -->

                    <div class="col-xl-3 col-md-6">
                        <!-- Unpaid Invoice card -->
                        <div class="card bg-primary">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <h4 class="fs-22 fw-semibold ff-secondary mb-2 text-white">
                                            {{ App\Helpers\AppHelper::appCurrencySign() }}<span  data-target="{{ number_format($totalUnpaidAmount, 2) }}">{{ number_format($totalUnpaidAmount, 2) }}</span>
                                        </h4>
                                        <p class="text-uppercase fw-medium fs-14 text-white-50 mb-0">
                                            Unpaid Invoice Sum
                                        </p>
                                    </div>
                                    <div class="avatar-sm flex-shrink-0">
                                <span class="avatar-title bg-soft-light rounded-circle fs-3">
                                    <i class="las la-clock fs-24 text-white"></i>
                                </span>
                                    </div>
                                </div>
                                <div class="d-flex align-items-end justify-content-between mt-4">
                                    <div>
                                        <span class="badge bg-danger me-1">{{ $totalUnpaidCount }}</span> <span
                                            class="text-white">Unpaid by clients</span>
                                    </div>
                                </div>
                            </div><!-- end card body -->
                        </div><!-- end card -->
                    </div><!-- end col -->

                    <div class="col-xl-3 col-md-6">
                        <!-- Cancelled Invoices card -->
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <h4 class="fs-22 fw-semibold ff-secondary mb-2">
                                            {{ App\Helpers\AppHelper::appCurrencySign() }}<span  data-target="{{ number_format($totalCancelledAmount, 2) }}">{{ number_format($totalCancelledAmount, 2) }}</span>
                                        </h4>
                                        <p class="text-uppercase fw-medium fs-14 text-muted mb-0">
                                            Cancelled Invoices
                                        </p>
                                    </div>
                                    <div class="avatar-sm flex-shrink-0">
                                <span class="avatar-title bg-light rounded-circle fs-3">
                                    <i class="las la-times-circle fs-24 text-primary"></i>
                                </span>
                                    </div>
                                </div>
                                <div class="d-flex align-items-end justify-content-between mt-4">
                                    <div>
                                        <span class="badge bg-primary me-1">{{ $totalCancelledCount }}</span> <span
                                            class="text-muted">Cancelled Invoices</span>
                                    </div>
                                </div>
                            </div><!-- end card body -->
                        </div><!-- end card -->
                    </div><!-- end col -->
                </div><!-- end row -->

                <div class="row">
                    <!-- Monthly Earnings Chart -->
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title mb-0">Monthly Earnings Overview</h4>
                            </div>
                            <div class="card-body">
                                <div id="monthly_earnings_chart" data-colors='["#34c38f"]' class="apex-charts" dir="ltr"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Monthly Invoice Status Count Chart -->
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title mb-0">Monthly Invoice Status Count</h4>
                            </div>
                            <div class="card-body">
                                <div id="invoice_status_chart" data-colors='["#556ee6", "#f46a6a", "#f1b44c"]' class="apex-charts" dir="ltr"></div>
                            </div>
                        </div>
                    </div>

                </div>

        </div>
        <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
@endsection
@section('script')
    <script>
        // Fetch data and set up currency sign
        var monthlyPaidCount = @json($monthlyPaidCount);
        var monthlyUnpaidCount = @json($monthlyUnpaidCount);
        var monthlyVoidCount = @json($monthlyVoidCount);

    </script>

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        // Invoice Status Count Chart
        var statusOptions = {
            chart: {
                height: 350,
                type: 'line'
            },
            series: [
                {
                    name: 'Paid Invoices',
                    data: monthlyPaidCount
                },
                {
                    name: 'Unpaid Invoices',
                    data: monthlyUnpaidCount
                },
                {
                    name: 'Void Invoices',
                    data: monthlyVoidCount
                }
            ],
            xaxis: {
                categories: @json($last12MonthsLabels),  // Dynamic categories
            },
            colors: ['#0630f8', '#f80505', '#ffaa33']
        };
        var statusChart = new ApexCharts(document.querySelector("#invoice_status_chart"), statusOptions);
        statusChart.render();
    </script>

    <script>
        var yearlyEarnings = @json($last12MonthsEarnings);
        var months = @json($last12MonthsLabels);  // Using dynamic months from PHP
        var currencySign = "{{ App\Helpers\AppHelper::appCurrencySign() }}";

        var yearlyEarningsOptions = {
            chart: {
                height: 350,
                type: 'line'
            },
            series: [{
                name: 'Yearly Earnings',
                data: yearlyEarnings.map(value => parseFloat(value).toFixed(2))
            }],
            xaxis: {
                categories: months  // Dynamic categories
            },
            colors: ['#ffaa33'],
            tooltip: {
                y: {
                    formatter: function (value) {
                        return currencySign + parseFloat(value).toFixed(2);
                    }
                }
            },
            yaxis: {
                labels: {
                    formatter: function (value) {
                        return currencySign + parseFloat(value).toFixed(2);
                    }
                }
            }
        };

        var yearlyEarningsChart = new ApexCharts(document.querySelector("#monthly_earnings_chart"), yearlyEarningsOptions);
        yearlyEarningsChart.render();
    </script>



@endsection
