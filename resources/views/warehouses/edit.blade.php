@extends('layouts.app')
@section('title', __('Edit Warehouse'))
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>{{ __('Edit Warehouse') }}</h4>
    <a href="{{ route('warehouses.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> {{ __('Back') }}</a>
</div>
<div class="card">
    <div class="card-body">
        <form action="{{ route('warehouses.update', $warehouse) }}" method="POST">
            @csrf @method('PUT')
            <div class="mb-3">
                <label class="form-label">{{ __('Name') }} <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $warehouse->name) }}" required>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">{{ __('Phone') }}</label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone', $warehouse->phone) }}">
            </div>
            <div class="mb-3">
                <label class="form-label">{{ __('Address') }}</label>
                <textarea name="address" class="form-control" rows="2">{{ old('address', $warehouse->address) }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary"><i class="bi bi-check-circle"></i> {{ __('Update') }}</button>
        </form>
    </div>
</div>
@endsection
