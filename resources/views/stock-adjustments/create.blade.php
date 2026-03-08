@extends('layouts.app')
@section('title', __('New Adjustment'))
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>{{ __('New Adjustment') }}</h4>
    <a href="{{ route('stock-adjustments.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> {{ __('Back') }}</a>
</div>
<div class="card">
    <div class="card-body">
        <form action="{{ route('stock-adjustments.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">{{ __('Product') }} <span class="text-danger">*</span></label>
                <select name="product_id" class="form-select @error('product_id') is-invalid @enderror" required>
                    <option value="">{{ __('Select Product') }}</option>
                    @foreach($products as $p)
                    <option value="{{ $p->id }}" {{ old('product_id') == $p->id ? 'selected' : '' }}>{{ $p->name }} ({{ __('Stock') }}: {{ $p->quantity }})</option>
                    @endforeach
                </select>
                @error('product_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">{{ __('Type') }} <span class="text-danger">*</span></label>
                <select name="type" class="form-select" required>
                    <option value="addition">{{ __('Addition') }}</option>
                    <option value="subtraction">{{ __('Subtraction') }}</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">{{ __('Quantity') }} <span class="text-danger">*</span></label>
                <input type="number" name="quantity" class="form-control @error('quantity') is-invalid @enderror" value="{{ old('quantity') }}" min="1" required>
                @error('quantity')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">{{ __('Reason') }}</label>
                <input type="text" name="reason" class="form-control" value="{{ old('reason') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">{{ __('Date') }} <span class="text-danger">*</span></label>
                <input type="date" name="adjustment_date" class="form-control" value="{{ old('adjustment_date', date('Y-m-d')) }}" required>
            </div>
            <button type="submit" class="btn btn-primary"><i class="bi bi-check-circle"></i> {{ __('Save') }}</button>
        </form>
    </div>
</div>
@endsection
