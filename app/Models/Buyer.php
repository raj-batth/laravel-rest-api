<?php

namespace App\Models;

use App\Scopes\BuyerScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Buyer extends User
{
    use HasFactory;

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    // ? Need to override booted method, to assign a global scope
    protected static function booted()
    {
        static::addGlobalScope(new BuyerScope);
    }
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
