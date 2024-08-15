@extends('customer.layout.base')
@section('title', 'Sales Report')
@section('invoices-sales-page','active')
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
                            <div class="table-card table-responsive">
                                <table id="DataTables_Table_0" class="table nowrap dt-responsive align-middle table-hover table-bordered mb-0 dataTable no-footer dtr-inline collapsed">
                                    <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Invoice Number</th>
                                        <th>Product Name</th>
                                        <th>Category</th>
                                        <th>Qty</th>
                                        <th>Amount</th>
                                        <th>Customer</th>
                                        <th>Date of Sale</th>
                                    </tr>
                                    </thead>
                                    @php $i = 1; @endphp
                                    <tbody id="sales-report-table-body">
                                    @foreach ($invoices as $invoice)
                                        @php
                                            $invoice_paid_date = $invoice->invoice_paid_date;
                                            $invoice_paid_time = $invoice->invoice_paid_time;
                                            $invoice_paid_date = \DateTime::createFromFormat('Y-m-d', $invoice_paid_date);
                                            $invoice_paid_time = \DateTime::createFromFormat('H:i:s', $invoice_paid_time);
                                            $paid_date_time = $invoice_paid_date ? $invoice_paid_date->format('d M Y') . ' ' . $invoice_paid_time->format('g:i A') : 'N/A';
                                        @endphp
                                        @foreach ($invoice->items as $item)
                                            <tr id="invoice-{{ $invoice->id }}">
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $invoice->stripe_invoice_number }}</td>
                                                <td>{{ $item->product->name }}</td>
                                                <td>{{ $item->product->category->name }}</td>
                                                <td>{{ $item->product_quantity }}</td>
                                                <td>
                                                <span class="badge text-bg-success p-1">
                                                    {{ App\Helpers\AppHelper::appCurrencySign() }}{{ number_format($item->product_quantity * $item->product_amount, 2) }}
                                                </span>
                                                </td>
                                                <td>
                                                    {{ $invoice->customer->first_name. ' ' .$invoice->customer->last_name ?? 'N/A' }}
                                                    <br>
                                                    {{ $invoice->customer->phone }}
                                                    <span class="badge text-bg-warning p-1">
                                                    ({{ $invoice->customer->country->iso_code }})
                                                </span>
                                                </td>
                                                <td>{{ $paid_date_time  }}</td>
                                            </tr>
                                        @endforeach
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
