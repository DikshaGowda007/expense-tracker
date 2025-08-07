<?php
namespace App\Http\Controllers;

use App\Constants\CommonConstant;
use App\Http\Requests\V1\Transaction\Add\TransactionRequest;
use App\Http\Requests\V1\Transaction\Edit\TransactionRequest as EditTransactionRequest;
use App\Http\Requests\V1\Transaction\Delete\TransactionRequest as DeleteTransactionRequest;
use App\Modules\V1\Services\Transaction\Add\TransactionService;
use App\Modules\V1\Services\Transaction\Get\TransactionService as GetTransactionService;
use App\Modules\V1\Services\Transaction\Edit\TransactionService as EditTransactionService;
use App\Modules\V1\Services\Transaction\Delete\TransactionService as DeleteTransactionService;
use App\Modules\V1\Services\Transaction\Get\CategoryTransactionService;
use Illuminate\Http\Request;

class TransactionController
{
    public function getTransaction(Request $request)
    {
        try {
            $userId = $request->get('jwtUser')['loggedin_user_id'];
            $transactionService = app(GetTransactionService::class);
            return response()->json($transactionService->get($userId));
        } catch (\Throwable $e) {
            return response()->json(['status' => CommonConstant::ERROR, 'message' => $e->getMessage()], 200);
        }
    }

    public function addTransaction(TransactionRequest $transactionRequest)
    {
        try {
            $transactionService = app(TransactionService::class);
            $transactionDetailsBo = $transactionService->prepareBo($transactionRequest);
            return response()->json($transactionService->add($transactionDetailsBo));
        } catch (\Throwable $e) {
            return response()->json(['status' => CommonConstant::ERROR, 'message' => $e->getMessage()], 200);
        }
    }

    public function editTransaction(EditTransactionRequest $editTransactionRequest)
    {
        try {
            $transactionService = app(EditTransactionService::class);
            $transactionDetailsBo = $transactionService->prepareBo($editTransactionRequest);
            return response()->json($transactionService->edit($transactionDetailsBo));
        } catch (\Throwable $e) {
            return response()->json(['status' => CommonConstant::ERROR, 'message' => $e->getMessage()], 200);
        }
    }

    public function deleteTransaction(DeleteTransactionRequest $deleteTransactionRequest)
    {
        try {
            $transactionService = app(DeleteTransactionService::class);
            $transactionDetailsBo = $transactionService->prepareBo($deleteTransactionRequest);
            return response()->json($transactionService->delete($transactionDetailsBo));
        } catch (\Throwable $e) {
            return response()->json(['status' => CommonConstant::ERROR, 'message' => $e->getMessage()], 200);
        }
    }

    public function getCategorySummary(Request $request)
    {
        try {
            $userId = $request->get('jwtUser')['loggedin_user_id'];
            $transactionService = app(CategoryTransactionService::class);
            return response()->json($transactionService->get($userId));
        } catch (\Throwable $e) {
            return response()->json(['status' => CommonConstant::ERROR, 'message' => $e->getMessage()], 200);
        }
    }
}