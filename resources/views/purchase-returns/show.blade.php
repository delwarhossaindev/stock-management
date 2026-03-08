@extends('layouts.app')
@section('title', __('Purchase Return'))
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>{{ __('Purchase Return') }}</h4>
    <a href="{{ route('purchase-returns.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> {{ __('Back') }}</a>
</div>
<div class="card">
    <div class="card-body">
        <table class="table table-bordered">
            <tr><th style="width:200px">{{ __('Purchase No') }}</th><td>{{ $purchase_return->purchase->purchase_no }}</td></tr>
            <tr><th>{{ __('Product') }}</th><td>{{ $purchase_return->product->name }}</td></tr>
            <tr><th>{{ __('Quantity') }}</th><td>{{ $purchase_return->quantity }}</td></tr>
            <tr><th>{{ __('Amount') }}</th><td>৳{{ number_format($purchase_return->amount, 2) }}</td></tr>
            <tr><th>{{ __('Reason') }}</th><td>{{ $purchase_return->reason ?? '-' }}</td></tr>
            <tr><th>{{ __('Date') }}</th><td>{{ $purchase_return->return_date->format('d/m/Y') }}</td></tr>
        </table>
    </div>
</div>
@endsection
