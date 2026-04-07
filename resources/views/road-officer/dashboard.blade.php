@extends('layouts.app')
@section('page_title', 'Officer Dashboard')

@section('content')

{{-- Page Header --}}
<div class="page-header animate-up">
    <div>
        <h1 class="page-title"><i class="bi bi-person-badge-fill"></i> Officer Dashboard</h1>
        <p class="page-subtitle">Search and verify vehicle compliance in real time</p>
    </div>
    <a href="{{ route('officer.search') }}" class="btn btn-primary">
        <i class="bi bi-search"></i> Search Vehicle
    </a>
</div>

{{-- Stat Cards --}}
<div class="stat-cards-grid" style="grid-template-columns: repeat(3, 1fr);">
    <div class="stat-card green animate-up stagger-1">
        <div class="stat-icon"><i class="bi bi-patch-check-fill"></i></div>
        <div class="stat-info">
            <div class="stat-value" data-count="{{ $compliantVehicles }}">{{ $compliantVehicles }}</div>
            <div class="stat-label">Compliant Vehicles</div>
        </div>
    </div>
    <div class="stat-card rose animate-up stagger-2">
        <div class="stat-icon"><i class="bi bi-exclamation-octagon-fill"></i></div>
        <div class="stat-info">
            <div class="stat-value" data-count="{{ $nonCompliantVehicles }}">{{ $nonCompliantVehicles }}</div>
            <div class="stat-label">Non-Compliant</div>
        </div>
    </div>
    <div class="stat-card blue animate-up stagger-3">
        <div class="stat-icon"><i class="bi bi-clipboard2-check-fill"></i></div>
        <div class="stat-info">
            <div class="stat-value" data-count="{{ count($recentVerifications) }}">{{ count($recentVerifications) }}</div>
            <div class="stat-label">Verified Today</div>
        </div>
    </div>
</div>

{{-- Quick Search --}}
<div class="search-hero animate-up">
    <h2><i class="bi bi-search"></i> Quick Vehicle Lookup</h2>
    <p>Enter a plate number or VIN to instantly check compliance status</p>
    <form action="{{ route('officer.searchVehicle') }}" method="POST">
        @csrf
        <div class="search-input-group">
            <input type="text" name="q" placeholder="e.g. KA-01-AB-1234 or VIN number…" required autofocus>
            <button type="submit" class="btn-search">
                <i class="bi bi-search"></i> Search
            </button>
        </div>
    </form>
    <p style="margin-top:1rem;font-size:0.82rem;opacity:0.65;position:relative;z-index:1;">
        Need advanced filters? <a href="{{ route('officer.search') }}" style="color:rgba(255,255,255,0.9);font-weight:600;">Go to full search →</a>
    </p>
</div>

{{-- Recent Verifications + Guide Row --}}
<div class="row g-4 animate-up">

    {{-- Recent verifications --}}
    <div class="col-lg-7">
        <div class="table-card h-100">
            <div class="table-header">
                <span class="table-title"><i class="bi bi-clock-history"></i> Recent Verifications</span>
                @if (!empty($recentVerifications))
                    <span class="badge badge-info">Today</span>
                @endif
            </div>
            @if (!empty($recentVerifications))
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Plate Number</th>
                                <th>Checked At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($recentVerifications as $v)
                                <tr>
                                    <td>
                                        <div style="display:flex;align-items:center;gap:0.6rem;">
                                            <div style="width:32px;height:32px;border-radius:7px;background:var(--blue-bg);display:flex;align-items:center;justify-content:center;color:var(--blue);">
                                                <i class="bi bi-car-front"></i>
                                            </div>
                                            <strong>{{ $v['plate_number'] }}</strong>
                                        </div>
                                    </td>
                                    <td style="color:var(--text-muted);font-size:0.82rem;">{{ $v['checked_at'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-icon" style="background:var(--blue-bg);color:var(--blue);"><i class="bi bi-clipboard2"></i></div>
                    <h5>No verifications yet</h5>
                    <p>Your search history for today will appear here.</p>
                </div>
            @endif
        </div>
    </div>

    {{-- Guide + action cards --}}
    <div class="col-lg-5 d-flex flex-column gap-3">

        <div class="guide-card">
            <div class="guide-card-header"><i class="bi bi-info-circle-fill"></i> Compliance Guide</div>
            <ul class="guide-list">
                <li><strong>Vehicle License</strong> — must be approved &amp; not expired</li>
                <li><strong>Insurance Certificate</strong> — must be valid &amp; approved</li>
                <li><strong>Roadworthiness Certificate</strong> — must be current</li>
            </ul>
            <div style="padding: 0.75rem 1.5rem; border-top: 1px solid var(--border); display:flex; gap:0.5rem; flex-wrap:wrap;">
                <span class="badge badge-success"><i class="bi bi-check-circle-fill"></i> Compliant</span>
                <span class="badge badge-warning"><i class="bi bi-hourglass"></i> Pending</span>
                <span class="badge badge-danger"><i class="bi bi-x-circle-fill"></i> Non-Compliant</span>
            </div>
        </div>

        <a href="{{ route('officer.search') }}" class="action-card">
            <div class="action-card-icon"><i class="bi bi-search"></i></div>
            <div class="action-card-body">
                <h6>Advanced Search</h6>
                <p>Search with more options and generate verification reports.</p>
            </div>
        </a>

    </div>
</div>

@endsection
