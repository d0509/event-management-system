<?php

namespace App\Services;

use App\Models\RoleUser;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;

class UserService
{

    public function collection()
    {
         $data = User::select(['id','name', 'email', 'mobile_no', 'city_id', 'status'])->whereHas('role', function($q){
            return $q->where('name', 'user');
         });
        // dd($data);

        return DataTables::of($data)
            ->addColumn('action', function ($row) {
                // dd($row->id);
                $editUrl = route('admin.user.show', ['user' => $row->id]);
                $btn = '<a href="' . $editUrl . '" class="text-white w-3 btn btn-primary mr-2"> <i class="fa-solid fa-eye"></i></a>';
                // $btn .= '<a  href="#" class="text-white  btn btn-danger" onclick="event.preventDefault(); deleteCategory(' . $row->id . ');"> <i class="fa-sharp fa-solid fa-trash"></i></a>';
                return $btn;
            })
            ->addColumn('city_id', function ($row) {
                return $row->city->name;
            })
            ->setRowId('id')
            ->rawColumns(['city_id','action'])
            ->addIndexColumn()
            // ->toJson()
            ->make(true);

        return true;
    }
}
