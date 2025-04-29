@extends('layouts.global')

@section('title') Dashboard @endsection
@section('pageTitle') Dashboard Overview @endsection

@section('content')
<div class="container-fluid">
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card text-white bg-primary shadow-sm">
                <div class="card-body">
                    <h6 class="card-title">Orders Today</h6>
                    <h3>{{ $ordersToday }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-success shadow-sm">
                <div class="card-body">
                    <h6 class="card-title">Orders This Week</h6>
                    <h3>{{ $ordersThisWeek }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-info shadow-sm">
                <div class="card-body">
                    <h6 class="card-title">Orders This Month</h6>
                    <h3>{{ $ordersThisMonth }}</h3>
                </div>
            </div>
        </div>
    </div>

    {{-- Filter minggu --}}
    <form method="GET" class="mb-3">
    <div class="row g-2">
        <div class="col-md-4">
            <input type="date" name="week" class="form-control" value="{{ request('week') }}">
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary">Filter</button> {{-- ubah di sini --}}
        </div>
    </div>
</form>

    {{-- Tabel Profit Mingguan --}}
    <div class="card mb-4">
        <div class="card-header bg-secondary text-black">
            Profit per Day ({{ $start->format('d M') }} - {{ $end->format('d M Y') }})
        </div>
        <div class="card-body p-0">
            <table class="table table-bordered mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Date</th>
                        <th>Total Profit</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($profits as $profit)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($profit->date)->format('d-m-Y') }}</td>
                            <td>Rp{{ number_format($profit->total_profit, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="text-center text-muted">No data available</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            <strong>Total Weekly Profit:</strong> Rp{{ number_format($totalWeeklyProfit, 2) }}
        </div>
    </div>

    {{-- Tabel Total Price Mingguan --}}
    <div class="card mb-4">
        <div class="card-header bg-secondary text-black">
            Total Price per Day ({{ $start->format('d M') }} - {{ $end->format('d M Y') }})
        </div>
        <div class="card-body p-0">
            <table class="table table-bordered mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Date</th>
                        <th>Total Price</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($totalPrices as $price)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($price->date)->format('d-m-Y') }}</td>
                            <td>Rp{{ number_format($price->total_price, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="text-center text-muted">No data available</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            <strong>Total Weekly Price:</strong> Rp{{ number_format($totalWeeklyPrice, 2) }}
        </div>
    </div>

    {{-- Tabel Service Fee --}}
    <div class="card mb-4">
        <div class="card-header bg-secondary text-black">
            Service Fee per Day ({{ $start->format('d M') }} - {{ $end->format('d M Y') }})
        </div>
        <div class="card-body p-0">
            <table class="table table-bordered mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Date</th>
                        <th>Total Service Fee</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($serviceFees as $fee)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($fee->date)->format('d-m-Y') }}</td>
                            <td>Rp{{ number_format($fee->total_service_fee, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="text-center text-muted">No data available</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            <strong>Total Weekly Service Fee:</strong> Rp{{ number_format($totalWeeklyServiceFee, 2) }}
        </div>
    </div>
</div>
@endsection
