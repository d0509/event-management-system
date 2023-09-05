<?php

namespace App\Services;

use App\Http\Requests\Auth\CompanyRegister;
use App\Http\Requests\Company\EditCompany;
use App\Models\Company;
use App\Models\RoleUser;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CompanyService
{

    public function getAllCompanies()
    {
        return Company::latest()->get();
    }

    public function storeByAdmin(CompanyRegister $request)
    {
        $validated = $request->validated();
        $validated['password'] = Hash::make($validated['password']);

        $user = User::create([
            'name' => $validated['name'],
            'password' => $validated['password'],
            'email' => $validated['email'],
            'city_id' => $validated['city_id'],
            'mobile_no' => $validated['mobile_no'],
            'status' =>  $validated['status'],
        ]);

        $lastUserId = $user->id;

        $company = Company::create([
            'user_id' => $lastUserId,
            'address' => $validated['address'],
            'description' => $validated['description'],
            'name' => $validated['company_name']
        ]);

        $user_role = RoleUser::create([
            'user_id' => $lastUserId,
            'role_id' => '2'
        ]);
    }

    public function updateByAdmin(EditCompany $request, Company $company)
    {
        $validated = $request->validated();

        $user = $company->user;
        // dd($validated);
        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'city_id' => $validated['city_id'],
            'mobile_no' => $validated['mobile_no'],
            'status' => $validated['status'],
        ]);


        $company->update([
            'address' => $validated['address'],
            'description' => $validated['description'],
            'name' => $validated['company_name']
        ]);
    }
}
