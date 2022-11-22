<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Ticket\Ticket;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles, SoftDeletes;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'username',
        'email',
        'password',
        'country',
        'gender',
        'timezone',
        'image',
        'contact',
        'userType',
        'status',
        'verified',
        'last_login_at',
        'last_login_ip',
        'company_id',
        'station_id',
        'station_name',
        'station_code',
        'station_street',
        'deleted_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'cust_id');
    }

    public function custsetting(){
        return $this->hasOne(CustomerSetting::class, 'custs_id', 'id');
    }

    public function customercustomsetting(){

        return $this->hasMany(senduserlist::class, 'tocust_id');
    }


}
