<?php


namespace App\Services\Impl;

use App\Category;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Services\BaseService;
use App\Services\CategoryServiceInterface;

class CategoryService extends BaseService implements CategoryServiceInterface
{
    protected $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function getAll()
    {
       return $this->categoryRepository->getAll("name", "ASC");
    }

    public function create($request)
    {
        $category = new Category();
        $category->name = $request->name;
        $this->categoryRepository->create($category);
    }

    public function find($id)
    {
        return $this->categoryRepository->find($id);
    }

    public function findByName($name)
    {
        $id = null;

        try {
            $result = $this->categoryRepository->findByClauses([
                ['field' => 'name', 'value' => $name, 'operator' => '=']
            ]);

            if (isset($result)) {
                $first = $result->first();
                if (isset($first)) {
                    $id = $first->id;
                }
            }

        } catch (Exception $exception) {
            $id = null;
        }

        return $id;
    }

    public function delete($id)
    {
        $this->categoryRepository->delete($id);
    }

    public function update($request, $category)
    {
        $category->name = $request->name;
        $this->categoryRepository->update($category);
    }
}
