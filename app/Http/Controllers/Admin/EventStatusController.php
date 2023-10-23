<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Services\Fcm;
use Illuminate\Http\Request;

class EventStatusController extends Controller
{
   

    public function __invoke(Request $request)
    {
        $event = $request->id;
        $event = Event::find($event);

        $updatedStatus = ($event->is_approved == 1) ? 0 : 1;

        $event->update([
            'is_approved' => $updatedStatus,
        ]);

        $fcm = new Fcm();
        $fcm->sendBroadcastNotification('Event status updated', 'The event has been approved.');

        return response()->json(['success' => true]);
    }
}
