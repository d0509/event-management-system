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
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    protected $cityService;
    protected $eventService;
    protected $categoryService;

    public function __construct(CityService $cityService, EventService $eventService, CategoryService $categoryService)
    {
        $this->cityService = $cityService;
        $this->eventService = $eventService;
        $this->categoryService = $categoryService;
    }


    public function index(Request $request)
    {
        if ($request->ajax()) {
            $user_bookings =  $this->eventService->companyCollection();
            return $user_bookings;
        }

        return view('company.event.index');
    }

    public function create()
    {
        $event = $this->cityService->collection();

        return view('company.pages.create-event', [
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
        // dd($event);
        return view('admin.event.show', [
            'event' => $event
        ]);
    }

    public function edit(Event $event)
    {
        if(Auth::user()->company->id == $event->company_id){
            return view('company.pages.create-event', [
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
        // dd(3);
        $this->eventService->update($request, $event);
        return redirect()->route('company.event.index');
    }

    public function destroy(Event $event)
    {
        $delete = $event->delete();
        if ($delete == true) {
            return response()->json(['success' => true]);
            // session()->flash('success', 'Event deleted successfully');
        } else {
            return response()->json('error');
        }
    }
}
