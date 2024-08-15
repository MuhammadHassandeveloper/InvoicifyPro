<?php

namespace App\Http\Controllers;

use App\Helpers\AppHelper;
use App\Models\ShippingCharge;
use App\Models\Country;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;

class ShippingChargeController extends Controller
{
    public function index()
    {
        $data = [];
        $data['title'] = 'Shipping Charges';
        $data['shippingCharges'] = ShippingCharge::with('country')->get();
        $data['countries'] = Country::where('status',1)->get();
        return view('admin.shipping_charges.index', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'country_id' => 'required|exists:countries,id',
            'name' => 'required|string|max:255',
            'percentage' => 'required|numeric|min:0|max:100',
        ]);

        $request->merge(['user_id' => Sentinel::getUser()->id]);
        $shippingCharge = ShippingCharge::create($request->all());

        $shippingChargeHtml = view('admin.shipping_charges.partials.shipping_charge_row', compact('shippingCharge'))->render();
        AppHelper::storeActivity(Sentinel::getUser()->id,'Create Shipping Charge',$request->all());

        return response($shippingChargeHtml, 200);
    }

    public function show($id)
    {
        $shippingCharge = ShippingCharge::with('country')->find($id);

        if (!$shippingCharge) {
            return response()->json(['message' => 'Shipping Charge not found'], 404);
        }

        return response()->json($shippingCharge, 200);
    }

    public function edit($id)
    {
        $shippingCharge = ShippingCharge::with('country')->find($id);

        if (!$shippingCharge) {
            return response()->json(['message' => 'Shipping Charge not found'], 404);
        }

        return response()->json($shippingCharge, 200);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'country_id' => 'required|exists:countries,id',
            'name' => 'required|string|max:255',
            'percentage' => 'required|numeric|min:0|max:100',
        ]);

        $shippingCharge = ShippingCharge::find($id);
        if (!$shippingCharge) {
            return response()->json(['message' => 'Shipping Charge not found'], 404);
        }

        $request->merge(['user_id' => Sentinel::getUser()->id]);
        $shippingCharge->update($request->all());
        $shippingChargeHtml = view('admin.shipping_charges.partials.shipping_charge_row', compact('shippingCharge'))->render();
        AppHelper::storeActivity(Sentinel::getUser()->id,'Update Shipping Charge',$request->all());

        return response($shippingChargeHtml, 200);
    }

    public function destroy($id)
    {
        $shippingCharge = ShippingCharge::find($id);

        if (!$shippingCharge) {
            return response()->json(['message' => 'Shipping Charge not found'], 404);
        }

        $shippingCharge->delete();

        return response()->json(['message' => 'Shipping Charge deleted successfully'], 200);
    }

    public function changeStatus(Request $request, $id)
    {
        $shippingCharge = ShippingCharge::find($id);
        if (!$shippingCharge) {
            return response()->json(['message' => 'Shipping Charge not found'], 404);
        }
        $shippingCharge->status = $request->status;
        $shippingCharge->save();
        $shippingChargeHtml = view('admin.shipping_charges.partials.shipping_charge_row', compact('shippingCharge'))->render();

        return response($shippingChargeHtml, 200);
    }
}

