@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="page-title">
        <i class="bi bi-speedometer2"></i> Welcome, {{ auth()->user()->name }}
    </div>

    <div class="card mb-4">
        <div class="card-body text-center py-5">
            <i class="bi bi-check-circle" style="font-size: 3rem; color: #d32f2f;"></i>
            <h4 class="mt-3 mb-2">You're Successfully Logged In!</h4>
            <p class="text-muted mb-4">Welcome to the Fededge Vehicle Registration and Compliance Management System.</p>

            @if (auth()->user()->isAdmin())
                <p class="mb-3">As an administrator, you have full access to manage vehicles, users, documents, and compliance verification.</p>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">
                    <i class="bi bi-speedometer2"></i> Go to Admin Dashboard
                </a>
            @elseif (auth()->user()->isVehicleOwner())
                <p class="mb-3">As a vehicle owner, you can register vehicles, upload documents, and monitor compliance status.</p>
                <a href="{{ route('vehicle-owner.dashboard') }}" class="btn btn-primary">
                    <i class="bi bi-speedometer2"></i> Go to My Dashboard
                </a>
            @elseif (auth()->user()->isRoadOfficer())
                <p class="mb-3">As a road officer, you can search and verify vehicle compliance throughout the region.</p>
                <a href="{{ route('officer.dashboard') }}" class="btn btn-primary">
                    <i class="bi bi-speedometer2"></i> Go to Officer Dashboard
                </a>
            @endif
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-info-circle"></i> Getting Started
                </div>
                <div class="card-body">
                    <ul class="mb-0">
                        <li class="mb-2">Review your account profile and settings</li>
                        <li class="mb-2">Familiarize yourself with the available features</li>
                        <li class="mb-2">Check out the help documentation if needed</li>
                        <li>Contact support for any questions</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-shield-check"></i> System Information
                </div>
                <div class="card-body">
                    <p><strong>System:</strong> Fededge Vehicle Management</p>
                    <p><strong>Version:</strong> 1.0.0</p>
                    <p><strong>Your Role:</strong>
                        @if (auth()->user()->isAdmin())
                            Administrator
                        @elseif (auth()->user()->isVehicleOwner())
                            Vehicle Owner
                        @elseif (auth()->user()->isRoadOfficer())
                            Road Officer
                        @else
                            User
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header">
            <i class="bi bi-question-circle"></i> Quick Actions
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <a href="{{ route('profile.edit') }}" class="btn btn-outline-secondary w-100">
                        <i class="bi bi-person"></i> Edit Profile
                    </a>
                </div>
                <div class="col-md-4 mb-3">
                    <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger w-100">
                            <i class="bi bi-box-arrow-right"></i> Sign Out
                        </button>
                    </form>
                </div>
                <div class="col-md-4 mb-3">
                    <a href="{{ route('welcome') }}" class="btn btn-outline-primary w-100">
                        <i class="bi bi-house"></i> Home
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
