<?php

namespace App\Services;

use App\Models\User;
use Yajra\DataTables\Facades\DataTables;

class UserService
{

    public function collection()
    {
         $data = User::select(['id','name', 'email', 'mobile_no', 'city_id', 'status'])->latest()->whereHas('role', function($q){
            return $q->where('name', 'user');
         });

        return DataTables::of($data)
            ->addColumn('action', function ($row) {
                $editUrl = route('admin.user.show', ['user' => $row->id]);
                $btn = '<a href="' . $editUrl . '" class="text-white w-3 btn btn-primary mr-2"> <i class="fa-solid fa-eye"></i></a>';
                return $btn;
            })
            ->addColumn('city_id', function ($row) {
                return $row->city->name;
            })
            ->setRowId('id')
            ->rawColumns(['city_id','action'])
            ->addIndexColumn()
            ->make(true);

        return true;
    }
}
