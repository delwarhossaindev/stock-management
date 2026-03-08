@extends('layouts.app')
@section('title', __('Brand'))
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>{{ __('Brand') }}: {{ $brand->name }}</h4>
    <a href="{{ route('brands.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> {{ __('Back') }}</a>
</div>
<div class="card">
    <div class="card-body">
        <table class="table table-bordered">
            <tr><th style="width:200px">{{ __('Name') }}</th><td>{{ $brand->name }}</td></tr>
            <tr><th>{{ __('Description') }}</th><td>{{ $brand->description ?? '-' }}</td></tr>
            <tr><th>{{ __('Products') }}</th><td>{{ $brand->products_count }}</td></tr>
            <tr><th>{{ __('Date') }}</th><td>{{ $brand->created_at->format('d/m/Y') }}</td></tr>
        </table>
    </div>
</div>
@endsection
