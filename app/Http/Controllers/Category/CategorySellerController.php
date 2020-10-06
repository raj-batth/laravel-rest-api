<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Http\Resources\Users\UserCollection;
use App\Models\Category;
use App\Models\Seller;
use App\Services\FilterAndSort\FilterAndSortFacade;
use App\Services\Pagination\PaginationFacade;

class CategorySellerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Category $category, Seller $seller)
    {
        $sellers = $category->products()
            ->with('seller')
            ->get()->pluck('seller')
            ->unique()
            ->values();
        $filteredAndSortedSellers = FilterAndSortFacade::apply($sellers, $seller);
        $paginatedSellers = PaginationFacade::apply($filteredAndSortedSellers);

        return UserCollection::collection($paginatedSellers);
    }
}
