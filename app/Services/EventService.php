<?php

namespace App\Services;

use App\Http\Requests\Admin\Event\Status;
use App\Http\Requests\Company\AddEvent;
// use Plank\Mediable\MediaUploader;
use Plank\Mediable\Media;
use Plank\Mediable\Mediable;
use App\Models\Event;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Plank\Mediable\Facades\MediaUploader;
use Yajra\DataTables\Facades\DataTables;

class EventService
{

    public function companyCollection()
    {
        // dd($data);
        $data = Event::with(['category:id,name', 'company:id,name', 'city:id,name'])->select(['id','company_id', 'city_id', 'name', 'category_id', 'description', 'available_seat', 'venue', 'event_date', 'start_time', 'end_time', 'ticket', 'is_free'])
            ->where('company_id', Auth::user()->company->id);
        // dd($data);
        return DataTables::of($data)
            ->addColumn('action', function ($row) {
                // dd($row);

                $showURL = route('company.event.show', ['event' => $row->id]);
                // dd($showURL);
                $editURL = route('company.event.edit', ['event' => $row->id]);
                $deleteURL = route('company.event.destroy', ['event' => $row->id]);
                $btn = '<div class="d-flex"><a href="' . $showURL . '" class="text-white w-3 btn btn-primary mr-2"> <i class="fa-solid fa-eye"></i></a><a href="' . $deleteURL . '" class="text-white w-3 btn btn-danger mr-2"> <i class="fas fa-trash"></i></a><a href="' . $editURL . '" class="text-white w-3 btn btn-primary mr-2"> <i class="fa-solid fa-pen-to-square"></i></a></div>';
              
                // $btn2 = '<a href="'.$downloadUrl.'" class="text-white w-3 btn btn-primary mr-2"> <i class="fas fa-download"></i></a>';
                // $btn .= '<a  href="#" class="text-white  btn btn-danger" onclick="event.preventDefault(); deleteCategory(' . $row->id . ');"> <i class="fa-sharp fa-solid fa-trash"></i></a>';
                return $btn;
            })
            ->orderColumn('name', function ($query, $order) {
                $query->orderBy('id', $order);
            })
            // ->addColumn('company_id',function($row){
            //     return $row->company->name;
            // })

            ->addColumn('category_id', function ($row) {
                return $row->category->name;
            })
            ->addColumn('event_date', function ($row) {
                // $event_date = $row->event_date;                
                return Carbon::parse($row->event_date)->format(config('site.date_format'));
            })
            ->addColumn('start_time', function ($row) {
                return Carbon::parse($row->start_time)->format(config('site.time_format'));
            })
            ->addColumn('end_time', function ($row) {
                return Carbon::parse($row->end_time)->format(config('site.time_format'));
            })
            ->rawColumns(['category_id', 'event_date', 'start_time', 'end_time', 'action'])
            // ->rawColumns(['action', 'event_id','company_id','city_id','category_id'])
            ->setRowId('id')
            ->addIndexColumn()

            ->make(true);

        return true;
    }

    public function collection()
    {


        $user = Auth::user();

        if (isset($user)) {
            if (Auth::user()->role->name == config('site.role_names.company')) {
                $events = Event::latest()->where('company_id', Auth::user()->company->id)->get();
                return $events;
            } elseif (Auth::user()->role->name == config('site.role_names.user')) {
                // dd(request('city'));
                if (request('city') && request('search')) {
                    $events = Event::latest()->where('city_id', request('select'))->where('name', 'like', '%' . request('search') . '%')->where('event_date', '>=', Carbon::now())->where('is_approved', 1)->get();
                    return $events;
                } elseif (request('search')) {
                    $events = Event::latest()->where('name', 'like', '%' . request('search') . '%')->where('is_approved', 1)->where('event_date', '>=', Carbon::now())->get();
                    return $events;
                } elseif (request('city')) {
                    // dd(request('city'));
                    $events = Event::latest()->where('is_approved', 1)->where('event_date', '>=', Carbon::now())->where('city_id', request('city'))->get();
                    return $events;
                } else {
                    $events = Event::latest()->where('is_approved', 1)->where('event_date', '>=', Carbon::now())->get();
                    return $events;
                }
            } else {
                $events = Event::latest()->get();
                return $events;
            }
        } else {
            // dd('im not logged in ');
            if (request('city') && request('search')) {
                $events = Event::latest()->where('city_id', request('select'))->where('name', 'like', '%' . request('search') . '%')->where('is_approved', 1)->get();
                return $events;
            } elseif (request('search')) {
                $events = Event::latest()->where('name', 'like', '%' . request('search') . '%')->where('event_date', '>=', Carbon::now())->where('is_approved', 1)->get();
                return $events;
            } elseif (request('city')) {
                $events = Event::latest()->where('is_approved', 1)->where('city_id', request('city'))->where('event_date', '>=', Carbon::now())->get();
                return $events;
            } else {
                // dd('i dont have any condition to show event');
                $events = Event::latest()->where('is_approved', 1)->where('event_date', '>=', Carbon::now())->get();
                // dd(Event::where('is_approved',1)->get()->toArray());
                return $events;
            }
        }
    }


    public function store(AddEvent $request)
    {

        $free = $request->ticket;

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
            'is_free' => $free == 0 ? 1 : 0,
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
