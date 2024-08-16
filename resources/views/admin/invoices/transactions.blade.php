@extends('admin.layout.base')
@section('title', $title)
@section('transactions-page','active')
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
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-card mt-2 mt-2">
                                <table id="DataTables_Table_0" class="table table-sm dt-responsive align-middle table-hover table-bordered mb-0 dataTable no-footer dtr-inline collapsed">
                                    <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Transaction ID</th>
                                        <th>Invoice Number</th>
                                        <th>Customer</th>
                                        <th>Amount Paid</th>
                                        <th>Payment Date</th>
                                        <th>Items</th>
                                    </tr>
                                    </thead>
                                    @php $i = 1; @endphp
                                    <tbody id="transactions-report-table-body">
                                    @foreach ($invoices as $invoice)
                                        @php
                                            $invoice_paid_date = $invoice->invoice_paid_date;
                                            $invoice_paid_time = $invoice->invoice_paid_time;
                                            $invoice_paid_date = \DateTime::createFromFormat('Y-m-d', $invoice_paid_date);
                                            $invoice_paid_time = \DateTime::createFromFormat('H:i:s', $invoice_paid_time);
                                            $paid_date_time = $invoice_paid_date ? $invoice_paid_date->format('d M Y') . ' ' . $invoice_paid_time->format('g:i A') : 'N/A';
                                        @endphp
                                        <tr id="transaction-{{ $invoice->id }}">
                                            <td>{{ $i++ }}</td>
                                            <td>
                                                <a href="javascript:void(0);" class="text-body align-middle fw-medium">{{ $invoice->charge_id ?? 'N/A' }}</a>
                                            </td>
                                            <td>{{ $invoice->stripe_invoice_number }}</td>
                                            <td>
                                                {{ $invoice->customer->first_name . ' ' . $invoice->customer->last_name ?? 'N/A' }}
                                                <br>
                                                {{ $invoice->customer->phone }}
                                                <span class="badge text-bg-warning p-1">
                                                    ({{ $invoice->customer->country->iso_code }})
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge text-bg-success p-1">
                                                    {{ App\Helpers\AppHelper::appCurrencySign() }}{{ number_format($invoice->amount, 2) }}
                                                </span>
                                            </td>
                                            <td>{{ $paid_date_time }}</td>
                                            <td>
                                                @foreach ($invoice->items as $item)
                                                    <div>
                                                        <b>{{ $item->product->name }}</b>
                                                        ({{ $item->product_quantity }} x {{ App\Helpers\AppHelper::appCurrencySign() }}{{ number_format($item->product_amount, 2) }})
                                                        = {{ App\Helpers\AppHelper::appCurrencySign() }}{{ number_format($item->product_quantity * $item->product_amount, 2) }}
                                                    </div>
                                                @endforeach
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
