@extends('layouts.app')

@section('title', 'Vehicle Search')

@section('content')
    <div class="page-title">
        <i class="bi bi-search"></i> Vehicle Search & Verification
    </div>

    <div class="row">
        <div class="col-lg-8 offset-lg-2">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="bi bi-search"></i> Search for Vehicle
                </div>
                <div class="card-body">
                    <form action="{{ route('officer.searchVehicle') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="search" class="form-label">Plate Number or VIN</label>
                            <input
                                type="text"
                                class="form-control form-control-lg"
                                id="search"
                                name="q"
                                placeholder="Enter plate number (e.g., KA-01-AB-1234) or VIN"
                                value="{{ request('q') }}"
                                required
                                autofocus
                            >
                            <small class="form-text text-muted">
                                Search by plate number or Vehicle Identification Number (VIN)
                            </small>
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg w-100">
                            <i class="bi bi-search"></i> Search Vehicle
                        </button>
                    </form>
                </div>
            </div>

            <!-- Tips Card -->
            <div class="card">
                <div class="card-header bg-info">
                    <i class="bi bi-info-circle"></i> Search Tips
                </div>
                <div class="card-body">
                    <h6>How to search:</h6>
                    <ul class="mb-0">
                        <li><strong>By Plate Number:</strong> Enter the vehicle's license plate (e.g., KA-01-AB-1234)</li>
                        <li><strong>By VIN:</strong> Enter the Vehicle Identification Number for more precise results</li>
                        <li>Search is case-insensitive</li>
                        <li>You can use partial matching (e.g., "KA-01" will find plates starting with KA-01)</li>
                    </ul>

                    <h6 class="mt-4">What you'll see in results:</h6>
                    <ul class="mb-0">
                        <li><strong>Vehicle Details:</strong> Make, model, year, and VIN</li>
                        <li><strong>Owner Information:</strong> Owner name and contact</li>
                        <li><strong>Compliance Status:</strong> Whether vehicle meets all requirements</li>
                        <li><strong>Document Status:</strong> Individual document verification</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
