<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    /**
     * Display documents for user's vehicles
     */
    public function index(): View
    {
        $documents = Document::whereIn('vehicle_id', auth()->user()->vehicles()->pluck('id'))
            ->with('vehicle', 'approver')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('vehicle-owner.documents.index', compact('documents'));
    }

    /**
     * Show upload document form
     */
    public function create(Vehicle $vehicle): View
    {
        $this->authorize('view', $vehicle);

        $documentTypes = [
            Document::TYPE_DRIVERS_LICENSE => "Driver's License",
            Document::TYPE_VEHICLE_LICENSE => 'Vehicle License',
            Document::TYPE_INSURANCE => 'Insurance Certificate',
            Document::TYPE_ROADWORTHINESS_CERTIFICATE => 'Roadworthiness Certificate',
            Document::TYPE_REGISTRATION_CERTIFICATE => 'Registration Certificate',
            Document::TYPE_INSPECTION_REPORT => 'Inspection Report'
        ];

        return view('vehicle-owner.documents.create', compact('vehicle', 'documentTypes'));
    }

    /**
     * Store uploaded document
     */
    public function store(Request $request, Vehicle $vehicle)
    {
        $this->authorize('view', $vehicle);

        $validated = $request->validate([
            'document_type' => 'required|in:drivers_license,vehicle_license,insurance,roadworthiness_certificate,registration_certificate,inspection_report',
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120', // 5MB max
            'issue_date' => 'required|date',
            'expiry_date' => 'required|date|after_or_equal:issue_date'
        ]);

        // Store file
        $file = $request->file('file');
        $originalName = $file->getClientOriginalName();
        $filePath = $file->store('documents/' . $vehicle->id, 'local');

        // Create document record
        Document::create([
            'vehicle_id' => $vehicle->id,
            'document_type' => $validated['document_type'],
            'file_path' => $filePath,
            'original_filename' => $originalName,
            'issue_date' => $validated['issue_date'],
            'expiry_date' => $validated['expiry_date'],
            'status' => Document::STATUS_PENDING
        ]);

        return redirect()->route('document.index')
            ->with('success', 'Document uploaded successfully. Admin will review and approve it.');
    }

    /**
     * Show document details
     */
    public function show(Document $document): View
    {
        $this->authorize('view', $document);

        $document->load('vehicle', 'approver');

        return view('vehicle-owner.documents.show', compact('document'));
    }

    /**
     * Download document
     */
    public function download(Document $document)
    {
        $this->authorize('view', $document);

        if (!Storage::exists($document->file_path)) {
            abort(404, 'File not found.');
        }

        return Storage::download($document->file_path, $document->original_filename);
    }

    /**
     * Delete document
     */
    public function destroy(Document $document)
    {
        $this->authorize('delete', $document);

        // Only allow deletion if document is pending or rejected
        if (!in_array($document->status, [Document::STATUS_PENDING, Document::STATUS_REJECTED])) {
            return back()->with('error', 'Cannot delete approved or expired documents.');
        }

        // Delete file
        if (Storage::exists($document->file_path)) {
            Storage::delete($document->file_path);
        }

        $document->delete();

        return redirect()->route('document.index')
            ->with('success', 'Document deleted successfully.');
    }

    /**
     * Reupload document (for rejected documents)
     */
    public function reupload(Document $document): View
    {
        $this->authorize('update', $document);

        if ($document->status !== Document::STATUS_REJECTED) {
            abort(403, 'Only rejected documents can be reuploaded.');
        }

        return view('vehicle-owner.documents.reupload', compact('document'));
    }

    /**
     * Store reuploaded document
     */
    public function storeReupload(Request $request, Document $document)
    {
        $this->authorize('update', $document);

        if ($document->status !== Document::STATUS_REJECTED) {
            abort(403, 'Only rejected documents can be reuploaded.');
        }

        $validated = $request->validate([
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'issue_date' => 'required|date',
            'expiry_date' => 'required|date|after_or_equal:issue_date'
        ]);

        // Delete old file
        if (Storage::exists($document->file_path)) {
            Storage::delete($document->file_path);
        }

        // Store new file
        $file = $request->file('file');
        $originalName = $file->getClientOriginalName();
        $filePath = $file->store('documents/' . $document->vehicle_id, 'local');

        // Update document record
        $document->update([
            'file_path' => $filePath,
            'original_filename' => $originalName,
            'issue_date' => $validated['issue_date'],
            'expiry_date' => $validated['expiry_date'],
            'status' => Document::STATUS_PENDING,
            'admin_feedback' => null
        ]);

        return redirect()->route('document.show', $document)
            ->with('success', 'Document reuploaded successfully. Admin will review it again.');
    }
}
