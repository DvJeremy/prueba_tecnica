<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /*
    Relación: un producto pertenece a muchas órdenes (a través de la tabla pivote)
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_product')->withPivot('quantity', 'subtotal');
    }
}