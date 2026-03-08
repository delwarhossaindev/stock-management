@extends('layouts.app')
@section('title', __('Expenses'))
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>{{ __('Expenses') }}</h4>
    @if(auth()->user()->hasPermission('expenses.create'))
    <a href="{{ route('expenses.create') }}" class="btn btn-primary"><i class="bi bi-plus-circle"></i> {{ __('New Expense') }}</a>
    @endif
</div>
<div class="card">
    <div class="card-body">
        <table class="table table-hover" id="expensesTable" style="width:100%">
            <thead><tr><th>#</th><th>{{ __('Category') }}</th><th>{{ __('Amount') }}</th><th>{{ __('Date') }}</th><th>{{ __('Description') }}</th><th>{{ __('Action') }}</th></tr></thead>
        </table>
    </div>
</div>
@endsection
@push('scripts')
<script>
$('#expensesTable').DataTable({
    processing: true, serverSide: true, language: dtLanguage,
    ajax: '{{ route("expenses.index") }}',
    columns: [
        {data: 'DT_RowIndex', orderable: false, searchable: false},
        {data: 'category_name'},
        {data: 'amount_fmt'},
        {data: 'date_fmt'},
        {data: 'description', defaultContent: '-'},
        {data: 'action', orderable: false, searchable: false}
    ]
});
</script>
@endpush
