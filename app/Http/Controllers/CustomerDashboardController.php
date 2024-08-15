<?php

namespace App\Http\Controllers;

use App\Models\Invoices;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CustomerDashboardController extends Controller
{

    public function customer_dashboard() {
        $last12MonthsEarnings = [];
        $last12MonthsLabels = [];
        $monthlyPaidCount = [];
        $monthlyUnpaidCount = [];
        $monthlyVoidCount = [];
        $currentMonth = Carbon::now()->startOfMonth();
        $customer_id = Sentinel::getUser()->id;
        for ($i = 0; $i < 12; $i++) {
            // Start and end of the month
            $monthStart = $currentMonth->copy()->subMonths($i)->startOfMonth();
            $monthEnd = $monthStart->copy()->endOfMonth();

            // Count of paid invoices
            $paidCount = DB::table('invoices')
                ->whereBetween('created_at', [$monthStart, $monthEnd])
                ->where('status', 'paid')
                ->where('customer_id',$customer_id)
                ->count();
            $monthlyPaidCount[] = $paidCount;

            // Count of unpaid invoices
            $unpaidCount = DB::table('invoices')
                ->whereBetween('created_at', [$monthStart, $monthEnd])
                ->where('status', 'open')
                ->where('customer_id',$customer_id)
                ->count();
            $monthlyUnpaidCount[] = $unpaidCount;

            // Count of void invoices
            $voidCount = DB::table('invoices')
                ->whereBetween('created_at', [$monthStart, $monthEnd])
                ->where('status', 'void')
                ->where('customer_id',$customer_id)
                ->count();
            $monthlyVoidCount[] = $voidCount;

            // Earnings for each month
            $earnings = Invoices::where('status', 'paid')
                ->whereBetween('invoice_paid_date', [$monthStart, $monthEnd])
                ->where('customer_id',$customer_id)
                ->sum('amount');
            $last12MonthsEarnings[] = $earnings;

            // Labels for each month
            $last12MonthsLabels[] = $monthStart->format('M Y');
        }

        // Reverse arrays to show from oldest to newest
        $last12MonthsEarnings = array_reverse($last12MonthsEarnings);
        $last12MonthsLabels = array_reverse($last12MonthsLabels);
        $monthlyPaidCount = array_reverse($monthlyPaidCount);
        $monthlyUnpaidCount = array_reverse($monthlyUnpaidCount);
        $monthlyVoidCount = array_reverse($monthlyVoidCount);


        $allinvoices = Invoices::where('customer_id',$customer_id)->get();

        $totalSentAmount = $allinvoices->sum('amount');
        $totalSentCount = $allinvoices->count();

        $totalPaidAmount = $allinvoices->where('status', 'paid')->sum('amount');
        $totalPaidCount = $allinvoices->where('status', 'paid')->count();

        $totalUnpaidAmount = $allinvoices->where('status', 'open')->sum('amount');
        $totalUnpaidCount = $allinvoices->where('status', 'open')->count();

        $totalCancelledAmount = $allinvoices->where('status', 'void')->sum('amount');
        $totalCancelledCount = $allinvoices->where('status', 'void')->count();


        return view('customer.dashboard', [
            'last12MonthsEarnings' => $last12MonthsEarnings,
            'last12MonthsLabels' => $last12MonthsLabels,
            'monthlyPaidCount' => $monthlyPaidCount,
            'monthlyUnpaidCount' => $monthlyUnpaidCount,
            'monthlyVoidCount' => $monthlyVoidCount,
            'title' => 'Customer Dashboard'
        ], compact(
            'totalSentAmount', 'totalSentCount',
            'totalPaidAmount', 'totalPaidCount',
            'totalUnpaidAmount', 'totalUnpaidCount',
            'totalCancelledAmount', 'totalCancelledCount',
        ));
    }


    public  function profile_setting(){
        $user = Sentinel::getUser();
        $data = [];
        $data['title'] = 'Profile Setting';
        $data['user'] = Sentinel::getUser();
        return view('customer.profile', $data);
    }

    public function profile_update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'billing_address' => 'required',
            'email' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = [
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'billing_address' => $request->input('billing_address'),
        ];

        if (!empty($request->input('password'))) {
            $passwordValidator = Validator::make($request->all(), [
                'password' => 'required|string|min:6|confirmed',
            ]);
            if ($passwordValidator->fails()) {
                return redirect()->back()->withErrors($passwordValidator)->withInput();
            }
            $data['password'] = Hash::make($request->input('password')) ;
        }
        $save = User::where('id', $request->id)->update($data);
        if ($save) {
            return back()->with('success', 'Profile changes saved successfully.');
        } else {
            return back()->with('error', 'Profile changes not saved.');
        }
    }


    public function index(Request $request)
    {
        $data = array();
        $data['title'] = 'All Invoices';
        $customer_id = Sentinel::getUser()->id;
        $query = Invoices::where(function ($query) {
            $query->where('status','!=','void')->whereNotNull('customer_id');
        });

        $query->where('customer_id',$customer_id);

        $data['invoices'] = $query->latest()->get();

        $allinvoices = Invoices::where('customer_id',$customer_id)->get();

        $totalSentAmount = $allinvoices->sum('amount');
        $totalSentCount = $allinvoices->count();

        $totalPaidAmount = $allinvoices->where('status', 'paid')->sum('amount');
        $totalPaidCount = $allinvoices->where('status', 'paid')->count();

        $totalUnpaidAmount = $allinvoices->where('status', 'open')->sum('amount');
        $totalUnpaidCount = $allinvoices->where('status', 'open')->count();

        $totalCancelledAmount = $allinvoices->where('status', 'void')->sum('amount');
        $totalCancelledCount = $allinvoices->where('status', 'void')->count();



        return view('customer.invoices.index', $data, compact(
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
        $customer_id = Sentinel::getUser()->id;
        $query = Invoices::where(function ($query) {
            $query->where('status','open')->whereNotNull('customer_id');
        });
        $query->where('customer_id',$customer_id);
        $data['invoices'] = $query->latest()->get();
        return view('customer.invoices.unpaid', $data);
    }

    public function paid(Request $request)
    {
        $data = array();
        $data['title'] = 'Paid Invoices';
        $customer_id = Sentinel::getUser()->id;
        $query = Invoices::where(function ($query) {
            $query->where('status','paid')->whereNotNull('customer_id');
        });
        $query->where('customer_id',$customer_id);
        $data['invoices'] = $query->latest()->get();
        return view('customer.invoices.paid', $data);
    }

    public function transactions(Request $request)
    {
        $data = array();
        $data['title'] = 'Transactions';
        $customer_id = Sentinel::getUser()->id;
        $query = Invoices::where(function ($query) {
            $query->where('status','paid')->whereNotNull('customer_id');
        });
        $query->where('customer_id',$customer_id);
        $data['invoices'] = $query->latest()->get();
        return view('customer.invoices.transactions', $data);
    }

    public function saleReport(Request $request)
    {
        $data = array();
        $data['title'] = 'Sale Reports';
        $customer_id = Sentinel::getUser()->id;
        $query = Invoices::where(function ($query) {
            $query->where('status','paid')->whereNotNull('customer_id');
        });
        $query->where('customer_id',$customer_id);
        $data['invoices'] = $query->latest()->get();
        return view('customer.invoices.sales_report', $data);
    }

    public function void(Request $request)
    {
        $data = array();
        $data['title'] = 'Void Invoices';
        $customer_id = Sentinel::getUser()->id;
        $query = Invoices::where(function ($query) {
            $query->where('status','void')->whereNotNull('customer_id');
        });
        $query->where('customer_id',$customer_id);
        $data['invoices'] = $query->latest()->get();
        return view('customer.invoices.void', $data);
    }



    public function show($id) {

        $data = array();
        $data['title'] = 'Invoice Detail';
        $data['invoice'] = Invoices::find($id);
        return view('customer.invoices.detail', $data);
    }

}
