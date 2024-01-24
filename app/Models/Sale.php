<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Akaunting\Money\Money;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = ['quantity', 'unit_cost', 'selling_price'];
    protected $appends = ['selling_price_formatted'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    protected function getSellingPriceFormattedAttribute(): string
    {
        return Money::GBP($this->selling_price, true)->format();
    }
}
