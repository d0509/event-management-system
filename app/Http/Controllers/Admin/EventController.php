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

    public function __construct(EventService $eventservice, CityService $cityservice, CategoryService $categoryservice)
    {
        $this->eventservice = $eventservice;
        $this->cityservice = $cityservice;
        $this->categoryservice = $categoryservice;
    }

    public function index()
    {

        return view(
            'admin.event.index',
            [
                'events' => $this->eventservice->collection()
            ]
        );
    }
    
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    
    public function show(string $id)
    {
        //
    }

   public function edit(Event $event)
    {
        return view('admin.event.edit', [
            'event' => $event,
            'cities' => $this->cityservice->collection(),
            'categories' => $this->categoryservice->index(),
        ]);
    }

   public function update(Status $request, Event $event)
    {
        $this->eventservice->chnagestatus($request, $event);
        return redirect()->route('admin.event.index');
    }

    public function destroy(string $id)
    {
        //
    }
}
