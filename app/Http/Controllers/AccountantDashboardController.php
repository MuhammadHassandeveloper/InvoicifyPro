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

class AccountantDashboardController extends Controller
{
    public function accountant_dashboard() {

        $user_id = Sentinel::getUser()->id;
        $data['title'] = 'Accountant Dashboard';
        $data['outOfStockCount'] = Product::where('available_stock', 0)->where('user_id',$user_id)->count();
        $data['lowStockCount'] = Product::where('available_stock', '<=', 10)->where('user_id',$user_id)->count();
        $data['activeCount'] = Product::where('status', 1)->where('user_id',$user_id)->count();
        $data['disabledCount'] = Product::where('status', 0)->where('user_id',$user_id)->count();


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
                 ->where('status', 1)->where('user_id',$user_id)->count();
            $monthlyActiveCount[] = $activeCount;

            $disabledCount = DB::table('products')
                ->whereBetween('created_at', [$monthStart, $monthEnd])
                ->where('status', 0)->where('user_id',$user_id)->count();
            $monthlyDisableddCount[] = $disabledCount;

            $OutStockCount = DB::table('products')
                ->whereBetween('created_at', [$monthStart, $monthEnd])
            ->where('available_stock', 0)->where('user_id',$user_id)->count();
            $monthlyOutStockCount[] = $OutStockCount;
            $last12MonthsLabels[] = $monthStart->format('M Y');

        }

        $data['monthlyActiveCount'] = array_reverse($monthlyActiveCount);
        $data['monthlyDisableddCount'] = array_reverse($monthlyDisableddCount);
        $data['monthlyOutStockCount'] = array_reverse($monthlyOutStockCount);
        $data['last12MonthsLabels'] = array_reverse($last12MonthsLabels);

        return view('accountant.dashboard', $data);
    }


    public  function profile_setting(){
        $user = Sentinel::getUser();
        $data = [];
        $data['title'] = 'Profile Setting';
        $data['user'] = Sentinel::getUser();
        return view('accountant.profile', $data);
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

}
