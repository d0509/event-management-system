<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function show(Event $event)
    {
        return view('frontend.pages.event-detail',[
            'event' => $event,
        ]);
    }
}
