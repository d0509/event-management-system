<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Password\Change;
use App\Services\PasswordService;

class PasswordController extends Controller
{
    protected $passwordService;
    
    public function __construct(PasswordService $passwordService)
    {
        $this->passwordService = $passwordService;
    }

    public function edit(){
        return view('backend.pages.auth.password');
    }

    public function update(Change $request){
        $this->passwordService->update($request);
        if ($request->user()->role->firstWhere('name', 'admin')) {
            return redirect()->route('admin.dashboard');
        } else if($request->user()->role->firstWhere('name', 'company')) {
            return redirect()->route('company.dashboard');
        }
    }
}
