<?php

namespace App\Services;

use Carbon\Carbon;
use App\Http\Requests\Auth\Login;
use App\Http\Requests\Auth\Register;
use App\Http\Requests\Auth\ForgotPassword;
use App\Models\PasswordResetToken;
use App\Models\User;
use App\Notifications\ResetPassword as AppNotificationsResetPassword;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Plank\Mediable\Facades\MediaUploader;

class AuthService
{
    public function signIn(Login $request)
    {
        $validated = $request->safe()->only(['password', 'email']);
        $user = User::where('email', $request->email)->exists();

        if ($user) {
            $user = User::where('email', $request->email)->first();
            if ($user->status == 'approved') {
                if (!Auth::attempt($validated)) {
                    throw ValidationException::withMessages([
                        'email' => 'Your provided credentials could not be verified.'
                    ]);
                }
            } else {
                session()->flash('danger', 'You are not approved by the Admin. To login please contact admin');
            }
        } else {
            session()->flash('danger', 'User with such credential does not exist!');
        }
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
            'status' =>  config('site.status.approved'),
            'role_id' => config('site.roles.user')
        ]);

        if ($request->hasFile('profile')) {
            $media = MediaUploader::fromSource($request->profile)
                ->toDisk('public')
                ->toDirectory('profile')
                ->upload();

            $user->attachMedia($media, 'profile');
        }
        $user->save();
        Auth::login($user);
        session()->flash('success', ' You have been logged in successfully.');
    }

    public function resetPassword(ForgotPassword $request)
    {
        $user = $request->validated();
        $user = User::where('email', $user['email'])->first();
        $token = Str::random(64);
        $existingRecord = PasswordResetToken::where('email', $request->email)->first();
        if ($existingRecord) {
            $existingRecord->update([
                'token' => $token,
                'created_at' => Carbon::now(),
            ]);
        } else {
            PasswordResetToken::create([
                'email' => $request->email,
                'token' => $token,
                'created_at' => Carbon::now(),
            ]);
        }
        $mail =  $user->notify(new AppNotificationsResetPassword($token, $request->email));

        if ($mail) {
            session()->flash('success', 'We have e-mailed your password reset link!');
        }
    }

    public function submitReset($request)
    {
        $user = PasswordResetToken::where('email', $request->token)->first();

        $password = Hash::make($request->password);
        if ($user) {
            $user_update = User::where('email', $user->email)->update(['password' => $password]);

            if ($user_update == '1') {
                session()->flash('success', 'Password changed successfully');
            } else {
                session()->flash('danger', 'There are some issues in changing password');
            }
        }
        else {
            session()->flash('error','User not found');
        }       
    }
}
