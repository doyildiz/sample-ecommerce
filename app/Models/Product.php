<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'stock',
        'price'
    ];

    public function options()
    {
        return $this->hasMany(Option::class, 'product_id');
    }

    public function optionNames()
    {
        return $this->hasMany(Option::class, 'product_id')
            ->select('name')
            ->groupBy('name');
    }

    public function cart()
    {
        return $this->belongsTo(Cart::class,'product_id');
    }

}
