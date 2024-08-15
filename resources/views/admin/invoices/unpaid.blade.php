@extends('admin.layout.base')
@section('title', $title)
@section('invoices-dropdown','active')
@section('invoices-dropdown-show','show')
@section('unpaid-invoices-list-page','active')
@section('unpaid-invoices-list-page','active')
@section('style')

@endsection
@section('content')
    <!-- Start Page-content -->
    <div class="page-content">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="ml-3"><b>{{ $title }}</b></h4>
                <span class="badge p-2   text-bg-warning">
                    UnPaid
                </span>
            </div>

            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <ul class="nav nav-tabs nav-tabs-custom nav-success mb-3" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link @yield('invoices-list-page')" href="{{ url('/admin/invoices') }}" role="tab" aria-selected="true">
                                        All
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link @yield('unpaid-invoices-list-page')" href="{{ url('/admin/invoices/unpaid') }}" role="tab" aria-selected="false">
                                        UnPaid
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link @yield('paid-invoices-list-page')" href="{{ url('/admin/invoices/paid') }}" role="tab" aria-selected="false">
                                        Paid
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link @yield('void-invoices-list-page')" href="{{ url('/admin/invoices/void') }}" role="tab" aria-selected="false">
                                        Void
                                    </a>
                                </li>

                            </ul>

                        <div class="table-card">
                            <table id="DataTables_Table_0" class="table nowrap dt-responsive align-middle table-hover table-bordered mb-0 dataTable no-footer dtr-inline collapsed">
                                <thead class="table-light">
                                <tr>
                                    <th>Invoice Number</th>
                                    <th>Customer</th>
                                    <th>Amount Due</th>
                                    <th>Created At</th>
                                    <th>Due Date</th>
                                    <th>Payment Link</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody id="invoice-table-body">
                                @foreach ($invoices as $invoice)
                                    <tr id="invoice-{{ $invoice->id }}">
                                        <td>
                                            <a href="{{ route('admin.invoices.show', $invoice->id) }}" class="text-body align-middle fw-medium">{{ $invoice->stripe_invoice_number }}</a>
                                        </td>
                                        <td>
                                            {{ $invoice->customer->first_name. ' ' .$invoice->customer->last_name ?? 'N/A' }}
                                            <br>
                                            {{ $invoice->customer->phone }}
                                            <span class="badge text-bg-warning">
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
                                                <span style="cursor: pointer; padding: 6px;" class="badge badge-soft-primary sharePaymentLink" data-link="{{ $invoice->stripe_invoice_url }}">Copy Now</span>
                                            @endif
                                        </td>

                                        <td>
                                            <a href="{{ route('admin.invoices.show', $invoice->id) }}" class="btn btn-soft-info btn-sm" >
                                                <i class="las la-eye fs-17 align-middle"></i>
                                            </a>

{{--                                            <a href="{{ route('admin.invoices.edit', $invoice->id) }}" class="btn btn-soft-primary btn-sm">--}}
{{--                                                <i class="las la-pen fs-17 align-middle"></i>--}}
{{--                                            </a>--}}

                                            <a href="{{ $invoice->stripe_invoice_pdf_url }}" class="btn btn-soft-warning btn-sm">
                                                <i class="la la-download fs-17 align-middle"></i>
                                            </a>

                                            <button class="btn btn-soft-danger btn-sm" onclick="deleteInvoice({{ $invoice->id }})">
                                                <i class="las la-trash fs-17 align-middle"></i>
                                            </button>

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
        var shareButtons = document.getElementsByClassName('sharePaymentLink');

        for (var i = 0; i < shareButtons.length; i++) {
            shareButtons[i].addEventListener('click', function() {
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
                setTimeout(function() {
                    that.innerText = 'Copy Now';
                }, 1000);
            });
        }
    </script>

@stop

