<?php

namespace App\Services;

use App\Http\Requests\Admin\Password\Change;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class PasswordService{

    public function update(Change $request){
        // dd(Hash::make($request->password));

        $user = auth()->user();
        // dd($user->password);

        if(!Hash::check($request->password, auth()->user()->password)){
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


?>