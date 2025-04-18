<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        // Ambil semua order dengan relasi ke produk
        $orders = Order::with('product')->orderBy('id', 'asc')->get();
        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        // Ambil semua produk untuk dropdown di form pembuatan order
        $products = Product::all();
        return view('orders.create', compact('products'));
    }

    public function store(Request $request)
    {
        // Validasi input dasar
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'product_name' => 'required|string|max:255',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|integer|min:1',
        ]);

        // Ambil data produk berdasarkan product_id
        $product = Product::findOrFail($request->product_id);

        // Hitung harga dan profit
        $price = $request->price ?? $product->price;
        $capital = $product->total_capital;
        $quantity = $request->quantity;

        $total_price = $price * $quantity;
        $total_capital = $capital * $quantity;
        $profit = $total_price - $total_capital;

        // Debug log untuk memastikan data
        \Log::info('Creating order with data:', [
            'customer_name' => $request->customer_name,
            'product_name' => $request->product_name,
            'product_id' => $request->product_id,
            'quantity' => $quantity,
            'price' =>  $request->$price,
            'capital' => $capital,
            'total_price' => $total_price,
            'total_capital' => $total_capital,
            'profit' => $profit,
        ]);

        // Simpan ke database
        Order::create([
            'customer_name' => $request->customer_name,
            'product_name' => $request->product_name,
            'product_id' => $request->product_id,
            'quantity' => $quantity,
            'price' => $price,
            'total_price' => $total_price,
            'profit' => $profit,
        ]);

        return redirect()->route('orders.index')->with('success', 'Order created successfully!');
    }

    public function edit($id)
    {
        $order = Order::findOrFail($id);
        $products = Product::all();
        return view('orders.edit', compact('order', 'products'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'product_name' => 'required|string|max:255',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);

        $price = $request->price ?? $product->price;
        $capital = $product->total_capital;
        $quantity = $request->quantity;

        $total_price = $price * $quantity;
        $total_capital = $capital * $quantity;
        $profit = $total_price - $total_capital;

        $order = Order::findOrFail($id);
        $order->update([
            'customer_name' => $request->customer_name,
            'product_name' => $request->product_name,
            'product_id' => $request->product_id,
            'quantity' => $quantity,
            'price' => $price,
            'total_price' => $total_price,
            'profit' => $profit,
        ]);

        return redirect()->route('orders.index')->with('success', 'Order updated successfully!');
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return redirect()->route('orders.index')->with('success', 'Order deleted successfully!');
    }
}
