@extends('layouts.app')
@section('title', __('Stock Report'))
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>{{ __('Stock Report') }}</h4>
    <button onclick="window.print()" class="btn btn-outline-secondary no-print"><i class="bi bi-printer"></i> {{ __('Print') }}</button>
</div>

<div class="card mb-3 no-print">
    <div class="card-body">
        <form method="GET" action="{{ route('reports.stock') }}" class="row g-2 align-items-end">
            <div class="col-md-3">
                <label class="form-label">{{ __('Category') }}</label>
                <select name="category_id" class="form-select">
                    <option value="">{{ __('All Categories') }}</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">{{ __('Stock Status') }}</label>
                <select name="stock_status" class="form-select">
                    <option value="">{{ __('All') }}</option>
                    <option value="in" {{ request('stock_status') === 'in' ? 'selected' : '' }}>{{ __('In Stock') }}</option>
                    <option value="low" {{ request('stock_status') === 'low' ? 'selected' : '' }}>{{ __('Low Stock (≤5)') }}</option>
                    <option value="out" {{ request('stock_status') === 'out' ? 'selected' : '' }}>{{ __('Out of Stock') }}</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">{{ __('Filter') }}</button>
            </div>
        </form>
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-4">
        <div class="card stat-card blue p-3">
            <i class="bi bi-box-seam stat-icon"></i>
            <div class="text-muted small">{{ __('Total Products') }}</div>
            <div class="fs-4 fw-bold">{{ $products->count() }}</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card stat-card green p-3">
            <i class="bi bi-cash-stack stat-icon"></i>
            <div class="text-muted small">{{ __('Total Stock Value (Buy)') }}</div>
            <div class="fs-4 fw-bold">৳{{ number_format($totalStockValue, 2) }}</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card stat-card yellow p-3">
            <i class="bi bi-currency-exchange stat-icon"></i>
            <div class="text-muted small">{{ __('Total Stock Value (Sell)') }}</div>
            <div class="fs-4 fw-bold">৳{{ number_format($totalSellValue, 2) }}</div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0" id="reportTable">
            <thead class="table-light">
                <tr><th>#</th><th>{{ __('Product') }}</th><th>{{ __('SKU') }}</th><th>{{ __('Category') }}</th><th>{{ __('Buy Price') }}</th><th>{{ __('Sell Price') }}</th><th>{{ __('Quantity') }}</th><th>{{ __('Stock Value') }}</th></tr>
            </thead>
            <tbody>
                @forelse($products as $i => $product)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $product->name }}</td>
                    <td><code>{{ $product->sku }}</code></td>
                    <td>{{ $product->category->name }}</td>
                    <td>৳{{ number_format($product->buy_price, 2) }}</td>
                    <td>৳{{ number_format($product->sell_price, 2) }}</td>
                    <td>
                        <span class="badge {{ $product->quantity <= 5 ? ($product->quantity == 0 ? 'bg-danger' : 'bg-warning text-dark') : 'bg-success' }}">
                            {{ $product->quantity }} {{ $product->unit }}
                        </span>
                    </td>
                    <td>৳{{ number_format($product->quantity * $product->buy_price, 2) }}</td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center text-muted py-3">{{ __('No products found.') }}</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(function() {
    $('#reportTable').DataTable({
        paging: true,
        ordering: true,
        info: true,
        language: dtLanguage
    });
});
</script>
@endpush
