<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Services\CityService;
use App\Services\EventService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $eventService;
    protected $cityService;

    private static $availableLocales = [
        'en' => 'English',
        'gu' => 'Gujarati',
    ];

    public function __construct()
    {
        $this->eventService=new EventService();
        $this->cityService = new CityService();
    }

    public function index(){
        // dd('hello');
       
                $events = $this->eventService->collection();
        $cities = $this->cityService->collection();
        $city_id = request('city');
        // dd($city_id);
        // dd($cities);
        return view('frontend.pages.home',[
            'events' => $events,
            'cities' => $cities,
            'city_id' => $city_id,
            'available_locales' =>self::$availableLocales,
        ]);
    }   
}
