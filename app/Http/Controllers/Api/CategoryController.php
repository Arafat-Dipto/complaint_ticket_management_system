<?php

namespace App\Http\Controllers\Api;

use App\Repositories\Category\ICategoryRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CategoryController extends BaseController
{
    /**
     * __construct
     *
     * @param  ICategoryRepository $categoryRepository
     * @return void
     */
    public function __construct(
        private readonly ICategoryRepository $categoryRepository
    ) {
    }

    /**
     * Get category list
     *
     * @return JsonResponse
     */
    public function getCategoryList(): JsonResponse
    {
        $result = $this->categoryRepository->getAllCategories();

        return $this->success($result, "Category list retrieved successfully");
    }

    /**
     * Category create
     *
     * @return JsonResponse
     */
    public function categoryCreate(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string',
        ]);

        try {
            $result = $this->categoryRepository->create([
                'name'       => $request->name,
                'slug'       => Str::slug($request->name),
                'created_by' => Auth::id(),
            ]);
            return $this->success($result->toArray(), "Category created successfully");

        } catch (\Exception $e) {
            return $this->error('Error', [$e->getMessage()]);
        }
    }

    /**
     * Show category details
     *
     * @param  integer $id
     * @return JsonResponse
     */
    public function categoryDetails($id): JsonResponse
    {
        $result = $this->categoryRepository->findFirstBy('id', $id);

        return $this->success($result->toArray(), "Category details retrieved successfully");

    }

    /**
     * Category update
     *
     * @param  int  $categoryId
     * @return JsonResponse
     */
    public function categoryUpdate(Request $request, int $categoryId): JsonResponse
    {
        try {
            $result = $this->categoryRepository->update($categoryId, [
                'name'       => $request->name,
                'slug'       => Str::slug($request->name),
                'updated_by' => Auth::id(),
            ]);
            return $this->success($result->toArray(), "Category updated successfully");

        } catch (\Exception $e) {
            return $this->error('Error', [$e->getMessage()]);
        }
    }

    /**
     * category delete
     *
     * @param  integer $id
     * @return JsonResponse
     */
    public function deleteCategory($id): JsonResponse
    {
        try {
            $category = $this->categoryRepository->find($id);
            if (!$category) {
                throw new \Exception("Category not found with ID: " . $id);
            }

            $this->categoryRepository->delete($id);

            return $this->success([], "Category deleted successfully");

        } catch (\Exception $e) {
            return $this->error('Error', [$e->getMessage()]);
        }
    }
}
