<?php

namespace App\Policies;

use App\Models\FoodItem;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class FoodItemPolicy
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
    public function view(User $user, FoodItem $foodItem): void
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
    public function update(User $user, FoodItem $foodItem): Response
    {
        return $user->id === $foodItem->user_id
        ? Response::allow()
        : Response::deny('You do not own this foodItem.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, FoodItem $foodItem): Response
    {
        return $user->id === $foodItem->user_id
        ? Response::allow()
        : Response::deny('You do not own this foodItem.');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, FoodItem $foodItem): void
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, FoodItem $foodItem): void
    {
        //
    }
}
