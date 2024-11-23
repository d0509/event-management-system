<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Services\CityService;
use App\Services\EventService;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;

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
        $this->eventService = new EventService();
        $this->cityService = new CityService();
    }

    public function index()
    {

        $events = $this->eventService->collection();
        $cities = $this->cityService->collection();
        $city_id = request('city');
        return view('frontend.pages.home', [
            'events' => $events,
            'cities' => $cities,
            'city_id' => $city_id,
            'available_locales' => self::$availableLocales,
        ]);
    }

    public function change(Request $request)
    {
        App::setLocale($request->lang);
        session()->put('locale', $request->lang);

        return redirect()->back();
    }
}
