@extends('layouts.global')

@section('title') Product List @endsection
@section('pageTitle') Product Management @endsection

@section('content')
<div class="container-fluid">
    <div class="bg-light shadow-sm p-4 rounded">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">Products List</h5>
            <a href="{{ route('products.create') }}" class="btn btn-primary">+ Create Product</a>
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
                        <th>Type</th>
                        <th>Print</th>
                        <th>Production</th>
                        <th>Packaging</th>
                        <th>Design Service</th>
                        <th>Packaging Service</th>
                        <th>Production Service</th>
                        <th>Total Capital</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td>{{ $product->type }}</td>
                            <td>{{ $product->print }}</td>
                            <td>{{ $product->production }}</td>
                            <td>{{ $product->packaging }}</td>
                            <td>{{ $product->design_service }}</td>
                            <td>{{ $product->packaging_service }}</td>
                            <td>{{ $product->production_service }}</td>
                            <td>{{ number_format($product->total_capital, 2) }}</td>
                            <td>
                                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-warning">Edit</a>

                                <form 
                                    action="{{ route('products.destroy', $product->id) }}" 
                                    method="POST" 
                                    style="display:inline" 
                                    onsubmit="return confirm('Are you sure you want to delete this product?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center">No products found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
