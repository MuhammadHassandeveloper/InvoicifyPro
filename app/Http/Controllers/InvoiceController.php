<?php

namespace App\Http\Controllers;

use App\Mail\InvoiceMail;
use App\Models\Country;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Invoices;
use App\Models\InvoicesItems;
use App\Models\Tax;
use App\Models\Discount;
use App\Models\ShippingCharge;
use App\Helpers\AppHelper;
use Illuminate\Support\Facades\Mail;
use Stripe\Invoice;
use Stripe\Stripe;
use Stripe\Invoice as StripeInvoice;
use Stripe\InvoiceItem;
use Stripe\TaxRate;
use Validator;
use Auth;
use App\Models\Product;


class InvoiceController extends Controller
{

    public function index(Request $request)
    {
        $data = array();
        $data['title'] = 'All Invoices';
        $query = Invoices::where(function ($query) {
            $query->where('status','!=','void')->whereNotNull('customer_id');
            });
        $data['invoices'] = $query->latest()->get();


        $allinvoices = Invoices::all();

        $totalSentAmount = $allinvoices->sum('amount');
        $totalSentCount = $allinvoices->count();

        $totalPaidAmount = $allinvoices->where('status', 'paid')->sum('amount');
        $totalPaidCount = $allinvoices->where('status', 'paid')->count();

        $totalUnpaidAmount = $allinvoices->where('status', 'open')->sum('amount');
        $totalUnpaidCount = $allinvoices->where('status', 'open')->count();

        $totalCancelledAmount = $allinvoices->where('status', 'void')->sum('amount');
        $totalCancelledCount = $allinvoices->where('status', 'void')->count();



        return view('admin.invoices.index', $data, compact(
            'totalSentAmount', 'totalSentCount',
            'totalPaidAmount', 'totalPaidCount',
            'totalUnpaidAmount', 'totalUnpaidCount',
            'totalCancelledAmount', 'totalCancelledCount',
        ));
    }

    public function unpaid(Request $request)
    {
        $data = array();
        $data['title'] = 'Unpaid Invoices';
        $query = Invoices::where(function ($query) {
            $query->where('status','open')->whereNotNull('customer_id');
        });
        $data['invoices'] = $query->latest()->get();
        return view('admin.invoices.unpaid', $data);
    }

    public function paid(Request $request)
    {
        $data = array();
        $data['title'] = 'Paid Invoices';
        $query = Invoices::where(function ($query) {
            $query->where('status','paid')->whereNotNull('customer_id');
        });
        $data['invoices'] = $query->latest()->get();
        return view('admin.invoices.paid', $data);
    }

    public function transactions(Request $request)
    {
        $data = array();
        $data['title'] = 'Transactions';
        $query = Invoices::where(function ($query) {
            $query->where('status','paid')->whereNotNull('customer_id');
        });
        $data['invoices'] = $query->latest()->get();
        return view('admin.invoices.transactions', $data);
    }

    public function saleReport(Request $request)
    {
        $data = array();
        $data['title'] = 'Sale Reports';
        $query = Invoices::where(function ($query) {
            $query->where('status','paid')->whereNotNull('customer_id');
        });
        $data['invoices'] = $query->latest()->get();
        return view('admin.invoices.sales_report', $data);
    }

    public function void(Request $request)
    {
        $data = array();
        $data['title'] = 'Void Invoices';
        $query = Invoices::where(function ($query) {
            $query->where('status','void')->whereNotNull('customer_id');
        });
        $data['invoices'] = $query->latest()->get();
        return view('admin.invoices.void', $data);
    }



    public function create() {
        $data = array();
        $data['title'] = 'Create Invoice';
        $data['clients'] = User::whereHas('roles', function ($query) {
            $query->where('roles.slug', 'customer');
        })->where('users.status', 1)
            ->whereHas('country', function ($query) {
                $query->where('status', 1);
            })
            ->get();

        $data['products'] = Product::where('status', 1)->where('available_stock' ,'>',0)->get();

        return view('admin.invoices.create', $data);
    }

    public function show($id) {

        $data = array();
        $data['title'] = 'Invoice Detail';
        $data['invoice'] = Invoices::find($id);
        return view('admin.invoices.detail', $data);
    }

    public function generateInvoice(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'client_id' => 'required|exists:users,id',
            'due_date' => 'required|date|after:today',
            'product_description.*' => 'required|string|max:200',
            'product_price.*' => 'required|numeric|max:999999.99',
            'product_qty.*' => 'required|integer|min:1',
            'note' => 'required|string|max:300',
            'tax_id' => 'nullable|exists:taxes,id',
            'discount_id' => 'nullable|exists:discounts,id',
            'shipping_charge_id' => 'nullable|exists:shipping_charges,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ]);
        }

        $secretKey = AppHelper::stripe_secret_key();
        $customer = User::find($request->client_id);

        if (empty($customer)) {
            return response()->json([
                'success' => false,
                'message' => 'Client detail not found.'
            ]);
        }

        $country = Country::find($customer->country_id);

        if (empty($country)) {
            return response()->json([
                'success' => false,
                'message' => 'Country detail not found.'
            ]);
        }

        $currencySign = AppHelper::appCurrencySign();
        $currencyCode = AppHelper::appCurrencyCode();

        if (empty($secretKey) || empty($currencySign) || empty($currencyCode)) {
            return response()->json([
                'success' => false,
                'message' => 'Please set up Stripe keys and currency settings in site settings before creating an invoice.'
            ]);
        }

        Stripe::setApiKey($secretKey);

        $dueDate = strtotime($request->due_date);
        if (empty($dueDate)) {
            return response()->json([
                'success' => false,
                'message' => 'Due date is required'
            ]);
        }

        try {
            // Update customer with billing details
            \Stripe\Customer::update(
                $customer->stripe_customer_id,
                [
                    'address' => [
                        'line1' => $request->client_billing_address,
                    ],
                    'email' => $request->client_email,
                    'phone' => $request->client_billing_phone,
                ]
            );

            $stripeInvoice = \Stripe\Invoice::create([
                'customer' => $customer->stripe_customer_id,
                'auto_advance' => false,
                'collection_method' => 'send_invoice',
                'due_date' => $dueDate,
                'description' => $request->note,
                'currency' => $currencyCode,
            ]);

            $totalAmount = 0;
            foreach ($request->product_description as $key => $description) {
                $unitAmount = $request->product_price[$key];
                $quantity = $request->product_qty[$key];
                $pname = $request->product_name[$key];
                $itemTotal = $unitAmount * $quantity;
                $totalAmount += $itemTotal;

                \Stripe\InvoiceItem::create([
                    'customer' => $customer->stripe_customer_id,
                    'invoice' => $stripeInvoice->id,
                    'quantity' => $quantity,
                    'unit_amount' => $unitAmount * 100,
                    'currency' => $currencyCode,
                    'description' => 'Item Name:' . ' ' . $pname . '____' . 'Description:' . ' ' . substr($description, 0, 140),
                ]);
            }

            $totalTaxAmount = 0;
            $totalDiscountAmount = 0;
            $totalShippingAmount = 0;

            if ($request->tax_id) {
                $tax = Tax::find($request->tax_id);
                if ($tax) {
                    $taxAmount = ($totalAmount * $tax->percentage) / 100;
                    $totalTaxAmount += $taxAmount;
                    \Stripe\InvoiceItem::create([
                        'customer' => $customer->stripe_customer_id,
                        'invoice' => $stripeInvoice->id,
                        'unit_amount' => $taxAmount * 100, // Stripe amount is in cents
                        'currency' => $currencyCode,
                        'quantity' => 1,
                        'description' => 'Tax: ' . $tax->name . ' (' . $tax->percentage . '%)'
                    ]);
                }
            }

            if ($request->discount_id) {
                $discount = Discount::find($request->discount_id);
                if ($discount) {
                    $discountAmount = ($totalAmount * $discount->percentage) / 100;
                    $totalDiscountAmount += $discountAmount;
                    \Stripe\InvoiceItem::create([
                        'customer' => $customer->stripe_customer_id,
                        'invoice' => $stripeInvoice->id,
                        'unit_amount' => -$discountAmount * 100, // Stripe amount is in cents
                        'currency' => $currencyCode,
                        'quantity' => 1,
                        'description' => 'Discount: ' . $discount->name . ' (' . $discount->percentage . '%)'
                    ]);
                }
            }

            if ($request->shipping_charge_id) {
                $shippingCharge = ShippingCharge::find($request->shipping_charge_id);
                if ($shippingCharge) {
                    $shippingAmount = ($totalAmount * $shippingCharge->percentage) / 100;
                    $totalShippingAmount += $shippingAmount;
                    \Stripe\InvoiceItem::create([
                        'customer' => $customer->stripe_customer_id,
                        'invoice' => $stripeInvoice->id,
                        'unit_amount' => $shippingAmount * 100, // Stripe amount is in cents
                        'currency' => $currencyCode,
                        'quantity' => 1,
                        'description' => 'Shipping: ' . $shippingCharge->name . ' (' . $shippingCharge->percentage . '%)'
                    ]);
                }
            }

            $finalTotalAmount = $totalAmount + $totalTaxAmount + $totalShippingAmount - $totalDiscountAmount;

            $stripeInvoice->description .= "\nTotal Amount: $currencySign" . number_format($finalTotalAmount, 2);

            $stripeInvoice->finalizeInvoice();
            $stripeInvoice = \Stripe\Invoice::retrieve($stripeInvoice->id);
            $myinvoice = Invoices::create([
                    'user_id' => Sentinel::getUser()->id,
                    'customer_id' => $request->client_id,
                    'country_id' => $request->country_id,
                    'stripe_invoice_id' => $stripeInvoice->id,
                    'stripe_invoice_number' => $stripeInvoice->number,
                    'stripe_invoice_url' => $stripeInvoice->hosted_invoice_url,
                    'stripe_invoice_pdf_url' => $stripeInvoice->invoice_pdf,
                    'stripe_customer_id' => $request->stripe_customer_id,
                    'sub_amount' => $totalAmount,
                    'amount' => $finalTotalAmount,
                    'description' => $request->note,
                    'note' => $request->note,
                    'period_start' => now(),
                    'period_end' => date('Y-m-d', strtotime($request->due_date)),
                    'invoice_paid_date' => null,
                    'invoice_paid_time' => null,
                    'status' => $stripeInvoice->status,
                    'charge_id' => $stripeInvoice->charge,
                    'tax_id' => $request->tax_id,
                    'discount_id' => $request->discount_id,
                    'charge_shipping_id' => $request->shipping_charge_id,
                    'total_tax_amount' => $totalTaxAmount,
                    'total_charge_amount' => $totalShippingAmount,
                    'total_discount_amount' => $totalDiscountAmount,
                ]);

                // Create the invoice items
                foreach ($request->product_description as $key => $description) {
                    InvoicesItems::create([
                        'invoice_id' => $myinvoice->id,
                        'customer_id' => $request->client_id,
                        'stripe_customer_id' => $request->stripe_customer_id,
                        'stripe_invoice_id' => $stripeInvoice->id,
                        'product_id' => $request->product_id[$key],
                        'product_amount' => $request->product_price[$key],
                        'product_quantity' => $request->product_qty[$key],
                        'product_description' => $description,
                    ]);
                }

                // Enable auto-advance on the Stripe invoice
                $stripeInvoice->auto_advance = true;
                $stripeInvoice->save();

                // Retrieve the customer details
                $customer = User::find($request->client_id);

                // Prepare sender details
                $senderName = Sentinel::getUser()->first_name . ' ' . Sentinel::getUser()->last_name;
                $senderEmail = Sentinel::getUser()->email;
                 Mail::to($customer->email)->send(new InvoiceMail($myinvoice, $customer->first_name, $customer->last_name, $customer->email, $customer->phone, $customer->billing_address,$senderName,$senderEmail));

            // Store activity log
                AppHelper::storeActivity(Sentinel::getUser()->id, 'Create Invoice', $request->all());
                return response()->json([
                    'success' => true,
                    'message' => 'Invoice created and payment link also sent successfully to client email address',
                    'invoice_id' => $myinvoice->id
                ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage() . ': ' . $e->getLine(),
            ]);
        }
    }

    public function edit($id) {
        $data = array();
        $data['title'] = 'Edit Invoice';
        $data['invoice'] = Invoices::with('items')->find($id); // Assuming 'items' is the relationship for invoice items
        $data['products'] = Product::all();
        $data['taxes'] = Tax::all();
        $data['discounts'] = Discount::all();
        $data['shippingCharges'] = ShippingCharge::all();
        $data['clients'] = User::whereHas('roles', function ($query) {
            $query->where('roles.slug', 'customer');
        })->where('users.status', 1)->get();
        return view('admin.invoices.edit', $data);
    }

    public function fecthInvoice($id)
    {
        $invoice = Invoices::with('items')->findOrFail($id);
        return response()->json($invoice);
    }



    public function getProductDetails($id)
    {
        $product = Product::find($id);
        return response()->json($product);
    }


    public function financialsDetails($countryId)
    {
        $taxes = Tax::where('country_id', $countryId)->where('status', 1)->get();
        $discounts = Discount::where('status', 1)->get();
        $shippingCharges = ShippingCharge::where('country_id', $countryId)->where('status',1)->get();
        return response()->json([
            'taxes' => $taxes,
            'discounts' => $discounts,
            'shippingCharges' => $shippingCharges,
        ]);
    }

    public function voidInvoice($id)
    {
        try {
            $myinvoice = Invoices::findOrFail($id);
            if (!empty($myinvoice->stripe_invoice_id)) {
                $secretKey = AppHelper::stripe_secret_key();
                Stripe::setApiKey($secretKey);
                $stripeInvoice = \Stripe\Invoice::retrieve($myinvoice->stripe_invoice_id);
                $stripeInvoice->voidInvoice();
            }

            $myinvoice->status = 'void';
            $myinvoice->save();
            return response()->json([
                'success' => true,
                'message' => 'Invoice voided or cancelled successfully.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage() . ': ' . $e->getLine(),
            ]);
        }
    }


    //fetch invoices from stripe and update invoices status
    public function updateInvoiceStatus()
    {
        $secretKey = AppHelper::stripe_secret_key();
        Stripe::setApiKey($secretKey);
        $stripeInvoices = $this->fetchPaidInvoices(); // Fetch only paid invoices
        $processedInvoices = [];

        foreach ($stripeInvoices as $stripeInvoice) {
            $invoice = Invoices::where('stripe_invoice_id', $stripeInvoice->id)->where('status','open')->first();
            $customer = User::where('email', $stripeInvoice->customer_email)->first();
            if ($customer && $invoice && !$this->isInvoiceProcessed($processedInvoices, $stripeInvoice->id)) {
                if ($invoice->status !== 'paid') {
                    $this->updateInvoiceData($invoice, $customer, $stripeInvoice);
                    $this->handleInvoicePayment($invoice, $stripeInvoice, $customer);
                    $processedInvoices[$stripeInvoice->id] = true;
                }
            }
        }
    }


    private function fetchPaidInvoices()
    {
        $invoices = [];
        $limit = 100;
        $startingAfter = null;
        $currentDate = now();
        $startOfMonth = $currentDate->startOfMonth()->timestamp;
        $endOfMonth = $currentDate->endOfMonth()->timestamp;
        do {
            $options = [
                'limit' => $limit,
                'created' => [
                    'gte' => $startOfMonth,
                    'lte' => $endOfMonth,
                ],
            ];

            if ($startingAfter) {
                $options['starting_after'] = $startingAfter;
            }

            $result = \Stripe\Invoice::all($options);
            $invoices = array_merge($invoices, $result->data);

            if (count($result->data) > 0) {
                $startingAfter = end($result->data)->id;
            } else {
                break;
            }
        } while ($result->has_more);

        return $invoices;
    }

    private function isInvoiceProcessed($processedInvoices, $stripeInvoiceId)
    {
        return array_key_exists($stripeInvoiceId, $processedInvoices);
    }

    private function updateInvoiceData($invoice, $customer, $stripeInvoice)
    {

        $invoice->customer_id = $customer->id;
        $invoice->stripe_invoice_id = $stripeInvoice->id;
        $invoice->stripe_invoice_url = $stripeInvoice->hosted_invoice_url;
        $invoice->stripe_invoice_pdf_url = $stripeInvoice->invoice_pdf;
        $invoice->amount = $stripeInvoice->total / 100;
    }

    private function handleInvoicePayment($invoice, $stripeInvoice, $customer)
    {
        if ($invoice->status === 'paid') {
            return; // Exit the function if the invoice is already paid
        }

        if ($stripeInvoice->status === 'paid') {
            try {
                $chargeId = $stripeInvoice->charge;
                $charge = \Stripe\Charge::retrieve($chargeId);
                $paidTimestamp = $charge->created;
                $paidDateTime = \Carbon\Carbon::createFromTimestamp($paidTimestamp);
                $invoice->invoice_paid_date = $paidDateTime->toDateString();
                $invoice->invoice_paid_time = $paidDateTime->toTimeString();
            } catch (\Exception $e) {
                $invoice->invoice_paid_date = now()->toDateString();
                $invoice->invoice_paid_time = now()->format('H:i:s');
            }

            $invoice->charge_id = $stripeInvoice->charge;
            $invoice->status = $stripeInvoice->status;
            $invoice->save();
            $invoiceItems = InvoicesItems::where('invoice_id', $invoice->id)->get();
            foreach ($invoiceItems as $item) {
                $product = $item->product;
                if ($product && $product->available_stock >= $item->product_quantity) {
                    $product->available_stock -= $item->product_quantity;
                    $product->save();
                }
            }
        }
    }



}
