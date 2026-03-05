@extends('layouts.app')
@section('title', $sale->invoice_no)
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>{{ __('Invoice') }}: {{ $sale->invoice_no }}</h4>
    <div>
        <button onclick="window.print()" class="btn btn-outline-secondary no-print"><i class="bi bi-printer"></i> {{ __('Print') }}</button>
        <a href="{{ route('sales.edit', $sale) }}" class="btn btn-warning no-print"><i class="bi bi-pencil"></i> {{ __('Edit') }}</a>
        <a href="{{ route('sales.index') }}" class="btn btn-secondary no-print"><i class="bi bi-arrow-left"></i> {{ __('Back') }}</a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="row mb-4">
            <div class="col-md-6">
                <h6 class="text-muted">{{ __('Customer') }}</h6>
                <p class="fw-bold fs-5">{{ $sale->customer->name ?? ($sale->customer_name ?? '-') }}</p>
            </div>
            <div class="col-md-3">
                <h6 class="text-muted">{{ __('Invoice No') }}</h6>
                <p class="fw-bold">{{ $sale->invoice_no }}</p>
            </div>
            <div class="col-md-3">
                <h6 class="text-muted">{{ __('Date') }}</h6>
                <p class="fw-bold">{{ $sale->sale_date->format('d/m/Y') }}</p>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>{{ __('Product') }}</th>
                        <th class="text-center">{{ __('Quantity') }}</th>
                        <th class="text-end">{{ __('Unit Price') }}</th>
                        <th class="text-end">{{ __('Total') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sale->items as $i => $item)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $item->product->name }}</td>
                        <td class="text-center">{{ $item->quantity }}</td>
                        <td class="text-end">৳{{ number_format($item->sell_price, 2) }}</td>
                        <td class="text-end">৳{{ number_format($item->total, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="row justify-content-end">
            <div class="col-md-5">
                <table class="table table-sm">
                    <tr>
                        <td>{{ __('Subtotal') }}</td>
                        <td class="text-end fw-bold">৳{{ number_format($sale->subtotal, 2) }}</td>
                    </tr>
                    <tr>
                        <td>{{ __('Discount') }}</td>
                        <td class="text-end">৳{{ number_format($sale->discount, 2) }}</td>
                    </tr>
                    @if($sale->tax_value > 0)
                    <tr>
                        <td>{{ __('Tax') }} ({{ $sale->tax_type === 'percentage' ? $sale->tax_value . '%' : '৳' . number_format($sale->tax_value, 2) }})</td>
                        <td class="text-end">৳{{ number_format($sale->tax_amount, 2) }}</td>
                    </tr>
                    @endif
                    <tr class="table-primary">
                        <td class="fw-bold fs-5">{{ __('Net Total') }}</td>
                        <td class="text-end fw-bold fs-5">৳{{ number_format($sale->total_price, 2) }}</td>
                    </tr>
                    <tr>
                        <td>{{ __('Paid Amount') }}</td>
                        <td class="text-end text-success fw-bold">৳{{ number_format($sale->paid_amount, 2) }}</td>
                    </tr>
                    <tr>
                        <td>{{ __('Due Amount') }}</td>
                        <td class="text-end {{ $sale->due_amount > 0 ? 'text-danger' : 'text-success' }} fw-bold">৳{{ number_format($sale->due_amount, 2) }}</td>
                    </tr>
                </table>
            </div>
        </div>

        @if($sale->note)
        <div class="mt-3">
            <h6 class="text-muted">{{ __('Note') }}</h6>
            <p>{{ $sale->note }}</p>
        </div>
        @endif
    </div>
</div>
@endsection
