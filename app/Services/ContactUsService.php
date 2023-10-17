<?php

namespace App\Services;

use App\Http\Requests\ContactUs\Store;
use App\Models\ContactUs;
use App\Models\User;
use App\Notifications\ContactUsNotification;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class ContactUsService
{

    public function collection()
    {

        $data = ContactUs::select(['id', 'name', 'email', 'phone', 'message', 'created_at'])->with(['user']);
        // dd($data);

        return DataTables::of($data)
            ->addColumn('action', function ($row) {

                $ShowUrl = route('admin.contact-us.destroy', ['contact_u' => $row->id]);
                // $downloadUrl = route('admin.contact-us.destroy', ['contact_u' => $row->id]);
                $btn = '<a class="delete_contact" id="delete_target_'.$row->id.'" data-id="'.$row->id.'" onclick="deleteInquiries('.$row->id.')" class="text-white w-3 btn btn-danger mr-2"> <i class="fa-solid fa-trash"></i></a>';
                // $btn2 = '<a href="'.$downloadUrl.'" class="text-white w-3 btn btn-primary mr-2"> <i class="fas fa-download"></i></a>';
                // $btn .= '<a  href="#" class="text-white  btn btn-danger" onclick="event.preventDefault(); deleteCategory(' . $row->id . ');"> <i class="fa-sharp fa-solid fa-trash"></i></a>';
                return $btn;
            })


            ->rawColumns(['action'])
            ->setRowId('id')
            ->addIndexColumn()
            ->make(true);

        return true;
    }

    public function store(Store $request)
    {

        $validated = $request->validated();
        $contact_us = ContactUs::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'message' =>  $validated['message'],
            'user_id' => Auth::id(),
        ]);

        $user = User::find(1);
        // dd($user);

        $user->notify(new ContactUsNotification($contact_us));

        if ($contact_us->exists()) {
            session()->flash('success', 'Your request is sent to admin successfully');
        }
    }

    public function destroy(String $id)
    {
        return ContactUs::where('id', $id)->delete();
       
       
    }
}
