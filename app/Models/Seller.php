<?php

namespace App\Models;

use App\Scopes\SellerScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Seller extends User
{
    use HasFactory;
    // ? Need to override booted method, to assign a global scope
    protected static function booted()
    {
        static::addGlobalScope(new SellerScope);
    }
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
