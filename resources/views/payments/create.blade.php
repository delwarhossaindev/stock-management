@extends('layouts.app')
@section('title', __('New Payment'))
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>{{ __('New Payment') }}</h4>
    <a href="{{ route('payments.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> {{ __('Back') }}</a>
</div>
<div class="card">
    <div class="card-body">
        <form action="{{ route('payments.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">{{ __('Type') }} <span class="text-danger">*</span></label>
                <select name="payable_type" id="payableType" class="form-select" required>
                    <option value="">{{ __('Select Type') }}</option>
                    <option value="sale">{{ __('Sale') }}</option>
                    <option value="purchase">{{ __('Purchase') }}</option>
                </select>
            </div>
            <div class="mb-3" id="saleGroup" style="display:none">
                <label class="form-label">{{ __('Sale Invoice') }} <span class="text-danger">*</span></label>
                <select name="payable_id" class="form-select payable-select">
                    <option value="">{{ __('Select Sale') }}</option>
                    @foreach($sales as $s)
                    <option value="{{ $s->id }}">{{ $s->invoice_no }} - {{ __('Due') }}: ৳{{ number_format($s->due_amount, 2) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3" id="purchaseGroup" style="display:none">
                <label class="form-label">{{ __('Purchase No') }} <span class="text-danger">*</span></label>
                <select name="payable_id" class="form-select payable-select">
                    <option value="">{{ __('Select Purchase') }}</option>
                    @foreach($purchases as $p)
                    <option value="{{ $p->id }}">{{ $p->purchase_no }} - {{ __('Due') }}: ৳{{ number_format($p->due_amount, 2) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">{{ __('Amount') }} <span class="text-danger">*</span></label>
                <input type="number" name="amount" class="form-control" step="0.01" min="0.01" required>
            </div>
            <div class="mb-3">
                <label class="form-label">{{ __('Method') }}</label>
                <select name="method" class="form-select">
                    <option value="cash">{{ __('Cash') }}</option>
                    <option value="bank">{{ __('Bank Transfer') }}</option>
                    <option value="mobile">{{ __('Mobile Banking') }}</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">{{ __('Date') }} <span class="text-danger">*</span></label>
                <input type="date" name="payment_date" class="form-control" value="{{ date('Y-m-d') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">{{ __('Note') }}</label>
                <textarea name="note" class="form-control" rows="2"></textarea>
            </div>
            <button type="submit" class="btn btn-primary"><i class="bi bi-check-circle"></i> {{ __('Save') }}</button>
        </form>
    </div>
</div>
@endsection
@push('scripts')
<script>
$('#payableType').change(function() {
    let val = $(this).val();
    $('#saleGroup, #purchaseGroup').hide();
    $('.payable-select').prop('disabled', true);
    if (val === 'sale') { $('#saleGroup').show().find('select').prop('disabled', false); }
    if (val === 'purchase') { $('#purchaseGroup').show().find('select').prop('disabled', false); }
});
</script>
@endpush
