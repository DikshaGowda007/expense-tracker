<?php
namespace App\Modules\V1\Services\Transaction\Edit;

use App\Constants\CommonConstant;
use App\Http\Requests\V1\Transaction\Edit\TransactionRequest;
use App\Modules\V1\Transaction\Bo\Edit\TransactionDetailsBO;
use App\Repositories\DAO\V1\TransactionDAO;
use App\Repositories\V1\TransactionRepository;
use Exception;

class TransactionService
{
    public function __construct(private TransactionDetailsBo $transactionDetailsBO, private TransactionDAO $transactionDAO, private TransactionRepository $transactionRepository)
    {
    }
    public function edit(TransactionDetailsBO $transactionDetailsBO)
    {
        try {
            $this->editTransactions();
            return ['status' => CommonConstant::SUCCESS, 'message' => 'Updated successfully'];
        } catch (Exception | \Throwable $e) {
            return ['status' => CommonConstant::ERROR, 'message' => $e->getMessage()];
        }
    }

    public function prepareBo(TransactionRequest $transactionRequest): TransactionDetailsBO
    {
        $this->transactionDetailsBO->setUserId($transactionRequest->get('jwtUser')['loggedin_user_id']);
        $this->transactionDetailsBO->setId($transactionRequest->input('id'));
        $this->transactionDetailsBO->setAmount($transactionRequest->input('amount'));
        $this->transactionDetailsBO->setCategoryId($transactionRequest->input('category_id'));
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
        $this->transactionDAO->setCategoryId($this->transactionDetailsBO->getCategoryId());

        return $this->transactionDAO;
    }

    private function editTransactions(): void
    {
        $id = $this->transactionDetailsBO->getId();
        $userId = $this->transactionDetailsBO->getUserId();
        $this->transactionRepository->updateByIdAndUserId($this->prepareDAO(), $id, $userId);
    }
}