<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        return CategoryResource::collection(Category::all(['id', 'name']))
            ->additional([
                'message' => 'Fetched list category successfully'
            ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): CategoryResource
    {
        $data = $request->validate([
            'name' => 'required|max:255|unique:categories'
        ]);

        return Category::create($data)
            ->toResource()
            ->additional([
                'message' => 'Category saved successfully'
            ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category): CategoryResource
    {
        return $category->toResource()
            ->additional([
                'message' => 'Fetched category detail successfully'
            ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name' => [
                'required',
                'max:255',
                Rule::unique('categories')->ignoreModel($category)
            ]
        ]);

        $category->update($data);

        return $category->toResource()
            ->additional([
                'message' => 'Category saved successfully'
            ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category): JsonResponse
    {
        $category->delete();

        return response()->json(['message' => 'Category deleted successfully']);
    }
}
