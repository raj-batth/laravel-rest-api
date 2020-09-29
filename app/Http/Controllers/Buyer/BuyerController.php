<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Http\Resources\Users\UserCollection;
use App\Http\Resources\Users\UserResource;
use App\Models\Buyer;
use Illuminate\Http\Request;

class BuyerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // ! The user who has one or many transactions is a buyer, This "transactions" relation is defined on Buyer Model

        // ? Since we have defined scope for buyer model, its is always gonna get only buyers so need to get buyer through "transactions" relation
        // $buyers = Buyer::has('transactions')->get();
        // UserCollection::collection(User::paginate(20))

        return UserCollection::collection(Buyer::paginate(20));
    }

    /**
     * Display the specified resource.
     *
     * @param  Buyer $buyer
     * @return \Illuminate\Http\Response
     */
    public function show(Buyer $buyer)
    {
        // ! To get buyer I have defined a scope in BuyerScope, so that while getting a single buyer, it would return buyer not found.
        return new UserResource($buyer);
    }
}
