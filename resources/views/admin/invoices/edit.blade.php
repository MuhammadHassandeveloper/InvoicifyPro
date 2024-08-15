@extends('admin.layout.base')
@section('title', $title)
@section('invoices-dropdown','active')
@section('invoices-dropdown-show','show')
@section('all-invoices-list-page','active')
@section('all-invoices-list-page','active')
@section('style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <style>
        .table-nowrap td, .table-nowrap th {
            white-space: normal !important;
        }
    </style>
@endsection
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">{{ $title }}</h4>
                    </div>
                </div>
            </div>

            @php
                $formattedDateTime = date('Y-m-d', strtotime($invoice->period_end));
            @endphp

            <div class="row justify-content-center">
                <div class="col-xxl-9">
                    <div class="card">
                        <form class="needs-validation was-validated"  id="invoice_form" method="post">
                            @csrf
                            <div class="card-body border-bottom border-bottom-dashed p-4">
                                <div class="row">
                                    <div class="col-lg-6 col-12">
                                        <div class="row">
                                            <div class="mt-2">
                                                <label for="choices-client">Select Client</label>
                                                <div class="input-light">
                                                    <select class="form-select bg-light border-0" name="client_id"
                                                            id="choices-client" required>
                                                        <option value="">--Select--</option>
                                                        @foreach($clients as $client)
                                                            <option value="{{ $client->id }}"
                                                                {{ $invoice->customer_id == $client->id ? 'selected' : '' }}>
                                                                {{ $client->first_name }} - {{ $client->email }}
                                                                <span class="badge badge-primary">
                                                                    ({{ $client->country->iso_code }})
                                                                </span>
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="mt-2">
                                                <input type="text" name="due_date" required
                                                       class="form-control bg-light border-0 js-range-datepicker-input"
                                                       value="{{ $formattedDateTime  }}"
                                                       data-time="true" placeholder="Select Date-time" readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-12">
                                        <label for="companyEmail">Email Address</label>
                                        <div class="mt-2">
                                            <input type="email" name="client_email" class="form-control bg-light border-0" id="companyEmail"
                                                   value="{{ $invoice->customer->email }}" readonly placeholder="Email Address" required>
                                        </div>
                                        <div class="mt-2">
                                            <input type="text" class="form-control bg-light border-0" id="companyPhone"
                                                   value="{{ $invoice->customer->phone }}" readonly placeholder="Phone" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body p-4 border-top border-top-dashed">
                                <div class="row">
                                    <div class="col-lg-6 col-sm-12">
                                        <label for="billingName" class="text-muted text-uppercase fw-semibold">Billing Address</label>
                                        <div class="mb-2">
                                            <input type="text" name="client_billing_name" class="form-control bg-light border-0" id="billingName"
                                                   value="{{ $invoice->customer->first_name }} {{ $invoice->customer->last_name }}" readonly placeholder="Full Name" required>
                                        </div>
                                        <div class="mb-2">
                                            <textarea class="form-control bg-light border-0" id="billingAddress"
                                                      rows="3" name="client_billing_address" readonly placeholder="Billing Address"
                                                      required>{{ $invoice->customer->billing_address }}</textarea>
                                        </div>
                                        <div class="mb-2">
                                            <input type="text" class="form-control bg-light border-0"
                                                   id="billingPhoneno" name="client_billing_phone" value="{{ $invoice->customer->billing_phone }}" readonly placeholder="Billing Phone" required>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-sm-12">
                                        <label for="shippingName" class="text-muted text-uppercase fw-semibold">Shipping Address</label>
                                        <div class="mb-2">
                                            <input type="text" name="client_shipping_name" class="form-control bg-light border-0" id="shippingName"
                                                   value="{{ $invoice->customer->first_name }} {{ $invoice->customer->last_name }}" readonly placeholder="Full Name" required>
                                        </div>
                                        <div class="mb-2">
                                            <textarea class="form-control bg-light border-0" id="shippingAddress"
                                                      rows="3" name="client_shipping_address" readonly placeholder="Shipping Address"
                                                      required>{{ $invoice->customer->shipping_address }}</textarea>
                                        </div>
                                        <div class="mb-2">
                                            <input type="text" class="form-control bg-light border-0" id="shippingPhone"
                                                   value="{{ $invoice->customer->shipping_phone }}" readonly name="client_shipping_phone" placeholder="Shipping Phone" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body p-4">
                                <div class="table-responsive">
                                    <table class="invoice-table table table-borderless table-nowrap mb-0">
                                        <thead class="align-middle">
                                        <tr class="table-active">
                                            <th scope="col" style="width: 10px;">#</th>
                                            <th scope="col">Product Details</th>
                                            <th scope="col" style="width: 80px;">
                                                <div class="d-flex currency-select input-light align-items-center">
                                                    Rate
                                                    <select class="form-select border-0 bg-light"
                                                            id="choices-payment-currency">
                                                        <!-- Options will be dynamically created -->
                                                    </select>
                                                </div>
                                            </th>
                                            <th scope="col" style="width: 80px;">Quantity</th>
                                            <th scope="col" class="text-end" style="width: 100px;">Subtotal</th>
                                            <th scope="col" class="text-end" style="width: 100px;"></th>
                                        </tr>
                                        </thead>
                                        <tbody id="product-list">
                                        @foreach($invoice->items as $index => $item)
                                            <tr id="product-row-{{ $index + 1 }}" class="product">
                                                <th scope="row" class="product-id">{{ $index + 1 }}</th>
                                                <td class="text-start">
                                                    <div class="mb-2">
                                                        <select name="product_id[]" class="form-select product-select bg-light border-0"
                                                                data-row="{{ $index + 1 }}" required>
                                                            <option value="">--Select--</option>
                                                            @foreach($products as $product)
                                                                <option value="{{ $product->id }}"
                                                                        data-name="{{ $product->name }}"
                                                                        data-price="{{ $product->price }}"
                                                                        data-description="{{ $product->description }}"
                                                                    {{ $item->product_id == $product->id ? 'selected' : '' }}>
                                                                    {{ $product->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <input type="hidden" name="product_name[]" id="product-name-{{ $index + 1 }}" value="{{ $item->product_name }}">
                                                    <textarea class="form-control bg-light border-0" name="product_description[]" required id="product-details-{{ $index + 1 }}" rows="3" readonly>{{ $item->product_description }}</textarea>
                                                </td>
                                                <td>
                                                    <input type="number" name="product_price[]" class="form-control product-price bg-light border-0" id="product-rate-{{ $index + 1 }}" step="0.01" placeholder="0.00" value="{{ $item->product_amount }}" required>
                                                </td>
                                                <td>
                                                    <div class="input-step">
                                                        <button type="button" class="minus">–</button>
                                                        <input type="number" name="product_qty[]" readonly class="product-quantity" id="product-qty-{{ $index + 1 }}"
                                                               value="{{ $item->product_quantity }}" min="0" step="1" required max="{{ $item->available_stock }}" maxlength="{{ $item->available_stock }}">
                                                        <button type="button" class="plus">+</button>
                                                    </div>
                                                </td>
                                                <td class="text-end">
                                                    <input type="text"
                                                           class="form-control bg-light border-0 product-line-price"
                                                           id="product-price-{{ $index + 1 }}" placeholder="0.00" value="{{ $item->product_quantity  * $item->product_amount}}" readonly>
                                                </td>
                                                <td class="product-removal">
                                                    <a href="javascript:void(0)"
                                                       class="btn btn-success remove-row">Delete</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <td colspan="6">
                                                <a href="javascript:addRow()"
                                                   class="btn btn-soft-secondary fw-medium"><i
                                                        class="ri-add-fill me-1 align-bottom"></i> Add Item</a>
                                            </td>
                                        </tr>


                                        <tr>
                                            <th scope="row">Estimated Tax</th>
                                            <td>
                                                <select name="tax_id" class="form-select bg-light border-0" id="cart-tax"
                                                        onchange="updateTotal()">
                                                    <option value="" selected>Select Tax</option>
                                                    <!-- Options will be added here by JavaScript -->
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Discount</th>
                                            <td>
                                                <select name="discount_id" class="form-select bg-light border-0" id="cart-discount"
                                                        onchange="updateTotal()">
                                                    <option value="" selected>Select Discount</option>
                                                    <!-- Options will be added here by JavaScript -->
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Shipping Charge</th>
                                            <td>
                                                <select name="shipping_charge_id" class="form-select bg-light border-0" id="cart-shipping"
                                                        onchange="updateTotal()">
                                                    <option value="" selected>Select Shipping</option>
                                                    <!-- Options will be added here by JavaScript -->
                                                </select>
                                            </td>
                                        </tr>


                                        <tr>
                                            <th scope="row">Subtotal</th>
                                            <td>
                                                <input type="text" class="form-control bg-light border-0"
                                                       id="cart-subtotal" value="{{ $invoice->sub_amount }}" readonly>
                                            </td>
                                        </tr>
                                        <tr class="border-top border-top-dashed mt-2">
                                            <th scope="row">Total Amount</th>
                                            <td>
                                                <input type="text" class="form-control bg-light border-0"
                                                       id="cart-total" value="{{ $invoice->amount }}" readonly v>
                                            </td>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>

                            <div class="mt-4">
                                <label for="note" class="form-label text-muted text-uppercase fw-semibold">NOTES</label>
                                <textarea class="form-control alert alert-info" name="note" id="note" placeholder="Notes" rows="2" required="">All accounts are to be paid within 7 days from receipt of invoice. To be paid by cheque or credit card or direct payment online. If account is not paid within 7 days the credits details supplied as confirmation of work undertaken will be charged the agreed quoted fee noted above.</textarea>
                            </div>

                            <div class="row justify-content-end mb-5">
                                <div class="col-lg-6">
                                    <div class="hstack gap-2 justify-content-end d-print-none mt-1">
                                        <button type="submit" class="btn btn-primary  me-3 mb-5 p-3">
                                            <i class="ri-download-2-line align-bottom me-1"></i> Send Invoice
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('script')
    <script type="text/javascript">
        let productIndex = 1; // Initial index for adding new rows

        // Function to add a new product row
        function addRow() {
            const rowCount = document.querySelectorAll('.product').length;
            const rowNumber = rowCount + 1;
            const newRow = `
        <tr id="product-row-${rowNumber}" class="product">
            <th scope="row" class="product-id">${rowNumber}</th>
            <td class="text-start">
                <div class="mb-2">
                    <select name="product_id[]" class="form-select product-select bg-light border-0" data-row="${rowNumber}" required>
                        <option value="">--Select--</option>
                        @foreach($products as $product)
            <option value="{{ $product->id }}" data-name="{{ $product->name }}" data-price="{{ $product->price }}" data-description="{{ $product->description }}">
                                {{ $product->name }}
            </option>
@endforeach
            </select>
        </div>
        <input type="hidden" name="product_name[]" id="product-name-${rowNumber}">
                <textarea name="product_description[]" class="form-control bg-light border-0 product-details" id="product-details-${rowNumber}" rows="3" readonly></textarea>
            </td>
            <td>
                <input type="number" name="product_price[]" class="form-control product-price bg-light border-0" id="product-rate-${rowNumber}" step="0.01" placeholder="0.00" required>
            </td>
            <td>
                <div class="input-step">
                    <button type="button" class="minus" data-row="${rowNumber}">–</button>
                    <input type="number" readonly class="product-quantity" id="product-qty-${rowNumber}" name="product_qty[]" value="0" min="0" step="1" required>
                    <button type="button" class="plus" data-row="${rowNumber}">+</button>
                </div>
            </td>
            <td class="text-end">
                <input type="text" class="form-control bg-light border-0 product-line-price" id="product-price-${rowNumber}" placeholder="0.00" readonly>
            </td>
            <td class="product-removal">
                <a href="javascript:void(0)" class="btn btn-success remove-row" data-row="${rowNumber}">Delete</a>
            </td>
        </tr>`;
            document.querySelector('#product-list').insertAdjacentHTML('beforeend', newRow);
            attachEventListenersToRow(rowNumber); // Attach event listeners to the new row
        }

        // Function to attach event listeners to a row
        function attachEventListenersToRow(rowNumber) {
            const minusButton = document.querySelector(`#product-row-${rowNumber} .minus`);
            const plusButton = document.querySelector(`#product-row-${rowNumber} .plus`);

            minusButton.addEventListener('click', function () {
                const quantityInput = document.querySelector(`#product-qty-${rowNumber}`);
                let quantity = parseInt(quantityInput.value, 10);
                quantity = Math.max(quantity - 1, 0); // Ensure quantity doesn't go below 0
                quantityInput.value = quantity;
                updateProductRow(`product-row-${rowNumber}`);
                updateTotal();
            });

            plusButton.addEventListener('click', function () {
                const quantityInput = document.querySelector(`#product-qty-${rowNumber}`);
                let quantity = parseInt(quantityInput.value, 10);
                quantity += 1;
                quantityInput.value = quantity;
                updateProductRow(`product-row-${rowNumber}`);
                updateTotal();
            });

            const productSelect = document.querySelector(`#product-row-${rowNumber} .product-select`);
            productSelect.addEventListener('change', function () {
                updateProductRow(`product-row-${rowNumber}`);
                updateTotal();
            });

            const quantityInput = document.querySelector(`#product-qty-${rowNumber}`);
            quantityInput.addEventListener('input', function () {
                updateProductRow(`product-row-${rowNumber}`);
                updateTotal();
            });
        }

        // Initial event listener for the first row
        document.addEventListener('DOMContentLoaded', function () {
            attachEventListenersToRow(1);
        });

        // Event listener for removing product rows
        document.addEventListener('click', function (event) {
            if (event.target.classList.contains('remove-row')) {
                const rowNumber = event.target.getAttribute('data-row');
                const row = document.querySelector(`#product-row-${rowNumber}`);
                if (row) {
                    row.remove();
                    updateTotal();
                }
            }
        });

        // Function to update a single product row
        function updateProductRow(rowId) {
            const rowNumber = rowId.split('-').pop();
            const quantity = parseInt(document.querySelector(`#product-qty-${rowNumber}`)?.value || 0, 10);
            const price = parseFloat(document.querySelector(`#product-rate-${rowNumber}`)?.value || 0, 10);
            const subtotal = (quantity * price).toFixed(2);

            // Update product details and price based on the selected product
            const productSelect = document.querySelector(`#product-row-${rowNumber} .product-select`);
            const selectedOption = productSelect ? productSelect.options[productSelect.selectedIndex] : null;
            const productDescription = selectedOption ? selectedOption.getAttribute('data-description') : '';
            const productName = selectedOption ? selectedOption.getAttribute('data-name') : '';
            const productPrice = selectedOption ? selectedOption.getAttribute('data-price') : '0.00';

            const detailsElem = document.querySelector(`#product-details-${rowNumber}`);
            const nameElem = document.querySelector(`#product-name-${rowNumber}`);
            const rateElem = document.querySelector(`#product-rate-${rowNumber}`);
            const priceElem = document.querySelector(`#product-price-${rowNumber}`);

            if (detailsElem && rateElem && priceElem) {
                detailsElem.value = productDescription;
                rateElem.value = productPrice;
                nameElem.value = productName;
                priceElem.value = subtotal;
            }
        }

        // Function to update the total calculation
        function updateTotal() {
            const rows = document.querySelectorAll('.product');
            let subtotal = 0;

            rows.forEach(row => {
                const linePrice = parseFloat(row.querySelector('.product-line-price').value) || 0;
                subtotal += linePrice;
            });

            const taxRate = parseFloat(document.querySelector('#cart-tax').value) || 0;
            const discountRate = parseFloat(document.querySelector('#cart-discount').value) || 0;
            const shippingRate = parseFloat(document.querySelector('#cart-shipping').value) || 0;

            const taxAmount = (subtotal * taxRate / 100).toFixed(2);
            const discountAmount = (subtotal * discountRate / 100).toFixed(2);
            const shippingAmount = (subtotal * shippingRate / 100).toFixed(2);

            const total = (subtotal + parseFloat(taxAmount) + parseFloat(shippingAmount) - parseFloat(discountAmount)).toFixed(2);

            document.querySelector('#cart-subtotal').value = subtotal.toFixed(2);
            document.querySelector('#cart-total').value = total;
        }

        // Function to update financials (taxes, discounts, shipping) based on the client's country
        function updateFinancials(countryId) {
            fetch(`/admin/invoices/financials/${countryId}`)
                .then(response => response.json())
                .then(data => {
                    populateDropdown('#cart-tax', data.taxes);
                    populateDropdown('#cart-discount', data.discounts);
                    populateDropdown('#cart-shipping', data.shippingCharges);
                    updateTotal();
                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        text: `Something went wrong. Please try again. Details: ${error.message}`,
                    });
                });
        }

        // Function to populate dropdowns for taxes, discounts, and shipping charges
        function populateDropdown(selector, items) {
            const dropdown = document.querySelector(selector);
            dropdown.innerHTML = ''; // Clear the dropdown
            const emptyOption = document.createElement('option');
            emptyOption.value = '';
            emptyOption.textContent = '--Select--';
            dropdown.appendChild(emptyOption);
            items.forEach(item => {
                const option = document.createElement('option');
                option.value = item.id;
                option.textContent = `${item.name} (${item.percentage}%)`;
                option.setAttribute('data-percentage', item.percentage);
                dropdown.appendChild(option);
            });
        }

        // Update financials based on client selection
        document.querySelector('#client_id').addEventListener('change', function () {
            const countryId = this.selectedOptions[0].getAttribute('data-country');
            if (countryId) {
                updateFinancials(countryId);
            }
        });

        // Initial update for financials on page load if client is preselected
        window.addEventListener('load', function () {
            const initialCountryId = document.querySelector('#client_id')?.selectedOptions[0]?.getAttribute('data-country');
            if (initialCountryId) {
                updateFinancials(initialCountryId);
            }
        });
    </script>

@endsection


