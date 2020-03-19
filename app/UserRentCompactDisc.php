<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserRentCompactDisc extends Model
{
    protected $table = 'user_rent_compact_discs';
    protected $primaryKey = 'id';
    protected $fillable = ['user_id', 'compact_disc_id', 'rent_date', 'return_date'];

    /**
     * Get user_rent_compact_disc associated with the cd
     */
    public function compactDisc(){
        return $this->hasOne('App\CompactDisc', 'compact_disc_id');
    }

    /**
     * Get user_rent_compact_disc record associated with the user
     */
    public function user(){
        return $this->hasOne('App\User', 'user_id');
    }
}
