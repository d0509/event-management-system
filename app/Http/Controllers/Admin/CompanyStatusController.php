<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;

class CompanyStatusController extends Controller
{
    public function __invoke(Request $request)
    {
        // dd($request->all());

        $company = $request->company_id;
        $company = Company::find($company);
        // dd($company->user->toArray());   
        $user = $company->user;
        // dd($user);
        $updatedStatus = ($request->status == 'pending') ? 'approved' : 'pending';
       
        $user->update([
            'status' => $updatedStatus,
        ]);

        return response()->json(['success' => true]);
    }
}
