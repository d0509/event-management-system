<?php

namespace App\Services;

use App\Http\Requests\Profile\Update;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Plank\Mediable\Facades\MediaUploader;

class ProfileService
{

    public function index()
    {
    }

    public function update(Update $request, User $user)
    {
        
        $user = Auth::user();
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'mobile_no' => $request->mobile_no,
            'city_id' => $request->city_id
        ]);

        if ($request->hasFile('profile')) {

            if (!empty($user->media[0])) {
                // dd($user->media);
                // dd('user already have profile picture and i want to update it');
                $profileMedia = $user->getMedia('profile')->first();
                // dd($request->files);
                if ($profileMedia) {
                    
                    MediaUploader::fromSource($request->file('profile'))
                        ->replace($profileMedia);

                    // Optionally, you can also update the media's attributes if needed
                    $user->syncMedia($profileMedia, 'profile');
                }
            } else {
                // dd(' i want to set my profile as this photo. it was blank earlier');
                $media = MediaUploader::fromSource($request->profile)
                    ->toDisk('public')
                    ->toDirectory('profile')
                    ->upload();

                $user->attachMedia($media, 'profile');
               
            }
        }

        session()->flash('success','Profile Updated successfully');
    }
}
