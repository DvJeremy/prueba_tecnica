<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens,HasFactory;

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