<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Buyer\BuyerController;
use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Seller\SellerController;
use App\Http\Controllers\Transaction\TransactionController;
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

// Categories
Route::apiResource('categories', CategoryController::class);

// Products
Route::apiResource('products', ProductController::class, ['only' => ['index', 'show']]);

// Sellers
Route::apiResource('sellers', SellerController::class, ['only' => ['index', 'show']]);

// Transactions
Route::apiResource('transactions', TransactionController::class, ['only' => ['index', 'show']]);

// Users
Route::apiResource('users', UserController::class);
