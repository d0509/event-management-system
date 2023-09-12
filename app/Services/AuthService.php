<?php
namespace App\Services;

use App\Http\Requests\Auth\Login;
use App\Http\Requests\Auth\Register;
use App\Http\Requests\Auth\ResetPassword;
use App\Models\RoleUser;
use App\Models\User;
use Illuminate\Support\Facades\Alert;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;


class AuthService{
    

    public function signin(Login $request){
        $validated = $request->safe()->only(['password', 'email']);
        if (!auth()->attempt($validated)) {
            throw ValidationException::withMessages([
                'email' => 'Your provided credentials could not be verified.'
            ]);
        }
    }

    public function signup(Register $request){
        $validated = $request->validated();
        $validated['password'] = Hash::make($validated['password']);

        $user = User::create([
            'name' => $validated['name'],
            'password' => $validated['password'],
            'email' => $validated['email'],
            'city_id' => $validated['city_id'],
            'mobile_no' => $validated['mobile_no'],
            'status' =>  'pending'
        ]);

        $lastUserId = $user->id;

        $user_role = RoleUser::create([
            'user_id' => $lastUserId,
            'role_id' => '3'
        ]);

        auth()->login($user);

        session()->flash('success', 'Login Successful. You have been logged in successfully.');

    }

    public function resetPassword(ResetPassword $request){
        $validated = $request->validated();
    }
}
