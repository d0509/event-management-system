<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Http\Requests\Company\AttendEvent as CompanyAttendEvent;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendEvent extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $todayEvent  =  Event::where('company_id',Auth::user()->company->id)->where('event_date',Carbon::now()->format('Y-m-d'))->select('id','name')->get();
        // dd($todayEvent->toArray());
        return view(
            'company.pages.attend-event',[
                'todayEvents' =>$todayEvent,
                
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('company.pages.attend-event');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CompanyAttendEvent $request)
    {
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
