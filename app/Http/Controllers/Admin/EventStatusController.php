<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\NotifyEventUser;
use App\Models\Event;
use App\Services\Fcm;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EventStatusController extends Controller
{


    public function __invoke(Request $request)
    {
        $event = $request->id;
        $event = Event::find($event);

        $updatedStatus = ($event->is_approved == 1) ? 0 : 1;

        $updated = $event->update([
            'is_approved' => $updatedStatus,
        ]);

        // dd($event);
        try {
            // dd($event);
           NotifyEventUser::dispatch($updatedStatus, $event);
        } catch (Exception $e) {
            Log::info($e);
        }

        // $fcm = new Fcm();
        // $fcm->sendBroadcastNotification('Event status updated', 'The event has been approved.');

        return response()->json(['success' => true]);
    }
}
