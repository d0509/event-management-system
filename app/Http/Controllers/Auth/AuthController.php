<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\Auth\Login;
use App\Http\Requests\Auth\Register;
use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{

    public function login()
    {
        return view('Admin.form.login');
    }

    public function signin(Login $request): RedirectResponse
    {
        $validated = $request->safe()->only(['password', 'email']);
        if (!auth()->attempt($validated)) {
            throw ValidationException::withMessages([
                'email' => 'Your provided credentials could not be verified.'
            ]);
        } else {
            session()->regenerate();
            return redirect()->route('homepage');
        }
    }

    public function register()
    {
        $cities = City::all();
        return view('User.form.register', [
            'cities' => $cities
        ]);
    }

    public function signup(Register $request)
    {
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

        $user_role = UserRole::create([
            'user_id' => $lastUserId,
            'role_id' => '3'
        ]);

        auth()->login($user);

        return redirect()->route('homepage');
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->route('login');
    }

    public function companyRegisterForm()
    {
        return view('User.form.register', [
            'cities' => City::all()
        ]);
    }

    public function companyRegister(Register $request)
    {
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

        $user_role = UserRole::create([
            'user_id' => $lastUserId,
            'role_id' => '2'
        ]);

        auth()->login($user);

        return redirect()->route('homepage');
    }
}
