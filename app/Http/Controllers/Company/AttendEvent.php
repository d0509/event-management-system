<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Http\Requests\AttendEvent\Create;
use App\Models\Event;
use App\Services\AttendEventService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendEvent extends Controller
{
    protected $attendService;

    public function __construct(AttendEventService $attendService)
    {
        $this->attendService = $attendService;
    }


    public function index(Request $request)
    {
        if ($request->ajax()) {
            $userBookings =  $this->attendService->collection();
            return $userBookings;
        }
        return view('backend.pages.attend-event.index');
    }

    public function create()
    {
        $todayEvents  =  Event::where('company_id', Auth::user()->company->id)->where('event_date', Carbon::now()->format('Y-m-d'))->select('id', 'name')->get();
        return view('backend.pages.attend-event.create', ['todayEvents' => $todayEvents]);
    }

    public function store(Create $request)
    {
        return $this->attendService->attend($request);
    }
}
