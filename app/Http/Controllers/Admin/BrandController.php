<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::orderBy('name', 'asc')->get();
        return inertia('Admin/Brand/Index', [
            'brands' => $brands
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        Brand::create([
            'name' => $request->name,
            'image' => $request->file('image') ? $request->file('image')->store('brands', 'public') : null,
        ]);

        return redirect()->route('admin.brands.index')->with('success', 'Brand Created Successfully');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $brand = Brand::findOrFail($id);
        $brand->update([
            'name' => $request->name,
            'image' => $request->file('image') ? $request->file('image')->store('brands', 'public') : null,
        ]);

        return redirect()->route('admin.brands.index')->with('success', 'Brand Updated Successfully');
    }

    public function destroy($id)
    {
        $brand = \App\Models\Brand::findOrFail($id);
        $brand->delete();
        if ($brand->image) {
            \Storage::disk('public')->delete($brand->image);
        }

        return redirect()->route('admin.brands.index')->with('success', 'Brand Deleted Successfully');
    }
}
