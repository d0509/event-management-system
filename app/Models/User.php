<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Database\Eloquent\SoftDeletes;
use Plank\Mediable\Mediable;


class User extends Authenticatable implements CanResetPassword
{
    use HasApiTokens, HasFactory, Notifiable,SoftDeletes,Mediable;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'mobile_no',
        'city_id',
        'status',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function hasRole($role)
    {
        return $this->roles->contains('name', $role);
    }

    public function company()
    {
        return $this->hasOne(Company::class);
    }

    public function passwordResetToken()
    {
        return $this->hasOne(PasswordResetToken::class);
    }

    public function booking(){
        return $this->belongsToMany(Booking::class);
    }

    
}
