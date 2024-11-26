<?php

namespace App\Http\Controllers;

use App\Helpers\AppHelper;
use App\Models\Invoices;
use App\Models\User;
use App\Models\Role;
use App\Models\Country;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Stripe\Customer;
use Stripe\Stripe;

class ClientController extends Controller
{
    public function index()
    {
        $clients = User::whereHas('roles', function ($query) {
            $query->where('roles.slug', 'customer');
        })->latest()->get();
        return view('admin.clients.index', ['clients' => $clients, 'title' => 'All Clients']);
    }

    public function active()
    {
        $clients = User::whereHas('roles', function ($query) {
            $query->where('roles.slug', 'customer');
        })->where('users.status', 1)->get();
        return view('admin.clients.active', ['clients' => $clients, 'title' => 'All Active Clients']);
    }

    public function disabled()
    {
        $clients = User::whereHas('roles', function ($query) {
            $query->where('roles.slug', 'customer');
        })->where('users.status', 0)->get();
        return view('admin.clients.disabled', ['clients' => $clients, 'title' => 'All Disabled Clients']);
    }

    public function create()
    {
        $countries = Country::all();
        return view('admin.clients.create', compact('countries'));
    }

    public function store(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'phone' => 'required|numeric|min:11|unique:users,phone',
            'billing_address' => 'required|string',
            'billing_city' => 'required|string',
            'billing_state' => 'required|string',
            'billing_phone' => 'required|',
            'shipping_address' => 'required|string',
            'shipping_city' => 'required|string',
            'shipping_state' => 'required|string',
            'shipping_phone' => 'required',
            'country_id' => 'required|exists:countries,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $secretKey = AppHelper::stripe_secret_key();
        Stripe::setApiKey($secretKey);
        $stripeCustomer = Customer::create([
            'email' => $request->input('email'),
            'name' => $request->input('first_name') . ' ' . $request->input('last_name'),
            'phone' => $request->input('phone'),
        ]);

        $user = Sentinel::register([
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);

        $data = [
            'password' => Hash::make($request->password),
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'phone' => $request->input('phone'),
            'billing_address' => $request->input('billing_address'),
            'billing_city' => $request->input('billing_city'),
            'billing_state' => $request->input('billing_state'),
            'billing_phone' => $request->input('billing_phone'),
            'shipping_address' => $request->input('shipping_address'),
            'shipping_city' => $request->input('shipping_city'),
            'shipping_state' => $request->input('shipping_state'),
            'shipping_phone' => $request->input('shipping_phone'),
            'country_id' => $request->input('country_id'),
            'stripe_customer_id' => $stripeCustomer->id,
        ];

        // Assign activation to the user
        DB::table('activations')->insert([
            'user_id' => $user->id,
            'code' => Str::random(60),
            'completed' => 0,
            'completed_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        User::where('id', $user->id)->update($data);
        $role = Sentinel::findRoleByName('customer');
        AppHelper::storeActivity(Sentinel::getUser()->id,'Add Client',$request->all());

        if ($role) {
            $role->users()->attach($user);
            // Mail::to($user->email)->send(new WelcomeEmail($user, $request->input('password')));
            return redirect()->route('admin.clients.index')->with('success', 'Client created successfully.');
        } else {
            return back()->with('error', 'Client creation not successful');
        }
    }

    public function edit($id)
    {
        $client = User::findOrFail($id);
        $roles = Role::all();
        $countries = Country::all();
        return view('admin.clients.edit', compact('client', 'roles', 'countries'));
    }

    public function update(Request $request, $id)
    {
        $client = User::findOrFail($id);
        $request->validate([
            'email' => 'required|email|unique:users,email,' . $client->id,
            'password' => 'nullable|min:6|confirmed',
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'billing_address' => 'required',
            'billing_city' => 'required',
            'billing_state' => 'required',
            'billing_phone' => 'required',
            'shipping_address' => 'required',
            'shipping_city' => 'required',
            'shipping_state' => 'required',
            'shipping_phone' => 'required',
            'country_id' => 'required|exists:countries,id',
        ]);


        $secretKey = AppHelper::stripe_secret_key();
        Stripe::setApiKey($secretKey);
        $stripeCustomer = Customer::retrieve($client->stripe_customer_id);
        $stripeCustomer->name = $request->input('first_name') . ' ' . $request->input('last_name');
        $stripeCustomer->phone = $request->input('phone');
        $stripeCustomer->save();

        $data = $request->except('password');
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }
        $client->update($data);

        AppHelper::storeActivity(Sentinel::getUser()->id,'Update Client',$request->all());
        return redirect()->route('admin.clients.index')->with('success', 'Client updated successfully.');
    }

    public function show($id)
    {
        $client = User::findOrFail($id);
        return response()->json(['customer' => $client]);
    }

    public function destroy($id)
    {
        $client = User::findOrFail($id);
        Invoices::where('customer_id',$id)->delete();
        $client->delete();
        return response()->json(['message' => 'Client deleted successfully']);
    }

    public function changeStatus($id)
    {
        $client = User::findOrFail($id);
        $client->status = !$client->status;
        $client->save();
        $completedStatus = $client->status ? 1 : 0;
        DB::table('activations')
            ->where('user_id', $client->id)
            ->update(['completed' => $completedStatus]);
        return response()->json(['message' => 'Client status updated successfully']);
    }

    public function getClientDetails($id)
    {
        $client = User::findOrFail($id);
        return response()->json([
            'email' => $client->email,
            'phone' => $client->phone,
            'billing_name' => $client->first_name . ' ' . $client->last_name,
            'billing_address' => $client->billing_address,
            'billing_phone' => $client->billing_phone,
            'shipping_name' => $client->first_name . ' ' . $client->last_name,
            'shipping_address' => $client->shipping_address,
            'shipping_phone' => $client->shipping_phone,
            'country_id' => $client->country_id,
            'currency' => AppHelper::appCurrencySign(),
        ]);
    }



}
