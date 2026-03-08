@extends('layouts.app')
@section('title', __('Stock Adjustments'))
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>{{ __('Stock Adjustments') }}</h4>
    @if(auth()->user()->can('stock-adjustments.create'))
    <a href="{{ route('stock-adjustments.create') }}" class="btn btn-primary"><i class="bi bi-plus-circle"></i> {{ __('New Adjustment') }}</a>
    @endif
</div>
<div class="card">
    <div class="card-body">
        <table class="table table-hover" id="adjTable" style="width:100%">
            <thead><tr><th>#</th><th>{{ __('Product') }}</th><th>{{ __('Type') }}</th><th>{{ __('Quantity') }}</th><th>{{ __('Reason') }}</th><th>{{ __('Date') }}</th><th>{{ __('Action') }}</th></tr></thead>
        </table>
    </div>
</div>
@endsection
@push('scripts')
<script>
$('#adjTable').DataTable({
    processing: true, serverSide: true, language: dtLanguage,
    ajax: '{{ route("stock-adjustments.index") }}',
    columns: [
        {data: 'DT_RowIndex', orderable: false, searchable: false},
        {data: 'product_name'},
        {data: 'type_badge'},
        {data: 'quantity'},
        {data: 'reason', defaultContent: '-'},
        {data: 'date_fmt'},
        {data: 'action', orderable: false, searchable: false}
    ]
});
</script>
@endpush
