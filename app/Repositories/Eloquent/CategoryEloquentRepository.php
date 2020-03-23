<?php


namespace App\Repositories\Eloquent;


use App\Category;
use App\Repositories\Contracts\CategoryRepositoryInterface;

class CategoryEloquentRepository extends EloquentRepository implements CategoryRepositoryInterface
{

    /**
     * get Model
     * @return string
     */
    public function getModel()
    {
        return Category::class;
    }
}
