<?php
namespace App\Modules\V1\Services\Transaction\Get;

use App\Constants\CommonConstant;
use App\Repositories\DAO\V1\TransactionDAO;
use App\Repositories\V1\TransactionRepository;
use Exception;
use Illuminate\Support\Collection;

class TransactionService
{
    public function __construct(private TransactionDAO $transactionDAO, private TransactionRepository $transactionRepository)
    {
    }
    public function get(int $userId)
    {
        try {
            $transactionDetails = $this->fetchTransactions($userId);
            $response = $this->formatResponse($transactionDetails);
            return ['status' => CommonConstant::SUCCESS, 'message' => $response];
        } catch (Exception | \Throwable $e) {
            return ['status' => CommonConstant::ERROR, 'message' => $e->getMessage()];
        }
    }

    private function fetchTransactions(int $userId)
    {
        $transactions = $this->transactionRepository->fetchByUserIdAndStatusAndIsDeleted($userId);
        return $transactions->isNotEmpty() ? collect($transactions->toArray()) : collect([]);
    }

    private function formatResponse(Collection $transactionDetails): array|string
    {
        $transformed = [];
        foreach ($transactionDetails as $value) {
            $this->prepareTransactionData(collect($value), $transformed);
        }
        return empty($transformed) ? 'No transactions found' : $transformed;
    }

    private function prepareTransactionData(Collection $transactions, array &$transformed)
    {
        $transformed[] = [
            "id" => $transactions->get('id'),
            "category_id" => $transactions->get('category_id'),
            "text" => $transactions->get('text'),
            "amount" => (float) $transactions->get('amount'),
            "notes" => $transactions->get('notes'),
            "updated_at" => $transactions->get('updated_at'),
        ];
    }
}