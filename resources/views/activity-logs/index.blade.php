@extends('layouts.app')
@section('title', __('Activity Log'))
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>{{ __('Activity Log') }}</h4>
</div>
<div class="card">
    <div class="card-body">
        <table class="table table-hover" id="activityTable" style="width:100%">
            <thead><tr><th>#</th><th>{{ __('User') }}</th><th>{{ __('Action') }}</th><th>{{ __('Model') }}</th><th>{{ __('Date') }}</th></tr></thead>
        </table>
    </div>
</div>
@endsection
@push('scripts')
<script>
$('#activityTable').DataTable({
    processing: true, serverSide: true, language: dtLanguage,
    ajax: '{{ route("activity-logs.index") }}',
    columns: [
        {data: 'DT_RowIndex', orderable: false, searchable: false},
        {data: 'user_name'}, {data: 'action'}, {data: 'model_display'}, {data: 'date_fmt'}
    ]
});
</script>
@endpush
