<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CouponCode extends Model
{
    use HasFactory, SoftDeletes ;

    protected $fillable = [
        'company_id',
        'code',
        'usable_count',
        'percentage',
        'start_date',
        'end_date'
    ];

    public function company(){
        return $this->belongsTo(Company::class);
    }

    public function event(){
        return $this->belongsToMany(Event::class);
    }

    public function booking(){
        return $this->belongsToMany(Booking::class);
    }

}
