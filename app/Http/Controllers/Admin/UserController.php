<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $users = $this->userService->collection();
            return $users;
        }
        return view('backend.pages.user.index');
    }

    public function show(User $user)
    {
        return view('backend.pages.user.show', [
            'user' => $user,
        ]);
    }
    
}
