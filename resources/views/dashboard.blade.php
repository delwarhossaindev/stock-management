@extends('layouts.app')

@section('title', __('Dashboard') . ' - ' . __('Stock Management'))

@section('content')
<h4 class="mb-4">{{ __('Dashboard') }}</h4>

<div class="row g-3 mb-4">
    <div class="col-md-4 col-sm-6">
        <div class="card stat-card blue p-3">
            <i class="bi bi-box-seam stat-icon"></i>
            <div class="text-muted small">{{ __('Total Products') }}</div>
            <div class="fs-4 fw-bold">{{ $totalProducts }}</div>
        </div>
    </div>
    <div class="col-md-4 col-sm-6">
        <div class="card stat-card green p-3">
            <i class="bi bi-tags stat-icon"></i>
            <div class="text-muted small">{{ __('Categories') }}</div>
            <div class="fs-4 fw-bold">{{ $totalCategories }}</div>
        </div>
    </div>
    <div class="col-md-4 col-sm-6">
        <div class="card stat-card yellow p-3">
            <i class="bi bi-people stat-icon"></i>
            <div class="text-muted small">{{ __('Suppliers') }}</div>
            <div class="fs-4 fw-bold">{{ $totalSuppliers }}</div>
        </div>
    </div>
    <div class="col-md-4 col-sm-6">
        <div class="card stat-card blue p-3">
            <i class="bi bi-cart-plus stat-icon"></i>
            <div class="text-muted small">{{ __('Total Purchases') }}</div>
            <div class="fs-4 fw-bold">৳{{ number_format($totalPurchases, 2) }}</div>
        </div>
    </div>
    <div class="col-md-4 col-sm-6">
        <div class="card stat-card green p-3">
            <i class="bi bi-cart-check stat-icon"></i>
            <div class="text-muted small">{{ __('Total Sales') }}</div>
            <div class="fs-4 fw-bold">৳{{ number_format($totalSales, 2) }}</div>
        </div>
    </div>
    <div class="col-md-4 col-sm-6">
        <div class="card stat-card {{ $totalProfit >= 0 ? 'green' : 'red' }} p-3">
            <i class="bi bi-graph-up-arrow stat-icon"></i>
            <div class="text-muted small">{{ __('Profit/Loss') }}</div>
            <div class="fs-4 fw-bold">৳{{ number_format($totalProfit, 2) }}</div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header bg-danger text-white">
                <i class="bi bi-exclamation-triangle"></i> {{ __('Low Stock Alert') }} (≤5)
            </div>
            <div class="card-body p-0">
                <table class="table table-sm mb-0">
                    <thead><tr><th>{{ __('Product') }}</th><th>{{ __('Quantity') }}</th></tr></thead>
                    <tbody>
                        @forelse($lowStockProducts as $product)
                            <tr>
                                <td>{{ $product->name }}</td>
                                <td><span class="badge bg-danger">{{ $product->quantity }}</span></td>
                            </tr>
                        @empty
                            <tr><td colspan="2" class="text-center text-muted">{{ __('No low stock') }}</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <i class="bi bi-cart-plus"></i> {{ __('Recent Purchases') }}
            </div>
            <div class="card-body p-0">
                <table class="table table-sm mb-0">
                    <thead><tr><th>{{ __('Purchase No') }}</th><th>{{ __('Supplier') }}</th><th>{{ __('Total') }}</th></tr></thead>
                    <tbody>
                        @forelse($recentPurchases as $purchase)
                            <tr>
                                <td><a href="{{ route('purchases.show', $purchase) }}">{{ $purchase->purchase_no }}</a></td>
                                <td>{{ $purchase->supplier->name ?? '-' }}</td>
                                <td>৳{{ number_format($purchase->total_price, 2) }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="text-center text-muted">{{ __('No purchases') }}</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header bg-success text-white">
                <i class="bi bi-cart-check"></i> {{ __('Recent Sales') }}
            </div>
            <div class="card-body p-0">
                <table class="table table-sm mb-0">
                    <thead><tr><th>{{ __('Invoice No') }}</th><th>{{ __('Customer Name') }}</th><th>{{ __('Total') }}</th></tr></thead>
                    <tbody>
                        @forelse($recentSales as $sale)
                            <tr>
                                <td><a href="{{ route('sales.show', $sale) }}">{{ $sale->invoice_no }}</a></td>
                                <td>{{ $sale->customer_name ?? '-' }}</td>
                                <td>৳{{ number_format($sale->total_price, 2) }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="text-center text-muted">{{ __('No sales') }}</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
