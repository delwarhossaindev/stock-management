@extends('layouts.app')
@section('title', __('Notifications'))
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>{{ __('Notifications') }}</h4>
</div>

<div class="row">
    {{-- Out of Stock --}}
    <div class="col-md-6 mb-3">
        <div class="card border-danger">
            <div class="card-header bg-danger text-white">
                <i class="bi bi-exclamation-triangle"></i> {{ __('Out of Stock') }} <span class="badge bg-light text-danger ms-1">{{ $outOfStock->count() }}</span>
            </div>
            <div class="card-body p-0">
                @if($outOfStock->count())
                <table class="table table-sm table-hover mb-0">
                    <thead><tr><th>{{ __('Product') }}</th><th>{{ __('SKU') }}</th></tr></thead>
                    <tbody>
                        @foreach($outOfStock as $p)
                        <tr>
                            <td><a href="{{ route('products.show', $p) }}">{{ $p->name }}</a></td>
                            <td>{{ $p->sku }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <p class="text-center text-muted py-3 mb-0">{{ __('No out of stock products.') }}</p>
                @endif
            </div>
        </div>
    </div>

    {{-- Low Stock --}}
    <div class="col-md-6 mb-3">
        <div class="card border-warning">
            <div class="card-header bg-warning text-dark">
                <i class="bi bi-exclamation-circle"></i> {{ __('Low Stock') }} (≤{{ $threshold }}) <span class="badge bg-dark ms-1">{{ $lowStock->count() }}</span>
            </div>
            <div class="card-body p-0">
                @if($lowStock->count())
                <table class="table table-sm table-hover mb-0">
                    <thead><tr><th>{{ __('Product') }}</th><th>{{ __('Stock') }}</th></tr></thead>
                    <tbody>
                        @foreach($lowStock as $p)
                        <tr>
                            <td><a href="{{ route('products.show', $p) }}">{{ $p->name }}</a></td>
                            <td><span class="badge bg-warning text-dark">{{ $p->quantity }}</span></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <p class="text-center text-muted py-3 mb-0">{{ __('No low stock products.') }}</p>
                @endif
            </div>
        </div>
    </div>

    {{-- Due Purchases --}}
    <div class="col-md-6 mb-3">
        <div class="card border-primary">
            <div class="card-header bg-primary text-white">
                <i class="bi bi-cash-stack"></i> {{ __('Due Purchases') }} <span class="badge bg-light text-primary ms-1">{{ $duePurchases->count() }}</span>
            </div>
            <div class="card-body p-0">
                @if($duePurchases->count())
                <table class="table table-sm table-hover mb-0">
                    <thead><tr><th>{{ __('Purchase No') }}</th><th>{{ __('Supplier') }}</th><th>{{ __('Due') }}</th></tr></thead>
                    <tbody>
                        @foreach($duePurchases as $p)
                        <tr>
                            <td><a href="{{ route('purchases.show', $p) }}">{{ $p->purchase_no }}</a></td>
                            <td>{{ $p->supplier->name ?? '-' }}</td>
                            <td class="text-danger fw-bold">৳{{ number_format($p->due_amount, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <p class="text-center text-muted py-3 mb-0">{{ __('No due purchases.') }}</p>
                @endif
            </div>
        </div>
    </div>

    {{-- Due Sales --}}
    <div class="col-md-6 mb-3">
        <div class="card border-success">
            <div class="card-header bg-success text-white">
                <i class="bi bi-cash-coin"></i> {{ __('Due Sales') }} <span class="badge bg-light text-success ms-1">{{ $dueSales->count() }}</span>
            </div>
            <div class="card-body p-0">
                @if($dueSales->count())
                <table class="table table-sm table-hover mb-0">
                    <thead><tr><th>{{ __('Invoice No') }}</th><th>{{ __('Customer') }}</th><th>{{ __('Due') }}</th></tr></thead>
                    <tbody>
                        @foreach($dueSales as $s)
                        <tr>
                            <td><a href="{{ route('sales.show', $s) }}">{{ $s->invoice_no }}</a></td>
                            <td>{{ $s->customer->name ?? $s->customer_name ?? '-' }}</td>
                            <td class="text-danger fw-bold">৳{{ number_format($s->due_amount, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <p class="text-center text-muted py-3 mb-0">{{ __('No due sales.') }}</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
