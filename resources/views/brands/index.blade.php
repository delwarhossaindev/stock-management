@extends('layouts.app')
@section('title', __('Brands'))
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>{{ __('Brands') }}</h4>
    @if(auth()->user()->hasPermission('brands.create'))
    <a href="{{ route('brands.create') }}" class="btn btn-primary"><i class="bi bi-plus-circle"></i> {{ __('New Brand') }}</a>
    @endif
</div>
<div class="card">
    <div class="card-body">
        <table class="table table-hover" id="brandsTable" style="width:100%">
            <thead><tr><th>#</th><th>{{ __('Name') }}</th><th>{{ __('Products') }}</th><th>{{ __('Description') }}</th><th>{{ __('Action') }}</th></tr></thead>
        </table>
    </div>
</div>
@endsection
@push('scripts')
<script>
$('#brandsTable').DataTable({
    processing: true, serverSide: true, language: dtLanguage,
    ajax: '{{ route("brands.index") }}',
    columns: [
        {data: 'DT_RowIndex', orderable: false, searchable: false},
        {data: 'name'},
        {data: 'products_count'},
        {data: 'description', defaultContent: '-'},
        {data: 'action', orderable: false, searchable: false}
    ]
});
</script>
@endpush
