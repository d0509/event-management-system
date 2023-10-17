<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\Update;
use App\Models\User;
use App\Services\CityService;
use App\Services\ProfileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{

    protected $cityService;
    protected $profileService;

    public function __construct(CityService $cityService, ProfileService $profileService )
    {
        $this->cityService = $cityService;
        $this->profileService = $profileService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cities = $this->cityService->collection();
        return view('frontend.profile.edit',[
            'cities' => $cities,
            'user' => Auth::user()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
       
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Update $request, User $user)
    {
        $this->profileService->update($request,$user);
        return redirect()->route('homepage');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
