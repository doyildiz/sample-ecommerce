<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartDetail extends Model
{
    use HasFactory;
    /**
     * @var string[]
     */
    protected $fillable = [
        'cart_id',
        'product_id',
        'option_id',
        'quantity',
        'unit_price',
        'total_price',
    ];

    protected $table = 'cart_details';

    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

    public function option()
    {
        return $this->hasOne(Option::class, 'id', 'option_id');
    }
}
