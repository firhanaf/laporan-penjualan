<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
class ProductController extends Controller
{
    public function index()
{
    $products = Product::orderBy('id', 'asc')->get();
    return view('products.index', compact('products'));
}
    public function create()
    {
        return view('products.create');
    }

    // Simpan data product ke database
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type'                => 'required|string|max:255',
            'print'               => 'nullable|numeric',
            'production'          => 'nullable|numeric',
            'packaging'           => 'nullable|numeric',
            'design_service'      => 'nullable|numeric',
            'packaging_service'   => 'nullable|numeric',
            'production_service'  => 'nullable|numeric',
        ]);

        $totalCapital = 
        ($validated['print'] ?? 0) +
        ($validated['production'] ?? 0) +
        ($validated['packaging'] ?? 0) +
        ($validated['design_service'] ?? 0) +
        ($validated['packaging_service'] ?? 0) +
        ($validated['production_service'] ?? 0);

    // Tambahkan ke array validasi
    $validated['total_capital'] = $totalCapital;

        Product::create($validated);

        return redirect()->route('products.index')->with('success', 'Product created successfully!');
    }

    public function edit($id)
{
    $product = Product::findOrFail($id);
    return view('products.edit', compact('product'));
}

public function update(Request $request, $id)
{
    $validated = $request->validate([
        'type' => 'required|string|max:255',
        'print' => 'nullable|numeric',
        'production' => 'nullable|numeric',
        'packaging' => 'nullable|numeric',
        'design_service' => 'nullable|numeric',
        'packaging_service' => 'nullable|numeric',
        'production_service' => 'nullable|numeric',
    ]);

    $validated['total_capital'] =
        ($validated['print'] ?? 0) +
        ($validated['production'] ?? 0) +
        ($validated['packaging'] ?? 0) +
        ($validated['design_service'] ?? 0) +
        ($validated['packaging_service'] ?? 0) +
        ($validated['production_service'] ?? 0);

    Product::findOrFail($id)->update($validated);

    return redirect()->route('products.index')->with('success', 'Product updated successfully!');
}

public function destroy($id)
{
    Product::findOrFail($id)->delete(); // soft delete
    return redirect()->route('products.index')->with('success', 'Product deleted successfully!');
}
}
