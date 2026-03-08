@extends('layouts.app')
@section('title', __('Edit Role'))
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>{{ __('Edit Role') }}</h4>
    <a href="{{ route('roles.index') }}" class="btn btn-secondary">{{ __('Back') }}</a>
</div>
<form action="{{ route('roles.update', $role) }}" method="POST">
    @csrf @method('PUT')
    <div class="card mb-3">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">{{ __('Role Name') }} <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $role->name) }}" required {{ $role->name === 'admin' ? 'readonly' : '' }}>
                </div>
            </div>
            @if($role->name === 'admin')
            <div class="alert alert-info mb-0">
                <i class="bi bi-info-circle"></i> {{ __('Admin role always has all permissions.') }}
            </div>
            @endif
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header"><i class="bi bi-shield-check"></i> {{ __('Permissions') }}</div>
        <div class="card-body">
            <div class="row">
                @foreach($permissions as $group => $groupPermissions)
                <div class="col-md-4 col-lg-3 mb-3">
                    <div class="card h-100">
                        <div class="card-header py-2 d-flex align-items-center">
                            <div class="form-check">
                                <input class="form-check-input select-all-group" type="checkbox" id="group-{{ $group }}"
                                    {{ $role->name === 'admin' ? 'checked disabled' : '' }}>
                                <label class="form-check-label fw-bold" for="group-{{ $group }}">{{ __(ucfirst(str_replace('-', ' ', $group))) }}</label>
                            </div>
                        </div>
                        <div class="card-body py-2">
                            @foreach($groupPermissions as $perm)
                            <div class="form-check">
                                <input class="form-check-input perm-checkbox" type="checkbox" name="permissions[]" value="{{ $perm->id }}" id="perm-{{ $perm->id }}"
                                    {{ in_array($perm->id, old('permissions', $rolePermissionIds)) ? 'checked' : '' }}
                                    {{ $role->name === 'admin' ? 'disabled' : '' }}>
                                <label class="form-check-label" for="perm-{{ $perm->id }}">
                                    {{ __(ucfirst(str_replace('.', ' ', str_replace($group . '.', '', $perm->name)))) }}
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg"></i> {{ __('Update') }}</button>
</form>
@endsection

@push('scripts')
<script>
$(function() {
    // Set initial state of select-all checkboxes
    $('.select-all-group').each(function() {
        if ($(this).prop('disabled')) return;
        var card = $(this).closest('.card');
        var total = card.find('.perm-checkbox').length;
        var checked = card.find('.perm-checkbox:checked').length;
        $(this).prop('checked', total === checked && total > 0);
    });

    $('.select-all-group').on('change', function() {
        $(this).closest('.card').find('.perm-checkbox').prop('checked', this.checked);
    });

    $('.perm-checkbox').on('change', function() {
        var card = $(this).closest('.card');
        var total = card.find('.perm-checkbox').length;
        var checked = card.find('.perm-checkbox:checked').length;
        card.find('.select-all-group').prop('checked', total === checked);
    });
});
</script>
@endpush
