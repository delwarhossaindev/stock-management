@extends('layouts.app')
@section('title', __('Stock Adjustment'))
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>{{ __('Stock Adjustment') }}</h4>
    <a href="{{ route('stock-adjustments.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> {{ __('Back') }}</a>
</div>
<div class="card">
    <div class="card-body">
        <table class="table table-bordered">
            <tr><th style="width:200px">{{ __('Product') }}</th><td>{{ $stock_adjustment->product->name }}</td></tr>
            <tr><th>{{ __('Type') }}</th><td><span class="badge {{ $stock_adjustment->type === 'addition' ? 'bg-success' : 'bg-danger' }}">{{ $stock_adjustment->type === 'addition' ? __('Addition') : __('Subtraction') }}</span></td></tr>
            <tr><th>{{ __('Quantity') }}</th><td>{{ $stock_adjustment->quantity }}</td></tr>
            <tr><th>{{ __('Reason') }}</th><td>{{ $stock_adjustment->reason ?? '-' }}</td></tr>
            <tr><th>{{ __('Date') }}</th><td>{{ $stock_adjustment->adjustment_date->format('d/m/Y') }}</td></tr>
        </table>
    </div>
</div>
@endsection
