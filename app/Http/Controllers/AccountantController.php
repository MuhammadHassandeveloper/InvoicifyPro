<?php

namespace App\Http\Controllers;

use App\Helpers\AppHelper;
use App\Models\Country;
use App\Models\User;
use App\Models\Role;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AccountantController extends Controller
{
    public function index()
    {
        $accountants = User::whereHas('roles', function ($query) {
            $query->where('roles.slug', 'accountant');
        })->whereHas('country', function ($query) {
            $query->where('status', 1);
        })->get();

        return view('admin.accountants.index', ['accountants' => $accountants, 'title' => 'Accountants']);
    }

    public function create()
    {
        $data = array();
        $data['title'] = 'Create Accountant';
        $data['countries'] = Country::all();
        return view('admin.accountants.create',$data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'phone' => 'required|numeric|unique:users,phone',
            'country_id' => 'required|exists:countries,id',
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
            'country_id' => $request->input('country_id'),
        ];

        DB::table('activations')->insert([
            'user_id' => $user->id,
            'code' => Str::random(60),
            'completed' => 0,
            'completed_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $role = Sentinel::findRoleByName('accountant');
        User::where('id', $user->id)->update($data);
        AppHelper::storeActivity(Sentinel::getUser()->id,'Create Accountant',$request->all());

        if ($role) {
            $role->users()->attach($user);
            return redirect()->route('admin.accountants.index')->with('success', 'Accountant created successfully.');
        } else {
            return back()->with('error', 'Role assignment failed.');
        }
    }

    public function edit($id)
    {
        $data = array();
        $data['title'] = 'Edit Accountant';
        $data['countries'] = Country::all();
        $data['accountant'] = User::findOrFail($id);
        return view('admin.accountants.edit', $data);
    }

    public function update(Request $request, $id)
    {

        $accountant = User::findOrFail($id);
        $request->validate([
            'email' => 'required|email|unique:users,email,' . $accountant->id,
            'password' => 'nullable|min:6|confirmed',
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'country_id' => 'required|exists:countries,id',
        ]);

        $data = $request->except('password');
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }
        $accountant->update($data);
        AppHelper::storeActivity(Sentinel::getUser()->id,'update Accountant',$request->all());
        return redirect()->route('admin.accountants.index')->with('success', 'Accountant updated successfully.');
    }

    public function destroy($id)
    {
        $accountant = User::findOrFail($id);
        $accountant->delete();
        return redirect()->route('admin.accountants.index')->with('success', 'Accountant deleted successfully.');
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
        return response()->json(['message' => 'Accountant status updated successfully']);
    }
}

