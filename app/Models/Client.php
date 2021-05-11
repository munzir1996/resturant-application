<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'country',
        'job',
        'identity_no',
        'verified',
        'verification_code'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public const RESTAURANT_OWNER = 'صاحب المطعم';
    public const GENERAL_DIRECTOR = 'المدير العام';
    public const AUTHORIZED = 'مفوض';
    public const YES = 'yes';
    public const NO = 'no';

    /**
     * Get all of the resturants for the Client
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function resturants()
    {
        return $this->hasMany(Resturant::class);
    }

}





