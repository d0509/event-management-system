<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Http\Requests\Company\AddEvent;
use App\Services\CityService;
use App\Services\EventService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EventController extends Controller
{
    protected $cityservice;
    protected $eventservice;

    public function __construct(CityService $cityservice, EventService $eventservice)
    {
        $this->cityservice = $cityservice;
        $this->eventservice = $eventservice;
    }


    public function index()
    {
        $this->eventservice->index();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $event = $this->cityservice->getAllCities();

        return view('company.pages.createEvent', [
            'cities' => $this->cityservice->getAllCities()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddEvent $request)
    {
        // dd(3);
        $this->eventservice->store($request);

        return redirect()->route('event.store');
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
