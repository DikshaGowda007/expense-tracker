<?php
namespace App\Repositories\V1;

use App\Models\Category;
use App\Repositories\DAO\V1\CategoryDAO;

interface CategoryRepository
{

    public function insert(CategoryDAO $categoryDAO): Category;
}