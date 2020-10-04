<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Resources\Categories\CategoryCollection;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product)
    {
        $categories = $product->categories;
        return CategoryCollection::collection($categories);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @param  \App\Models\Category  $category
     */
    public function update(Product $product, Category $category)
    {
        // attach :(Allow duplicate), sync(removes old and new one), syncWithoutDetach(keep old and attach new one without duplicating it)
        // ? Only updating pivot table
        $product->categories()->syncWithoutDetaching([$category->id]);
        return CategoryCollection::collection($product->categories);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product, Category $category)
    {
        if (!$product->categories()->find($category->id)) {
            return response([
                'message' => 'Not found.',
                'errors' => [
                    'category' => [
                        'The specified category does not belong to this product.'
                    ]
                ]
            ], Response::HTTP_NOT_FOUND);
        }

        $product->categories()->detach($category->id);

        $categories = $product->categories;

        return CategoryCollection::collection($categories);
    }
}
