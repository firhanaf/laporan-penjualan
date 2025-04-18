<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'customer_name',
        'product_name',
        'product_id',
        'quantity',
        'price',
        'capital',
        'total_price',
        'total_capital',
        'profit',
    ];

    // Definisikan relasi ke model Product
    public function product()
    {
        return $this->belongsTo(Product::class); // Berarti Order memiliki satu Product
    }
}
