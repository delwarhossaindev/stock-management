@extends('layouts.app')
@section('title', __('Edit Expense Category'))
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>{{ __('Edit Expense Category') }}</h4>
    <a href="{{ route('expense-categories.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> {{ __('Back') }}</a>
</div>
<div class="card">
    <div class="card-body">
        <form action="{{ route('expense-categories.update', $expense_category) }}" method="POST">
            @csrf @method('PUT')
            <div class="mb-3">
                <label class="form-label">{{ __('Name') }} <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $expense_category->name) }}" required>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <button type="submit" class="btn btn-primary"><i class="bi bi-check-circle"></i> {{ __('Update') }}</button>
        </form>
    </div>
</div>
@endsection
