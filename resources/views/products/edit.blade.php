@extends('layouts.global')

@section('title') Edit Product @endsection 

@section('content')
<div class="col-md-8">
  <form 
    class="bg-white shadow-sm p-3" 
    action="{{ route('products.update', $product->id) }}" 
    method="POST">
    @csrf
    @method('PUT')

    <label>Product type</label>
    <input type="text" class="form-control" name="type" value="{{ old('type', $product->type) }}">
    <br>

    @foreach (['print', 'production', 'packaging', 'design_service', 'packaging_service', 'production_service'] as $field)
      <label>{{ ucwords(str_replace('_', ' ', $field)) }}</label>
      <input type="number" step="0.01" class="form-control" name="{{ $field }}" value="{{ old($field, $product->$field) }}">
      <br>
    @endforeach

    <label>Total Capital</label>
    <input type="number" class="form-control" name="total_capital" id="total_capital" value="{{ $product->total_capital }}" readonly>
    <br>

    <input type="submit" class="btn btn-primary" value="Update">
  </form>

  <script>
    function calculateTotal() {
      const fields = ['print', 'production', 'packaging', 'design_service', 'packaging_service', 'production_service'];
      let total = 0;
      fields.forEach(field => {
        let val = parseFloat(document.querySelector(`[name="${field}"]`).value) || 0;
        total += val;
      });
      document.getElementById('total_capital').value = total.toFixed(2);
    }

    document.addEventListener('DOMContentLoaded', function () {
      document.querySelectorAll('input[type="number"]').forEach(input => {
        input.addEventListener('input', calculateTotal);
      });
      calculateTotal();
    });
  </script>
</div>
@endsection
