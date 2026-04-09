@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row mb-4">
        <div class="col-md-12">
            <h2 class="mb-4">Log Aktivitas</h2>
        </div>
    </div>

    @if($logs->isEmpty())
        <div class="alert alert-info">
            Tidak ada aktivitas yang tercatat.
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>User</th>
                        <th>Aktivitas</th>
                        <th>Deskripsi</th>
                        <th>IP Address</th>
                        <th>User Agent</th>
                        <th>Tanggal & Waktu</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($logs as $index => $log)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <span class="badge bg-primary">
                                    {{ $log->user->name ?? 'Sistem' }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-info">
                                    {{ $log->action }}
                                </span>
                            </td>
                            <td>{{ $log->description ?? '-' }}</td>
                            <td>
                                <small class="text-muted">{{ $log->ip_address ?? '-' }}</small>
                            </td>
                            <td>
                                <small class="text-muted" title="{{ $log->user_agent ?? '-' }}">
                                    {{ Str::limit($log->user_agent, 30, '...') ?? '-' }}
                                </small>
                            </td>
                            <td>
                                <small>{{ $log->created_at->format('d/m/Y H:i:s') }}</small>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($logs->hasPages())
            <div class="mt-3">
                {{ $logs->links('pagination::bootstrap-5-sm') }}
            </div>
        @endif
    @endif
</div>
@endsection
