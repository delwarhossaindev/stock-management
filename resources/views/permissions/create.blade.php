@extends('layouts.app')
@section('title', __('New Permission'))
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>{{ __('New Permission') }}</h4>
    <a href="{{ route('permissions.index') }}" class="btn btn-secondary">{{ __('Back') }}</a>
</div>
<form action="{{ route('permissions.store') }}" method="POST">
    @csrf
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">{{ __('Permission Name') }} <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="e.g. module.action" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    <small class="text-muted">{{ __('Use format: group.action (e.g. categories.view, products.create)') }}</small>
                </div>
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg"></i> {{ __('Save') }}</button>
</form>
@endsection
