<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Resources\Users\UserCollection;
use App\Models\Buyer;
use App\Models\Product;
use App\Services\FilterAndSort\FilterAndSortFacade;
use App\Services\Pagination\PaginationFacade;
use Illuminate\Http\Request;

class ProductBuyerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product, Buyer $buyer)
    {
        $transactionsWithBuyers = $product->transactions()->with('buyer')->get();
        $buyers = $transactionsWithBuyers->pluck('buyer')->unique('id')->values();

        $filteredAndSortedBuyers = FilterAndSortFacade::apply($buyers, $buyer);
        $paginatedBuyers = PaginationFacade::apply($filteredAndSortedBuyers);

        return UserCollection::collection($paginatedBuyers);
    }
}
