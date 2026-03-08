@extends('layouts.app')
@section('title', __('Payments'))
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>{{ __('Payments') }}</h4>
    <a href="{{ route('payments.create') }}" class="btn btn-primary"><i class="bi bi-plus-circle"></i> {{ __('New Payment') }}</a>
</div>
<div class="card">
    <div class="card-body">
        <table class="table table-hover" id="paymentsTable" style="width:100%">
            <thead><tr><th>#</th><th>{{ __('Type') }}</th><th>{{ __('Reference') }}</th><th>{{ __('Amount') }}</th><th>{{ __('Method') }}</th><th>{{ __('Date') }}</th><th>{{ __('Action') }}</th></tr></thead>
        </table>
    </div>
</div>
@endsection
@push('scripts')
<script>
$('#paymentsTable').DataTable({
    processing: true, serverSide: true, language: dtLanguage,
    ajax: '{{ route("payments.index") }}',
    columns: [
        {data: 'DT_RowIndex', orderable: false, searchable: false},
        {data: 'type'}, {data: 'reference'}, {data: 'amount_fmt'},
        {data: 'method'}, {data: 'date_fmt'},
        {data: 'action', orderable: false, searchable: false}
    ]
});
</script>
@endpush
