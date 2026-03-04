@extends('layouts.app')
@section('title', __('User Management'))
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>{{ __('User Management') }}</h4>
    <a href="{{ route('users.create') }}" class="btn btn-primary"><i class="bi bi-plus"></i> {{ __('New User') }}</a>
</div>
<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0" id="dataTable">
            <thead class="table-light">
                <tr><th>#</th><th>{{ __('Name') }}</th><th>{{ __('Email') }}</th><th>{{ __('Role') }}</th><th>{{ __('Joined') }}</th><th>{{ __('Action') }}</th></tr>
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
        ajax: "{{ route('users.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'name', name: 'name'},
            {data: 'email', name: 'email'},
            {data: 'role_badge', name: 'role', searchable: false},
            {data: 'joined', name: 'created_at'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ],
        language: dtLanguage
    });
});
</script>
@endpush
