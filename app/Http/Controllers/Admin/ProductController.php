<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category', 'brand', 'product_images')->get();

        return Inertia::render('Admin/Product/Index', [
            'products' => $products,
            'brands' => DB::table('brands')->select('id', 'name')->get(),
            'categories' => DB::table('categories')->select('id', 'name')->get(),
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Product/Create');
    }

    public function store(Request $request)
    {
        $product = new Product();
        $product->title         = $request->title;
        $product->price         = $request->price;
        $product->quantity      = $request->quantity;
        $product->description   = $request->description;
        $product->category_id   = $request->category_id;
        $product->brand_id      = $request->brand_id;
        $product->created_by      = Auth::id();

        $product->save();

        if ($request->hasFile('product_images')) {
            foreach ($request->file('product_images') as $image) {
                $uniqueName = time() . '-' . Str::random(10) . '.' . $image->getClientOriginalExtension();

                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $image->storeAs('product_images', $uniqueName, 'public')
                ]);
            }
        }
        return redirect()->route('admin.products.index')->with('success', 'Product Created Successfully');
    }

    public function update(Request $request, $id)
    {
        // update the product using patch method
        // dd($request->all());
        $product = Product::findOrFail($id);
        $product->title         = $request->title;
        $product->price         = $request->price;
        $product->quantity      = $request->quantity;
        $product->description   = $request->description;
        $product->category_id   = $request->category_id;
        $product->brand_id      = $request->brand_id;
        $product->updated_by      = Auth::id();


        if ($request->hasFile('product_images')) {
            foreach ($request->file('product_images') as $image) {
                $uniqueName = time() . '-' . Str::random(10) . '.' . $image->getClientOriginalExtension();
                // $image->move('product_images', $uniqueName);

                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $image->storeAs('product_images', $uniqueName, 'public')
                ]);
            }
        }
        $product->update();

        return redirect()->back()->with('success', 'Product Updated Successfully');
    }

    public function destroy($id)
    {
        //soft delete the product
        $product = Product::findOrFail($id);
        $product->delete();
    }


    public function deleteImage($id)
    {
        $image = ProductImage::findOrFail($id);
        if(file_exists(public_path($image->image))){    
        unlink(public_path($image->image));
        }
        $image->delete();
    }
}
