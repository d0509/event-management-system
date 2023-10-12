<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Password\Change;
use App\Services\PasswordService;
use Illuminate\Http\Request;

class PasswordController extends Controller
{

    protected $passwordService;

    public function __construct(PasswordService $passwordService)
    {
        $this->passwordService = $passwordService;
    }

    public function edit()
    {
        return view('User.auth.password');
    }

    public function update(Change $request)
    {
        $this->passwordService->update($request);
        return redirect()->route('homepage');
    }
}
