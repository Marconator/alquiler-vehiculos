<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at',
        'id'
    ];

    /**
    * Get the rent orders for the car.
    */
    public function rentOrders()
    {
      return $this->hasMany(RentOrders::class);
    }
}
