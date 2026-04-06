<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Document;

class DocumentPolicy
{
    /**
     * Determine if the user can view the document
     */
    public function view(User $user, Document $document): bool
    {
        // Admins can view all documents
        if ($user->isAdmin()) {
            return true;
        }

        // Owners can view documents for their vehicles
        return $user->id === $document->vehicle->owner_id;
    }

    /**
     * Determine if the user can create documents
     */
    public function create(User $user): bool
    {
        return $user->isVehicleOwner();
    }

    /**
     * Determine if the user can update the document
     */
    public function update(User $user, Document $document): bool
    {
        // Admins can update all documents
        if ($user->isAdmin()) {
            return true;
        }

        // Owners can update their own documents (for reuploads)
        return $user->id === $document->vehicle->owner_id;
    }

    /**
     * Determine if the user can delete the document
     */
    public function delete(User $user, Document $document): bool
    {
        // Admins can delete all documents
        if ($user->isAdmin()) {
            return true;
        }

        // Owners can delete their own documents (only if pending or rejected)
        return $user->id === $document->vehicle->owner_id;
    }
}
