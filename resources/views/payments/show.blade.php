@extends('layouts.app')
@section('title', __('Payment'))
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>{{ __('Payment') }}</h4>
    <a href="{{ route('payments.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> {{ __('Back') }}</a>
</div>
<div class="card">
    <div class="card-body">
        <table class="table table-bordered">
            <tr><th style="width:200px">{{ __('Type') }}</th><td>{{ $payment->payable_type === 'App\\Models\\Sale' ? __('Sale') : __('Purchase') }}</td></tr>
            <tr><th>{{ __('Reference') }}</th><td>{{ $payment->payable_type === 'App\\Models\\Sale' ? $payment->payable->invoice_no : $payment->payable->purchase_no }}</td></tr>
            <tr><th>{{ __('Amount') }}</th><td>৳{{ number_format($payment->amount, 2) }}</td></tr>
            <tr><th>{{ __('Method') }}</th><td>{{ ucfirst($payment->method) }}</td></tr>
            <tr><th>{{ __('Date') }}</th><td>{{ $payment->payment_date->format('d/m/Y') }}</td></tr>
            <tr><th>{{ __('Note') }}</th><td>{{ $payment->note ?? '-' }}</td></tr>
        </table>
    </div>
</div>
@endsection
