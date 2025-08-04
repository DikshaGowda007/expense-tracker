<?php
namespace App\Modules\V1\Services\Transaction\Add;

use App\Constants\CommonConstant;
use App\Http\Requests\V1\Transaction\Add\TransactionRequest;
use App\Modules\V1\Transaction\Bo\Add\TransactionDetailsBO;
use App\Repositories\DAO\V1\TransactionDAO;
use App\Repositories\V1\TransactionRepository;
use Exception;

class TransactionService
{
    public function __construct(private TransactionDetailsBO $transactionDetailsBO, private TransactionDAO $transactionDAO, private TransactionRepository $transactionRepository)
    {
    }
    public function add(TransactionDetailsBO $transactionDetailsBO)
    {
        try {
            $transaction = $this->addTransactions();
            return ['status' => CommonConstant::SUCCESS, 'message' => $transaction . ' added successfully'];
        } catch (Exception | \Throwable $e) {
            return ['status' => CommonConstant::ERROR, 'message' => $e->getMessage()];
        }
    }

    public function prepareBo(TransactionRequest $transactionRequest): TransactionDetailsBO
    {
        $this->transactionDetailsBO->setUserId($transactionRequest->get('jwtUser')['loggedin_user_id']);
        $this->transactionDetailsBO->setAmount($transactionRequest->input('amount'));
        $this->transactionDetailsBO->setCategory($transactionRequest->input('category'));
        $this->transactionDetailsBO->setNotes($transactionRequest->input('notes'));
        $this->transactionDetailsBO->setText($transactionRequest->input('text'));

        return $this->transactionDetailsBO;
    }

    public function prepareDAO(): TransactionDAO
    {
        $this->transactionDAO->setUserId($this->transactionDetailsBO->getUserId());
        $this->transactionDAO->setText($this->transactionDetailsBO->getText());
        $this->transactionDAO->setAmount($this->transactionDetailsBO->getAmount());
        $this->transactionDAO->setNotes($this->transactionDetailsBO->getNotes());
        $this->transactionDAO->setCategoryId($this->transactionDetailsBO->getCategory());
        $this->transactionDAO->setStatus(CommonConstant::STATUS_ACTIVE);
        $this->transactionDAO->setIsDeleted(CommonConstant::IS_DELETED_NO);
        $this->transactionDAO->setCategoryId($this->transactionDetailsBO->getCategory());

        return $this->transactionDAO;
    }

    private function addTransactions()
    {
        $transaction = $this->transactionRepository->insert($this->prepareDAO());
        return $transaction ? $transaction->text : throw new Exception('Insert failed');
    }
}