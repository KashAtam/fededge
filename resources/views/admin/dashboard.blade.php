@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="page-title">
        <i class="bi bi-speedometer2"></i> Admin Dashboard
    </div>

    <!-- Statistics Row -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="bi bi-car-front"></i>
                </div>
                <div>
                    <div class="stat-value">{{ $totalVehicles }}</div>
                    <div class="stat-label">Total Vehicles</div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="bi bi-people"></i>
                </div>
                <div>
                    <div class="stat-value">{{ $totalUsers }}</div>
                    <div class="stat-label">Total Users</div>
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
                    <i class="bi bi-check-circle"></i>
                </div>
                <div>
                    <div class="stat-value">{{ $compliantVehicles }}</div>
                    <div class="stat-label">Compliant Vehicles</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row mb-4">
        <div class="col-lg-6 mb-3">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-pie-chart"></i> Document Status Overview
                </div>
                <div class="card-body">
                    <canvas id="documentStatusChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-3">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-bar-chart"></i> Vehicle Compliance Status
                </div>
                <div class="card-body">
                    <canvas id="complianceChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Users by Role -->
    <div class="row mb-4">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-pie-chart"></i> Users by Role
                </div>
                <div class="card-body">
                    <canvas id="usersByRoleChart" style="max-height: 300px;"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Documents Summary -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card text-center">
                <div class="card-body">
                    <h3 class="card-title text-success">{{ $approvedDocuments }}</h3>
                    <p class="card-text">Approved Documents</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-center">
                <div class="card-body">
                    <h3 class="card-title text-warning">{{ $pendingDocuments }}</h3>
                    <p class="card-text">Pending Documents</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-center">
                <div class="card-body">
                    <h3 class="card-title text-danger">{{ $rejectedDocuments }}</h3>
                    <p class="card-text">Rejected Documents</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-center">
                <div class="card-body">
                    <h3 class="card-title text-info">{{ $expiredDocuments }}</h3>
                    <p class="card-text">Expired Documents</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Pending Documents -->
    <div class="row mb-4">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-exclamation-triangle"></i> Recent Pending Documents
                </div>
                <div class="card-body p-0">
                    @if ($recentPendingDocuments->isNotEmpty())
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Vehicle</th>
                                        <th>Document Type</th>
                                        <th>Owner</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($recentPendingDocuments as $doc)
                                        <tr>
                                            <td>
                                                <strong>{{ $doc->vehicle->plate_number }}</strong>
                                            </td>
                                            <td>{{ $doc->getDocumentTypeLabel() }}</td>
                                            <td>{{ $doc->vehicle->owner->name }}</td>
                                            <td>
                                                <a href="{{ route('admin.documents.show', $doc) }}" class="btn btn-sm btn-primary">
                                                    <i class="bi bi-eye"></i> Review
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-center text-muted py-4">No pending documents</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Expiring Soon Documents -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-calendar-event"></i> Documents Expiring Soon
                </div>
                <div class="card-body p-0">
                    @if ($expiringDocuments->isNotEmpty())
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Vehicle</th>
                                        <th>Expires In</th>
                                        <th>Owner</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($expiringDocuments as $doc)
                                        <tr>
                                            <td>
                                                <strong>{{ $doc->vehicle->plate_number }}</strong>
                                            </td>
                                            <td>
                                                <span class="badge badge-warning">{{ $doc->daysUntilExpiry() }} days</span>
                                            </td>
                                            <td>{{ $doc->vehicle->owner->name }}</td>
                                            <td>
                                                <a href="{{ route('admin.documents.show', $doc) }}" class="btn btn-sm btn-primary">
                                                    <i class="bi bi-eye"></i> View
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-center text-muted py-4">No documents expiring soon</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-lightning"></i> Quick Actions
                </div>
                <div class="card-body">
                    <a href="{{ route('admin.vehicles.index') }}" class="btn btn-primary me-2">
                        <i class="bi bi-car-front"></i> View All Vehicles
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-primary me-2">
                        <i class="bi bi-people"></i> Manage Users
                    </a>
                    <a href="{{ route('admin.documents.index') }}" class="btn btn-primary me-2">
                        <i class="bi bi-file-pdf"></i> Review Documents
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Document Status Chart
        const docCtx = document.getElementById('documentStatusChart')?.getContext('2d');
        if (docCtx) {
            new Chart(docCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Approved', 'Pending', 'Rejected', 'Expired'],
                    datasets: [{
                        data: [{{ $approvedDocuments }}, {{ $pendingDocuments }}, {{ $rejectedDocuments }}, {{ $expiredDocuments }}],
                        backgroundColor: ['#28a745', '#ffc107', '#dc3545', '#17a2b8'],
                        borderColor: '#fff',
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        }

        // Compliance Chart
        const compCtx = document.getElementById('complianceChart')?.getContext('2d');
        if (compCtx) {
            new Chart(compCtx, {
                type: 'bar',
                data: {
                    labels: ['Compliant', 'Non-Compliant'],
                    datasets: [{
                        label: 'Vehicles',
                        data: [{{ $compliantVehicles }}, {{ $nonCompliantVehicles }}],
                        backgroundColor: ['#28a745', '#dc3545'],
                        borderColor: '#fff',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'bottom'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }

        // Users by Role Chart
        const roleCtx = document.getElementById('usersByRoleChart')?.getContext('2d');
        if (roleCtx) {
            new Chart(roleCtx, {
                type: 'bar',
                data: {
                    labels: @json(array_keys($usersByRole)),
                    datasets: [{
                        label: 'Number of Users',
                        data: @json(array_values($usersByRole)),
                        backgroundColor: ['#d32f2f', '#f57c00', '#1976d2'],
                        borderColor: '#fff',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'bottom'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }
    </script>
@endpush
