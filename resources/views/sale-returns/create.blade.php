@extends('layouts.app')
@section('title', __('New Sale Return'))
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>{{ __('New Sale Return') }}</h4>
    <a href="{{ route('sale-returns.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> {{ __('Back') }}</a>
</div>
<div class="card">
    <div class="card-body">
        <form action="{{ route('sale-returns.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">{{ __('Sale Invoice') }} <span class="text-danger">*</span></label>
                <select name="sale_id" id="saleSelect" class="form-select" required>
                    <option value="">{{ __('Select Sale') }}</option>
                    @foreach($sales as $sale)
                    <option value="{{ $sale->id }}" data-items='@json($sale->items)'>{{ $sale->invoice_no }} - ৳{{ number_format($sale->total_price, 2) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">{{ __('Product') }} <span class="text-danger">*</span></label>
                <select name="product_id" id="productSelect" class="form-select" required>
                    <option value="">{{ __('Select Product') }}</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">{{ __('Quantity') }} <span class="text-danger">*</span></label>
                <input type="number" name="quantity" class="form-control" min="1" required>
            </div>
            <div class="mb-3">
                <label class="form-label">{{ __('Reason') }}</label>
                <input type="text" name="reason" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">{{ __('Date') }} <span class="text-danger">*</span></label>
                <input type="date" name="return_date" class="form-control" value="{{ date('Y-m-d') }}" required>
            </div>
            <button type="submit" class="btn btn-primary"><i class="bi bi-check-circle"></i> {{ __('Save') }}</button>
        </form>
    </div>
</div>
@endsection
@push('scripts')
<script>
$('#saleSelect').change(function() {
    let items = $(this).find(':selected').data('items') || [];
    let html = '<option value="">' + '{{ __("Select Product") }}' + '</option>';
    items.forEach(i => { html += '<option value="'+i.product_id+'">'+( i.product ? i.product.name : 'Product #'+i.product_id)+' (Qty: '+i.quantity+')</option>'; });
    $('#productSelect').html(html);
});
</script>
@endpush
