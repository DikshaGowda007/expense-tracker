<?php
namespace App\Modules\V1\Services\Transaction;

use App\Models\Transaction;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class TransactionAccessService
{
    public function hasTransactionCreateAccess(): bool
    {
        return Gate::forUser(Auth::user())->allows('transaction_add', Transaction::class);
    }

    public function hasTransactionUpdateAccess(): bool
    {
        $transactionId = request('id');
        $transaction = Transaction::find($transactionId);
        // dd($transaction);
        // dd($transactionId);

        return $transaction && Gate::forUser(Auth::user())->allows('transaction_edit', $transaction);
    }

    public function hasTransactionDeleteAccess(): bool
    {
        $transactionId = request('id');
        $transaction = Transaction::find($transactionId);

        return $transaction && Gate::forUser(Auth::user())->allows('transaction_delete', $transaction);
    }
}