<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoleUser extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "role_user";

    public function user()
    {
        return $this->hasMany(Role::class);
    }

    public function role()
    {
        return $this->belongsToMany(User::class);
    }
}
