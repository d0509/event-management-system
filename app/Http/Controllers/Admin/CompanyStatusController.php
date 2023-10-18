<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyStatusController extends Controller
{
    public function __invoke(Request $request)
    {
        // dd($request);
        $company = $request->id;
        // dd($company);
        $company = Company::find($company);
        // dd($company->user->toArray());   
        $user = $company->user;
        // dd($user->status);
        $updatedStatus = ($user->status == config('site.status.pending')) ? config('site.status.approved') : config('site.status.pending');
    //    dd($updatedStatus);
        $user->update([
            'status' => $updatedStatus,
        ]);

        return response()->json(['success' => true]);
    }
}
