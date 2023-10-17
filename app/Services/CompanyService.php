<?php

namespace App\Services;

use App\Http\Requests\Admin\Event\Status;
use App\Http\Requests\Auth\CompanyRegister;
use App\Http\Requests\Company\Add;
use App\Http\Requests\Company\EditCompany;
use App\Models\Company;
use App\Models\Event;
use App\Models\RoleUser;
use App\Models\User;
use App\Notifications\CompanyRegistered;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Plank\Mediable\Facades\MediaUploader;
use Throwable;
use Yajra\DataTables\Facades\DataTables;

class CompanyService
{


    public function collection()
    {
        $data = Company::with(['user:id,name,status'])->select(['id', 'user_id', 'name', 'description', 'address']);
        return DataTables::of($data)
            ->addColumn('action', function ($row) {
                $editURL = route('admin.company.edit', ['company' => $row->id]);
                $btn = '<div class="d-flex"><a class="text-white w-3 btn btn-danger mr-2" onclick="deleteCompany('.$row->id.')" > <i class="fas fa-trash"></i></a><a href="' . $editURL . '" class="text-white w-3 btn btn-primary mr-2"> <i class="fa-solid fa-pen-to-square"></i></a></div>';
                return $btn;
            })
            ->addColumn('user_id',function($row){
               
                $status = $row->user->status;
               
                $condition = $status == config('site.status.approved') ? 'checked' : '';
                $switch = '
                <div class="form-check form-switch text-center " >
                <input class="form-check-input" type="checkbox" data-companyId="' . $row->id . '"  role="switch" id="flexSwitchCheckChecked" ' . $condition . '>
                <label class="form-check-label" for="flexSwitchCheckChecked"></label>
                </div>';
                return $switch;

            })
            ->orderColumn('name', function ($query, $order) {
                $query->orderBy('id', $order);
            })
            ->rawColumns(['name','action','user_id'])
            ->setRowId('id')
            ->addIndexColumn()
            ->make(true);

    }

    public function storeByAdmin(Add $request)
    {
        // dd($request->toArray());
        $validated = $request->validated();
        $validated['password'] = Hash::make($validated['password']);

        $user = User::create([
            'role_id' => config('site.roles.company'),
            'name' => $validated['name'],
            'password' => $validated['password'],
            'email' => $validated['email'],
            'city_id' => $validated['city_id'],
            'mobile_no' => $validated['mobile_no'],
            'status' =>  $validated['status'],
        ]);

        $lastUserId = $user->id;
        if ($request->hasFile('profile')) {
            $media = MediaUploader::fromSource($request->profile)
                ->toDisk('public')
                ->toDirectory('profile')
                ->upload();

            $user->attachMedia($media, 'profile');
        }
        $user->save();

        $company = Company::create([
            'user_id' => $lastUserId,
            'address' => $validated['address'],
            'description' => $validated['description'],
            'name' => $validated['company_name']
        ]);



        try {
            $user->notify(new CompanyRegistered($request));
            // session()->flash('success','Company is notified about their registeration by the admin');
        } catch (Exception $e) {
            // dd($e->message);
            // session()->flash('danger','Unfortunately we are not able to send mail to the company to let them know about their confirmation for registeration');
            Log::info($e);
        }
    }

    public function updateByAdmin(EditCompany $request, Company $company)
    {
        $validated = $request->validated();

        $user = $company->user;

        $updated_user = $user->update([
            'role_id' => config('site.roles.company'),
            'name' => $validated['name'],
            'email' => $validated['email'],
            'city_id' => $validated['city_id'],
            'mobile_no' => $validated['mobile_no'],
            'status' => $validated['status'],
        ]);


        $updated_company = $company->update([
            'address' => $validated['address'],
            'description' => $validated['description'],
            'name' => $validated['company_name']
        ]);

        // dd($user->toArray());

        // $user->notify(new CompanyUpdated($company, $user));
    }

    public function registeredByCompany(CompanyRegister $request)
    {
        $validated = $request->validated();
        $validated['password'] = Hash::make($validated['password']);

        $user = User::create([
            'role_id' => config('site.roles.company'),
            'name' => $validated['name'],
            'password' => $validated['password'],
            'email' => $validated['email'],
            'city_id' => $validated['city_id'],
            'mobile_no' => $validated['mobile_no'],
            'status' =>  'pending'
        ]);

        $media = MediaUploader::fromSource($request->profile)
            ->toDisk('public')
            ->toDirectory('profile')
            ->upload();

        $user->attachMedia($media, 'profile');
        $user->save();

        $lastUserId = $user->id;

        $company = Company::create([
            'user_id' => $lastUserId,
            'address' => $validated['address'],
            'description' => $validated['description'],
            'name' => $validated['company_name']
        ]);

        session()->flash('success', 'Your request is sent to the Admin. We will contact you shortly.');
    }
}
