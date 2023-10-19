<?php

namespace App\Http\Controllers\User;

use App\Models\Event;
use App\Http\Controllers\Controller;

class EventController extends Controller
{
    public function show(Event $event)
    {
        return view('frontend.pages.event-detail',[
            'event' => $event,
        ]);
    }
}
