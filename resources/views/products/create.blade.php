@extends('layouts.app')
@section('title', __('New Product'))
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>{{ __('New Product') }}</h4>
    <a href="{{ route('products.index') }}" class="btn btn-secondary">{{ __('Back') }}</a>
</div>
<div class="card">
    <div class="card-body">
        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">{{ __('Name') }} <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">{{ __('SKU') }} <span class="text-danger">*</span></label>
                    <input type="text" name="sku" class="form-control" value="{{ old('sku') }}" required>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">{{ __('Barcode') }}</label>
                    <input type="text" name="barcode" class="form-control" value="{{ old('barcode') }}" placeholder="{{ __('Optional') }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">{{ __('Category') }} <span class="text-danger">*</span></label>
                    <select name="category_id" class="form-select" required>
                        <option value="">{{ __('Select Category') }}</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">{{ __('Unit') }} <span class="text-danger">*</span></label>
                    <select name="unit_id" class="form-select" required>
                        <option value="">{{ __('Select Unit') }}</option>
                        @foreach($units as $unit)
                            <option value="{{ $unit->id }}" {{ old('unit_id') == $unit->id ? 'selected' : '' }}>{{ $unit->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">{{ __('Buy Price') }} <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text">৳</span>
                        <input type="number" step="0.01" name="buy_price" class="form-control" value="{{ old('buy_price', 0) }}" required>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">{{ __('Sell Price') }} <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text">৳</span>
                        <input type="number" step="0.01" name="sell_price" class="form-control" value="{{ old('sell_price', 0) }}" required>
                    </div>
                </div>
                <div class="col-md-2 mb-3">
                    <label class="form-label">{{ __('Tax Rate') }} (%)</label>
                    <input type="number" step="0.01" name="tax_rate" class="form-control" value="{{ old('tax_rate', 0) }}" min="0" max="100">
                </div>
                <div class="col-md-2 mb-3">
                    <label class="form-label">{{ __('Quantity') }} <span class="text-danger">*</span></label>
                    <input type="number" name="quantity" class="form-control" value="{{ old('quantity', 0) }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">{{ __('Description') }}</label>
                    <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">{{ __('Image') }}</label>
                    <input type="file" name="image" class="form-control" accept="image/*">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
        </form>
    </div>
</div>
@endsection
