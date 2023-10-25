<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Coupon extends Model
{
    use HasFactory, SoftDeletes ;

    protected $table = 'coupon_codes';

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

}
