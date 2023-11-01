<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventStatusController extends Controller
{
    
    public function __invoke(Request $request)
    {
        $event = $request->id;
        $event = Event::find($event);
        $updatedStatus = ($event->is_approved == 1 ) ? 0 : 1;
       
        $event->update([
            'is_approved' => $updatedStatus,
        ]);

        return response()->json(['success' => true]);
    }
}
