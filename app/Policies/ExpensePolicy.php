<?php

namespace App\Policies;

use App\Models\Budget;
use App\Models\Expense;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ExpensePolicy
{

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, Budget $budget): Response
    {
        return $user->id === $budget->user_id ? Response::allow() : Response::deny("Acceso denegado");
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Expense $expense): Response
    {
        return $user->id === $expense->budget->user_id ? Response::allow() : Response::deny("Acceso denegado");
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Expense $expense): Response
    {
        return $user->id === $expense->budget->user_id ? Response::allow() : Response::deny("Acceso denegado");
    }

}
