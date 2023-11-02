<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Services\CityService;
use App\Services\ProfileService;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\Update;

class ProfileController extends Controller
{

    protected $cityService;
    protected $profileService;

    public function __construct( ProfileService $profileService )
    {
        $this->cityService = new CityService();
        $this->profileService = $profileService;
    }
    
    public function index()
    {
        $cities = $this->cityService->collection();
        return view('frontend.pages.edit-profile',[
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
