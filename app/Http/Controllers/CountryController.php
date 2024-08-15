<?php

namespace App\Http\Controllers;

use App\Helpers\AppHelper;
use App\Models\Country;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function index()
    {
        $data = array();
        $data['title'] = 'Countries';
        $data['countries'] = Country::all();
        return view('admin.countries.index', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:countries,name',
            'iso_code' => 'required|string|max:10|unique:countries,iso_code',
            'currency_sign' => 'required|string|max:10',
            'currency_code' => 'required|string|max:10|unique:countries,currency_code',
        ]);


        $country = Country::create($request->all());
        $countryHtml = view('admin.countries.partials.country_row', compact('country'))->render();
        AppHelper::storeActivity(Sentinel::getUser()->id,'Create Country',$request->all());

        return response($countryHtml, 200);
    }

    public function show($id)
    {
        $country = Country::find($id);

        if (!$country) {
            return response()->json(['message' => 'Country not found'], 404);
        }

        return response()->json($country, 200);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'iso_code' => 'required|string|max:10',
            'currency_sign' => 'required|string|max:10',
            'currency_code' => 'required|string|max:10',
        ]);

        $country = Country::find($id);

        if (!$country) {
            return response()->json(['message' => 'Country not found'], 404);
        }

        $country->update($request->all());

        $countryHtml = view('admin.countries.partials.country_row', compact('country'))->render();
        AppHelper::storeActivity(Sentinel::getUser()->id,'Create Country',$request->all());

        return response($countryHtml, 200);
    }

    public function destroy($id)
    {
        $country = Country::find($id);

        if (!$country) {
            return response()->json(['message' => 'Country not found'], 404);
        }

        $country->delete();

        return response()->json(['message' => 'Country deleted successfully'], 200);
    }

    public function changeStatus(Request $request, $id)
    {
        $country = Country::find($id);

        if (!$country) {
            return response()->json(['message' => 'Country not found'], 404);
        }
        $country->status = $request->status;
        $country->save();
        $countryHtml = view('admin.countries.partials.country_row', compact('country'))->render();
        return response($countryHtml, 200);
    }
}
