@extends('layouts.app')
@section('title', __('Sale Return'))
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>{{ __('Sale Return') }}</h4>
    <a href="{{ route('sale-returns.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> {{ __('Back') }}</a>
</div>
<div class="card">
    <div class="card-body">
        <table class="table table-bordered">
            <tr><th style="width:200px">{{ __('Invoice No') }}</th><td>{{ $sale_return->sale->invoice_no }}</td></tr>
            <tr><th>{{ __('Product') }}</th><td>{{ $sale_return->product->name }}</td></tr>
            <tr><th>{{ __('Quantity') }}</th><td>{{ $sale_return->quantity }}</td></tr>
            <tr><th>{{ __('Amount') }}</th><td>৳{{ number_format($sale_return->amount, 2) }}</td></tr>
            <tr><th>{{ __('Reason') }}</th><td>{{ $sale_return->reason ?? '-' }}</td></tr>
            <tr><th>{{ __('Date') }}</th><td>{{ $sale_return->return_date->format('d/m/Y') }}</td></tr>
        </table>
    </div>
</div>
@endsection
