<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable =[
        'user_id',
        'name',
        'description',
        'address',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function event(){
        return $this->hasMany(Event::class);
    }

    public function booking(){
        return $this->hasMany(Booking::class);
    }
}
