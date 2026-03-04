@extends('layouts.app')
@section('title', __('New Unit'))
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>{{ __('New Unit') }}</h4>
    <a href="{{ route('units.index') }}" class="btn btn-secondary">{{ __('Back') }}</a>
</div>
<div class="card">
    <div class="card-body">
        <form action="{{ route('units.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">{{ __('Name') }} <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            </div>
            <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
        </form>
    </div>
</div>
@endsection
