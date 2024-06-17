<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.products.index', [
            'products' => Product::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required',
            'description' => 'nullable',
            'price' => 'nullable',
            'is_show' => 'required',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $validate['is_show'] = $validate['is_show'] == 'true' ? 1 : 0;

        if ($request->hasFile('image')) {
            $image_path = $request->file('image')->store('product', 'public');
            $validate['image'] = $image_path;
        }

        Product::create($validate);

        return redirect()->back()->with('success', 'Product created successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validate = $request->validate([
            'name' => 'required',
            'description' => 'nullable',
            'price' => 'nullable',
            'is_show' => 'required',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $validate['is_show'] = $validate['is_show'] == 'true' ? 1 : 0;

        if ($request->hasFile('image')) {
            $image_path = $request->file('image')->store('product', 'public');
            $validate['image'] = $image_path;
        }

        $product->update($validate);

        return redirect()->back()->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
