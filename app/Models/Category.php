<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description'
    ];

    public function products()
    {
        // This category has many to many relationship to production e.e A category has multiple products and vice versa.
        return $this->belongsToMany(Product::class);
    }
}
