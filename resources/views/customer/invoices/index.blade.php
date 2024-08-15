@extends('customer.layout.base')
@section('title', $title)
@section('invoices-dropdown','active')
@section('invoices-dropdown-show','show')
@section('all-invoices-list-page','active')
@section('all-invoices-list-page','active')
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
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <ul class="nav nav-tabs nav-tabs-custom nav-success mb-3" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link @yield('all-invoices-list-page')"
                                       href="{{ url('/customer/invoices') }}" role="tab" aria-selected="true">
                                        All
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link @yield('unpaid-invoices-list-page')"
                                       href="{{ url('/customer/invoices/unpaid') }}" role="tab" aria-selected="false">
                                        UnPaid
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link @yield('paid-invoices-list-page')"
                                       href="{{ url('/customer/invoices/paid') }}" role="tab" aria-selected="false">
                                        Paid
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link @yield('void-invoices-list-page')"
                                       href="{{ url('/customer/invoices/void') }}" role="tab" aria-selected="false">
                                        Void
                                    </a>
                                </li>

                            </ul>

                            <div class="table-card">
                                <table id="DataTables_Table_0"
                                       class="table nowrap dt-responsive align-middle table-hover table-bordered mb-0 dataTable no-footer dtr-inline collapsed">
                                    <thead class="table-light">
                                    <tr>
                                        <th>Invoice Number</th>
                                        <th>Customer</th>
                                        <th>Amount Due</th>
                                        <th>Created At</th>
                                        <th>Due Date</th>
                                        <th>Payment Link</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody id="invoice-table-body">
                                    @foreach ($invoices as $invoice)
                                        <tr id="invoice-{{ $invoice->id }}">
                                            <td>
                                                <a href="{{ route('customer.invoices.show', $invoice->id) }}"
                                                   class="text-body align-middle fw-medium">{{ $invoice->stripe_invoice_number }}</a>
                                            </td>
                                            <td>
                                                {{ $invoice->customer->first_name. ' ' .$invoice->customer->last_name ?? 'N/A' }}
                                                <br>
                                                {{ $invoice->customer->phone }}
                                                <span class="badge text-bg-warning ">
                                                ({{ $invoice->customer->country->iso_code }})
                                            </span>

                                            </td>
                                            <td>
                                            <span class="badge text-bg-dark">
                                                {{ App\Helpers\AppHelper::appCurrencySign() }}{{ number_format($invoice->amount, 2) }}
                                            </span>
                                            </td>
                                            <td>{{ $invoice->created_at->format('d M Y') }}</td>
                                            <td>{{ date('d M Y',strtotime($invoice->period_end ))}}</td>

                                            <td>
                                                @if($invoice->status != 'void')
                                                    <span style="cursor: pointer;"
                                                          class="badge badge-soft-primary sharePaymentLink"
                                                          data-link="{{ $invoice->stripe_invoice_url }}">Copy Now</span>
                                                @endif
                                            </td>
                                            <td>
                                        <span
                                            class="badge  {{ $invoice->status === 'paid' ? 'badge-soft-success' : 'badge-soft-info' }}">
                                            {{ ucfirst($invoice->status) }}
                                        </span>
                                            </td>
                                            <td>
                                                <a class="btn btn-soft-info btn-sm"
                                                   href="{{ route('customer.invoices.show', $invoice->id) }}">
                                                    <i class="las la-eye fs-17 align-middle"></i>
                                                </a>


                                                <a href="{{ $invoice->stripe_invoice_pdf_url }}"
                                                   class="btn btn-soft-warning btn-sm">
                                                    <i class="la la-download fs-17 align-middle"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('script')
    <script>

        function voidInvoice(invoiceId) {
            Swal.fire({
                title: 'Are you sure?',
                text: "Are you sure you want to void this invoice? Once voided, the customer will no longer be able to make payments on this invoice. This action cannot be undone.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, void it!',
                cancelButtonText: 'Cancel',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "/customer/invoices/make-void/" + invoiceId,
                        type: 'GET',
                        data: {
                            "_token": "{{ csrf_token() }}"
                        },
                        success: function (response) {
                            Swal.fire({
                                icon: 'success',
                                text: response.message,
                                confirmButtonText: 'OK'
                            }).then(() => {
                                window.location.href = `/customer/invoices`;
                            });
                        },
                        error: function () {
                            Swal.fire({
                                icon: 'error',
                                text: 'Something went wrong. Please try again.',
                            });
                        }
                    });
                }
            });
        }


        var shareButtons = document.getElementsByClassName('sharePaymentLink');
        for (var i = 0; i < shareButtons.length; i++) {
            shareButtons[i].addEventListener('click', function () {
                var currentUrl = this.getAttribute('data-link');
                var tempInput = document.createElement('input');
                tempInput.setAttribute('type', 'text');
                tempInput.setAttribute('value', currentUrl);
                document.body.appendChild(tempInput);
                tempInput.select();
                document.execCommand('copy');
                document.body.removeChild(tempInput);
                this.innerText = 'Copied!';
                var that = this;
                setTimeout(function () {
                    that.innerText = 'Copy Now';
                }, 1000);
            });
        }
    </script>

@stop

