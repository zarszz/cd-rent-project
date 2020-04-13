<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserPayRent extends Model
{
    protected $table = 'user_pay_rent';
    protected $fillable = ['rent_id', 'total_payment', 'rental_duration', 'is_already_do_payment'];
    protected $primaryKey = 'id';

    /**
     * Get user_pay_rent record associated with user_rent_cd record in 1 to 1 relation
     */
    public function userRentCompactDisc()
    {
        return $this->hasOne('App\UserRentCompactDisc', 'rent_id');
    }
}
