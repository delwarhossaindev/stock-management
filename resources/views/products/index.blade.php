@extends('layouts.app')
@section('title', __('Products'))
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>{{ __('Products') }}</h4>
    <div>
        <a href="{{ route('products.export') }}" class="btn btn-success"><i class="bi bi-download"></i> {{ __('Export') }}</a>
        @if(auth()->user()->can('products.create'))
        <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#importModal"><i class="bi bi-upload"></i> {{ __('Import') }}</button>
        <a href="{{ route('products.create') }}" class="btn btn-primary"><i class="bi bi-plus"></i> {{ __('New Product') }}</a>
        @endif
    </div>
</div>
<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0" id="dataTable">
            <thead class="table-light">
                <tr><th>#</th><th>{{ __('Name') }}</th><th>{{ __('SKU') }}</th><th>{{ __('Barcode') }}</th><th>{{ __('Category') }}</th><th>{{ __('Buy Price') }}</th><th>{{ __('Sell Price') }}</th><th>{{ __('Stock') }}</th><th>{{ __('Action') }}</th></tr>
            </thead>
        </table>
    </div>
</div>

@if(auth()->user()->can('products.create'))
<!-- Import Modal -->
<div class="modal fade" id="importModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('products.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Import Products') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">{{ __('Select Excel file') }}</label>
                        <input type="file" name="file" class="form-control" accept=".xlsx,.xls,.csv" required>
                    </div>
                    <div class="text-muted small">
                        <i class="bi bi-info-circle"></i> {{ __('To know correct format') }}
                        <a href="{{ route('products.sample') }}">{{ __('Download sample file') }}</a>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('Import Now') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endsection

@push('scripts')
<script>
$(function() {
    $('#dataTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('products.index', ['category_id' => request('category_id'), 'unit_id' => request('unit_id')]) }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'name', name: 'name'},
            {data: 'sku', name: 'sku'},
            {data: 'barcode', name: 'barcode'},
            {data: 'category_name', name: 'category.name'},
            {data: 'buy_price_fmt', name: 'buy_price'},
            {data: 'sell_price_fmt', name: 'sell_price'},
            {data: 'stock_badge', name: 'quantity'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ],
        language: dtLanguage
    });
});
</script>
@endpush
