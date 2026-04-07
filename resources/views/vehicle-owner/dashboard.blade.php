@extends('layouts.app')
@section('page_title', 'My Dashboard')

@section('content')

{{-- Welcome Banner --}}
<div class="welcome-banner animate-up">
    <div class="welcome-banner-text">
        <h3>Welcome back, {{ auth()->user()->name }}! 👋</h3>
        <p>Here's the latest status of your vehicles and compliance documents.</p>
        <div class="d-flex gap-2 mt-3 flex-wrap">
            <a href="{{ route('vehicle.create') }}" class="btn btn-sm" style="background:rgba(255,255,255,0.2);color:white;border:1px solid rgba(255,255,255,0.4);">
                <i class="bi bi-plus-lg"></i> Add Vehicle
            </a>
            <a href="{{ route('document.index') }}" class="btn btn-sm" style="background:rgba(255,255,255,0.15);color:white;border:1px solid rgba(255,255,255,0.3);">
                <i class="bi bi-file-earmark-text"></i> My Documents
            </a>
        </div>
    </div>
    <i class="bi bi-car-front-fill welcome-banner-icon"></i>
</div>

{{-- Action Required Banner --}}
@if ($pendingDocuments > 0 || $expiringDocuments > 0)
<div class="notice-banner amber mb-4 animate-up">
    <i class="bi bi-exclamation-triangle-fill"></i>
    <div>
        @if ($pendingDocuments > 0)
            <strong>{{ $pendingDocuments }} document{{ $pendingDocuments > 1 ? 's' : '' }}</strong> awaiting admin approval.&nbsp;
        @endif
        @if ($expiringDocuments > 0)
            <strong>{{ $expiringDocuments }} document{{ $expiringDocuments > 1 ? 's' : '' }}</strong> expiring soon — please renew.
        @endif
    </div>
    <a href="{{ route('document.index') }}" class="btn btn-sm ms-auto" style="background:rgba(245,158,11,0.2);border:1px solid rgba(245,158,11,0.4);color:#92400e;white-space:nowrap;">
        View Documents
    </a>
</div>
@endif

{{-- Stat Cards --}}
<div class="stat-cards-grid">
    <div class="stat-card red animate-up stagger-1">
        <div class="stat-icon"><i class="bi bi-car-front-fill"></i></div>
        <div class="stat-info">
            <div class="stat-value" data-count="{{ count($vehicles) }}">{{ count($vehicles) }}</div>
            <div class="stat-label">My Vehicles</div>
        </div>
    </div>
    <div class="stat-card amber animate-up stagger-2">
        <div class="stat-icon"><i class="bi bi-hourglass-split"></i></div>
        <div class="stat-info">
            <div class="stat-value" data-count="{{ $pendingDocuments }}">{{ $pendingDocuments }}</div>
            <div class="stat-label">Pending Documents</div>
        </div>
    </div>
    <div class="stat-card rose animate-up stagger-3">
        <div class="stat-icon"><i class="bi bi-calendar-x"></i></div>
        <div class="stat-info">
            <div class="stat-value" data-count="{{ $expiringDocuments }}">{{ $expiringDocuments }}</div>
            <div class="stat-label">Expiring Soon</div>
        </div>
    </div>
    <div class="stat-card green animate-up stagger-4">
        <div class="stat-icon"><i class="bi bi-patch-check-fill"></i></div>
        <div class="stat-info">
            <div class="stat-value" data-count="{{ count($vehicles->filter(fn($v) => $v->isCompliant())) }}">{{ count($vehicles->filter(fn($v) => $v->isCompliant())) }}</div>
            <div class="stat-label">Compliant</div>
        </div>
    </div>
</div>

{{-- Vehicles Table --}}
<div class="table-card mb-4 animate-up">
    <div class="table-header">
        <span class="table-title"><i class="bi bi-car-front"></i> My Vehicles</span>
        <a href="{{ route('vehicle.create') }}" class="btn btn-sm btn-primary">
            <i class="bi bi-plus-lg"></i> Add Vehicle
        </a>
    </div>

    @if ($vehicles->isNotEmpty())
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Plate Number</th>
                        <th>Model</th>
                        <th>Year</th>
                        <th>Status</th>
                        <th>Compliance</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($vehicles as $vehicle)
                        <tr>
                            <td>
                                <div style="display:flex;align-items:center;gap:0.6rem;">
                                    <div style="width:34px;height:34px;border-radius:8px;background:var(--red-glass);display:flex;align-items:center;justify-content:center;color:var(--red);font-size:1rem;">
                                        <i class="bi bi-car-front"></i>
                                    </div>
                                    <strong>{{ $vehicle->plate_number }}</strong>
                                </div>
                            </td>
                            <td>{{ $vehicle->brand_model }}</td>
                            <td>{{ $vehicle->year_of_manufacture }}</td>
                            <td>
                                @if ($vehicle->status === 'active')
                                    <span class="badge badge-success"><i class="bi bi-circle-fill" style="font-size:0.55rem;"></i> Active</span>
                                @elseif ($vehicle->status === 'inactive')
                                    <span class="badge badge-secondary">Inactive</span>
                                @else
                                    <span class="badge badge-danger">Suspended</span>
                                @endif
                            </td>
                            <td>
                                @if ($vehicle->isCompliant())
                                    <span class="badge badge-success"><i class="bi bi-patch-check-fill"></i> Compliant</span>
                                @else
                                    <span class="badge badge-warning"><i class="bi bi-exclamation-triangle-fill"></i> Review Needed</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('vehicle.show', $vehicle) }}" class="btn btn-sm btn-info" title="View"><i class="bi bi-eye"></i></a>
                                    <a href="{{ route('vehicle.edit', $vehicle) }}" class="btn btn-sm btn-warning" title="Edit"><i class="bi bi-pencil"></i></a>
                                    <a href="{{ route('vehicle.compliance', $vehicle) }}" class="btn btn-sm btn-secondary" title="Compliance"><i class="bi bi-check2-circle"></i></a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="empty-state">
            <div class="empty-icon"><i class="bi bi-car-front"></i></div>
            <h5>No vehicles yet</h5>
            <p>Register your first vehicle to start tracking compliance and documents.</p>
            <a href="{{ route('vehicle.create') }}" class="btn btn-primary mt-2">
                <i class="bi bi-plus-lg"></i> Add Your First Vehicle
            </a>
        </div>
    @endif
</div>

{{-- Action Cards --}}
<div class="row g-3 animate-up">
    <div class="col-md-6">
        <a href="{{ route('document.index') }}" class="action-card">
            <div class="action-card-icon"><i class="bi bi-file-earmark-text-fill"></i></div>
            <div class="action-card-body">
                <h6>Document Management</h6>
                <p>Upload, track, and manage all compliance documents for your vehicles.</p>
            </div>
        </a>
    </div>
    <div class="col-md-6">
        @if ($vehicles->isNotEmpty())
            <a href="{{ route('vehicle.compliance', $vehicles->first()) }}" class="action-card">
        @else
            <div class="action-card" style="opacity:0.55;cursor:not-allowed;">
        @endif
            <div class="action-card-icon green"><i class="bi bi-patch-check-fill"></i></div>
            <div class="action-card-body">
                <h6>Compliance Check</h6>
                <p>Review which documents are missing, expired, or pending approval.</p>
            </div>
        @if ($vehicles->isNotEmpty())
            </a>
        @else
            </div>
        @endif
    </div>
</div>

@endsection
