<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Booking extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'user_id',
        'event_id',
        'booking_number',
        'is_attended',
        'pdf_name',
        'total',
        'ticket_price',
        'sub_total',
        'discount',
        'type',
        'quantity',
        'total',
        'is_free_event'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function event(){
        return $this->belongsTo(Event::class);
    }

    public function company(){
        return $this->belongsTo(Company::class);
    }
}
