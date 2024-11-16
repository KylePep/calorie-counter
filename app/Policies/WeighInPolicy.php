<?php

namespace App\Policies;

use App\Models\User;
use App\Models\WeighIn;
use Illuminate\Auth\Access\Response;

class WeighInPolicy
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
    public function view(User $user, WeighIn $weighIn): void
    {
        //
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
    public function update(User $user, WeighIn $weighIn):  Response
    {
        return $user->id === $weighIn->user_id
        ? Response::allow()
        : Response::deny('You do not own this weighIn.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, WeighIn $weighIn): Response
    {
        return $user->id === $weighIn->user_id
        ? Response::allow()
        : Response::deny('You do not own this weighIn.');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, WeighIn $weighIn): void
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, WeighIn $weighIn): void
    {
        //
    }
}
