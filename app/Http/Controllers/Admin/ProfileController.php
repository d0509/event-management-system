<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\Update;
use App\Models\User;
use App\Services\CityService;
use App\Services\ProfileService;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    
    protected $cityService;
    protected $profileService;

    public function __construct(ProfileService $profileService){
        $this->cityService = new CityService();
        $this->profileService = $profileService;
    }

    public function index()
    {
        return view('backend.pages.profile.index');
    }

    public function edit(string $id)
    {
        $cities = $this->cityService->collection();
        return view('backend.pages.profile.edit',[
            'cities' => $cities,
            'user' => Auth::user()
        ]);
    }

    public function update(Update $request, User $user)
    {
        
        $this->profileService->update($request,$user);
        return redirect()->route('profile.index');
    }

}
