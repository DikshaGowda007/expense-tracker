<?php
namespace App\Http\Controllers;

use App\Constants\CommonConstant;
use App\Http\Requests\V1\Category\Add\CategoryRequest;
use App\Modules\V1\Services\Category\Add\CategoryService;

class CategoryController
{
    public function addCategory(CategoryRequest $categoryRequest)
    {
        try {
            $CategoryService = app(CategoryService::class);
            $CategoryDetailsBo = $CategoryService->prepareBo($categoryRequest);
            return response()->json($CategoryService->add($CategoryDetailsBo));
        } catch (\Throwable $e) {
            return response()->json(['status' => CommonConstant::ERROR, 'message' => $e->getMessage()], 200);
        }
    }
}