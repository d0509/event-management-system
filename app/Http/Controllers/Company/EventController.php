<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Http\Requests\Company\AddEvent;
use App\Models\Event;
use App\Services\CategoryService;
use App\Services\CityService;
use App\Services\EventService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    protected $cityService;
    protected $eventService;
    protected $categoryService;

    public function __construct(EventService $eventService)
    {
        $this->cityService = new CityService();
        $this->eventService = $eventService;
        $this->categoryService = new CategoryService();
    }


    public function index(Request $request)
    {
        if ($request->ajax()) {
            $user_bookings =  $this->eventService->collection();
            return $user_bookings;
        }

        return view('backend.pages.event.company-index');
    }

    public function create()
    {
        $event = $this->cityService->collection();

        return view('backend.pages.event.create', [
            'cities' => $this->cityService->collection(),
            'categories' => $this->categoryService->index()
        ]);
    }

    public function store(AddEvent $request)
    {
        $this->eventService->store($request);

        return redirect()->route('company.event.index');
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
        if(Auth::user()->company->id == $event->company_id){
            return view('backend.pages.event.create', [
                'event' => $event,
                'cities' => $this->cityService->collection(),
                'categories' => $this->categoryService->index(),
            ]);
        } else {
            abort(404);
        }
    }

    public function update(AddEvent $request, Event $event)
    {
        $this->eventService->update($request, $event);
        return redirect()->route('company.event.index');
    }

    public function destroy(Event $event)
    {
        $delete = $event->delete();
        if ($delete == true) {
            return response()->json(['success' => true]);
        } else {
            return response()->json('error');
        }
    }
}
