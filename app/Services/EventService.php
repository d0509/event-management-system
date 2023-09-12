<?php

namespace App\Services;

use App\Http\Requests\Company\AddEvent;
// use Plank\Mediable\MediaUploader;
use Plank\Mediable\Media;
use Plank\Mediable\Mediable;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;
use Plank\Mediable\Facades\MediaUploader;


class EventService
{

    public function index()
    {
        // return[

        //     'events' =>  Event::latest()->get(),
        //     // 'media' => Media::where('directory', '=', 'banner')->get(),
        // ];
        return $event = Event::latest()->get();
        $media = $event->getMedia('banner');
        // dd($media->toArray());
        //   dd($events->toArray());
    }


    public function store(AddEvent $request)
    {
        // dd($request);
        $validated = $request->validated();
        // dd(Auth::user()->company->id);
        // dd('im in add event store');
        $event = Event::create([

            'name' => $validated['name'],
            'city_id' => $validated['city_id'],
            'category_id' => $validated['category_id'],
            'description' => $validated['description'],
            'available_seat' => $validated['available_seat'],
            'venue' => $validated['venue'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'ticket' => $validated['ticket'],
            'is_approved' => 0,
            'event_date' => $validated['event_date'],
            'company_id' => Auth::user()->company->id,
        ]);

        $event->save();
        // dd($event->toArray());

        // $media = new Media();

        // $media = MediaUploader::fromSource($request->file('thumbnail'))->upload();

        $media = MediaUploader::fromSource($request->file('banner'))
            ->toDisk('public')
            ->toDirectory('banner')
            ->upload();

        // $media->uploadMedia($request->file('banner'), 'public', 'banner');
        // dd($media->toArray());
        // $media->event_id = $event->id;
        // $media->save();
        // dd($event);
        // $event = new Event();
        $event->attachMedia($media, 'banner');
        $event->save();
        // $event->media()->save($media);

        return true;
    }
}
