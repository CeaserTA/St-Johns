<?php

namespace App\Policies;

use App\Models\Giving;
use App\Models\User;

class GivingPolicy
{
    /**
     * Determine if the user can view any givings (admin only)
     */
    public function viewAny(User $user): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Determine if the user can view the giving
     */
    public function view(User $user, Giving $giving): bool
    {
        // Admin can view all
        if ($user->role === 'admin') {
            return true;
        }

        // Members can only view their own givings
        return $user->member && $giving->member_id === $user->member->id;
    }

    /**
     * Determine if the user can create givings
     */
    public function create(User $user): bool
    {
        // Anyone can give (members and guests)
        return true;
    }

    /**
     * Determine if the user can update the giving (admin only)
     */
    public function update(User $user, Giving $giving): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Determine if the user can delete the giving (admin only)
     */
    public function delete(User $user, Giving $giving): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Determine if the user can view financial reports (admin only)
     */
    public function viewReports(User $user): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Determine if the user can confirm givings (admin only)
     */
    public function confirm(User $user): bool
    {
        return $user->role === 'admin';
    }
}