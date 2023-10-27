<?php

namespace App\Services;

use App\Http\Requests\Admin\Event\Status;
use App\Http\Requests\Company\AddEvent;
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

        $data = Event::with(['category:id,name', 'city:id,name'])->select(['events.*'])
            ->where('company_id', Auth::user()->company->id);
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $showURL = route('company.event.show', ['event' => $row->id]);
                $editURL = route('company.event.edit', ['event' => $row->id]);
                $deleteURL = route('company.event.destroy', ['event' => $row->id]);
                $btn = '<div class="d-flex"><a href="' . $showURL . '" class="text-white w-3 btn btn-primary delete_event mr-2"> <i class="fa-solid fa-eye"></i></a><a data-eventId="' . $row->id . '" onclick="deleteEvent(' . $row->id . ')" class="text-white w-3 btn btn-danger delete_event mr-2"> <i class="fas fa-trash"></i></a><a href="' . $editURL . '" class="text-white w-3 btn btn-primary mr-2"> <i class="fa-solid fa-pen-to-square"></i></a></div>';
                return $btn;
            })
            ->orderColumn('name', function ($query, $order) {
                $query->orderBy('id', $order);
            })

            ->addColumn('category_id', function ($row) {
                return $row->category->name;
            })
            ->addColumn('event_date', function ($row) {
                return Carbon::parse($row->event_date)->format(config('site.date_format'));
            })

            ->addColumn('start_time', function ($row) {
                return Carbon::parse($row->start_time)->format(config('site.time_format'));
            })
            ->addColumn('end_time', function ($row) {
                return Carbon::parse($row->end_time)->format(config('site.time_format'));
            })
            ->rawColumns(['category_id', 'event_date', 'start_time', 'end_time', 'action', 'category_id'])
            ->setRowId('id')
            ->addIndexColumn()
            ->make(true);

        return true;
    }

    public function collection()
    {
        $user = Auth::user();
        if (isset($user)) {
            if (Auth::user()->role_id == config('site.roles.company')) {
                $data = Event::with(['category:id,name', 'city:id,name'])->select(['events.*'])
                    ->where('company_id', Auth::user()->company->id);
                return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        $showURL = route('company.event.show', ['event' => $row->id]);
                        $editURL = route('company.event.edit', ['event' => $row->id]);
                        $deleteURL = route('company.event.destroy', ['event' => $row->id]);
                        $btn = '<div class="d-flex"><a href="' . $showURL . '" class="text-white w-3 btn btn-primary delete_event mr-2"> <i class="fa-solid fa-eye"></i></a><a data-eventId="' . $row->id . '" onclick="deleteEvent(' . $row->id . ')" class="text-white w-3 btn btn-danger delete_event mr-2"> <i class="fas fa-trash"></i></a><a href="' . $editURL . '" class="text-white w-3 btn btn-primary mr-2"> <i class="fa-solid fa-pen-to-square"></i></a></div>';
                        return $btn;
                    })
                    ->orderColumn('name', function ($query, $order) {
                        $query->orderBy('id', $order);
                    })

                    ->addColumn('category_id', function ($row) {
                        return $row->category->name;
                    })
                    ->addColumn('event_date', function ($row) {
                        return Carbon::parse($row->event_date)->format(config('site.date_format'));
                    })

                    ->addColumn('start_time', function ($row) {
                        return Carbon::parse($row->start_time)->format(config('site.time_format'));
                    })
                    ->addColumn('end_time', function ($row) {
                        return Carbon::parse($row->end_time)->format(config('site.time_format'));
                    })
                    ->rawColumns(['category_id', 'event_date', 'start_time', 'end_time', 'action', 'category_id'])
                    ->setRowId('id')
                    ->addIndexColumn()
                    ->make(true);

                return true;
            } elseif (Auth::user()->role_id == config('site.roles.user')) {
                if (request('city') && request('search')) {
                    if (request('city') == 'empty') {
                        $events = Event::where('is_approved', 1)->where('name', 'like', '%' . request('search') . '%')->where('event_date', '>=', Carbon::now()->toDateString())->latest()->get();
                        return $events;
                    } else {
                        $events = Event::latest()->where('city_id', request('city'))->where('name', 'like', '%' . request('search') . '%')->where('event_date', '>=', Carbon::now()->toDateString())->where('is_approved', 1)->get();
                        return $events;
                    }
                } elseif (request('search')) {
                    $events = Event::where('name', 'like', '%' . request('search') . '%')->where('is_approved', 1)->where('event_date', '>=', Carbon::now()->toDateString())->latest()->get();
                    return $events;
                } elseif (request('city')) {
                    if (request('city') == 'empty') {
                        $events = Event::where('is_approved', 1)->where('event_date', '>=', Carbon::now()->toDateString())->latest()->get();
                        return $events;
                    } else {
                        $events = Event::where('is_approved', 1)->where('event_date', '>=', Carbon::now()->toDateString())->where('city_id', request('city'))->latest()->get();
                        return $events;
                    }
                } else {
                    // dd(Auth::user()->city_id);
                    $events = Event::where('is_approved', 1)->where('city_id', Auth::user()->city_id)->where('event_date', '>=', Carbon::now()->toDateString())->latest()->get();
                    // dd($events);
                    return $events;
                }
            } else {
                $data = Event::select('events.*')->with(['city:id,name', 'company:id,name', 'category:id,name']);
                return DataTables::of($data)
                    ->setRowId('id')
                    ->orderColumn('name', function ($query, $order) {
                        $query->orderBy('id', $order);
                    })
                    ->addColumn('is_approved', function ($row) {
                        $condition = $row->is_approved == 1 ? 'checked' : '';
                        $switch = '
                        <div class="form-check form-switch text-center " >
                        <input class="form-check-input" type="checkbox" data-eventId="' . $row->id . '"  role="switch" id="flexSwitchCheckChecked" ' . $condition . '>
                        <label class="form-check-label" for="flexSwitchCheckChecked"></label>
                        </div>';
                        return $switch;
                    })
                    ->addColumn('action', function ($row) {
                        $showURL = route('admin.event.show', ['event' => $row->id]);
                        $btn = '<a href="' . $showURL . '" class="btn btn-primary" ><i class="fa-regular fa-eye"></i></a>';
                        return $btn;
                    })
                    ->addColumn('event_date', function ($row) {
                        return Carbon::parse($row->event_date)->format(config('site.date_format'));
                    })
                    ->addColumn('start_time', function ($row) {
                        return Carbon::parse($row->start_time)->format(config('site.time_format'));
                    })
                    ->addColumn('category_id', function ($row) {
                        return $row->category->name;
                    })
                    ->orderColumn('category_id', function ($query, $order) {
                        $query->orderBy('category_id', $order);
                    })
                    ->rawColumns(['name', 'event_date', 'start_time', 'is_approved', 'action', 'city_id', 'category_id'])
                    ->setRowId('id')
                    ->addIndexColumn()
                    ->make(true);
            }
        } else {
            if (request('city') && request('search')) {
                if (request('city') == 'empty') {
                    $events = Event::where('is_approved', 1)->where('name', 'like', '%' . request('search') . '%')->where('event_date', '>=', Carbon::now()->toDateString())->latest()->get();
                    return $events;
                } else {
                    $events = Event::latest()->where('city_id', request('city'))->where('name', 'like', '%' . request('search') . '%')->where('event_date', '>=', Carbon::now()->toDateString())->where('is_approved', 1)->get();
                    return $events;
                }
            } elseif (request('search')) {
                $events = Event::where('name', 'like', '%' . request('search') . '%')->where('is_approved', 1)->where('event_date', '>=', Carbon::now()->toDateString())->latest()->get();
                return $events;
            } elseif (request('city')) {
                if (request('city') == 'empty') {
                    $events = Event::where('is_approved', 1)->where('event_date', '>=', Carbon::now()->toDateString())->latest()->get();
                    return $events;
                } else {
                    $events = Event::where('is_approved', 1)->where('event_date', '>=', Carbon::now()->toDateString())->where('city_id', request('city'))->latest()->get();
                    return $events;
                }
            } else {
                // dd(Auth::user()->city_id);
                $events = Event::where('is_approved', 1)->where('event_date', '>=', Carbon::now()->toDateString())->latest()->get();
                // dd($events);
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

    public function changeStatus(Status $request, Event $event)
    {
        $validated = $request->validated();

        $event->update([
            'is_approved' => $validated['is_approved'],
        ]);
    }

    public function resource($id)
    {
        $event  = Event::find($id);
        // dd($event);
        return $event;
    }
}
