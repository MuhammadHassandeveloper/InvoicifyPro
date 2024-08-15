@extends('accountant.layout.base')
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
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="fs-22 fw-semibold">{{ $outOfStockCount }}</h4>
                            <p class="text-uppercase fw-medium">Out of Stock</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="fs-22 fw-semibold">{{ $lowStockCount }}</h4>
                            <p class="text-uppercase fw-medium">Low Stock</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="fs-22 fw-semibold">{{ $activeCount }}</h4>
                            <p class="text-uppercase fw-medium">Active Products</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="fs-22 fw-semibold">{{ $disabledCount }}</h4>
                            <p class="text-uppercase fw-medium">Disabled Products</p>
                        </div>
                    </div>
                </div>
            </div>

                <div class="row">

                    <!-- Monthly Invoice Status Count Chart -->
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title mb-0">Monthly Products Status Count</h4>
                            </div>
                            <div class="card-body">
                                <div id="product_status_chart" data-colors='["#556ee6", "#f46a6a", "#f1b44c"]' class="apex-charts" dir="ltr"></div>
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
        var monthlyActiveCount = @json($monthlyActiveCount);
        var monthlyDisableddCount = @json($monthlyDisableddCount);
        var monthlyOutStockCount = @json($monthlyOutStockCount);

    </script>

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        // Invoice Status Count Chart
        var statusOptions = {
            chart: {
                height: 350,
                type: 'bar'
            },
            series: [
                {
                    name: 'Active Products',
                    data: monthlyActiveCount
                },
                {
                    name: 'Disabled Products',
                    data: monthlyDisableddCount
                },
                {
                    name: 'Out Of Stock Products',
                    data: monthlyOutStockCount
                }
            ],
            xaxis: {
                categories: @json($last12MonthsLabels),  // Dynamic categories
            },
            colors: ['#0630f8', '#f80505', '#ffaa33']
        };
        var statusChart = new ApexCharts(document.querySelector("#product_status_chart"), statusOptions);
        statusChart.render();
    </script>


@endsection
