@extends('layouts.app')
@section('page_title', 'Vehicle Search')

@section('content')

<div class="page-header animate-up">
    <div>
        <h1 class="page-title"><i class="bi bi-search"></i> Vehicle Search</h1>
        <p class="page-subtitle">Look up any vehicle by plate number or VIN</p>
    </div>
    <a href="{{ route('officer.dashboard') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Back
    </a>
</div>

{{-- Hero search box --}}
<div class="search-hero animate-up">
    <h2>Find a Vehicle</h2>
    <p>Enter a plate number or Vehicle Identification Number to check compliance status</p>
    <form action="{{ route('officer.searchVehicle') }}" method="POST">
        @csrf
        <div class="search-input-group">
            <input
                type="text"
                name="q"
                value="{{ request('q') }}"
                placeholder="e.g. KA-01-AB-1234 or full VIN…"
                required
                autofocus
            >
            <button type="submit" class="btn-search">
                <i class="bi bi-search"></i> Search
            </button>
        </div>
    </form>
</div>

{{-- Tips + Guide --}}
<div class="row g-4 animate-up">
    <div class="col-md-6">
        <div class="guide-card">
            <div class="guide-card-header"><i class="bi bi-lightbulb-fill"></i> How to Search</div>
            <ul class="guide-list">
                <li><strong>By Plate Number</strong> — Enter the licence plate (e.g. KA-01-AB-1234)</li>
                <li><strong>By VIN</strong> — Enter the Vehicle Identification Number for precise results</li>
                <li>Search is case-insensitive</li>
                <li>Partial matching is supported — "KA-01" matches all plates starting with KA-01</li>
            </ul>
        </div>
    </div>
    <div class="col-md-6">
        <div class="guide-card">
            <div class="guide-card-header" style="background:var(--green-bg);color:var(--green);border-color:rgba(16,185,129,0.15);">
                <i class="bi bi-clipboard2-data-fill"></i> What You'll See
            </div>
            <ul class="guide-list">
                <li><strong>Vehicle Details</strong> — Make, model, year, and VIN</li>
                <li><strong>Owner Information</strong> — Owner name and contact details</li>
                <li><strong>Compliance Status</strong> — Whether the vehicle meets all requirements</li>
                <li><strong>Document Status</strong> — Verification state of each document</li>
            </ul>
        </div>
    </div>
</div>

{{-- Status legend --}}
<div class="card mt-4 animate-up">
    <div class="card-header"><i class="bi bi-info-circle-fill"></i> Status Reference</div>
    <div class="card-body">
        <div class="d-flex gap-3 flex-wrap align-items-center">
            <div style="display:flex;align-items:center;gap:0.5rem;">
                <span class="badge badge-success"><i class="bi bi-patch-check-fill"></i> Compliant</span>
                <span style="font-size:0.82rem;color:var(--text-muted);">All required docs are valid</span>
            </div>
            <div style="display:flex;align-items:center;gap:0.5rem;">
                <span class="badge badge-warning"><i class="bi bi-hourglass-split"></i> Pending</span>
                <span style="font-size:0.82rem;color:var(--text-muted);">Awaiting admin review</span>
            </div>
            <div style="display:flex;align-items:center;gap:0.5rem;">
                <span class="badge badge-danger"><i class="bi bi-x-circle-fill"></i> Non-Compliant</span>
                <span style="font-size:0.82rem;color:var(--text-muted);">Missing or expired documents</span>
            </div>
        </div>
    </div>
</div>

@endsection
