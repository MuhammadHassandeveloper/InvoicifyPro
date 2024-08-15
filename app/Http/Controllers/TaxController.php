<?php
namespace App\Http\Controllers;

use App\Helpers\AppHelper;
use App\Models\Tax;
use App\Models\Country;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;

class TaxController extends Controller
{
    public function index()
    {
        $data = [];
        $data['title'] = 'Taxes';
        $data['taxes'] = Tax::with('country')->get();
        $data['countries'] = Country::where('status',1)->get();
        return view('admin.taxes.index', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'country_id' => 'required|exists:countries,id',
            'name' => 'required|string|max:255',
            'percentage' => 'required|numeric|min:0|max:100',
        ]);

        $request->merge(['user_id' => Sentinel::getUser()->id]);
        $tax = Tax::create($request->all());

        AppHelper::storeActivity(Sentinel::getUser()->id,'create tax',$request->all());

        $taxHtml = view('admin.taxes.partials.tax_row', compact('tax'))->render();
        AppHelper::storeActivity(Sentinel::getUser()->id,'Create Shipping Charge',$request->all());
        return response($taxHtml, 200);
    }

    public function show($id)
    {
        $tax = Tax::with('country')->find($id);

        if (!$tax) {
            return response()->json(['message' => 'Tax not found'], 404);
        }

        return response()->json($tax, 200);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'country_id' => 'required|exists:countries,id',
            'name' => 'required|string|max:255',
            'percentage' => 'required|numeric|min:0|max:100',
        ]);

        $tax = Tax::find($id);

        if (!$tax) {
            return response()->json(['message' => 'Tax not found'], 404);
        }

        $request->merge(['user_id' => Sentinel::getUser()->id]);
        $tax->update($request->all());
        AppHelper::storeActivity(Sentinel::getUser()->id,'update tax',$request->all());

        $taxHtml = view('admin.taxes.partials.tax_row', compact('tax'))->render();

        return response($taxHtml, 200);
    }

    public function destroy($id)
    {
        $tax = Tax::find($id);
        if (!$tax) {
            return response()->json(['message' => 'Tax not found'], 404);
        }
        $tax->delete();
        return response()->json(['message' => 'Tax deleted successfully'], 200);
    }

    public function changeStatus(Request $request, $id)
    {
        $tax = Tax::find($id);
        if (!$tax) {
            return response()->json(['message' => 'Tax not found'], 404);
        }
        $tax->status = $request->status;
        $tax->save();
        $taxHtml = view('admin.taxes.partials.tax_row', compact('tax'))->render();
        return response($taxHtml, 200);
    }
}
