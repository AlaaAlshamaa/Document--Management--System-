<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Models\Category;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\CommentResource;
use App\Http\Resources\DocumentResource;
use App\Http\Traits\ApiResponseTrait;
use Illuminate\Support\Facades\Cache;

class CategoryController extends Controller
{
    use ApiResponseTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Cache::remember('categories', 60, function () {
            return Category::all();
        });
        $data = CategoryResource::collection($categories);
        return $this->customeResponse($data, 'Done!', 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $category = Category::create([
            'name' => $request->name,
        ]);
        $data = new CategoryResource($category);
        return $this->customeResponse($data, 'Created Successfully', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        $data['category']          = new CategoryResource($category);
        $data['category_comments'] =  CommentResource::collection($category->comments);
        $data['documents']         =  DocumentResource::collection($category->documents);
        return $this->customeResponse($data, 'Done!', 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $category->name = $request->input('name') ?? $category->name;
        $category->save();

        $data = new CategoryResource($category);
        return $this->customeResponse($data, 'Successfully Updated', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return response()->json(['message' => 'Deleted'], 200);
    }

}
