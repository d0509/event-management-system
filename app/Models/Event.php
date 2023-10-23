<?php

namespace App\Models;

use App\Notifications\EventApprovedNotification;
use Illuminate\Database\Eloquent\BroadcastsEvents;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Plank\Mediable\Models\MediableModel;
use Plank\Mediable\Contracts\Mediable;
use Plank\Mediable\Facades\MediaUploader;
use Plank\Mediable\Media;
use Plank\Mediable\Mediable as MediableMediable;

class Event extends Model 
{
    use HasFactory,SoftDeletes,MediableMediable,BroadcastsEvents;
    
    
    protected $fillable = [
        'city_id',
        'company_id',
        'name',
        'category_id',
        'description',
        'available_seat',
        'venue',
        'event_date',
        'start_time',
        'end_time',
        'ticket',
        'is_approved',
        'location'
    ];

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function city(){
        return $this->belongsTo(City::class);
    }

    public function company(){
        return $this->belongsTo(Company::class);
    }

    public function booking(){
        return $this->hasMany(Booking::class);    
    }

    public function scopeFilter($query, array $filters)
    {
        
        $query->when(
            $filters['search'] ??  false,
            fn ($query, $search) =>
            $query->where(
                fn ($query) =>
                $query->where('name', 'like', '%' . $search . '%')
                   
            )
        );
        $query->when(
            $filters['city'] ?? false,
            fn ($query, $city) =>
            $query->whereHas(
                'city',
                fn ($query) =>
                $query->where('', $city)
            )
        );       
    }

    public function sendUpdatedNotification()
    {
        $notification = new EventApprovedNotification($this);

        $this->notify($notification);
    }

   
}
