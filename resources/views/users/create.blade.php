@extends('layouts.app')
@section('title', __('New User'))
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>{{ __('New User') }}</h4>
    <a href="{{ route('users.index') }}" class="btn btn-secondary">{{ __('Back') }}</a>
</div>
<form action="{{ route('users.store') }}" method="POST">
    @csrf
    <div class="card mb-3">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">{{ __('Name') }} <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">{{ __('Email') }} <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">{{ __('Password') }} <span class="text-danger">*</span></label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">{{ __('Confirm Password') }} <span class="text-danger">*</span></label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">{{ __('Role') }} <span class="text-danger">*</span></label>
                    <select name="role" class="form-select" required>
                        @foreach($roles as $role)
                        <option value="{{ $role->name }}" {{ old('role') == $role->name ? 'selected' : '' }}>{{ __($role->name) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header"><i class="bi bi-shield-check"></i> {{ __('Extra Permissions') }} <small class="text-muted">({{ __('In addition to role permissions') }})</small></div>
        <div class="card-body">
            <div class="row">
                @foreach($permissions as $group => $groupPermissions)
                <div class="col-md-4 col-lg-3 mb-3">
                    <div class="card h-100">
                        <div class="card-header py-2 d-flex align-items-center">
                            <div class="form-check">
                                <input class="form-check-input select-all-group" type="checkbox" id="group-{{ $group }}">
                                <label class="form-check-label fw-bold" for="group-{{ $group }}">{{ __(ucfirst(str_replace('-', ' ', $group))) }}</label>
                            </div>
                        </div>
                        <div class="card-body py-2">
                            @foreach($groupPermissions as $perm)
                            <div class="form-check">
                                <input class="form-check-input perm-checkbox" type="checkbox" name="permissions[]" value="{{ $perm->id }}" id="perm-{{ $perm->id }}"
                                    {{ in_array($perm->id, old('permissions', [])) ? 'checked' : '' }}>
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

    <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg"></i> {{ __('Save') }}</button>
</form>
@endsection

@push('scripts')
<script>
$(function() {
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
