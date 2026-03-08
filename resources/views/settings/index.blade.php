@extends('layouts.app')
@section('title', __('Settings'))
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>{{ __('Settings') }}</h4>
</div>
<form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-header"><i class="bi bi-building"></i> {{ __('Company Information') }}</div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">{{ __('Company Name') }}</label>
                            <input type="text" name="company_name" class="form-control" value="{{ old('company_name', $settings['company_name']) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">{{ __('Phone') }}</label>
                            <input type="text" name="company_phone" class="form-control" value="{{ old('company_phone', $settings['company_phone']) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">{{ __('Email') }}</label>
                            <input type="email" name="company_email" class="form-control" value="{{ old('company_email', $settings['company_email']) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">{{ __('Company Logo') }}</label>
                            <input type="file" name="company_logo" class="form-control" accept="image/*">
                            @if(\App\Models\Setting::get('company_logo'))
                                <img src="{{ asset('storage/' . \App\Models\Setting::get('company_logo')) }}" alt="Logo" class="mt-2" style="max-height:60px;">
                            @endif
                        </div>
                        <div class="col-12">
                            <label class="form-label">{{ __('Address') }}</label>
                            <textarea name="company_address" class="form-control" rows="2">{{ old('company_address', $settings['company_address']) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-header"><i class="bi bi-gear"></i> {{ __('General Settings') }}</div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">{{ __('Currency Symbol') }}</label>
                        <input type="text" name="currency_symbol" class="form-control" value="{{ old('currency_symbol', $settings['currency_symbol']) }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('Low Stock Threshold') }}</label>
                        <input type="number" name="low_stock_threshold" class="form-control" value="{{ old('low_stock_threshold', $settings['low_stock_threshold']) }}" min="1">
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary w-100 btn-lg"><i class="bi bi-check-circle"></i> {{ __('Save') }}</button>
        </div>
    </div>
</form>
@endsection
