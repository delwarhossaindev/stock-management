@extends('layouts.app')
@section('title', __('Purchases'))
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>{{ __('Purchases') }}</h4>
    <div>
        <a href="{{ route('purchases.export') }}" class="btn btn-success"><i class="bi bi-download"></i> {{ __('Export') }}</a>
        @if(auth()->user()->isAdmin())
        <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#importModal"><i class="bi bi-upload"></i> {{ __('Import') }}</button>
        @endif
        <a href="{{ route('purchases.create') }}" class="btn btn-primary"><i class="bi bi-plus"></i> {{ __('New Purchase') }}</a>
    </div>
</div>
<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0" id="dataTable">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>{{ __('Date') }}</th>
                    <th>{{ __('Purchase No') }}</th>
                    <th>{{ __('Supplier') }}</th>
                    <th>{{ __('Total') }}</th>
                    <th>{{ __('Paid') }}</th>
                    <th>{{ __('Due') }}</th>
                    <th>{{ __('Action') }}</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

@if(auth()->user()->isAdmin())
<!-- Import Modal -->
<div class="modal fade" id="importModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('purchases.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Import Purchases') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">{{ __('Select Excel file') }}</label>
                        <input type="file" name="file" class="form-control" accept=".xlsx,.xls,.csv" required>
                    </div>
                    <div class="text-muted small">
                        <i class="bi bi-info-circle"></i> {{ __('To know correct format') }}
                        <a href="{{ route('purchases.sample') }}">{{ __('Download sample file') }}</a>
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
        ajax: "{{ route('purchases.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'date_fmt', name: 'purchase_date'},
            {data: 'purchase_no', name: 'purchase_no'},
            {data: 'supplier_display', name: 'supplier.name'},
            {data: 'total_price_fmt', name: 'total_price'},
            {data: 'paid_fmt', name: 'paid_amount'},
            {data: 'due_fmt', name: 'due_amount'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ],
        language: dtLanguage
    });
});
</script>
@endpush
