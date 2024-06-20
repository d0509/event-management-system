<?php

namespace App\Services;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Admin\Password\Update;
use Illuminate\Validation\ValidationException;

class PasswordService{

    public function update($request){
        $user = Auth::user();
        if(!Hash::check($request->password, Auth::user()->password)){
            throw ValidationException::withMessages([
                'password' => "Old Password Doesn't match!."
            ]);
        } else {
            $user->update([
                'password' => Hash::make($request->new_password)
            ]);

            session()->flash('success', 'Password Changed successfully.');
        }        
    }
}
