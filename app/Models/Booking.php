<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'user_id',
        'event_id',
        'booking_number',
        'is_attended',
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
}
