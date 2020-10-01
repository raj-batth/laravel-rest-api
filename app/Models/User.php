<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $dates = ['deleted_at'];
    const VERIFIED_USER = 1;
    const UNVERIFIED_USER = 0;

    const ADMIN_USER = 1;
    const REGULAR_USER = 0;



    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'verified',
        'verification_token',
        'admin'
    ];

    protected $table = 'users';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'verification_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function setNameAttribute($name)
    {
        $this->attributes['name'] = strtolower($name);
    }
    public function getNameAttribute($name)
    {
        return ucwords($name);
    }
    public function setEmailAttribute($email)
    {
        $this->attributes['email'] = strtolower($email);
    }


    public function isVerified()
    {
        return $this->verified === USER::VERIFIED_USER;
    }
    public function isAdmin()
    {
        return $this->admin === USER::ADMIN_USER;
    }

    public static function generateVerification()
    {
        return Str::random(40);
    }
}
