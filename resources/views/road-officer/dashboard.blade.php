@extends('layouts.app')

@section('title', 'Road Officer Dashboard')

@section('content')
    <div class="page-title">
        <i class="bi bi-person-badge"></i> Road Officer Dashboard
    </div>

    <!-- Quick Statistics -->
    <div class="row mb-4">
        <div class="col-md-4 mb-3">
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

        <div class="col-md-4 mb-3">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="bi bi-exclamation-circle"></i>
                </div>
                <div>
                    <div class="stat-value">{{ $nonCompliantVehicles }}</div>
                    <div class="stat-label">Non-Compliant Vehicles</div>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="bi bi-search"></i>
                </div>
                <div>
                    <div class="stat-value">{{ count($recentVerifications) }}</div>
                    <div class="stat-label">Verifications Today</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search Box -->
    <div class="row mb-4">
        <div class="col-lg-8 offset-lg-2">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-search"></i> Quick Vehicle Search
                </div>
                <div class="card-body">
                    <form action="{{ route('officer.searchVehicle') }}" method="POST" class="d-flex gap-2">
                        @csrf
                        <input type="text" name="q" class="form-control" placeholder="Enter plate number or VIN..."
                            required>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-search"></i> Search
                        </button>
                    </form>
                    <a href="{{ route('officer.search') }}" class="btn btn-link mt-2">
                        <i class="bi bi-arrow-right"></i> Go to Advanced Search
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Verifications -->
    @if (!empty($recentVerifications))
        <div class="row mb-4">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <i class="bi bi-clock-history"></i> Recent Verifications
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Plate Number</th>
                                        <th>Checked At</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($recentVerifications as $verification)
                                        <tr>
                                            <td>
                                                <strong>{{ $verification['plate_number'] }}</strong>
                                            </td>
                                            <td>{{ $verification['checked_at'] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Action Cards -->
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header bg-primary">
                    <i class="bi bi-search"></i> Search & Verify
                </div>
                <div class="card-body">
                    <p class="card-text">Search for vehicles by plate number or VIN to verify their compliance status and view documentation.</p>
                    <a href="{{ route('officer.search') }}" class="btn btn-primary">
                        <i class="bi bi-search"></i> Search Vehicles
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header bg-info">
                    <i class="bi bi-file-text"></i> Generate Report
                </div>
                <div class="card-body">
                    <p class="card-text">Generate verification reports for vehicles you've checked. Keep records for your patrol logs.</p>
                    <a href="{{ route('officer.search') }}" class="btn btn-info">
                        <i class="bi bi-file-pdf"></i> Start Verification
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Information Box -->
    <div class="card mt-4 border-info">
        <div class="card-header bg-info">
            <i class="bi bi-info-circle"></i> Compliance Verification Guide
        </div>
        <div class="card-body">
            <h6>What to verify:</h6>
            <ul>
                <li><strong>Vehicle License:</strong> Must be approved and not expired</li>
                <li><strong>Insurance Certificate:</strong> Must be approved and valid</li>
                <li><strong>Roadworthiness Certificate:</strong> Must be approved and current</li>
            </ul>
            <p class="mt-3 mb-0"><strong>Status Indicators:</strong></p>
            <p class="mb-0">
                <span class="badge bg-success">Compliant</span> - All required documents are valid
                <span class="badge bg-warning ms-2">Pending</span> - Awaiting admin review
                <span class="badge bg-danger ms-2">Non-Compliant</span> - Missing or expired documents
            </p>
        </div>
    </div>
@endsection
