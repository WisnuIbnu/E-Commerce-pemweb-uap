<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Withdrawal;
use Illuminate\Auth\Access\Response;

class WithdrawalPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Withdrawal $withdrawal): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        return $user->role !== 'admin'
        ? Response::allow()
        : Response::deny('Admin cannot make a withdrawal request.');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user): Response
    {
        return $user->role !== 'admin'
        ? Response::allow()
        : Response::deny('Admin cannot make a withdrawal request.');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Withdrawal $withdrawal): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Withdrawal $withdrawal): bool
    {
        return false;
    }
}
