<?php

namespace App\Modules\V1\Services\Transaction\Add;

use App\Constants\CommonConstant;
use App\Http\Requests\V1\Transaction\Add\TransactionRequest;
use App\Modules\V1\Transaction\Bo\Add\TransactionDetailsBo;
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

    public function add(TransactionDetailsBo $transactionDetailsBo)
    {
        try {
            $transaction = $this->addTransactions();

            return ['status' => CommonConstant::SUCCESS, 'message' => $transaction.' added successfully'];
        } catch (Exception|\Throwable $e) {
            return ['status' => CommonConstant::ERROR, 'message' => $e->getMessage()];
        }
    }

    public function prepareBo(TransactionRequest $transactionRequest): TransactionDetailsBo
    {
        $this->transactionDetailsBo->setUserId($transactionRequest->get('jwtUser')['loggedin_user_id']);
        $this->transactionDetailsBo->setAmount($transactionRequest->input('amount'));
        $this->transactionDetailsBo->setCategory($transactionRequest->input('category'));
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
        $this->transactionDAO->setCategoryId($this->transactionDetailsBo->getCategory());
        $this->transactionDAO->setStatus(CommonConstant::STATUS_ACTIVE);
        $this->transactionDAO->setIsDeleted(CommonConstant::IS_DELETED_NO);
        $this->transactionDAO->setCategoryId($this->transactionDetailsBo->getCategory());

        return $this->transactionDAO;
    }

    private function addTransactions()
    {
        $transaction = $this->transactionRepository->insert($this->prepareDAO());

        return $transaction ? $transaction->text : throw new Exception('Insert failed');
    }
}
