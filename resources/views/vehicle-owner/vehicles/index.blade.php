@extends('layouts.app')

@section('title', 'My Vehicles')

@section('content')
    <div class="page-title">
        <i class="bi bi-car-front"></i> My Vehicles
    </div>

    <div class="row mb-4">
        <div class="col-md-6">
            <p class="text-muted">Manage all your registered vehicles</p>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('vehicle.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg"></i> Add New Vehicle
            </a>
        </div>
    </div>

    @if ($vehicles->isNotEmpty())
        <div class="row">
            @foreach ($vehicles as $vehicle)
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="bi bi-car-front"></i> {{ $vehicle->plate_number }}
                            </h5>
                        </div>
                        <div class="card-body">
                            <dl class="row">
                                <dt class="col-sm-4">Model:</dt>
                                <dd class="col-sm-8">{{ $vehicle->brand_model }}</dd>

                                <dt class="col-sm-4">Year:</dt>
                                <dd class="col-sm-8">{{ $vehicle->year_of_manufacture }}</dd>

                                <dt class="col-sm-4">Type:</dt>
                                <dd class="col-sm-8">{{ ucfirst($vehicle->vehicle_type) }}</dd>

                                <dt class="col-sm-4">Status:</dt>
                                <dd class="col-sm-8">
                                    @if ($vehicle->status === 'active')
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-warning">{{ ucfirst($vehicle->status) }}</span>
                                    @endif
                                </dd>

                                <dt class="col-sm-4">Compliance:</dt>
                                <dd class="col-sm-8">
                                    @if ($vehicle->compliance_status === 'compliant')
                                        <span class="badge bg-success">
                                            <i class="bi bi-check-circle"></i> Compliant
                                        </span>
                                    @else
                                        <span class="badge bg-warning">
                                            <i class="bi bi-exclamation-triangle"></i> Review Needed
                                        </span>
                                    @endif
                                </dd>
                            </dl>
                        </div>
                        <div class="card-footer bg-light">
                            <a href="{{ route('vehicle.show', $vehicle) }}" class="btn btn-sm btn-info">
                                <i class="bi bi-eye"></i> View
                            </a>
                            <a href="{{ route('vehicle.edit', $vehicle) }}" class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                            <a href="{{ route('vehicle.compliance', $vehicle) }}" class="btn btn-sm btn-primary">
                                <i class="bi bi-check2"></i> Check Compliance
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $vehicles->links() }}
        </div>
    @else
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="bi bi-car-front" style="font-size: 4rem; color: #ccc;"></i>
                <h5 class="mt-3">No Vehicles Registered</h5>
                <p class="text-muted">You haven't registered any vehicles yet.</p>
                <a href="{{ route('vehicle.create') }}" class="btn btn-primary mt-3">
                    <i class="bi bi-plus-lg"></i> Register Your First Vehicle
                </a>
            </div>
        </div>
    @endif
@endsection
