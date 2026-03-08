@extends('layouts.app')
@section('title', __('Permissions'))
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>{{ __('Permissions') }}</h4>
    @if(auth()->user()->can('permissions.create'))
    <a href="{{ route('permissions.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> {{ __('New Permission') }}</a>
    @endif
</div>
<div class="card">
    <div class="card-body">
        <table class="table table-hover" id="permissions-table" style="width:100%">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>{{ __('Name') }}</th>
                    <th>{{ __('Group') }}</th>
                    <th>{{ __('Roles') }}</th>
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
    $('#permissions-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('permissions.index') }}',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'name', name: 'name' },
            { data: 'group_display', name: 'group_display', orderable: false, searchable: false },
            { data: 'roles_count_badge', name: 'roles_count', searchable: false },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        language: dtLanguage,
        order: [[1, 'asc']]
    });
});
</script>
@endpush
