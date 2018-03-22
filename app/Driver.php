<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Tymon\JWTAuth\Contracts\JWTSubject as AuthenticatableUserContract;

class Driver extends Model implements AuthenticatableContract, AuthorizableContract,  AuthenticatableUserContract
{
    use Authenticatable, Authorizable, CanResetPassword;
    protected $hidden = ['password', 'remember_token'];
    protected $table = 'drivers';
    protected $primaryKey  = 'staff_number'; //use staff number to authenticate instead id
    public $incrementing = false;
    
    public function getJWTIdentifier()
    {
        return $this->getKey(); // Eloquent model method
    }

    /**
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function assignedBus(){
        return $this->hasOne('App\Bus', 'driver_id', 'id');
    }
}
