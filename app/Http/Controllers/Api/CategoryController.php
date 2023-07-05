<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    protected CategoryService $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }
    

    public function allCategory()
    {
        $data = $this->categoryService->allCategory();
        $formatedData = CategoryResource::collection($data);
        return $this->successResponse($formatedData, 'All Category data Show', 200);
    }
    
    public function singleCategory(Category $category)
    {
        $formatedData = new CategoryResource($category);
        return $this->successResponse($formatedData, 'Single Category data Show', 200);
    }

    public function store(CategoryRequest $request)
    {
        try{
            $data = $this->categoryService->store($request);
            return $this->successResponse($data, 'Category Store Successfully', 200);
           
        }catch(\Exception $e ){
            Log::error($e);
            return $this->errorResponse();
        }
    }

    public function update(Category $category, CategoryRequest $request)
    {
        $data = $this->categoryService->update($category, $request);
        return $this->successResponse($data, 'Category Update Successfully', 200);
    }

    public function delete(Category $category)
    {
        $data = $this->categoryService->delete($category);
        return $this->successResponse($data, 'Category Delete Successfully', 200);
    }
}
