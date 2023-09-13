<?php

namespace App\Models;

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
    use HasFactory;
    use SoftDeletes;
    use MediableMediable;

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
        'is_approved'
    ];

    // public function media()
    // {
    //     return $this->hasMany(Media::class);
    // }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    

    
    // use HasMedia;
}
