<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Password\Update;
use App\Services\PasswordService;

class PasswordController extends Controller
{
    protected $passwordService;

    public function __construct(PasswordService $passwordService)
    {
        $this->passwordService = $passwordService;
    }

    public function edit()
    {
        return view('frontend.auth.password');
    }

    public function update(Update $request)
    {
        $this->passwordService->update($request);
        return redirect()->route('home');
    }
}
