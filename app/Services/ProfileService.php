<?php
namespace App\Services;

use App\Http\Requests\Profile\Update;
use App\Models\User;

 class ProfileService{

    public function index(){

    }

    public function update(Update $request){
        // dd(3);   
        // dd($validated);
        $user = auth()->user();
        $user->update([
            'name' =>$request->name,
            'email' => $request->email,
            'mobile_no' => $request->mobile_no,
            'city_id' => $request->city_id
        ]);
    }

    
}
