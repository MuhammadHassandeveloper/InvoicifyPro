<?php

namespace App\Http\Controllers;

use App\Helpers\AppHelper;
use App\Models\Category;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $data = [];
        $data['title'] = 'Categories';
        $data['categories'] = Category::all();
        return view('admin.categories.index', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        $request->merge(['user_id' => Sentinel::getUser()->id]);
        $category = Category::create($request->all());
        $categoryHtml = view('admin.categories.partials.category_row', compact('category'))->render();
        AppHelper::storeActivity(Sentinel::getUser()->id,'Create Category',$request->all());

        return response($categoryHtml, 200);
    }

    public function show($id)
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }
        return response()->json($category, 200);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $category = Category::find($id);
        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }
        $request->merge(['user_id' => Sentinel::getUser()->id]);
        $category->update($request->all());
        $categoryHtml = view('admin.categories.partials.category_row', compact('category'))->render();
        AppHelper::storeActivity(Sentinel::getUser()->id,'Update Category',$request->all());
        return response($categoryHtml, 200);
    }

    public function destroy($id)
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }
        $category->delete();
        return response()->json(['message' => 'Category deleted successfully'], 200);
    }

    public function changeStatus(Request $request, $id)
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json(['message' => 'category not found'], 404);
        }
        $category->status = $request->status;
        $category->save();
        $categoryHtml = view('admin.categories.partials.category_row', compact('category'))->render();
        return response($categoryHtml, 200);
    }
}
