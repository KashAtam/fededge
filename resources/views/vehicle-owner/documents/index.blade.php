@extends('layouts.app')

@section('title', 'My Documents')

@section('content')
    <div class="page-title">
        <i class="bi bi-file-pdf"></i> My Documents
    </div>

    <div class="row mb-4">
        <div class="col-md-6">
            <p class="text-muted">Upload and manage your vehicle documents</p>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('vehicle.index') }}" class="btn btn-secondary">
                <i class="bi bi-car-front"></i> My Vehicles
            </a>
        </div>
    </div>

    @if ($documents->isNotEmpty())
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Vehicle</th>
                        <th>Document Type</th>
                        <th>Issue Date</th>
                        <th>Expiry Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($documents as $doc)
                        <tr>
                            <td>
                                <strong>{{ $doc->vehicle->plate_number }}</strong>
                            </td>
                            <td>{{ $doc->getDocumentTypeLabel() }}</td>
                            <td>{{ $doc->issue_date->format('M d, Y') }}</td>
                            <td>
                                @if ($doc->isExpired())
                                    <span class="text-danger"><strong>{{ $doc->expiry_date->format('M d, Y') }}</strong> (Expired)</span>
                                @elseif ($doc->isExpiringSoon())
                                    <span class="text-warning"><strong>{{ $doc->expiry_date->format('M d, Y') }}</strong> ({{ $doc->daysUntilExpiry() }} days)</span>
                                @else
                                    {{ $doc->expiry_date->format('M d, Y') }}
                                @endif
                            </td>
                            <td>
                                <span class="badge badge-{{ $doc->getStatusColor() }}">
                                    {{ ucfirst($doc->status) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('document.show', $doc) }}" class="btn btn-sm btn-info" title="View">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('document.download', $doc) }}" class="btn btn-sm btn-success" title="Download">
                                    <i class="bi bi-download"></i>
                                </a>
                                @if ($doc->status === 'rejected')
                                    <a href="{{ route('document.reupload', $doc) }}" class="btn btn-sm btn-warning" title="Re-upload">
                                        <i class="bi bi-cloud-upload"></i>
                                    </a>
                                @endif
                                @if (in_array($doc->status, ['pending', 'rejected']))
                                    <form action="{{ route('document.destroy', $doc) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Delete" onclick="return confirm('Are you sure?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $documents->links() }}
        </div>
    @else
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="bi bi-file-pdf" style="font-size: 4rem; color: #ccc;"></i>
                <h5 class="mt-3">No Documents Uploaded</h5>
                <p class="text-muted">You haven't uploaded any documents yet. Upload documents for your vehicles to maintain compliance.</p>
                <a href="{{ route('vehicle.index') }}" class="btn btn-primary mt-3">
                    <i class="bi bi-car-front"></i> Go to My Vehicles
                </a>
            </div>
        </div>
    @endif
@endsection
