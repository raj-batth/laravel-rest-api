<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Http\Resources\Transactions\TransactionCollection;
use App\Models\Seller;
use App\Models\Transaction;
use App\Services\FilterAndSort\FilterAndSortFacade;
use App\Services\Pagination\PaginationFacade;
use Illuminate\Http\Request;

class SellerTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Seller $seller, Transaction $transaction)
    {
        $productWithTransactions = $seller->products()->whereHas('transactions')->with('transactions')->get();
        $transactions = $productWithTransactions->pluck('transactions')->collapse();

        $filteredAndSortedTransactions = FilterAndSortFacade::apply($transactions, $transaction);
        $paginatedTransactions = PaginationFacade::apply($filteredAndSortedTransactions);

        return TransactionCollection::collection($paginatedTransactions);
    }
}
