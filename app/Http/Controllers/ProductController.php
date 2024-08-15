<?php

namespace App\Http\Controllers;

use App\Helpers\AppHelper;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $data = [];
        $data['title'] = 'All Products';
        $data['products'] = Product::where('available_stock','>',0)->latest()->get();

        // Add counts for different product conditions
        $data['outOfStockCount'] = Product::countOutOfStock();
        $data['lowStockCount'] = Product::countLowStock();
        $data['activeCount'] = Product::countActive();
        $data['disabledCount'] = Product::countDisabled();

        return view('admin.products.index', $data);
    }

    public function active()
    {
        $data = [];
        $data['title'] = 'Active Products';
        $data['products'] = Product::where('available_stock','>',0)->where('status',1)->get();
        return view('admin.products.active', $data);
    }

    public function disabled()
    {
        $data = [];
        $data['title'] = 'Disabled Products';
        $data['products'] = Product::where('status',0)->where('available_stock', '>', 0)->get();
        return view('admin.products.disabled', $data);
    }

    public function low_stock()
    {
        $data = [];
        $data['title'] = 'Low Stock Products';
        $data['products'] = Product::where('available_stock', '>', 0)
            ->where('available_stock', '<=', 15)
            ->orderBy('available_stock', 'asc')
            ->get();
        return view('admin.products.low_stock', $data);
    }

    public function out_of_stock()
    {
        $data = [];
        $data['title'] = 'Out Of Stock Products';
        $data['products'] = Product::where('available_stock',0)->latest()->get();
        return view('admin.products.out_of_stock', $data);
    }

    public function create()
    {
        $data = [];
        $data['title'] = 'Create Product';
        $data['categories'] = Category::all();
        $data['brands'] = Brand::all();
        return view('admin.products.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required|string|unique:products,name|max:40',
            'brand' => 'required|exists:brands,id',
            'category' => 'required|exists:categories,id',
            'price' => 'required|',
            'available_stock' => 'required|',
            'product_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp',
            'product_description' => 'required|string|min:50|max:190',
        ]);

        $image = null;
        if ($request->hasFile('product_image')) {
            $file = $request->file('product_image');
            $extension = $file->getClientOriginalExtension();
            $filename = rand(0, 9999) . time() . '.' . $extension;
            $file->move(public_path('products'), $filename);
            $image = 'products/' . $filename;
        }

        $product = new Product();
        $product->name = $request->product_name;
        $product->brand_id = $request->brand;
        $product->category_id = $request->category;
        $product->price = $request->price;
        $product->available_stock = $request->available_stock;
        $product->image = $image;
        $product->description = $request->product_description;
        $product->user_id = Sentinel::getUser()->id;
        $product->save();
        AppHelper::storeActivity(Sentinel::getUser()->id,'Create Product',$request->all());

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
    }

    public function show($id)
    {
        $product = Product::with('brand', 'category')->findOrFail($id);
        return response()->json($product);
    }

    public function edit($id)
    {
        $data = [];
        $data['title'] = 'Edit Product';
        $data['product'] = Product::findOrFail($id);
        $data['categories'] = Category::all();
        $data['brands'] = Brand::all();
        return view('admin.products.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'product_name' => 'required|string|max:40',
            'brand' => 'required|exists:brands,id',
            'category' => 'required|exists:categories,id',
            'price' => 'required|',
            'available_stock' => 'required|',
            'product_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp',
            'product_description' => 'required|string|min:50|max:190|'
        ]);

        $product = Product::findOrFail($id);

        if ($request->hasFile('product_image')) {
            // Handle file upload
            $file = $request->file('product_image');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('products'), $filename);
            $product->image = 'products/' . $filename; // Store the relative path
        }

        $product->update([
            'name' => $request->product_name,
            'brand_id' => $request->brand,
            'category_id' => $request->category,
            'price' => $request->price,
            'available_stock' => $request->available_stock,
            'description' => $request->product_description,
             'user_id' => Sentinel::getUser()->id
        ]);

        if ($request->hasFile('product_image')) {
            $product->image = asset('products/' . $filename);
        }
        AppHelper::storeActivity(Sentinel::getUser()->id,'Update Product',$request->all());
        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }


    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        Storage::disk('public')->delete('products/'.$product->image);
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
    }

    public function changeStatus(Request $request, $id)
    {
        $product = Product::find($id);
        if($product) {
            if($product->status == 0) {
                $product->status = 1;
            } else {
                $product->status = 0;
            }
            $product->save();
        } else {
            return redirect()->route('admin.products.index')->with('error', 'Product status not update.');
        }
        return redirect()->route('admin.products.index')->with('success', 'Product status successfully updated.');
    }

    public function updateStock(Request $request){
        $product = Product::find($request->id);
        if($product) {
            $product->available_stock = $request->available_stock;
            $product->save();
        } else {
            return redirect()->back()->with('error', 'Product status not update.');
        }
        return redirect()->back()->with('success', 'Product stock successfully updated.');
    }

}

