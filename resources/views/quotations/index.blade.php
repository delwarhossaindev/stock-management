@extends('layouts.app')
@section('title', __('Quotations'))
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>{{ __('Quotations') }}</h4>
    <div>
        <a href="{{ route('quotations.create') }}" class="btn btn-primary"><i class="bi bi-plus"></i> {{ __('New Quotation') }}</a>
    </div>
</div>
<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0" id="dataTable">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>{{ __('Quotation No') }}</th>
                    <th>{{ __('Date') }}</th>
                    <th>{{ __('Customer') }}</th>
                    <th>{{ __('Total') }}</th>
                    <th>{{ __('Action') }}</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(function() {
    $('#dataTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('quotations.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'quotation_no', name: 'quotation_no'},
            {data: 'date_fmt', name: 'quotation_date'},
            {data: 'customer_display', name: 'customer.name'},
            {data: 'total_price_fmt', name: 'total_price'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ],
        language: dtLanguage
    });
});
</script>
@endpush
