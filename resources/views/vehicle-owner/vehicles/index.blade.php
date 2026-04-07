@extends('layouts.app')
@section('page_title', 'My Vehicles')

@section('content')

<div class="page-header animate-up">
    <div>
        <h1 class="page-title"><i class="bi bi-car-front-fill"></i> My Vehicles</h1>
        <p class="page-subtitle">Manage all your registered vehicles</p>
    </div>
    <a href="{{ route('vehicle.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Add Vehicle
    </a>
</div>

@if ($vehicles->isNotEmpty())

    <div class="row g-4 animate-up">
        @foreach ($vehicles as $vehicle)
            <div class="col-md-6 col-xl-4">
                <div class="vehicle-card">
                    <div class="vehicle-card-header">
                        <div class="vehicle-plate">
                            <i class="bi bi-car-front-fill"></i>
                            {{ $vehicle->plate_number }}
                        </div>
                        @if ($vehicle->isCompliant())
                            <span class="badge badge-success" style="background:rgba(255,255,255,0.2) !important;color:white !important;">
                                <i class="bi bi-patch-check-fill"></i> Compliant
                            </span>
                        @else
                            <span class="badge badge-warning" style="background:rgba(255,255,255,0.2) !important;color:white !important;">
                                <i class="bi bi-exclamation-triangle-fill"></i> Review
                            </span>
                        @endif
                    </div>

                    <div class="vehicle-card-body">
                        <div class="vehicle-meta">
                            <div class="vehicle-meta-item">
                                <label>Model</label>
                                <span>{{ $vehicle->brand_model }}</span>
                            </div>
                            <div class="vehicle-meta-item">
                                <label>Year</label>
                                <span>{{ $vehicle->year_of_manufacture }}</span>
                            </div>
                            <div class="vehicle-meta-item">
                                <label>Type</label>
                                <span>{{ ucfirst($vehicle->vehicle_type) }}</span>
                            </div>
                            <div class="vehicle-meta-item">
                                <label>Status</label>
                                <span>
                                    @if ($vehicle->status === 'active')
                                        <span class="badge badge-success">Active</span>
                                    @else
                                        <span class="badge badge-warning">{{ ucfirst($vehicle->status) }}</span>
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="vehicle-card-footer">
                        <a href="{{ route('vehicle.show', $vehicle) }}" class="btn btn-sm btn-info">
                            <i class="bi bi-eye"></i> View
                        </a>
                        <a href="{{ route('vehicle.edit', $vehicle) }}" class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                        <a href="{{ route('vehicle.compliance', $vehicle) }}" class="btn btn-sm btn-secondary">
                            <i class="bi bi-check2-circle"></i> Compliance
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-4">{{ $vehicles->links() }}</div>

@else
    <div class="card animate-up">
        <div class="empty-state">
            <div class="empty-icon"><i class="bi bi-car-front"></i></div>
            <h5>No Vehicles Registered</h5>
            <p>You haven't added any vehicles yet. Register your first vehicle to start managing compliance.</p>
            <a href="{{ route('vehicle.create') }}" class="btn btn-primary mt-2">
                <i class="bi bi-plus-lg"></i> Register Your First Vehicle
            </a>
        </div>
    </div>
@endif

@endsection
