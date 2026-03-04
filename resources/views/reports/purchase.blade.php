@extends('layouts.app')
@section('title', __('Purchase Report'))
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>{{ __('Purchase Report') }}</h4>
    <button onclick="window.print()" class="btn btn-outline-secondary no-print"><i class="bi bi-printer"></i> {{ __('Print') }}</button>
</div>

<div class="card mb-3 no-print">
    <div class="card-body">
        <form method="GET" action="{{ route('reports.purchase') }}" class="row g-2 align-items-end">
            <div class="col-md-3">
                <label class="form-label">{{ __('From Date') }}</label>
                <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">{{ __('To Date') }}</label>
                <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">{{ __('Supplier') }}</label>
                <select name="supplier_id" class="form-select">
                    <option value="">{{ __('All Suppliers') }}</option>
                    @foreach($suppliers as $supplier)
                        <option value="{{ $supplier->id }}" {{ request('supplier_id') == $supplier->id ? 'selected' : '' }}>{{ $supplier->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">{{ __('Filter') }}</button>
            </div>
        </form>
    </div>
</div>

<div class="card mb-3 stat-card blue p-3">
    <i class="bi bi-cart-plus stat-icon"></i>
    <div class="text-muted small">{{ __('Total Purchase Amount') }}</div>
    <div class="fs-4 fw-bold">৳{{ number_format($totalAmount, 2) }}</div>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0" id="reportTable">
            <thead class="table-light">
                <tr><th>#</th><th>{{ __('Date') }}</th><th>{{ __('Purchase No') }}</th><th>{{ __('Supplier') }}</th><th>{{ __('Items') }}</th><th>{{ __('Discount') }}</th><th>{{ __('Total') }}</th><th>{{ __('Paid') }}</th><th>{{ __('Due') }}</th></tr>
            </thead>
            <tbody>
                @forelse($purchases as $i => $purchase)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $purchase->purchase_date->format('d/m/Y') }}</td>
                    <td><a href="{{ route('purchases.show', $purchase) }}">{{ $purchase->purchase_no }}</a></td>
                    <td>{{ $purchase->supplier->name ?? '-' }}</td>
                    <td>{{ $purchase->items_count }}</td>
                    <td>৳{{ number_format($purchase->discount, 2) }}</td>
                    <td><strong>৳{{ number_format($purchase->total_price, 2) }}</strong></td>
                    <td>৳{{ number_format($purchase->paid_amount, 2) }}</td>
                    <td class="{{ $purchase->due_amount > 0 ? 'text-danger' : 'text-success' }}">৳{{ number_format($purchase->due_amount, 2) }}</td>
                </tr>
                @empty
                <tr><td colspan="9" class="text-center text-muted py-3">{{ __('No purchases found.') }}</td></tr>
                @endforelse
            </tbody>
            @if($purchases->count())
            <tfoot class="table-light">
                <tr>
                    <th colspan="6" class="text-end">{{ __('Grand Total') }}:</th>
                    <th>৳{{ number_format($totalAmount, 2) }}</th>
                    <th>৳{{ number_format($purchases->sum('paid_amount'), 2) }}</th>
                    <th>৳{{ number_format($purchases->sum('due_amount'), 2) }}</th>
                </tr>
            </tfoot>
            @endif
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
