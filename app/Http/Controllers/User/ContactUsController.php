<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactUs\Create;
use App\Services\ContactUsService;
use Illuminate\Http\Request;

class ContactUsController extends Controller
{
    protected $contactUsService;

    public function __construct(ContactUsService $contactUsService)
    {
        $this->contactUsService = $contactUsService;
    }

    public function index()
    {
        return view('frontend.pages.contact-us');
    }
    
    public function store(Create $request)
    {
        $this->contactUsService->store($request);
        return redirect()->back();
    }
}
