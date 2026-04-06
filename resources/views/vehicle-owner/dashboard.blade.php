@extends('layouts.app')

@section('title', 'Vehicle Owner Dashboard')

@section('content')
    <div class="page-title">
        <i class="bi bi-speedometer2"></i> My Dashboard
    </div>

    <!-- Welcome Card -->
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Welcome, {{ auth()->user()->name }}!</h5>
            <p class="card-text">Manage your vehicles and documents efficiently. Keep your vehicle registrations and compliance documents up to date.</p>
        </div>
    </div>

    <!-- Statistics -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="bi bi-car-front"></i>
                </div>
                <div>
                    <div class="stat-value">{{ count($vehicles) }}</div>
                    <div class="stat-label">My Vehicles</div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="bi bi-file-pdf"></i>
                </div>
                <div>
                    <div class="stat-value">{{ $pendingDocuments }}</div>
                    <div class="stat-label">Pending Documents</div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="bi bi-calendar-event"></i>
                </div>
                <div>
                    <div class="stat-value">{{ $expiringDocuments }}</div>
                    <div class="stat-label">Expiring Soon</div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="bi bi-check-circle"></i>
                </div>
                <div>
                    <div class="stat-value">{{ count($vehicles->filter(fn($v) => $v->isCompliant())) }}</div>
                    <div class="stat-label">Compliant</div>
                </div>
            </div>
        </div>
    </div>

    <!-- My Vehicles Overview -->
    <div class="row mb-4">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-car-front"></i> My Vehicles</span>
                    <a href="{{ route('vehicle.create') }}" class="btn btn-sm btn-primary">
                        <i class="bi bi-plus-lg"></i> Add Vehicle
                    </a>
                </div>
                <div class="card-body p-0">
                    @if ($vehicles->isNotEmpty())
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Plate Number</th>
                                        <th>Model</th>
                                        <th>Year</th>
                                        <th>Status</th>
                                        <th>Compliance</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($vehicles as $vehicle)
                                        <tr>
                                            <td>
                                                <strong>{{ $vehicle->plate_number }}</strong>
                                            </td>
                                            <td>{{ $vehicle->brand_model }}</td>
                                            <td>{{ $vehicle->year_of_manufacture }}</td>
                                            <td>
                                                @if ($vehicle->status === 'active')
                                                    <span class="badge bg-success">Active</span>
                                                @elseif ($vehicle->status === 'inactive')
                                                    <span class="badge bg-secondary">Inactive</span>
                                                @else
                                                    <span class="badge bg-danger">Suspended</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($vehicle->isCompliant())
                                                    <span class="badge bg-success">
                                                        <i class="bi bi-check-circle"></i> Compliant
                                                    </span>
                                                @else
                                                    <span class="badge bg-warning">
                                                        <i class="bi bi-exclamation-triangle"></i> Review Needed
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('vehicle.show', $vehicle) }}" class="btn btn-sm btn-info">
                                                    <i class="bi bi-eye"></i> View
                                                </a>
                                                <a href="{{ route('vehicle.edit', $vehicle) }}" class="btn btn-sm btn-warning">
                                                    <i class="bi bi-pencil"></i> Edit
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-car-front" style="font-size: 3rem; color: #ccc;"></i>
                            <p class="text-muted mt-3">No vehicles registered yet.</p>
                            <a href="{{ route('vehicle.create') }}" class="btn btn-primary mt-2">
                                <i class="bi bi-plus-lg"></i> Add Your First Vehicle
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Action Cards -->
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header bg-primary">
                    <i class="bi bi-file-pdf"></i> Document Management
                </div>
                <div class="card-body">
                    <p class="card-text">Upload and manage your vehicle documents including licenses, insurance, and certificates.</p>
                    <a href="{{ route('document.index') }}" class="btn btn-primary">
                        <i class="bi bi-arrow-right"></i> Manage Documents
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header bg-info">
                    <i class="bi bi-check2-circle"></i> Compliance Status
                </div>
                <div class="card-body">
                    <p class="card-text">Check the compliance status of your vehicles and see what documents may be missing or expired.</p>
                    @if ($vehicles->isNotEmpty())
                        <a href="{{ route('vehicle.compliance', $vehicles->first()) }}" class="btn btn-info">
                            <i class="bi bi-arrow-right"></i> Check Compliance
                        </a>
                    @else
                        <button class="btn btn-info" disabled>
                            Add a vehicle first
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Tips -->
    @if ($pendingDocuments > 0 || $expiringDocuments > 0)
        <div class="card mt-4 border-warning">
            <div class="card-header bg-warning">
                <i class="bi bi-exclamation-triangle"></i> Action Required
            </div>
            <div class="card-body">
                @if ($pendingDocuments > 0)
                    <p><strong>{{ $pendingDocuments }}</strong> document(s) are awaiting admin approval. Please check back later.</p>
                @endif
                @if ($expiringDocuments > 0)
                    <p><strong>{{ $expiringDocuments }}</strong> document(s) are expiring soon. Please renew them.</p>
                @endif
                <a href="{{ route('document.index') }}" class="btn btn-warning btn-sm">
                    <i class="bi bi-file-pdf"></i> View Documents
                </a>
            </div>
        </div>
    @endif
@endsection
