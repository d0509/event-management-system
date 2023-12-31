<?php

namespace App\Services;

use App\Http\Requests\Auth\Login;
use App\Http\Requests\Auth\Register;
use App\Http\Requests\Auth\ResetPassword;
use App\Http\Requests\Auth\ResetPasswordPost;
use App\Models\PasswordResetToken;
use App\Models\RoleUser;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Auth\Notifications\ResetPassword as NotificationsResetPassword;
use Illuminate\Support\Facades\Alert;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use Plank\Mediable\Facades\MediaUploader;

class AuthService
{


    public function signIn(Login $request)
    {
        // dd(redirect()->back());
        $validated = $request->safe()->only(['password', 'email']);

        $user = User::where('email', $request->email)->exists();

        if ($user) {
            $user = User::where('email', $request->email)->first();
            // dd($user);
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
            session()->flash('danger','User with such credential does not exist!');
        }
    }

    public function signup(Register $request)
    {
        // dd($request->file);
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

        $lastUserId = $user->id;
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

    public function resetPassword(ResetPassword $request)
    {
        $user = $request->validated();
        $user = User::where('email', $user['email'])->first();

        $token = Str::random(64);
        // dd($token);
        $existingRecord = PasswordResetToken::where('email', $request->email)->first();
        // dd($existingRecord->toArray());
        if ($existingRecord) {
            // Update the existing record with the new token and timestamp
            $existingRecord->update([
                'token' => $token,
                'created_at' => Carbon::now(),
                // 'email' => $existingRecord['email']
            ]);
        } else {
            // Create a new record
            PasswordResetToken::create([
                'email' => $request->email,
                'token' => $token,
                'created_at' => Carbon::now(),
            ]);
        }


        // $mail =  $user->notify(new NotificationsResetPassword($user['email'], $token));
        $mail =  $user->notify(new NotificationsResetPassword($token));

        if ($mail) {
            session()->flash('success', 'We have e-mailed your password reset link!');
        }
    }

    public function submitReset(ResetPasswordPost $request)
    {
        // dd($request->toArray());

        // $token = $request['token'];
        // dd($token);

        $user = PasswordResetToken::where('token', '=', $request->token)->first();

        $user_detail = User::where('email', $user['email'])->first();
        // dd($user_detail->toArray() );
        $password = Hash::make($request->password);
        // dd($password);

        $user_update = User::where('email', '=', $user->email)->update(['password' => $password]);


        if ($user_update == '1') {
            session()->flash('success', 'Password changed successfully');
        } else {
            session()->flash('danger', 'There are some issues in changing password');
        }
        // dd($user['email']);


    }
}
