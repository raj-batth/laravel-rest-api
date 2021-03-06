<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Resources\Transactions\TransactionCollection;
use App\Models\Product;
use App\Models\Transaction;
use App\Services\FilterAndSort\FilterAndSortFacade;
use App\Services\Pagination\PaginationFacade;
use Illuminate\Http\Request;

class ProductTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product, Transaction $transaction)
    {
        $transactions = $product->transactions;

        $filteredAndSortedTransactions = FilterAndSortFacade::apply($transactions, $transaction);
        $paginatedTransactions = PaginationFacade::apply($filteredAndSortedTransactions);
        
        return TransactionCollection::collection($paginatedTransactions);
    }
}
