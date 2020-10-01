<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = ['deleted_at'];
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
