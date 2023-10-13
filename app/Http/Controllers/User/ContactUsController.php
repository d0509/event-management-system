<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactUs\Store;
use App\Services\ContactUsService;
use Illuminate\Http\Request;

class ContactUsController extends Controller
{
    protected $contactUsService;

    public function __construct(ContactUsService $contactUsService)
    {
        $this->contactUsService = $contactUsService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('User.pages.contact-us');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Store $request)
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Store $request)
    {
       
        $this->contactUsService->store($request);
        return redirect()->route('home');
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

    
    public function update(Request $request, string $id)
    {
        //
    }

   
    public function destroy(string $id)
    {
        //
    }
}
