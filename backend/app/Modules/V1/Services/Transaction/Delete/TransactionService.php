<?php
namespace App\Modules\V1\Services\Transaction\Delete;

use App\Constants\CommonConstant;
use App\Http\Requests\V1\Transaction\Delete\TransactionRequest;
use App\Modules\V1\Transaction\Bo\Delete\TransactionDetailsBO;
use App\Repositories\DAO\V1\TransactionDAO;
use App\Repositories\V1\TransactionRepository;
use Exception;

class TransactionService
{
    public function __construct(private TransactionDetailsBo $transactionDetailsBO, private TransactionDAO $transactionDAO, private TransactionRepository $transactionRepository)
    {
    }
    public function delete(TransactionDetailsBO $transactionDetailsBO)
    {
        try {
            $this->deleteTransactions();
            return ['status' => CommonConstant::SUCCESS, 'message' => 'Deleted successfully'];
        } catch (Exception | \Throwable $e) {
            return ['status' => CommonConstant::ERROR, 'message' => $e->getMessage()];
        }
    }

    public function prepareBo(TransactionRequest $transactionRequest): TransactionDetailsBO
    {
        $this->transactionDetailsBO->setUserId($transactionRequest->get('jwtUser')['loggedin_user_id']);
        $this->transactionDetailsBO->setId($transactionRequest->get('id'));

        return $this->transactionDetailsBO;
    }

    public function prepareDAO(): TransactionDAO
    {
        $this->transactionDAO->setId($this->transactionDetailsBO->getId());
        $this->transactionDAO->setStatus(0);
        $this->transactionDAO->setIsDeleted(1);

        return $this->transactionDAO;
    }

    private function deleteTransactions()
    {
        $id = $this->transactionDetailsBO->getId();
        $userId = $this->transactionDetailsBO->getUserId();
        $this->transactionRepository->updateByIdAndUserId($this->prepareDAO(), $id, $userId);
    }
}