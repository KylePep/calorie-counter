<?php

namespace App\Policies;

use App\Models\Account;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AccountPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): void
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Account $account): Response
    {
        return $user->id === $account->user_id
        ? Response::allow()
        : Response::deny('You do not own this account.');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): void
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Account $account): Response
    {
        return $user->id === $account->user_id
        ? Response::allow()
        : Response::deny('You do not own this account.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Account $account): Response
    {
        return $user->id === $account->user_id
        ? Response::allow()
        : Response::deny('You do not own this account.');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Account $account): void
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Account $account): void
    {
        //
    }
}
