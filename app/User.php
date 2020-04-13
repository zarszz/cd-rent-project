<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Model implements AuthenticatableContract, AuthorizableContract, JWTSubject
{
    use Authenticatable, Authorizable;

    protected $table = 'users';
    protected $primaryKey = 'id';

    /**
     * The attributes assignable.
     * @var array
     */
    protected $fillable = ['username', 'email', 'password', 'first_name', 'last_name', 'address'];

    /**
     * The attributes excluded from model JSON
     */
    protected $hidden = ['password'];

    /**
     * Set user to has many rent_compact_disc
     */
    public function userRentCompactDisc()
    {
        return $this->hasMany('App\UserRentCompactDisc', 'id');
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containring any custom claims to added to the JWT
     *
     * @return array
     */
    public function getjwtCustomClaims()
    {
        return [];
    }
}
