@extends('layouts.app')
@section('title', __('Sale Report'))
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>{{ __('Sale Report') }}</h4>
    <button onclick="window.print()" class="btn btn-outline-secondary no-print"><i class="bi bi-printer"></i> {{ __('Print') }}</button>
</div>

<div class="card mb-3 no-print">
    <div class="card-body">
        <form method="GET" action="{{ route('reports.sale') }}" class="row g-2 align-items-end">
            <div class="col-md-3">
                <label class="form-label">{{ __('From Date') }}</label>
                <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">{{ __('To Date') }}</label>
                <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">{{ __('Customer Name') }}</label>
                <input type="text" name="customer_name" class="form-control" value="{{ request('customer_name') }}" placeholder="{{ __('Customer Name') }}">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">{{ __('Filter') }}</button>
            </div>
        </form>
    </div>
</div>

<div class="card mb-3 stat-card green p-3">
    <i class="bi bi-cart-check stat-icon"></i>
    <div class="text-muted small">{{ __('Total Sale Amount') }}</div>
    <div class="fs-4 fw-bold">৳{{ number_format($totalAmount, 2) }}</div>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0" id="reportTable">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>{{ __('Date') }}</th>
                    <th>{{ __('Invoice No') }}</th>
                    <th>{{ __('Customer Name') }}</th>
                    <th>{{ __('Items') }}</th>
                    <th>{{ __('Discount') }}</th>
                    <th>{{ __('Total') }}</th>
                    <th>{{ __('Paid') }}</th>
                    <th>{{ __('Due') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sales as $i => $sale)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $sale->sale_date->format('d/m/Y') }}</td>
                    <td><a href="{{ route('sales.show', $sale) }}">{{ $sale->invoice_no }}</a></td>
                    <td>{{ $sale->customer_name ?? '-' }}</td>
                    <td><span class="badge bg-secondary">{{ $sale->items_count }}</span></td>
                    <td>৳{{ number_format($sale->discount, 2) }}</td>
                    <td><strong>৳{{ number_format($sale->total_price, 2) }}</strong></td>
                    <td class="text-success">৳{{ number_format($sale->paid_amount, 2) }}</td>
                    <td class="{{ $sale->due_amount > 0 ? 'text-danger' : 'text-success' }}">৳{{ number_format($sale->due_amount, 2) }}</td>
                </tr>
                @empty
                <tr><td colspan="9" class="text-center text-muted py-3">{{ __('No sales found.') }}</td></tr>
                @endforelse
            </tbody>
            @if($sales->count())
            <tfoot class="table-light">
                <tr>
                    <th colspan="6" class="text-end">{{ __('Grand Total') }}:</th>
                    <th>৳{{ number_format($totalAmount, 2) }}</th>
                    <th>৳{{ number_format($sales->sum('paid_amount'), 2) }}</th>
                    <th>৳{{ number_format($sales->sum('due_amount'), 2) }}</th>
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
