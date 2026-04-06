<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RoadOfficerController extends Controller
{
    /**
     * Display road officer dashboard
     */
    public function dashboard(): View
    {
        $recentVerifications = session()->get('recent_verifications', []);
        $compliantVehicles = 0;
        $nonCompliantVehicles = 0;

        // Count vehicles for quick stats
        $allVehicles = Vehicle::with('documents')->get();
        foreach ($allVehicles as $vehicle) {
            if ($vehicle->isCompliant()) {
                $compliantVehicles++;
            } else {
                $nonCompliantVehicles++;
            }
        }

        return view('road-officer.dashboard', compact(
            'compliantVehicles',
            'nonCompliantVehicles',
            'recentVerifications'
        ));
    }

    /**
     * Show vehicle verification search form
     */
    public function search(): View
    {
        return view('road-officer.search');
    }

    /**
     * Search for vehicle by plate number
     */
    public function searchVehicle(Request $request): View
    {
        $query = $request->get('q');
        $vehicle = null;
        $notFound = false;

        if ($query) {
            $vehicle = Vehicle::with(['owner', 'documents'])
                ->where('plate_number', 'ilike', '%' . $query . '%')
                ->orWhere('vin', 'ilike', '%' . $query . '%')
                ->first();

            if (!$vehicle) {
                $notFound = true;
            } else {
                // Add to recent verifications
                $recentVerifications = session()->get('recent_verifications', []);
                $verification = [
                    'plate_number' => $vehicle->plate_number,
                    'checked_at' => now()->format('Y-m-d H:i:s')
                ];

                // Remove duplicate if exists
                $recentVerifications = array_filter($recentVerifications, fn($v) => $v['plate_number'] !== $vehicle->plate_number);

                array_unshift($recentVerifications, $verification);
                $recentVerifications = array_slice($recentVerifications, 0, 10);

                session()->put('recent_verifications', $recentVerifications);
            }
        }

        return view('road-officer.search-results', compact('vehicle', 'notFound', 'query'));
    }

    /**
     * Display vehicle verification details
     */
    public function verify(Vehicle $vehicle): View
    {
        $vehicle->load(['owner', 'documents']);

        // Determine compliance status
        $isCompliant = $vehicle->isCompliant();
        $complianceStatus = $vehicle->getComplianceStatus();

        // Check individual documents
        $requiredDocuments = [
            'vehicle_license' => 'Vehicle License',
            'insurance' => 'Insurance Certificate',
            'roadworthiness_certificate' => 'Roadworthiness Certificate'
        ];

        $documentDetails = [];

        foreach ($requiredDocuments as $type => $label) {
            $document = $vehicle->documents()
                ->where('document_type', $type)
                ->latest()
                ->first();

            if ($document) {
                $documentDetails[$type] = [
                    'label' => $label,
                    'status' => $document->status,
                    'issue_date' => $document->issue_date->format('Y-m-d'),
                    'expiry_date' => $document->expiry_date->format('Y-m-d'),
                    'is_expired' => $document->isExpired(),
                    'days_until_expiry' => $document->daysUntilExpiry(),
                    'file_path' => $document->file_path
                ];
            } else {
                $documentDetails[$type] = [
                    'label' => $label,
                    'status' => 'missing',
                    'issue_date' => null,
                    'expiry_date' => null,
                    'is_expired' => false,
                    'days_until_expiry' => null,
                    'file_path' => null
                ];
            }
        }

        return view('road-officer.verify', compact(
            'vehicle',
            'isCompliant',
            'complianceStatus',
            'documentDetails'
        ));
    }

    /**
     * Generate verification report
     */
    public function report(Vehicle $vehicle)
    {
        $vehicle->load(['owner', 'documents']);

        // This could be extended to generate PDF reports
        // For now, return the verify view with print-friendly styling

        return view('road-officer.report', compact('vehicle'));
    }
}
