<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Event\Status;
use App\Models\Event;
use App\Services\CategoryService;
use App\Services\CityService;
use App\Services\EventService;
use Illuminate\Http\Request;

class EventController extends Controller
{

    protected $eventservice;
    protected $cityservice;
    protected $categoryservice;
    /**
     * Display a listing of the resource.
     */

    public function __construct(EventService $eventservice, CityService $cityservice, CategoryService $categoryservice)
    {
        $this->eventservice = $eventservice;
        $this->cityservice = $cityservice;
        $this->categoryservice = $categoryservice;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    
        return view(
            'admin.event.index',[
            'events' => $this->eventservice->index()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        return view('admin.event.edit',[
            'event' => $event,
            'cities' => $this->cityservice->getAllCities(),
            'categories' => $this->categoryservice->index(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update( Status $request, Event $event)
    {
        $this->eventservice->chnagestatus($request,$event);
        return redirect()->route('admin.event.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
