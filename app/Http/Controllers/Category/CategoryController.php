<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\Categories\CategoryStoreRequest;
use App\Http\Requests\Categories\CategoryUpdateRequest;
use App\Http\Resources\Categories\CategoryCollection;
use App\Http\Resources\Categories\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return CategoryCollection::collection(Category::paginate(20));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\Categories\CategoryStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryStoreRequest $request)
    {
        $category = Category::create($request->all());
        return new CategoryResource($category);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return new CategoryResource($category);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\Categories\CategoryUpdateRequest  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryUpdateRequest $request, Category $category)
    {
        // if ($request->has('name')) {
        //     $category->name = $request->name;
        // }
        // if ($request->has('description')) {
        //     $category->description = $request->description;
        // }
        // $category->fill($request->only(['name', 'description']));
        // $category->save();
        $category->update($request->all());
        return new CategoryResource($category);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return new CategoryResource($category);
    }
}
