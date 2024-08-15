<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Invoices;
use App\Models\SiteSetting;
use App\Models\User;
use Carbon\Carbon;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{


    public function admin_dashboard() {
        $last12MonthsEarnings = [];
        $last12MonthsLabels = [];
        $monthlyPaidCount = [];
        $monthlyUnpaidCount = [];
        $monthlyVoidCount = [];
        $data = [];
        $currentMonth = Carbon::now()->startOfMonth();

        for ($i = 0; $i < 12; $i++) {
            // Start and end of the month
            $monthStart = $currentMonth->copy()->subMonths($i)->startOfMonth();
            $monthEnd = $monthStart->copy()->endOfMonth();

            // Count of paid invoices
            $paidCount = DB::table('invoices')
                ->whereBetween('created_at', [$monthStart, $monthEnd])
                ->where('status', 'paid')
                ->count();
            $monthlyPaidCount[] = $paidCount;

            // Count of unpaid invoices
            $unpaidCount = DB::table('invoices')
                ->whereBetween('created_at', [$monthStart, $monthEnd])
                ->where('status', 'open')
                ->count();
            $monthlyUnpaidCount[] = $unpaidCount;

            // Count of void invoices
            $voidCount = DB::table('invoices')
                ->whereBetween('created_at', [$monthStart, $monthEnd])
                ->where('status', 'void')
                ->count();
            $monthlyVoidCount[] = $voidCount;

            // Earnings for each month
            $earnings = Invoices::where('status', 'paid')
                ->whereBetween('invoice_paid_date', [$monthStart, $monthEnd])
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


        $allinvoices = Invoices::all();

        $totalSentAmount = $allinvoices->sum('amount');
        $totalSentCount = $allinvoices->count();

        $totalPaidAmount = $allinvoices->where('status', 'paid')->sum('amount');
        $totalPaidCount = $allinvoices->where('status', 'paid')->count();

        $totalUnpaidAmount = $allinvoices->where('status', 'open')->sum('amount');
        $totalUnpaidCount = $allinvoices->where('status', 'open')->count();

        $totalCancelledAmount = $allinvoices->where('status', 'void')->sum('amount');
        $totalCancelledCount = $allinvoices->where('status', 'void')->count();


        $last12MonthsLabels = [];
        $monthlyActiveCount = [];
        $monthlyDisableddCount = [];
        $monthlyOutStockCount = [];
        $currentMonth = Carbon::now()->startOfMonth();

        for ($i = 0; $i < 12; $i++) {
            // Start and end of the month
            $monthStart = $currentMonth->copy()->subMonths($i)->startOfMonth();
            $monthEnd = $monthStart->copy()->endOfMonth();

            $activeCount = DB::table('products')
                ->whereBetween('created_at', [$monthStart, $monthEnd])
                ->where('status', 1)->count();
            $monthlyActiveCount[] = $activeCount;

            $disabledCount = DB::table('products')
                ->whereBetween('created_at', [$monthStart, $monthEnd])
                ->where('status', 0)->count();
            $monthlyDisableddCount[] = $disabledCount;

            $OutStockCount = DB::table('products')
                ->whereBetween('created_at', [$monthStart, $monthEnd])
                ->where('available_stock', 0)->count();
            $monthlyOutStockCount[] = $OutStockCount;
            $last12MonthsLabels[] = $monthStart->format('M Y');

        }

        $monthlyActiveCount = array_reverse($monthlyActiveCount);
        $monthlyDisableddCount = array_reverse($monthlyDisableddCount);
        $monthlyOutStockCount = array_reverse($monthlyOutStockCount);
        $last12MonthsLabels = array_reverse($last12MonthsLabels);

        return view('admin.dashboard', [
            'last12MonthsEarnings' => $last12MonthsEarnings,
            'last12MonthsLabels' => $last12MonthsLabels,
            'monthlyPaidCount' => $monthlyPaidCount,
            'monthlyUnpaidCount' => $monthlyUnpaidCount,
            'monthlyVoidCount' => $monthlyVoidCount,
            'monthlyDisableddCount' => $monthlyDisableddCount,
            'monthlyActiveCount' => $monthlyActiveCount,
            'monthlyOutStockCount' => $monthlyOutStockCount,
            'title' => 'Admin Dashboard'
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
                return view('admin.profile', $data);
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


    public  function site_setting_from(){
        $user = Sentinel::getUser();
            $data = [];
            $data['title'] = 'Site Setting';
            $data['siteSettings'] = SiteSetting::first();
            return view('admin.site_setting', $data);
    }


    public function site_setting_save(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'site_name' => 'required',
            'stripe_publish_key' => 'required',
            'stripe_secret_key' => 'required',

            'site_white_logo' => 'image|mimes:png,jpg,jpeg,svg',
            'site_dark_logo' => 'image|mimes:png,jpg,jpeg,svg',
            'site_fav_icon' => 'image|mimes:png,jpg,jpeg,svg',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $siteSettings = SiteSetting::firstOrNew([]);

        foreach (['site_name', 'stripe_publish_key', 'stripe_secret_key','currency_sign','currency_code'] as $field) {
            $newValue = $request->input($field);
            if ($siteSettings->$field !== $newValue) {
                $siteSettings->$field = $newValue;
            }
        }

        foreach (['site_white_logo', 'site_dark_logo', 'site_fav_icon'] as $field) {
            if ($request->hasFile($field)) {
                $file = $request->file($field);
                $fileName = $file->getClientOriginalName();
                if ($siteSettings->$field !== $fileName) {
                    $file->move(public_path('assets/logo'), $fileName);
                    $siteSettings->$field = $fileName;
                }
            }
        }

        $siteSettings->save();

        return redirect()->back()->with('success', 'Site settings updated successfully');
    }

    public function activitylogs(Request $request) {
        $title = 'Activity Logs';
        $fromDate = $request->input('from_date', now()->subDay()->format('Y-m-d'));
        $toDate = $request->input('to_date', now()->format('Y-m-d'));
        $activityLogs = ActivityLog::with('user')
            ->whereDate('created_at', '>=', $fromDate)
            ->whereDate('created_at', '<=', $toDate)
            ->orderBy('created_at', 'desc')
            ->get();

        foreach ($activityLogs as $log) {
            $log->details = json_decode($log->details, true);
        }

        return view('admin.acitivitylogs', compact('title', 'activityLogs', 'fromDate', 'toDate'));
    }







}
