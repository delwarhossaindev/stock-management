@extends('layouts.app')
@section('title', __('Expense Categories'))
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>{{ __('Expense Categories') }}</h4>
    @if(auth()->user()->can('expense-categories.create'))
    <a href="{{ route('expense-categories.create') }}" class="btn btn-primary"><i class="bi bi-plus-circle"></i> {{ __('New Category') }}</a>
    @endif
</div>
<div class="card">
    <div class="card-body">
        <table class="table table-hover" id="expenseCategoriesTable" style="width:100%">
            <thead><tr><th>#</th><th>{{ __('Name') }}</th><th>{{ __('Expenses') }}</th><th>{{ __('Action') }}</th></tr></thead>
        </table>
    </div>
</div>
@endsection
@push('scripts')
<script>
$('#expenseCategoriesTable').DataTable({
    processing: true, serverSide: true, language: dtLanguage,
    ajax: '{{ route("expense-categories.index") }}',
    columns: [
        {data: 'DT_RowIndex', orderable: false, searchable: false},
        {data: 'name'},
        {data: 'expenses_count'},
        {data: 'action', orderable: false, searchable: false}
    ]
});
</script>
@endpush
