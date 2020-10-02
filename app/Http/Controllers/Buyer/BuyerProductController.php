<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Http\Resources\Products\ProductCollection;
use App\Http\Resources\Products\ProductResource;
use App\Http\Resources\Transactions\TransactionCollection;
use App\Models\Buyer;
use App\Models\Transaction;
use Illuminate\Http\Request;

class BuyerProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Buyer $buyer)
    {
        return $product = ProductCollection::collection($buyer->transactions()->with('product')->get()->pluck('product'));
    }
}
