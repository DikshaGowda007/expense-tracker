<?php

namespace App\Repositories\MySql\V1;

use App\Models\Transaction;
use App\Repositories\DAO\V1\TransactionDAO;
use App\Repositories\V1\TransactionRepository;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class TransactionRepositoryImpl implements TransactionRepository
{
    public function insert(TransactionDAO $transactionDAO): Transaction
    {
        $transactionDAO->setCreatedAt(Carbon::now()->format('Y-m-d H:i:s'));
        $transactionDAO->setUpdatedAt(Carbon::now()->format('Y-m-d H:i:s'));
        return Transaction::create($transactionDAO->toArray());
    }

    public function updateByIdAndUserId(TransactionDAO $transactionDAO, int $id, int $userId): bool
    {
        return Transaction::where('id', $id)->where('user_id', $userId)->where('status', 1)->where('is_deleted', 0)->update($transactionDAO->toArray());
    }

    public function fetchByUserIdAndStatusAndIsDeleted(int $userId): Collection
    {
        return Transaction::where('user_id', $userId)->where('status', 1)->where('is_deleted', 0)->get();
    }
}