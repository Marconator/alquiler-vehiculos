<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Car;
use App\Models\User;

class RentOrders extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'car_id',
        'starting_date',
        'ending_date'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'user_id',
        'created_at',
        'updated_at'
    ];

    /**
    * Get the car that owns the rent order.
    */
    public function user()
    {
      return $this->belongsTo(User::class);
    }

    /**
    * Get the user that owns the rent order.
    */
    public function car()
    {
      return $this->belongsTo(Car::class);
    }
}
