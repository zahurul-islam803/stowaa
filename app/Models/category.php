<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Stripe\Product;

class category extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    function product()
    {
        return $this->belongsTo(Product::class, 'category_id');
    }
}
