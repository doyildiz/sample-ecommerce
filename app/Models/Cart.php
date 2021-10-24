<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    /**
     * @var string[]
     */
    protected $fillable = [
        'token',
        'customer_id',
        'total_price',
        'discounted_price',
    ];

    protected $table = 'cart';

    public function details()
    {
        return $this->hasMany(CartDetail::class, 'cart_id');
    }

}
