@extends('layouts.global')

@section('title', 'Dashboard')
@section('pageTitle', 'Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="bg-light p-3 rounded shadow-sm">
                <h6>Orders Today</h6>
                <h3>{{ $ordersToday }}</h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="bg-light p-3 rounded shadow-sm">
                <h6>Orders This Week</h6>
                <h3>{{ $ordersThisWeek }}</h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="bg-light p-3 rounded shadow-sm">
                <h6>Orders This Month</h6>
                <h3>{{ $ordersThisMonth }}</h3>
            </div>
        </div>
    </div>

    {{-- Profit Section --}}
    <div class="bg-white p-4 rounded shadow-sm">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">Profit ({{ $start->format('d M') }} - {{ $end->format('d M Y') }})</h5>
            <form method="GET" action="{{ route('dashboard') }}" class="form-inline">
                <input type="date" name="week" value="{{ $filterDate }}" class="form-control mr-2">
                <button type="submit" class="btn btn-primary btn-sm">Filter</button>
            </form>
        </div>
        <table class="table table-bordered">
            <thead class="thead-light">
                <tr>
                    <th>Date</th>
                    <th>Total Profit</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($profits as $profit)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($profit->date)->format('D, d M Y') }}</td>
                        <td>Rp {{ number_format($profit->total_profit, 2) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="text-center">No data found for this week.</td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr style="background-color: #f8f9fa;">
                    <th style="font-size: 1.1rem;">Total Weekly Profit</th>
                    <th style="font-size: 1.2rem; font-weight: bold; color: #28a745;">
                        Rp {{ number_format($totalWeeklyProfit, 2) }}
                    </th>
                </tr>
            </tfoot>
        </table>
    </div>

    {{-- Service Fee Section --}}
    <div class="bg-white p-4 rounded shadow-sm mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">Service Fee ({{ $start->format('d M') }} - {{ $end->format('d M Y') }})</h5>
        </div>
        <table class="table table-bordered">
            <thead class="thead-light">
                <tr>
                    <th>Date</th>
                    <th>Total Service Fee</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($serviceFees as $fee)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($fee->date)->format('D, d M Y') }}</td>
                        <td>Rp {{ number_format($fee->total_service_fee, 2) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="text-center">No data found for this week.</td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr style="background-color: #f8f9fa;">
                    <th style="font-size: 1.1rem;">Total Weekly Service Fee</th>
                    <th style="font-size: 1.2rem; font-weight: bold; color: #007bff;">
                        Rp {{ number_format($totalWeeklyServiceFee, 2) }}
                    </th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
@endsection
