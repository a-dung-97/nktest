<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Carbon\Carbon;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role', 'birthday', 'gender'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['password'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    public function isAdmin()
    {
        return $this->role == 'admin';
    }
    public function student()
    {
        return $this->hasOne('App\Student');
    }
    public function teacher()
    {
        return $this->hasOne('App\Teacher');
    }

    public function getRoleAttribute($value)
    {
        return $value == 1 ? 'admin' : ($value == 2 ? 'teacher' : 'student');
    }
    // public function getBirthdayAttribute($value)
    // {
    //     return Carbon::create($value)->format('d-m-Y');
    // }
    public function getLastNameAttribute()
    {
        $arr = explode(' ', $this->name);
        return $arr[count($arr) - 1];
    }
    public function hasRole($role)
    {
        return $role == $this->role ? true : false;
    }
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
