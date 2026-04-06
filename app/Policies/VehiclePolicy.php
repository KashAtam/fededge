<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Vehicle;

class VehiclePolicy
{
    /**
     * Determine if the user can view the vehicle
     */
    public function view(User $user, Vehicle $vehicle): bool
    {
        // Admins can view all vehicles
        if ($user->isAdmin()) {
            return true;
        }

        // Owners can view their own vehicles
        return $user->id === $vehicle->owner_id;
    }

    /**
     * Determine if the user can create vehicles
     */
    public function create(User $user): bool
    {
        return $user->isVehicleOwner();
    }

    /**
     * Determine if the user can update the vehicle
     */
    public function update(User $user, Vehicle $vehicle): bool
    {
        // Admins can update all vehicles
        if ($user->isAdmin()) {
            return true;
        }

        // Owners can update their own vehicles
        return $user->id === $vehicle->owner_id;
    }

    /**
     * Determine if the user can delete the vehicle
     */
    public function delete(User $user, Vehicle $vehicle): bool
    {
        // Admins can delete all vehicles
        if ($user->isAdmin()) {
            return true;
        }

        // Owners can delete their own vehicles
        return $user->id === $vehicle->owner_id;
    }
}
