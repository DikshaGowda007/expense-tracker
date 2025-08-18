<?php

namespace App\Repositories\MySql\V1;

use App\Models\Category;
use App\Repositories\DAO\V1\CategoryDAO;
use App\Repositories\V1\CategoryRepository;
use Carbon\Carbon;

class CategoryRepositoryImpl implements CategoryRepository
{
    public function insert(CategoryDAO $categoryDAO): Category
    {
        $categoryDAO->setCreatedAt(Carbon::now()->format('Y-m-d H:i:s'));
        $categoryDAO->setUpdatedAt(Carbon::now()->format('Y-m-d H:i:s'));
        return Category::create($categoryDAO->toArray());
    }
}