<?php
namespace App\Http\Controllers;

use App\Helpers\AppHelper;
use App\Models\Discount;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    public function index()
    {
        $data = [];
        $data['title'] = 'Discounts';
        $data['discounts'] = Discount::all();
        return view('admin.discounts.index', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'percentage' => 'required|numeric|min:0|max:100',
        ]);

        $request->merge(['user_id' => Sentinel::getUser()->id]);
        $discount = Discount::create($request->all());

        $discountHtml = view('admin.discounts.partials.discount_row', compact('discount'))->render();
        AppHelper::storeActivity(Sentinel::getUser()->id,'Create Discount',$request->all());

        return response($discountHtml, 200);
    }

    public function show($id)
    {
        $discount = Discount::find($id);

        if (!$discount) {
            return response()->json(['message' => 'Discount not found'], 404);
        }

        return response()->json($discount, 200);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'percentage' => 'required|numeric|min:0|max:100',
        ]);

        $discount = Discount::find($id);

        if (!$discount) {
            return response()->json(['message' => 'Discount not found'], 404);
        }

        $request->merge(['user_id' => Sentinel::getUser()->id]);
        $discount->update($request->all());
        AppHelper::storeActivity(Sentinel::getUser()->id,'Update Discount',$request->all());

        $discountHtml = view('admin.discounts.partials.discount_row', compact('discount'))->render();

        return response($discountHtml, 200);
    }

    public function destroy($id)
    {
        $discount = Discount::find($id);

        if (!$discount) {
            return response()->json(['message' => 'Discount not found'], 404);
        }

        $discount->delete();

        return response()->json(['message' => 'Discount deleted successfully'], 200);
    }

    public function changeStatus(Request $request, $id)
    {
        $discount = Discount::find($id);
        if (!$discount) {
            return response()->json(['message' => 'discount not found'], 404);
        }
        $discount->status = $request->status;
        $discount->save();
        $discountHtml = view('admin.discounts.partials.discount_row', compact('discount'))->render();
        return response($discountHtml, 200);
    }
}
