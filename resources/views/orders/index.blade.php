@extends('layouts.global')

@section('title') Order List @endsection
@section('pageTitle') Order Management @endsection

@section('content')
<div class="container-fluid">
    <div class="bg-light shadow-sm p-4 rounded">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">Order List</h5>
            <a href="{{ route('orders.create') }}" class="btn btn-primary">+ Create Order</a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
            <thead class="thead-light">
    <tr>
        <th>#</th>
        <th>Customer Name</th>
        <th>Product Name</th>
        <th>Quantity</th>
        <th>Total Price</th>
        <th>Profit</th>
        <th>Service Fee</th> {{-- Tambahan --}}
        <th>Date</th>
        <th>Action</th>
    </tr>
</thead>
<tbody>
    @foreach ($orders as $order)
        <tr>
            <td>{{ $order->id }}</td>
            <td>{{ $order->customer_name }}</td>
            <td>{{ $order->product_name }}</td>
            <td>{{ $order->quantity }}</td>
            <td>{{ number_format($order->total_price, 2) }}</td>
            <td>{{ number_format($order->profit, 2) }}</td>
            <td>
                @if ($order->product)
                    {{ number_format($order->product->service_fee * $order->quantity, 2) }}
                @else
                    N/A
                @endif
            </td>
            <td>{{ $order->created_at->format('d-m-Y') }}</td>
            <td>
                <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-sm btn-warning">Edit</a>
                <form 
                    action="{{ route('orders.destroy', $order->id) }}" 
                    method="POST" 
                    style="display:inline" 
                    onsubmit="return confirm('Are you sure you want to delete this order?')">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger">Delete</button>
                </form>
            </td>
        </tr>
    @endforeach
</tbody>
            </table>
            <div class="d-flex justify-content-center mt-3">
            {{ $orders->withQueryString()->links() }}
</div>
        </div>
    </div>
</div>
@endsection
