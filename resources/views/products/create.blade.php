@extends('layouts.global')

@section('title') Create Product @endsection 

@section('content')

<div class="col-md-8">
  <form 
    class="bg-white shadow-sm p-3" 
    action="{{ route('products.store') }}" 
    method="POST">
    @csrf

    <label>Product type</label>
    <input type="text" class="form-control" name="type"/>
    <br>

    <label>Print Fee</label>
    <input type="number" class="form-control" name="print"/>
    <br>

    <label>Production Fee/Additional</label>
    <input type="number" class="form-control" name="production"/>
    <br>

    <label>Packaging Fee</label>
    <input type="number" class="form-control" name="packaging"/>
    <br>

    <label>Design Service</label>
    <input type="number" class="form-control" name="design_service"/>
    <br>

    <label>Packaging Service</label>
    <input type="number" class="form-control" name="packaging_service"/>
    <br>

    <label>Production Service</label>
    <input type="number" class="form-control" name="production_service"/>
    <br>

    <label>Total Capital</label><br>
<input 
  type="number" 
  class="form-control" 
  name="total_capital" 
  id="total_capital" 
  readonly/>
<br>

    <input type="submit" class="btn btn-primary" value="Save"/>
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

  // Pasang event listener ke semua input biaya
  document.addEventListener('DOMContentLoaded', function () {
    const inputs = document.querySelectorAll('input[type="number"]');
    inputs.forEach(input => {
      input.addEventListener('input', calculateTotal);
    });

    calculateTotal(); // kalkulasi awal saat load
  });
</script>

</div>

@endsection
