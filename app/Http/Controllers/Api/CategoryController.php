<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\CreateCategoryResquest;
use App\Services\CategoryServiceInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryServiceInterface $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        try {
            $categories = $this->categoryService->getAll();
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'data' => $categories
        ], 200);
    }

    public function store(CreateCategoryResquest $request)
    {
        try {
            $this->categoryService->create($request);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'message' => __('language.create_category_success')
        ], 200);
    }

    public function destroy($id)
    {
        try {
            $category = $this->categoryService->find($id);
            if (!$category) {
                return response()->json([
                    'status' => 'error',
                    'message' => __('language.can_not_find_category')
                ], 500);
            }
            $this->categoryService->delete($id);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'message' => __('language.delete_category_success')
        ], 200);
    }

    public function update(CreateCategoryResquest $request, $id)
    {
        try {
            $category = $this->categoryService->find($id);
            if (!$category) {
                return response()->json([
                    'status' => 'error',
                    'message' => __('language.can_not_find_category')
                ], 500);
            }
            $this->categoryService->update($request, $category);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'message' => __('language.update_category_success')
        ], 200);
    }
}
