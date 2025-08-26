<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\SaveProductRequest;
use App\Http\Resources\ProductResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $validated = $request->validate([
            'pagesize' => 'nullable|integer|min:1',
            'category' => ['nullable', Rule::exists('categories', 'id')],
            'search' => 'nullable|max:255'
        ]);

        $pageSize = $validated['pagesize'] ?? 10;

        $products = Product::select(['id', 'name', 'price', 'category_id', 'user_id', 'image'])
            ->with(['category:name,id', 'user:name,id']);

        if (isset($validated['category'])) {
            $products->where('category_id', $validated['category']);
        }

        if (isset($validated['search'])) {
            $products->search($validated['search']);
        }

        return ProductResource::collection($products->paginate($pageSize));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SaveProductRequest $request): ProductResource
    {
        $data = $request->validated();
        $data['file'] = $request->file('file')->store('app');
        $data['image'] = $request->file('image')->store('image', 'public');
        $data['user_id'] = $request->user()->id;

        return Product::create($data)
            ->toResource()
            ->additional(['message' => 'Product saved succesfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product): ProductResource
    {
        return $product->toResource()
            ->additional(['message' => 'Fetched product detail successfully']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SaveProductRequest $request, Product $product): ProductResource
    {
        $data = $request->validated();
        $data['user_id'] = $request->user()->id;

        if ($request->hasFile('file')) {
            $data['file'] = $request->file('file')->store('app');
            Storage::delete($product->file);
        }

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('image', 'public');
            Storage::delete($product->image);
        }

        $product->update($data);

        return $product->toResource()
            ->additional(['message' => 'Product saved succesfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product): JsonResponse
    {
        $product->delete();

        return response()->json(['message' => 'Product deleted successfully']);
    }
}
