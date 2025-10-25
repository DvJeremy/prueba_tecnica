<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /*
    Relación: un usuario tiene muchas órdenes
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}