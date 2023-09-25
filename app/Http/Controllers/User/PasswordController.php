<?php

namespace App\Http\Controllers\User;

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

    public function edit()
    {
        return view('User.auth.password');
    }

    public function update(Change $request)
    {
        $this->passwordservice->update($request);
        return redirect()->route('homepage');
    }
}
