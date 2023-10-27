<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactUs;
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

    public function destroy(String $id)    {
        $contactUs = ContactUs::find($id);

        if (!$contactUs) {
            return response()->json(['error' => 'Record not found']);
        }

        $delete = $contactUs->delete();

        if ($delete) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['error' => 'Failed to delete record']);
        }
    }
}
