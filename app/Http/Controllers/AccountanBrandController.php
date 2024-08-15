<?php

namespace App\Http\Controllers;

use App\Helpers\AppHelper;
use App\Models\Brand;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;

class AccountanBrandController extends Controller
{
    public function index()
    {
        $data = [];
        $data['title'] = 'Brands';
        $user_id = Sentinel::getUser()->id;
        $data['brands'] = Brand::where('user_id',$user_id)->get();
        return view('accountant.brands.index', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:brands,name',
        ]);

        $request->merge(['user_id' => Sentinel::getUser()->id]);
        $brand = Brand::create($request->all());
        $brandHtml = view('accountant.brands.partials.brand_row', compact('brand'))->render();
        AppHelper::storeActivity(Sentinel::getUser()->id,'Create Brand',$request->all());

        return response($brandHtml, 200);
    }

    public function show($id)
    {
        $brand = Brand::find($id);

        if (!$brand) {
            return response()->json(['message' => 'Brand not found'], 404);
        }

        return response()->json($brand, 200);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $brand = Brand::find($id);

        if (!$brand) {
            return response()->json(['message' => 'Brand not found'], 404);
        }
        $request->merge(['user_id' => Sentinel::getUser()->id]);
        $brand->update($request->all());
        AppHelper::storeActivity(Sentinel::getUser()->id,'Updated Brand',$request->all());

        $brandHtml = view('accountant.brands.partials.brand_row', compact('brand'))->render();

        return response($brandHtml, 200);
    }

    public function destroy($id)
    {
        $brand = Brand::find($id);

        if (!$brand) {
            return response()->json(['message' => 'Brand not found'], 404);
        }

        $brand->delete();

        return response()->json(['message' => 'Brand deleted successfully'], 200);
    }

    public function changeStatus(Request $request, $id)
    {
        $brand = Brand::find($id);

        if (!$brand) {
            return response()->json(['message' => 'Brand not found'], 404);
        }

        $brand->status = $request->status;
        $brand->save();
        $brandHtml = view('accountant.brands.partials.brand_row', compact('brand'))->render();

        return response($brandHtml, 200);
    }
}
