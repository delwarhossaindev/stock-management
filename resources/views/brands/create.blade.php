@extends('layouts.app')
@section('title', __('New Brand'))
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>{{ __('New Brand') }}</h4>
    <a href="{{ route('brands.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> {{ __('Back') }}</a>
</div>
<div class="card">
    <div class="card-body">
        <form action="{{ route('brands.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">{{ __('Name') }} <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">{{ __('Description') }}</label>
                <textarea name="description" class="form-control" rows="2">{{ old('description') }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary"><i class="bi bi-check-circle"></i> {{ __('Save') }}</button>
        </form>
    </div>
</div>
@endsection
