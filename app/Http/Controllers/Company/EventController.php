<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Http\Requests\Company\AddEvent;
use App\Models\Event;
use App\Services\CategoryService;
use App\Services\CityService;
use App\Services\EventService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EventController extends Controller
{
    protected $cityservice;
    protected $eventservice;
    protected $categoryservice;

    public function __construct(CityService $cityservice, EventService $eventservice, CategoryService $categoryservice)
    {
        $this->cityservice = $cityservice;
        $this->eventservice = $eventservice;
        $this->categoryservice = $categoryservice;
    }


    public function index()
    {
        $events = $this->eventservice->index();
         
        // dd($events);
        return view('company.event.index',[
            'events' => $events
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $event = $this->cityservice->getAllCities();

        return view('company.pages.createEvent', [
            'cities' => $this->cityservice->getAllCities(),
            'categories' => $this->categoryservice->index()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddEvent $request)
    {
        // dd(5);
        $this->eventservice->store($request);

        return redirect()->route('event.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        return view('company.pages.createEvent',[
            'event' => $event,
            'cities' => $this->cityservice->getAllCities(),
            'categories' => $this->categoryservice->index(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AddEvent $request, Event $event)
    {
        // dd(3);
        $this->eventservice->update($request,$event);
        return redirect()->route('event.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->route('event.index');
    }
}
