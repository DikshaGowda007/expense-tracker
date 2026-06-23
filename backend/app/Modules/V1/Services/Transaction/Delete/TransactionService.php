<?php

namespace App\Modules\V1\Services\Transaction\Delete;

use App\Constants\CommonConstant;
use App\Http\Requests\V1\Transaction\Delete\TransactionRequest;
use App\Modules\V1\Transaction\Bo\Delete\TransactionDetailsBo;
use App\Repositories\DAO\V1\TransactionDAO;
use App\Repositories\V1\TransactionRepository;
use Exception;

class TransactionService
{
    public function __construct(
        private TransactionDetailsBo $transactionDetailsBo,
        private TransactionDAO $transactionDAO,
        private TransactionRepository $transactionRepository
    ) {}

    public function delete(TransactionDetailsBo $transactionDetailsBo)
    {
        try {
            $this->deleteTransactions();

            return ['status' => CommonConstant::SUCCESS, 'message' => 'Deleted successfully'];
        } catch (Exception|\Throwable $e) {
            return ['status' => CommonConstant::ERROR, 'message' => $e->getMessage()];
        }
    }

    public function prepareBo(TransactionRequest $transactionRequest): TransactionDetailsBo
    {
        $this->transactionDetailsBo->setUserId($transactionRequest->get('jwtUser')['loggedin_user_id']);
        $this->transactionDetailsBo->setId($transactionRequest->get('id'));

        return $this->transactionDetailsBo;
    }

    public function prepareDAO(): TransactionDAO
    {
        $this->transactionDAO->setId($this->transactionDetailsBo->getId());
        $this->transactionDAO->setStatus(0);
        $this->transactionDAO->setIsDeleted(1);

        return $this->transactionDAO;
    }

    private function deleteTransactions()
    {
        $id = $this->transactionDetailsBo->getId();
        $userId = $this->transactionDetailsBo->getUserId();
        $this->transactionRepository->updateByIdAndUserId($this->prepareDAO(), $id, $userId);
    }
}
