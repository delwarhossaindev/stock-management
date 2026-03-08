@extends('layouts.app')
@section('title', __('Edit Expense'))
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>{{ __('Edit Expense') }}</h4>
    <a href="{{ route('expenses.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> {{ __('Back') }}</a>
</div>
<div class="card">
    <div class="card-body">
        <form action="{{ route('expenses.update', $expense) }}" method="POST">
            @csrf @method('PUT')
            <div class="mb-3">
                <label class="form-label">{{ __('Category') }} <span class="text-danger">*</span></label>
                <select name="expense_category_id" class="form-select @error('expense_category_id') is-invalid @enderror" required>
                    <option value="">{{ __('Select Category') }}</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('expense_category_id', $expense->expense_category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('expense_category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">{{ __('Amount') }} <span class="text-danger">*</span></label>
                <input type="number" name="amount" class="form-control @error('amount') is-invalid @enderror" value="{{ old('amount', $expense->amount) }}" step="0.01" min="0.01" required>
                @error('amount')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">{{ __('Date') }} <span class="text-danger">*</span></label>
                <input type="date" name="expense_date" class="form-control @error('expense_date') is-invalid @enderror" value="{{ old('expense_date', $expense->expense_date->format('Y-m-d')) }}" required>
                @error('expense_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">{{ __('Description') }}</label>
                <textarea name="description" class="form-control" rows="2">{{ old('description', $expense->description) }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary"><i class="bi bi-check-circle"></i> {{ __('Update') }}</button>
        </form>
    </div>
</div>
@endsection
