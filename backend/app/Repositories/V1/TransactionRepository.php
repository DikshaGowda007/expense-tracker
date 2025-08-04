<?php
namespace App\Repositories\V1;

use App\Models\Transaction;
use App\Repositories\DAO\V1\TransactionDAO;
use Illuminate\Support\Collection;

interface TransactionRepository
{
    public function insert(TransactionDAO $transactionDAO): Transaction;

    public function updateByIdAndUserId(TransactionDAO $transactionDAO, int $id, int $userId): bool;

    public function fetchByUserIdAndStatusAndIsDeleted(int $userId): Collection;
}