<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Http\Requests\Seller\SellerProductStoreRequest;
use App\Http\Requests\Seller\SellerProductUpdateRequest;
use App\Http\Resources\Products\ProductCollection;
use App\Http\Resources\Products\ProductResource;
use App\Models\Product;
use App\Models\Seller;
use App\Models\User;
use App\Services\FilterAndSort\FilterAndSortFacade;
use App\Services\Pagination\PaginationFacade;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Expr\FuncCall;

class SellerProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Seller $seller, Product $product)
    {
        $products = $seller->products;

        $filteredAndSortedProducts = FilterAndSortFacade::apply($products, $product);
        $paginatedProducts = PaginationFacade::apply($filteredAndSortedProducts);

        return ProductCollection::collection($paginatedProducts);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\Seller\SellerProductStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SellerProductStoreRequest $request, User $seller)
    {
        $data = $request->all();
        $data['status']    = Product::UNAVAILABLE_PRODUCT;
        $data['image']     = $request->image->store('');
        $data['seller_id'] = $seller->id;
        $product = Product::create($data);
        return new ProductResource($product);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\Seller\SellerProductUpdateRequest  $request
     * @param  \App\Models\Seller  $seller
     * @return \Illuminate\Http\Response
     */
    public function update(SellerProductUpdateRequest $request, Seller $seller, Product $product)
    {
        if ($seller->id !== $product->seller_id) {
            return response([
                "message" => "Forbidden.",
                "errors" => [
                    "seller" => [
                        "The product can only be updated by the original Seller."
                    ]
                ]
            ], Response::HTTP_FORBIDDEN);
        }

        $product->fill($request->only([
            'name', 'description', 'quantity'
        ]));

        if ($request->has('status')) {
            $product->status = $request->status;

            if ($product->isAvailable() && $product->categories()->count() == 0) {
                return response([
                    'message' => 'Update conflict.',
                    'errors' => [
                        'category' => [
                            'An available product must belong to at least one Category.'
                        ]
                    ]
                ], Response::HTTP_CONFLICT);
            }
        }

        if ($request->has('image')) {
            Storage::delete($product->image);
            $product->image = $request->image->store('');
        }

        $product->save();
        return new ProductResource($product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Seller  $seller
     * @return \Illuminate\Http\Response
     */
    public function destroy(Seller $seller, Product $product)
    {
        if ($seller->id !== $product->seller_id) {
            return response([
                "message" => "Forbidden.",
                "errors" => [
                    "seller" => [
                        "The product can only be deleted by the original Seller."
                    ]
                ]
            ], Response::HTTP_FORBIDDEN);
        }

        $product->delete();
        Storage::delete($product->image);
        // ?? Don't need to delete image itself, since its only a soft delete
        return new ProductResource($product);
    }
}
