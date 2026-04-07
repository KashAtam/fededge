@extends('layouts.app')

@section('title', 'Profile Settings')

@section('content')
    <div class="page-title">
        <i class="bi bi-person-circle"></i> Profile Settings
    </div>

    <div class="row mb-4">
        <div class="col-lg-8">
            <!-- Update Profile Information -->
            <div class="card mb-4">
                <div class="card-header">
                    <i class="bi bi-person"></i> Profile Information
                </div>
                <div class="card-body">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Update Password -->
            <div class="card mb-4">
                <div class="card-header">
                    <i class="bi bi-lock"></i> Update Password
                </div>
                <div class="card-body">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Delete Account -->
            <div class="card">
                <div class="card-header bg-danger">
                    <i class="bi bi-exclamation-triangle"></i> Danger Zone
                </div>
                <div class="card-body">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card sticky-top" style="top: 80px;">
                <div class="card-header">
                    <i class="bi bi-info-circle"></i> Account Information
                </div>
                <div class="card-body">
                    <p><strong>Account Email:</strong><br>
                    {{ auth()->user()->email }}</p>

                    <p><strong>Account Role:</strong><br>
                    @if (auth()->user()->isAdmin())
                        <span class="badge bg-danger">Administrator</span>
                    @elseif (auth()->user()->isVehicleOwner())
                        <span class="badge bg-success">Vehicle Owner</span>
                    @elseif (auth()->user()->isRoadOfficer())
                        <span class="badge bg-info">Road Officer</span>
                    @else
                        <span class="badge bg-secondary">User</span>
                    @endif
                    </p>

                    <p><strong>Member Since:</strong><br>
                    {{ auth()->user()->created_at->format('F j, Y') }}</p>

                    <hr>

                    <a href="{{ route('dashboard') }}" class="btn btn-sm btn-outline-primary w-100 mb-2">
                        <i class="bi bi-speedometer2"></i> Go to Dashboard
                    </a>

                    <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-danger w-100">
                            <i class="bi bi-box-arrow-right"></i> Sign Out
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
