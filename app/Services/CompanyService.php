<?php

namespace App\Services;

use Exception;
use App\Models\User;
use App\Models\Company;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use App\Notifications\CompanyRegistered;
use Plank\Mediable\Facades\MediaUploader;
use Illuminate\Support\Facades\Auth;

class CompanyService
{
    public function collection()
    {
        $data = Company::with(['user:id,name,status'])->select(['id', 'user_id', 'name', 'description', 'address'])->latest();
        return DataTables::of($data)
            ->addColumn('action', function ($row) {
                $editURL = route('admin.company.edit', ['company' => $row->id]);
                $btn = '<div class="d-flex"><a class="text-white w-3 btn btn-danger mr-2" onclick="deleteCompany(' . $row->id . ')" > <i class="fas fa-trash"></i></a><a href="' . $editURL . '" class="text-white w-3 btn btn-primary mr-2"> <i class="fa-solid fa-pen-to-square"></i></a></div>';
                return $btn;
            })
            ->addColumn('user_id', function ($row) {

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
            ->rawColumns(['name', 'action', 'user_id'])
            ->setRowId('id')
            ->addIndexColumn()
            ->make(true);
    }

    public function store($request)
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
            'status' => Auth::check() ? $validated['status'] : config('site.status.pending'),
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

        if (Auth::check() == false) {
            session()->flash('success', 'Your request is sent to the Admin. We will contact you shortly.');
        } elseif (Auth::user()->role->name == config('site.role_names.admin')) {
            try {
                $user->notify(new CompanyRegistered($request));
            } catch (Exception $e) {
                Log::info($e);
            }
        }
    }


    public function update($request,$company)
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
    }

    public function changeStatus($id)
    {
        $company = Company::where('id', $id)->with('user')->first();
        $updatedStatus = ($company->user->status == config('site.status.pending')) ? config('site.status.approved') : config('site.status.pending');
        $company->user->update([
            'status' => $updatedStatus,
        ]);

        return response()->json(['success' => true]);
    }
}
