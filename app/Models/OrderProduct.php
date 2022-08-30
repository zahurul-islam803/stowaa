<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{

    protected $guarded = ['id'];
    use HasFactory;
    function rel_to_product()
    {
        return $this->belongsTo(product::class, 'product_id');
    }
}
