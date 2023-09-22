<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\EventService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $eventservice;

    public function __construct(EventService $eventservice)
    {
        $this->eventservice=$eventservice;
    }

    public function index(){
        // dd('hello');
        $events = $this->eventservice->collection();
        return view('User.pages.events',[
            'events' => $events
        ]);
    }
}
