<?php

namespace App\Policies;

use App\Models\CalorieDay;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CalorieDayPolicy
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
    public function view(User $user, CalorieDay $calorieDay): Response
    {
        return $user->id === $calorieDay->user_id
        ? Response::allow()
        : Response::deny('You do not own this calorieDay.');
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
    public function update(User $user, CalorieDay $calorieDay): Response
    {
        return $user->id === $calorieDay->user_id
        ? Response::allow()
        : Response::deny('You do not own this calorieDay.');
    }


    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, CalorieDay $calorieDay): void
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, CalorieDay $calorieDay): void
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, CalorieDay $calorieDay): void
    {
        //
    }
}
