<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Http\Resources\Users\UserCollection;
use App\Models\Category;
use Illuminate\Http\Request;

class CategorySellerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Category $category)
    {
        return UserCollection::collection($category->products()
            ->with('seller')
            ->get()->pluck('seller')
            ->unique()
            ->values());
    }
}
