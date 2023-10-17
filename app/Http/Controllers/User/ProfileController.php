<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\CityService;
use App\Services\ProfileService;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\Update;

class ProfileController extends Controller
{

    protected $cityService;
    protected $profileService;

    public function __construct(CityService $cityService, ProfileService $profileService )
    {
        $this->cityService = $cityService;
        $this->profileService = $profileService;
    }

    
    public function index()
    {
        $cities = $this->cityService->collection();
        return view('frontend.profile.edit',[
            'cities' => $cities,
            'user' => Auth::user()
        ]);
    }

    public function update(Update $request, User $user)
    {
        $this->profileService->update($request,$user);
        return redirect()->route('home');
    }
}
