@extends('layouts.app')
@section('page_title', 'My Documents')

@section('content')

<div class="page-header animate-up">
    <div>
        <h1 class="page-title"><i class="bi bi-file-earmark-text-fill"></i> My Documents</h1>
        <p class="page-subtitle">Upload and manage your vehicle compliance documents</p>
    </div>
    <a href="{{ route('vehicle.index') }}" class="btn btn-secondary">
        <i class="bi bi-car-front"></i> My Vehicles
    </a>
</div>

@if ($documents->isNotEmpty())

    <div class="table-card animate-up">
        <div class="table-header">
            <span class="table-title"><i class="bi bi-file-earmark-text"></i> Documents</span>
            <span style="font-size:0.8rem;color:var(--text-muted);">{{ $documents->total() }} total</span>
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Vehicle</th>
                        <th>Document Type</th>
                        <th>Issue Date</th>
                        <th>Expiry Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($documents as $doc)
                        <tr>
                            <td>
                                <div style="display:flex;align-items:center;gap:0.6rem;">
                                    <div style="width:32px;height:32px;border-radius:7px;background:var(--red-glass);display:flex;align-items:center;justify-content:center;color:var(--red);font-size:0.95rem;">
                                        <i class="bi bi-car-front"></i>
                                    </div>
                                    <strong>{{ $doc->vehicle->plate_number }}</strong>
                                </div>
                            </td>
                            <td>
                                <div style="display:flex;align-items:center;gap:0.5rem;">
                                    <i class="bi bi-file-earmark-pdf" style="color:var(--rose);"></i>
                                    {{ $doc->getDocumentTypeLabel() }}
                                </div>
                            </td>
                            <td style="color:var(--text-muted);font-size:0.85rem;">
                                {{ $doc->issue_date->format('M d, Y') }}
                            </td>
                            <td>
                                @if ($doc->isExpired())
                                    <div style="display:flex;align-items:center;gap:0.4rem;">
                                        <span style="width:7px;height:7px;border-radius:50%;background:var(--rose);display:inline-block;"></span>
                                        <span style="color:var(--rose);font-size:0.85rem;font-weight:600;">{{ $doc->expiry_date->format('M d, Y') }}</span>
                                        <span class="badge badge-danger" style="font-size:0.68rem;">Expired</span>
                                    </div>
                                @elseif ($doc->isExpiringSoon())
                                    <div style="display:flex;align-items:center;gap:0.4rem;">
                                        <span style="width:7px;height:7px;border-radius:50%;background:var(--amber);display:inline-block;"></span>
                                        <span style="color:#92400e;font-size:0.85rem;font-weight:600;">{{ $doc->expiry_date->format('M d, Y') }}</span>
                                        <span class="badge badge-warning" style="font-size:0.68rem;">{{ $doc->daysUntilExpiry() }}d</span>
                                    </div>
                                @else
                                    <span style="font-size:0.85rem;color:var(--text-muted);">{{ $doc->expiry_date->format('M d, Y') }}</span>
                                @endif
                            </td>
                            <td>
                                @php
                                    $statusMap = [
                                        'approved' => ['class' => 'badge-success', 'icon' => 'bi-patch-check-fill'],
                                        'pending'  => ['class' => 'badge-warning', 'icon' => 'bi-hourglass-split'],
                                        'rejected' => ['class' => 'badge-danger',  'icon' => 'bi-x-circle-fill'],
                                        'expired'  => ['class' => 'badge-info',    'icon' => 'bi-calendar-x'],
                                    ];
                                    $s = $statusMap[$doc->status] ?? ['class' => 'badge-secondary', 'icon' => 'bi-circle'];
                                @endphp
                                <span class="badge {{ $s['class'] }}">
                                    <i class="bi {{ $s['icon'] }}"></i>
                                    {{ ucfirst($doc->status) }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('document.show', $doc) }}" class="btn btn-sm btn-info" title="View">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('document.download', $doc) }}" class="btn btn-sm btn-success" title="Download">
                                        <i class="bi bi-download"></i>
                                    </a>
                                    @if ($doc->status === 'rejected')
                                        <a href="{{ route('document.reupload', $doc) }}" class="btn btn-sm btn-warning" title="Re-upload">
                                            <i class="bi bi-cloud-upload"></i>
                                        </a>
                                    @endif
                                    @if (in_array($doc->status, ['pending', 'rejected']))
                                        <form action="{{ route('document.destroy', $doc) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete this document?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">{{ $documents->links() }}</div>

@else
    <div class="card animate-up">
        <div class="empty-state">
            <div class="empty-icon"><i class="bi bi-file-earmark-text"></i></div>
            <h5>No Documents Uploaded</h5>
            <p>Upload compliance documents for your vehicles to keep them verified and road-ready.</p>
            <a href="{{ route('vehicle.index') }}" class="btn btn-primary mt-2">
                <i class="bi bi-car-front"></i> Go to My Vehicles
            </a>
        </div>
    </div>
@endif

@endsection
