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

            <div class="row justify-content-center">
                <div class="col-xxl-9">
                    <div class="card" id="demo">
                        <div class="card-body">
                            <div class="row p-4">
                                <div class="col-lg-9">
                                    <h3 class="fw-bold mb-4">Invoice: {{ $invoice->stripe_invoice_number }} </h3>
                                    <div class="row g-4">
                                        <div class="col-lg-6 col-6">
                                            <p class="text-muted mb-1 text-uppercase fw-medium fs-14">Invoice No</p>
                                            <h5 class="fs-16 mb-0">#VL<span id="invoice-no">{{ $invoice->stripe_invoice_number }} </span></h5>
                                        </div>
                                        <!--end col-->
                                        <div class="col-lg-6 col-6">
                                            <p class="text-muted mb-1 text-uppercase fw-medium fs-14">Due Date</p>
                                            <h5 class="fs-16 mb-0"><span id="invoice-date">{{ date('d M Y',strtotime($invoice->period_end ))}}</span></h5>
                                        </div>
                                        <!--end col-->
                                        <div class="col-lg-6 col-6">
                                            <p class="text-muted mb-1 text-uppercase fw-medium fs-14">Payment Status</p>
                                            <span class="badge  {{ $invoice->status === 'paid' ? 'badge-soft-success' : 'badge-soft-info' }}">
                                                    {{ ucfirst($invoice->status) }}
                                             </span>

                                            @if($invoice->invoice_paid_date && $invoice->invoice_paid_time)
                                                @php
                                                    $invoice_paid_date = $invoice->invoice_paid_date;
                                                   $invoice_paid_time = $invoice->invoice_paid_time;
                                                   $invoice_paid_date = \DateTime::createFromFormat('Y-m-d', $invoice_paid_date);
                                                   $invoice_paid_time = \DateTime::createFromFormat('H:i:s', $invoice_paid_time);
                                                   $paid_date_time = $invoice_paid_date->format('d M Y') . ' ' . $invoice_paid_time->format('g:i A');
                                                @endphp
                                                <br>
                                                <span class="badge text-bg-warning  mt-2 fs-12">Paid Date: {{ $paid_date_time }}</span>
                                            @endif
                                        </div>
                                        <!--end col-->
                                        <div class="col-lg-6 col-6">
                                            <p class="text-muted mb-1 text-uppercase fw-medium fs-14">Total Amount</p>
                                            <h5 class="fs-16 mb-0">{{ App\Helpers\AppHelper::appCurrencySign() }}<span id="total-amount">{{ number_format($invoice->amount, 2) }}</span></h5>
                                        </div>
                                        <!--end col-->
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="mt-sm-0 mt-3">
                                        <h6 class="text-muted text-uppercase fw-semibold">Address</h6>
                                        <p class="text-muted mb-1" id="address-details">{{ $invoice->customer->billing_address }}</p>
                                        <p class="text-muted mb-1" id="zip-code"><span>Full Name:</span> {{ $invoice->customer->first_name . ' ' . $invoice->customer->last_name }}</p>
                                        <h6><span class="text-muted fw-normal">Email:</span><span id="email">{{ $invoice->customer->email }}</span></h6>
                                        <h6 class="mb-0"><span class="text-muted fw-normal">Contact No: </span><span id="contact-no"> +{{ $invoice->customer->phone }}</span></h6>
                                    </div>
                                </div>
                            </div><!--end col-->

                            <div class="row p-4 border-top border-top-dashed">
                                <div class="col-lg-9">
                                    <div class="row g-3">
                                        <div class="col-6">
                                            <h6 class="text-muted text-uppercase fw-semibold mb-3">Billing Address</h6>
                                            <p class="fw-medium mb-2" id="billing-name">{{ $invoice->customer->first_name . ' ' . $invoice->customer->last_name }}</p>
                                            <p class="text-muted mb-1" id="billing-address-line-1">{{ $invoice->customer->billing_address }}</p>
                                            <p class="text-muted mb-1"><span>Phone: +</span><span id="billing-phone-no">{{ $invoice->customer->billing_phone }}</span></p>
                                        </div>
                                        <!--end col-->
                                        <div class="col-6">
                                            <h6 class="text-muted text-uppercase fw-semibold mb-3">Shipping Address</h6>
                                            <p class="fw-medium mb-2" id="shipping-name">{{ $invoice->customer->first_name . ' ' . $invoice->customer->last_name }}</p>
                                            <p class="text-muted mb-1" id="shipping-address-line-1">{{ $invoice->customer->shipping_address }}</p>
                                            <p class="text-muted mb-1"><span>Phone: +</span><span id="shipping-phone-no">{{ $invoice->customer->shipping_phone }}</span></p>
                                        </div>
                                        <!--end col-->
                                    </div>
                                    <!--end row-->
                                </div><!--end col-->

                                <div class="col-lg-3">
                                    <h6 class="text-muted text-uppercase fw-semibold mb-3">Total Amount</h6>
                                    <h3 class="fw-bold mb-2">{{ App\Helpers\AppHelper::appCurrencySign() }}{{ number_format($invoice->amount, 2) }}</h3>
                                    <span class="badge text-bg-warning  fs-12">Due Date: {{ date('d M Y',strtotime($invoice->period_end ))}}</span>

                                </div>

                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card-body p-4">
                                        <div class="table-responsive">
                                            <table class="table table-borderless text-center table-nowrap align-middle mb-0">
                                                <thead>
                                                <tr class="table-active">
                                                    <th scope="col" style="width: 50px;">#</th>
                                                    <th scope="col">Product Details</th>
                                                    <th scope="col">Rate</th>
                                                    <th scope="col">Quantity</th>
                                                    <th scope="col" class="text-end">Amount</th>
                                                </tr>
                                                </thead>
                                                <tbody id="products-list">
                                                @php $x= 1;@endphp
                                                @foreach($invoice->items as $item)
                                                <tr>
                                                    <th scope="row">{{  $x ++ }}</th>
                                                    <td class="text-start">
                                                        <span class="fw-medium">{{ $item->product->name }}</span>
                                                        <br>
                                                        <span style="font-size: 12px;">{{$item->product->description }}</span>
                                                    </td>
                                                    <td>{{ App\Helpers\AppHelper::appCurrencySign() }}{{ $item->product_amount }}</td>
                                                    <td>{{ $item->product_quantity }}</td>
                                                    <td class="text-end">{{ App\Helpers\AppHelper::appCurrencySign() }}{{ $item->product_quantity * $item->product_amount }}</td>
                                                </tr>
                                                @endforeach

                                                </tbody>
                                            </table><!--end table-->
                                        </div>
                                        <div class="border-top border-top-dashed mt-2">
                                            <table class="table table-borderless table-nowrap align-middle mb-0 ms-auto" style="width:250px">
                                                <tbody>
                                                <tr>
                                                    <td>Sub Total</td>
                                                    <td class="text-end">{{ App\Helpers\AppHelper::appCurrencySign() }}{{ number_format($invoice->sub_amount, 2) }}</td>
                                                </tr>

                                                @if($invoice->tax && isset($invoice->tax->percentage))
                                                <tr>
                                                    <td>Estimated Tax ({{ $invoice->tax->percentage }}%)</td>
                                                    <td class="text-end">{{ App\Helpers\AppHelper::appCurrencySign() }}{{ number_format($invoice->total_tax_amount, 2) }}</td>
                                                </tr>
                                                @endif

                                                @if($invoice->discount && isset($invoice->discount->name))
                                                    <tr>
                                                        <td>Discount <small class="text-muted">({{ $invoice->discount->name }})</small></td>
                                                        <td class="text-end">- {{ App\Helpers\AppHelper::appCurrencySign() }}{{ number_format($invoice->total_discount_amount, 2) }}</td>
                                                    </tr>
                                                @endif
                                                @if($invoice->charge && isset($invoice->charge->percentage))
                                                    <tr>
                                                    <td>Shipping Charge</td>
                                                    <td class="text-end">{{ App\Helpers\AppHelper::appCurrencySign() }}{{ number_format($invoice->total_charge_amount, 2) }}</td>
                                                </tr>
                                                @endif
                                                <tr class="border-top border-top-dashed fs-15">
                                                    <th scope="row">Total Amount</th>
                                                    <th class="text-end">{{ App\Helpers\AppHelper::appCurrencySign() }}{{ number_format($invoice->amount, 2) }}</th>
                                                </tr>
                                                </tbody>
                                            </table>
                                            <!--end table-->
                                        </div>
                                        <div class="mt-3">
                                            <h6 class="text-muted text-uppercase fw-semibold mb-3">Payment Details:</h6>
                                            <p class="text-muted mb-1">Payment Method: <span class="fw-medium" id="payment-method">Mastercard</span></p>
                                            <p class="text-muted mb-1">Card Holder: <span class="fw-medium" id="card-holder-name">{{ $invoice->customer->first_name . ' ' . $invoice->customer->last_name }}</span></p>
                                            <p class="text-muted">Total Amount: <span class="fw-medium" id="">{{ App\Helpers\AppHelper::appCurrencySign() }} </span><span id="card-total-amount">{{ number_format($invoice->amount, 2) }}</span></p>
                                        </div>
                                        <div class="mt-4">
                                            <div class="alert alert-info">
                                                <p class="mb-0"><span class="fw-semibold">NOTES:</span>
                                                    <span id="note">
                                                         {{ $invoice->note }}
                                                    </span>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="hstack gap-2 justify-content-end d-print-none mt-4">
                                            <a href="javascript:window.print()" class="btn btn-primary"><i class="ri-printer-line align-bottom me-1"></i> Print</a>
                                            <a href="{{ $invoice->stripe_invoice_pdf_url }}" class="btn btn-primary"><i class="ri-download-2-line align-bottom me-1"></i> Download</a>
                                        </div>
                                    </div>
                                    <!--end card-body-->
                                </div><!--end col-->
                            </div>
                        </div>
                    </div>
                </div>
                <!--end col-->
            </div>
        </div>
    </div>

@stop
@section('script')

@stop
