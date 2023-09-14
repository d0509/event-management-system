<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Password\Change;
use App\Services\PasswordService;
use Illuminate\Http\Request;

class PasswordController extends Controller
{

    protected $passwordservice;

    public function __construct(PasswordService $passwordservice)
    {
        $this->passwordservice = $passwordservice;
    }

    public function edit(){
        return view('admin.auth.password');
    }

    public function update(Change $request){
        $this->passwordservice->update($request);
        if ($request->user()->role->firstWhere('name', 'admin')) {
            return redirect()->route('adminDashboard');
        } else if($request->user()->role->firstWhere('name', 'company')) {
            return redirect()->route('companyDashboard');
        }
    }
}
