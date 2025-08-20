<?php
namespace App\Modules\V1\Services\Transaction\Get;

use App\Constants\CommonConstant;
use App\Repositories\V1\TransactionRepository;
use Exception;
use Illuminate\Support\Collection;

class CategoryTransactionService
{
    public function __construct(private TransactionRepository $transactionRepository)
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
        $transactions = $this->transactionRepository->fetchCategoriesWithTransactionsByUserIdAndActiveStatus($userId);
        return $transactions->isNotEmpty() ? collect($transactions->toArray()) : collect([]);
    }

    private function formatResponse(Collection $transactionDetails): array|string
    {
        $transformed = [];
        $this->prepareTransactionData($transactionDetails, $transformed);
        return empty($transformed) ? 'No transactions found' : $transformed;
    }

    private function prepareTransactionData(Collection $transactionDetails, array &$transformed)
    {
        $formatted = $transactionDetails->map(function ($category) {
            return [
                'id' => $category['id'],
                'category' => $category['name'],
                'type' => $category['type'],
                'total_amount' => round(collect($category['transactions'])->pluck('amount')->sum(), 2),
                'transactions' => collect($category['transactions'])->map(function ($transaction) {
                    return [
                        'id' => $transaction['id'],
                        'text' => $transaction['text'],
                        'amount' => (float) $transaction['amount'],
                        'notes' => $transaction['notes'],
                        'updated_at' => $transaction['updated_at'],
                    ];
                })->toArray(),
            ];
        })->toArray();

        $transformed = array_merge($transformed, $formatted);
    }
}