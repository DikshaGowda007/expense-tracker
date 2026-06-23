<?php

namespace App\Modules\V1\Services\Transaction\Edit;

use App\Constants\CommonConstant;
use App\Http\Requests\V1\Transaction\Edit\TransactionRequest;
use App\Modules\V1\Transaction\Bo\Edit\TransactionDetailsBo;
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

    public function edit(TransactionDetailsBo $transactionDetailsBo)
    {
        try {
            $this->editTransactions();

            return ['status' => CommonConstant::SUCCESS, 'message' => 'Updated successfully'];
        } catch (Exception|\Throwable $e) {
            return ['status' => CommonConstant::ERROR, 'message' => $e->getMessage()];
        }
    }

    public function prepareBo(TransactionRequest $transactionRequest): TransactionDetailsBo
    {
        $this->transactionDetailsBo->setUserId($transactionRequest->get('jwtUser')['loggedin_user_id']);
        $this->transactionDetailsBo->setId($transactionRequest->input('id'));
        $this->transactionDetailsBo->setAmount($transactionRequest->input('amount'));
        $this->transactionDetailsBo->setCategoryId($transactionRequest->input('category_id'));
        $this->transactionDetailsBo->setNotes($transactionRequest->input('notes'));
        $this->transactionDetailsBo->setText($transactionRequest->input('text'));

        return $this->transactionDetailsBo;
    }

    public function prepareDAO(): TransactionDAO
    {
        $this->transactionDAO->setUserId($this->transactionDetailsBo->getUserId());
        $this->transactionDAO->setText($this->transactionDetailsBo->getText());
        $this->transactionDAO->setAmount($this->transactionDetailsBo->getAmount());
        $this->transactionDAO->setNotes($this->transactionDetailsBo->getNotes());
        $this->transactionDAO->setCategoryId($this->transactionDetailsBo->getCategoryId());

        return $this->transactionDAO;
    }

    private function editTransactions(): void
    {
        $id = $this->transactionDetailsBo->getId();
        $userId = $this->transactionDetailsBo->getUserId();
        $this->transactionRepository->updateByIdAndUserId($this->prepareDAO(), $id, $userId);
    }
}
