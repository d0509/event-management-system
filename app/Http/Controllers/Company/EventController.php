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
    protected $cityservice;
    protected $eventservice;
    protected $categoryservice;

    public function __construct(CityService $cityservice, EventService $eventservice, CategoryService $categoryservice)
    {
        $this->cityservice = $cityservice;
        $this->eventservice = $eventservice;
        $this->categoryservice = $categoryservice;
    }


    public function index(Request $request)
    {
        if ($request->ajax()) {
            $user_bookings =  $this->eventservice->companyCollection();
            return $user_bookings;
        }

        return view('company.event.index');
    }

    public function create()
    {
        $event = $this->cityservice->collection();

        return view('company.pages.createEvent', [
            'cities' => $this->cityservice->collection(),
            'categories' => $this->categoryservice->index()
        ]);
    }

    public function store(AddEvent $request)
    {
        $this->eventservice->store($request);

        return redirect()->route('company.event.index');
    }

    public function show(string $id)
    {
        
    }

    public function edit(Event $event)
    {
        if(Auth::user()->company->id == $event->company_id){
            return view('company.pages.createEvent', [
                'event' => $event,
                'cities' => $this->cityservice->collection(),
                'categories' => $this->categoryservice->index(),
            ]);
        } else {
            abort(404);
        }
    }

    public function update(AddEvent $request, Event $event)
    {
        // dd(3);
        $this->eventservice->update($request, $event);
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
