@extends('layouts.app')
@section('title', __('Database Backup'))
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>{{ __('Database Backup') }}</h4>
    <form action="{{ route('backups.store') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-primary"><i class="bi bi-database-add"></i> {{ __('Create Backup') }}</button>
    </form>
</div>

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show">{{ session('error') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
@endif

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>{{ __('File Name') }}</th>
                    <th>{{ __('Size') }}</th>
                    <th>{{ __('Date') }}</th>
                    <th>{{ __('Action') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($backups as $i => $backup)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td><i class="bi bi-file-earmark-code"></i> {{ $backup['name'] }}</td>
                    <td>{{ $backup['size'] }}</td>
                    <td>{{ $backup['date'] }}</td>
                    <td>
                        <a href="{{ route('backups.download', $backup['name']) }}" class="btn btn-sm btn-success" title="{{ __('Download') }}"><i class="bi bi-download"></i></a>
                        <form action="{{ route('backups.destroy', $backup['name']) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('Are you sure?') }}')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger" title="{{ __('Delete') }}"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-muted py-4">{{ __('No backups found.') }}</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
