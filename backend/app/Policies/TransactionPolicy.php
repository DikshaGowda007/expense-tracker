<?php

namespace App\Policies;

use App\Models\Transaction;
use App\Models\User;

class TransactionPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Transaction $transaction): bool
    {
        return $transaction->user_id === $user->id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function add(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function edit(User $user, Transaction $transaction): bool
    {
        dd(1);
        dd($transaction);
        dd($transaction->user_id === $user->id);
        return $transaction->user_id === $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Transaction $transaction): bool
    {
    return $transaction->user_id === $user->id;
    }
}
