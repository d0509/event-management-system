<?php

namespace App\Services;

use App\Http\Requests\Auth\CompanyRegister;
use App\Http\Requests\Company\Add;
use App\Http\Requests\Company\EditCompany;
use App\Models\Company;
use App\Models\RoleUser;
use App\Models\User;
// use App\Notifications\CompanyRegistered;
use App\Notifications\CompanyUpdated;
use Illuminate\Support\Facades\Hash;

class CompanyService
{

    public function getAllCompanies()
    {
        return Company::latest()->get();
    }

    public function storeByAdmin(Add $request)
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

        // dd($request->toArray());

        // $user->notify(new CompanyRegistered($request));
        
    }

    public function updateByAdmin(EditCompany $request, Company $company)
    {
        $validated = $request->validated();

        $user = $company->user;
        // dd($validated);
        $updated_user = $user->update([
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

        $user->notify(new CompanyUpdated($company, $user));
    }

    public function registeredByCompany(CompanyRegister $request){
        $validated = $request->validated();
        $validated['password'] = Hash::make($validated['password']);

        $user = User::create([
            'name' => $validated['name'],
            'password' => $validated['password'],
            'email' => $validated['email'],
            'city_id' => $validated['city_id'],
            'mobile_no' => $validated['mobile_no'],
            'status' =>  'pending'
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

        auth()->login($user);
    }
}
