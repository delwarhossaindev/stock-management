@extends('layouts.app')
@section('title', __('Profit / Loss Report'))
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>{{ __('Profit / Loss Report') }}</h4>
    <button onclick="window.print()" class="btn btn-outline-secondary no-print"><i class="bi bi-printer"></i> {{ __('Print') }}</button>
</div>

<div class="card mb-3 no-print">
    <div class="card-body">
        <form method="GET" action="{{ route('reports.profit') }}" class="row g-2 align-items-end">
            <div class="col-md-3">
                <label class="form-label">{{ __('From Date') }}</label>
                <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">{{ __('To Date') }}</label>
                <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">{{ __('Filter') }}</button>
            </div>
        </form>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card stat-card blue p-4 text-center">
            <i class="bi bi-cart-plus stat-icon"></i>
            <div class="text-muted">{{ __('Total Purchases') }}</div>
            <div class="fs-3 fw-bold text-primary">৳{{ number_format($totalPurchase, 2) }}</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card stat-card green p-4 text-center">
            <i class="bi bi-cart-check stat-icon"></i>
            <div class="text-muted">{{ __('Total Sales') }}</div>
            <div class="fs-3 fw-bold text-success">৳{{ number_format($totalSale, 2) }}</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card stat-card {{ $profit >= 0 ? 'green' : 'red' }} p-4 text-center">
            <i class="bi bi-graph-up-arrow stat-icon"></i>
            <div class="text-muted">{{ $profit >= 0 ? __('Profit') : __('Loss') }}</div>
            <div class="fs-3 fw-bold {{ $profit >= 0 ? 'text-success' : 'text-danger' }}">
                ৳{{ number_format(abs($profit), 2) }}
            </div>
        </div>
    </div>
</div>

<div class="card mt-4">
    <div class="card-body">
        <h5>{{ __('Summary') }}</h5>
        <table class="table">
            <tr>
                <td>{{ __('Total Purchases:') }}</td>
                <td class="text-end fw-bold">৳{{ number_format($totalPurchase, 2) }}</td>
            </tr>
            <tr>
                <td>{{ __('Total Sales:') }}</td>
                <td class="text-end fw-bold">৳{{ number_format($totalSale, 2) }}</td>
            </tr>
            <tr class="table-{{ $profit >= 0 ? 'success' : 'danger' }}">
                <td class="fw-bold">{{ $profit >= 0 ? __('Net Profit') : __('Net Loss') }}:</td>
                <td class="text-end fw-bold fs-5">৳{{ number_format(abs($profit), 2) }}</td>
            </tr>
        </table>
    </div>
</div>
@endsection
