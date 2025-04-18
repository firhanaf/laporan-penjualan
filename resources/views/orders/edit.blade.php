@extends('layouts.global')

@section('title') Order Management @endsection
@section('pageTitle') Order Management @endsection

@section('content')
<div class="container-fluid">
    <div class="bg-light shadow-sm p-4 rounded">
        <h5 class="mb-3">Edit Order</h5>

        <form action="{{ route('orders.update', $order->id) }}" method="POST" id="order-form">
            @csrf
            @method('PUT')

            <!-- Customer Name -->
            <div class="form-group">
                <label for="customer_name">Customer name</label>
                <input type="text" name="customer_name" id="customer_name" class="form-control" value="{{ $order->customer_name }}" required>
            </div>

            <!-- Product Name -->
            <div class="form-group">
                <label for="product_name">Product name</label>
                <input type="text" name="product_name" id="product_name" class="form-control" value="{{ $order->product_name }}" required>
            </div>

            <!-- Product Dropdown -->
            <div class="form-group">
                <label for="product_id">Product type</label>
                <select name="product_id" id="product_id" class="form-control" required>
                    <option value="">Select Product</option>
                    @foreach ($products as $product)
                        <option 
                            value="{{ $product->id }}"
                            data-capital="{{ $product->total_capital }}"
                            data-name="{{ $product->type }}"
                            {{ $product->id == $order->product_id ? 'selected' : '' }}
                        >
                            {{ $product->type }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Price -->
            <div class="form-group">
                <label for="price">Price</label>
                <input type="number" name="price" id="price" class="form-control" value="{{ $order->price }}" required min="1">
            </div>

            <!-- Capital -->
            <div class="form-group">
                <label for="capital">Capital</label>
                <input type="number" name="capital" id="capital" class="form-control" value="{{ $order->product->total_capital ?? '' }}" required min="1" readonly>
            </div>

            <!-- Quantity -->
            <div class="form-group">
                <label for="quantity">Quantity</label>
                <input type="number" name="quantity" id="quantity" class="form-control" value="{{ $order->quantity }}" required min="1">
            </div>

            <!-- Total Price -->
            <div class="form-group">
                <label for="total_price">Total price</label>
                <input type="number" name="total_price" id="total_price" class="form-control" value="{{ $order->total_price }}" readonly>
            </div>

            <!-- Total Capital -->
            <div class="form-group">
                <label for="total_capital">Total capital</label>
                <input type="number" name="total_capital" id="total_capital" class="form-control" value="{{ $order->product->total_capital * $order->quantity }}" readonly>
            </div>

            <!-- Profit -->
            <div class="form-group">
                <label for="profit">Profit</label>
                <input type="number" name="profit" id="profit" class="form-control" value="{{ $order->profit }}" readonly>
            </div>

            <button type="submit" class="btn btn-primary">Update Order</button>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const productDropdown = document.getElementById('product_id');
        const capitalInput = document.getElementById('capital');
        const productNameInput = document.getElementById('product_name');
        const priceInput = document.getElementById('price');
        const quantityInput = document.getElementById('quantity');
        const totalPriceInput = document.getElementById('total_price');
        const totalCapitalInput = document.getElementById('total_capital');
        const profitInput = document.getElementById('profit');

        function calculateValues() {
            const price = parseFloat(priceInput.value) || 0;
            const capital = parseFloat(capitalInput.value) || 0;
            const quantity = parseInt(quantityInput.value) || 0;

            const totalPrice = price * quantity;
            const totalCapital = capital * quantity;
            const profit = totalPrice - totalCapital;

            totalPriceInput.value = totalPrice.toFixed(2);
            totalCapitalInput.value = totalCapital.toFixed(2);
            profitInput.value = profit.toFixed(2);
        }

        productDropdown.addEventListener('change', function () {
            const selectedOption = this.options[this.selectedIndex];
            const capital = selectedOption.getAttribute('data-capital');
            const productName = selectedOption.getAttribute('data-name');

            if (capital) {
                capitalInput.value = capital;
            } else {
                capitalInput.value = '';
                productNameInput.value = '';
            }

            calculateValues();
        });

        priceInput.addEventListener('input', calculateValues);
        quantityInput.addEventListener('input', calculateValues);

        // Jalankan kalkulasi awal saat halaman dimuat
        calculateValues();
    });
</script>
@endsection