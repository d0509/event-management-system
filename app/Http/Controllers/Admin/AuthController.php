<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\Login;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $authservice;

    Public function __construct(AuthService $authservice)
    {
        $this->authservice = $authservice;
        
    }

    public function login()
    {
        return view('admin.form.login');
    }

    public function signin(Login $request){
        $this->authservice->signin($request);

        if ($request->user()->role->firstWhere('name', 'admin')) {
            return redirect()->route('adminDashboard');
        } else {
            return redirect()->route('homepage');
        }
    }


}
