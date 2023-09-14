<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
    use SoftDeletes;
    use HasFactory;



    public function user(){
        return $this->hasMany(User::class);
    }

    public function event(){
        return $this->hasMany(Event::class);
    }
}
