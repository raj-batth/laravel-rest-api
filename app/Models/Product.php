<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model {
    use HasFactory;

    const AVAILABLE_PRODUCT = 'available'; 
    const UNAVAILABLE_PRODUCT = 'unavailable';      

    // All the filed to be massively assigned 
    protected $fillable = [
        'name',
        'description',
        'quantity',
        'status',
        'image',
        'seller_id'
    ];

    public function isAvailable() {
        return $this->status === Product::AVAILABLE_PRODUCT;
    }

    public function categories() {
        return $this->belongsToMany(Category::class);
    }

    public function seller(){
      return $this->belongsToMany(Seller::class);
    }

    public function transactions() {
        return $this->hasMany(Transaction::class);
    }
}
