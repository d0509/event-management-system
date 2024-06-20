<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Plank\Mediable\Mediable as MediableMediable;
use Spatie\QueryBuilder\QueryBuilder;

class Event extends Model 
{
    use HasFactory,SoftDeletes,MediableMediable;
    
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
    
    public function scopeFilter(Builder $query)
    {
        return QueryBuilder::for($query)
            ->allowedFilters('name', 'email')
            ->allowedSorts('name', 'created_at');
    }

  

   
}
