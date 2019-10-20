<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    const TABLE_NAME                = 'users';

    const FIELD_ID                  = 'id';
    const FIELD_NAME                = 'name';
    const FIELD_EMAIL               = 'email';
    const FIELD_EMAIL_VERIFIED_AT   = 'email_verified_at';
    const FIELD_PASSWORD            = 'password';
    const FIELD_REMEMBER_TOKEN      = 'remember_token';
    const FIELD_CREATED_AT          = 'created_at';
    const FIELD_UPDATED_AT          = 'updated_at';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        self::FIELD_NAME, self::FIELD_EMAIL, self::FIELD_PASSWORD,
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        self::FIELD_PASSWORD, self::FIELD_REMEMBER_TOKEN,
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        self::FIELD_EMAIL_VERIFIED_AT   => 'datetime',
    ];
}
