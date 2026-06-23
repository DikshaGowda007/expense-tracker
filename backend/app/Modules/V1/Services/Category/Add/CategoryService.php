<?php

namespace App\Modules\V1\Services\Category\Add;

use App\Constants\CommonConstant;
use App\Http\Requests\V1\Category\Add\CategoryRequest;
use App\Modules\V1\Services\Category\Add\Bo\CategoryDetailsBo;
use App\Repositories\DAO\V1\CategoryDAO;
use App\Repositories\V1\CategoryRepository;
use Exception;

class CategoryService
{
    public function __construct(
        private CategoryDetailsBo $categoryDetailsBo,
        private CategoryDAO $categoryDAO,
        private CategoryRepository $categoryRepository
    ) {}

    public function add(CategoryDetailsBo $categoryDetailsBo)
    {
        try {
            $category = $this->addCategory();

            return ['status' => CommonConstant::SUCCESS, 'message' => $category.' added successfully'];
        } catch (Exception|\Throwable $e) {
            return ['status' => CommonConstant::ERROR, 'message' => $e->getMessage()];
        }
    }

    public function prepareBo(CategoryRequest $categoryRequest): CategoryDetailsBo
    {
        $this->categoryDetailsBo->setUserId($categoryRequest->get('jwtUser')['loggedin_user_id']);
        $this->categoryDetailsBo->setCategory($categoryRequest->input('category'));
        $categoryRequest->input('income') ? $this->categoryDetailsBo->setType(2) : $this->categoryDetailsBo->setType(1);

        return $this->categoryDetailsBo;
    }

    public function prepareDAO(): CategoryDAO
    {
        $this->categoryDAO->setName($this->categoryDetailsBo->getCategory());
        $this->categoryDAO->setType($this->categoryDetailsBo->getType());
        $this->categoryDAO->setUserId($this->categoryDetailsBo->getUserId());
        $this->categoryDAO->setStatus(CommonConstant::STATUS_ACTIVE);
        $this->categoryDAO->setIsDeleted(CommonConstant::IS_DELETED_NO);

        return $this->categoryDAO;
    }

    private function addCategory()
    {
        $category = $this->categoryRepository->insert($this->prepareDAO());

        return $category ? $category->name : throw new Exception('Insert failed');
    }
}
