@extends('layouts.app')
@section('title', __('Purchase Returns'))
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>{{ __('Purchase Returns') }}</h4>
    <a href="{{ route('purchase-returns.create') }}" class="btn btn-primary"><i class="bi bi-plus-circle"></i> {{ __('New Purchase Return') }}</a>
</div>
<div class="card">
    <div class="card-body">
        <table class="table table-hover" id="purchaseReturnsTable" style="width:100%">
            <thead><tr><th>#</th><th>{{ __('Purchase No') }}</th><th>{{ __('Product') }}</th><th>{{ __('Quantity') }}</th><th>{{ __('Amount') }}</th><th>{{ __('Date') }}</th><th>{{ __('Action') }}</th></tr></thead>
        </table>
    </div>
</div>
@endsection
@push('scripts')
<script>
$('#purchaseReturnsTable').DataTable({
    processing: true, serverSide: true, language: dtLanguage,
    ajax: '{{ route("purchase-returns.index") }}',
    columns: [
        {data: 'DT_RowIndex', orderable: false, searchable: false},
        {data: 'purchase_no'}, {data: 'product_name'}, {data: 'quantity'},
        {data: 'amount_fmt'}, {data: 'date_fmt'},
        {data: 'action', orderable: false, searchable: false}
    ]
});
</script>
@endpush
