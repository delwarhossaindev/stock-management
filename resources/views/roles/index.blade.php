@extends('layouts.app')
@section('title', __('Roles & Permissions'))
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>{{ __('Roles & Permissions') }}</h4>
    @if(auth()->user()->hasPermission('roles.create'))
    <a href="{{ route('roles.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> {{ __('New Role') }}</a>
    @endif
</div>
<div class="card">
    <div class="card-body">
        <table class="table table-hover" id="roles-table" style="width:100%">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>{{ __('Name') }}</th>
                    <th>{{ __('Users') }}</th>
                    <th>{{ __('Permissions') }}</th>
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
    $('#roles-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('roles.index') }}',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'name_display', name: 'name' },
            { data: 'users_count_badge', name: 'users_count', searchable: false },
            { data: 'permissions_count_badge', name: 'permissions_count', searchable: false },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        language: dtLanguage,
        order: [[1, 'asc']]
    });
});
</script>
@endpush
