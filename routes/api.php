<?php

use App\Http\Controllers\Buyer\BuyerCategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Buyer\BuyerController;
use App\Http\Controllers\Buyer\BuyerProductController;
use App\Http\Controllers\Buyer\BuyerSellerController;
use App\Http\Controllers\Buyer\BuyerTransactionController;
use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\Category\CategoryProductController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Seller\SellerController;
use App\Http\Controllers\Transaction\TransactionCategoryController;
use App\Http\Controllers\Transaction\TransactionController;
use App\Http\Controllers\Transaction\TransactionSellerController;
use App\Http\Controllers\User\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Buyers
Route::apiResource('buyers', BuyerController::class, ['only' => ['index', 'show']]);
Route::apiResource('buyers.categories', BuyerCategoryController::class, ['only' => ['index']]);
Route::apiResource('buyers.sellers', BuyerSellerController::class, ['only' => ['index']]);
Route::apiResource('buyers.products', BuyerProductController::class, ['only' => ['index']]);
Route::apiResource('buyers.transactions', BuyerTransactionController::class, ['only' => ['index']]);

// Categories
Route::apiResource('categories', CategoryController::class);
Route::apiResource('categories.products', CategoryProductController::class, ['only' => ['index']]);

// Products
Route::apiResource('products', ProductController::class, ['only' => ['index', 'show']]);

// Sellers
Route::apiResource('sellers', SellerController::class, ['only' => ['index', 'show']]);

// Transactions
Route::apiResource('transactions', TransactionController::class, ['only' => ['index', 'show']]);
Route::apiResource('transactions.categories', TransactionCategoryController::class, ['only' => ['index']]);
Route::apiResource('transactions.sellers', TransactionSellerController::class, ['only' => ['index']]);

// Users
Route::apiResource('users', UserController::class);
