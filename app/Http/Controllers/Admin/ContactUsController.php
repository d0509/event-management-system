<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ContactUsService;
use Illuminate\Http\Request;

class ContactUsController extends Controller
{
    protected $contactUsService;

    public function __construct(ContactUsService $contactUsService)
    {
        $this->contactUsService = $contactUsService;
    }
   
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $user_bookings =  $this->contactUsService->collection();
            return $user_bookings;
        }

        return view('backend.pages.contact-us.index');
    }

    public function destroy(string $id)
    {
       $delete = $this->contactUsService->destroy($id);
        if ($delete) {
            session()->flash('success','Inquiry deleted successfully');
            return response()->json(['success' => true]);
        } 
    }
}
