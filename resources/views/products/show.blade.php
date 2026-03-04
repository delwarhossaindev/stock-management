@extends('layouts.app')
@section('title', __('Product Details'))
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>{{ $product->name }}</h4>
    <a href="{{ route('products.index') }}" class="btn btn-secondary">{{ __('Back') }}</a>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="card mb-3">
            <div class="card-header">{{ __('Product Details') }}</div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr><th width="150">{{ __('SKU') }}:</th><td><code>{{ $product->sku }}</code></td></tr>
                    <tr><th>{{ __('Category') }}:</th><td>{{ $product->category->name }}</td></tr>
                    <tr><th>{{ __('Buy Price') }}:</th><td>৳{{ number_format($product->buy_price, 2) }}</td></tr>
                    <tr><th>{{ __('Sell Price') }}:</th><td>৳{{ number_format($product->sell_price, 2) }}</td></tr>
                    <tr><th>{{ __('Stock') }}:</th><td><span class="badge {{ $product->quantity <= 5 ? 'bg-danger' : 'bg-success' }}">{{ $product->quantity }} {{ $product->unit->name ?? '' }}</span></td></tr>
                    <tr><th>{{ __('Description') }}:</th><td>{{ $product->description ?? __('N/A') }}</td></tr>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card mb-3">
            <div class="card-header">{{ __('Stock Summary') }}</div>
            <div class="card-body">
                <p>{{ __('Total Purchased') }}: <strong>{{ $product->purchaseItems->sum('quantity') }}</strong></p>
                <p>{{ __('Total Sold') }}: <strong>{{ $product->saleItems->sum('quantity') }}</strong></p>
                <p>{{ __('Purchase Value') }}: <strong>৳{{ number_format($product->purchaseItems->sum('total'), 2) }}</strong></p>
                <p>{{ __('Sale Value') }}: <strong>৳{{ number_format($product->saleItems->sum('total'), 2) }}</strong></p>
            </div>
        </div>
    </div>
</div>
@endsection
