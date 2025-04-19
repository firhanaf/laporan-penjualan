<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'type',
        'total_capital',
        'print',
        'production',
        'packaging',
        'design_service',
        'packaging_service',
        'production_service',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class); // Berarti Product memiliki banyak Order
    }

    protected static function booted()
{
    static::saving(function ($product) {
        $product->service_fee = 
            $product->design_service + 
            $product->packaging_service + 
            $product->production_service;
    });
}
}
