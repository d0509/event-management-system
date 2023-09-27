<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\Update;
use App\Models\User;
use App\Services\CityService;
use App\Services\ProfileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    
    protected $cityservice;
    protected $profileservice;

    public function __construct(CityService $cityservice, ProfileService $profileservice){
        $this->cityservice = $cityservice;
        $this->profileservice = $profileservice;
    }

    public function index()
    {
        return view('admin.profile.index');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $cities = $this->cityservice->getAllCities();
        return view('admin.profile.edit',[
            'cities' => $cities,
            'user' => Auth::user()
        ]);
    }

    public function update(Update $request, User $user)
    {
        
        $this->profileservice->update($request,$user);
        return redirect()->route('profile.index');
    }

    public function destroy(string $id)
    {
        //
    }
}
