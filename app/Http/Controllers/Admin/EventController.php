<?php

namespace App\Http\Controllers\Admin;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Services\CityService;
use App\Services\EventService;
use App\Services\CategoryService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Event\Status;

class EventController extends Controller
{

    protected $eventService;
    protected $cityService;
    protected $categoryService;

    public function __construct(EventService $eventService, CityService $cityService, CategoryService $categoryService)
    {
        $this->eventService = $eventService;
        $this->cityService = new CityService();
        $this->categoryService = new CategoryService();
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $events  = $this->eventService->collection();
            return $events;
        }
        return view('backend.pages.event.company-index');
    }

    public function show(string $id)
    {
        $event =  $this->eventService->resource($id);
        return view('backend.pages.event.show', [
            'event' => $event
        ]);
    }

    public function edit(Event $event)
    {
        return view('backend.pages.event.edit', [
            'event' => $event,
            'cities' => $this->cityService->collection(),
            'categories' => $this->categoryService->index(),
        ]);
    }

    public function update(Status $request, Event $event)
    {
        $this->eventService->changeStatus($request, $event);
        return redirect()->route('admin.event.index');
    }

}
