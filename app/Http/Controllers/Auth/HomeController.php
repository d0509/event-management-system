<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Services\CityService;
use App\Services\EventService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $eventservice;
    protected $cityservice;

    public function __construct(EventService $eventservice,CityService $cityservice)
    {
        $this->eventservice=$eventservice;
        $this->cityservice = $cityservice;
    }

    public function index(){
        // dd('hello');
        $events = $this->eventservice->collection();
        $cities = $this->cityservice->collection();
        $city_id = request('city');
        // dd($city_id);
        // dd($cities);
        return view('User.pages.home',[
            'events' => $events,
            'cities' => $cities,
            'city_id' => $city_id
        ]);
    }   
}
