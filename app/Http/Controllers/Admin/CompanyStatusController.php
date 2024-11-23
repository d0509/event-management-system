<?php

namespace App\Http\Controllers\Admin;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CompanyStatusController extends Controller
{
    public function __invoke(Request $request)
    {
        $company = $request->id;
        $company = Company::find($company);
        $user = $company->user;
        $updatedStatus = ($user->status == config('site.status.pending')) ? config('site.status.approved') : config('site.status.pending');
        $user->update([
            'status' => $updatedStatus,
        ]);

        return response()->json(['success' => true]);
    }
}
