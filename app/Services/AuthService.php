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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use Plank\Mediable\Facades\MediaUploader;

class AuthService
{


    public function signin(Login $request)
    {
        $validated = $request->safe()->only(['password', 'email']);
        if (!auth()->attempt($validated)) {
            throw ValidationException::withMessages([
                'email' => 'Your provided credentials could not be verified.'
            ]);
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
            'status' =>  'pending'
        ]);

        $lastUserId = $user->id;

        $media = MediaUploader::fromSource($request->profile)
            ->toDisk('public')
            ->toDirectory('profile')
            ->upload();

        $user->attachMedia($media, 'profile');
        $user->save();

        $user_role = RoleUser::create([
            'user_id' => $lastUserId,
            'role_id' => '3'
        ]);

        auth()->login($user);

        session()->flash('success', ' You have been logged in successfully.');
    }

    public function resetPassword(ResetPassword $request)
    {
        $user = $request->validated();
        // dd($user['email']);
        $user = User::where('email', $user['email'])->first();

        $token = Str::random(64);
        // dd($token);
        $existingRecord = PasswordResetToken::where('email', $request->email)->first();

        if ($existingRecord) {
            // Update the existing record with the new token and timestamp
            $existingRecord->update([
                'token' => $token,
                'created_at' => Carbon::now(),
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

        $user = DB::table('password_reset_tokens')
            ->where('token', '=', $request->token)
            ->get();


            $password = Hash::make($request->password);
            // dd($password);

        foreach ($user as $u) {
            // dd($u->email);

            $user_update = DB::table('users')
                ->where('email', $u->email)
                ->update(['password' => $password]);

            // dd($user_update);

            
        }

        if($user_update == '1'){
            session()->flash('success', 'Password changed successfully');
        } else {
            session()->flash('danger', 'There are some issues in changing password');
        }
        // dd($user['email']);


    }
}
