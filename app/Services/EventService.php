<?php

namespace App\Services;

use App\Http\Requests\Admin\Event\Status;
use App\Http\Requests\Company\AddEvent;
// use Plank\Mediable\MediaUploader;
use Plank\Mediable\Media;
use Plank\Mediable\Mediable;
use App\Models\Event;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Plank\Mediable\Facades\MediaUploader;


class EventService
{

    public function collection()
    {
        $user = Auth::user();
        if (isset($user)) {
            if (Auth::user()->role->firstWhere('name', config('site.roles.company'))) {
                $events = Event::latest()->where('company_id', '=', Auth::user()->company->id)->get();
                return $events;
            } else {
                $events = Event::latest()->get();
                return $events;
            }
        } else {
            $events = Event::latest()->get();
            return $events;
        }
    }


    public function store(AddEvent $request)
    {

        $validated = $request->validated();
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
            'location' => $validated['location'],
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

    public function update(AddEvent $request, Event $event)
    {
        // dd( $request);
       
        $validated = $request->validated();

        $event->update([
            'name' => $validated['name'],
            'city_id' => $validated['city_id'],
            'category_id' => $validated['category_id'],
            'description' => $validated['description'],
            'available_seat' => $validated['available_seat'],
            'venue' => $validated['venue'],
            'location' => $validated['location'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'ticket' => $validated['ticket'],
            'event_date' => $validated['event_date'],
            
        ]);


        
        if ($request->hasFile('banner')) {
            $bannerMedia = $event->getMedia('banner')->first();

            if ($bannerMedia) {
                // Replace the 'banner' media with the new file
                MediaUploader::fromSource($request->file('banner'))
                    ->replace($bannerMedia);

                // Optionally, you can also update the media's attributes if needed
                $event->syncMedia($bannerMedia, 'banner');
            }
        }
        // dd('event updated by the company');
        
    }

    public function chnagestatus(Status $request, Event $event)
    {
        $validated = $request->validated();

        $event->update([
            'is_approved' => $validated['is_approved'],
        ]);
    }
}
