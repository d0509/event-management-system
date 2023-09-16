<?php

namespace App\Services;

use App\Http\Requests\Auth\Login;
use App\Http\Requests\Auth\Register;
use App\Http\Requests\Auth\ResetPassword;
use App\Models\PasswordResetToken;
use App\Models\RoleUser;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Auth\Notifications\ResetPassword as NotificationsResetPassword;
use Illuminate\Support\Facades\Alert;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;


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

        session()->flash('success', ' You have been logged in successfully.');
    }

    public function resetPassword(ResetPassword $request)
    {
        $user = $request->validated();
        // dd($user['email']);
        $user = User::where('email', $user['email'])->first();

        $token = Str::random(64);

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

        // $mail = Mail::send('email.forgetPassword', ['token' => $token], function($message) use($request){
        //     $message->to($request->email);
        //     $message->subject('Reset Password');
        // });

        // if($mail){
        //     session()->flash('success', ' We have e-mailed your password reset link!');  
        // } else {
        //     session()->flash('danger','We are facing some issues sending you mail');
        // }
        $user->notify(new NotificationsResetPassword($user['email'], $token));
    }
}
