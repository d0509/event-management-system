<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Services\EventService;
use Illuminate\Http\Request;

class EventStatusController extends Controller
{

    public $eventService;

    public function __construct(EventService $eventService)
    {
        $this->eventService = $eventService;
    }
    
    public function __invoke(Request $request)
    {
        return $this->eventService->changeEventStatus($request);
    }
}
