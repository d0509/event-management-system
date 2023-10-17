<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Event $event)
    {
        return view('frontend.pages.event-detail',[
            'event' => $event,
        ]);
    }

   public function edit(string $id)
    {
       
    }

   public function update(Request $request, string $id)
    {
        //
    }

   public function destroy(string $id)
    {
        //
    }
}
