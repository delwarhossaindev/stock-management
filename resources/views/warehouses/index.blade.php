@extends('layouts.app')
@section('title', __('Warehouses'))
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>{{ __('Warehouses') }}</h4>
    @if(auth()->user()->can('warehouses.create'))
    <a href="{{ route('warehouses.create') }}" class="btn btn-primary"><i class="bi bi-plus"></i> {{ __('New Warehouse') }}</a>
    @endif
</div>
<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0" id="dataTable">
            <thead class="table-light">
                <tr><th>#</th><th>{{ __('Name') }}</th><th>{{ __('Phone') }}</th><th>{{ __('Address') }}</th><th>{{ __('Products') }}</th><th>{{ __('Action') }}</th></tr>
            </thead>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(function() {
    $('#dataTable').DataTable({
        processing: true, serverSide: true,
        ajax: "{{ route('warehouses.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'name', name: 'name'},
            {data: 'phone', name: 'phone'},
            {data: 'address', name: 'address'},
            {data: 'products_count_badge', name: 'products_count', searchable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ],
        language: dtLanguage
    });
});
</script>
@endpush
