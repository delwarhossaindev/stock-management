@extends('layouts.app')
@section('title', $purchase->purchase_no)
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>{{ __('Purchase') }}: {{ $purchase->purchase_no }}</h4>
    <div>
        <button onclick="window.print()" class="btn btn-outline-secondary no-print"><i class="bi bi-printer"></i> {{ __('Print') }}</button>
        <a href="{{ route('purchases.edit', $purchase) }}" class="btn btn-warning no-print"><i class="bi bi-pencil"></i> {{ __('Edit') }}</a>
        <a href="{{ route('purchases.index') }}" class="btn btn-secondary no-print"><i class="bi bi-arrow-left"></i> {{ __('Back') }}</a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="row mb-4">
            <div class="col-md-6">
                <h6 class="text-muted">{{ __('Supplier') }}</h6>
                <p class="fw-bold fs-5">{{ $purchase->supplier->name ?? '-' }}</p>
            </div>
            <div class="col-md-3">
                <h6 class="text-muted">{{ __('Purchase No') }}</h6>
                <p class="fw-bold">{{ $purchase->purchase_no }}</p>
            </div>
            <div class="col-md-3">
                <h6 class="text-muted">{{ __('Date') }}</h6>
                <p class="fw-bold">{{ $purchase->purchase_date->format('d/m/Y') }}</p>
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
                    @foreach($purchase->items as $i => $item)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $item->product->name }}</td>
                        <td class="text-center">{{ $item->quantity }}</td>
                        <td class="text-end">৳{{ number_format($item->buy_price, 2) }}</td>
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
                        <td class="text-end fw-bold">৳{{ number_format($purchase->subtotal, 2) }}</td>
                    </tr>
                    <tr>
                        <td>{{ __('Discount') }}</td>
                        <td class="text-end">৳{{ number_format($purchase->discount, 2) }}</td>
                    </tr>
                    <tr class="table-primary">
                        <td class="fw-bold fs-5">{{ __('Net Total') }}</td>
                        <td class="text-end fw-bold fs-5">৳{{ number_format($purchase->total_price, 2) }}</td>
                    </tr>
                    <tr>
                        <td>{{ __('Paid Amount') }}</td>
                        <td class="text-end text-success fw-bold">৳{{ number_format($purchase->paid_amount, 2) }}</td>
                    </tr>
                    <tr>
                        <td>{{ __('Due Amount') }}</td>
                        <td class="text-end {{ $purchase->due_amount > 0 ? 'text-danger' : 'text-success' }} fw-bold">৳{{ number_format($purchase->due_amount, 2) }}</td>
                    </tr>
                </table>
            </div>
        </div>

        @if($purchase->note)
        <div class="mt-3">
            <h6 class="text-muted">{{ __('Note') }}</h6>
            <p>{{ $purchase->note }}</p>
        </div>
        @endif
    </div>
</div>
@endsection
