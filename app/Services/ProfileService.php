<?php

namespace App\Services;

use App\Http\Requests\Profile\Update;
use Plank\Mediable\Mediable;
use App\Models\User;
use Plank\Mediable\Facades\MediaUploader;

class ProfileService
{

    public function index()
    {
    }

    public function update(Update $request)
    {
        // dd(3);   
        // dd($request->files);
        // dd($validated);
        $user = auth()->user();
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'mobile_no' => $request->mobile_no,
            'city_id' => $request->city_id
        ]);

        if ($request->hasFile('profile')) {

            
            // dd(empty($user->media[0]));
            if (!empty($user->media[0])) {
                // dd($user->media);
                // dd('user already have profile picture and i want to update it');
                $profileMedia = $user->getMedia('profile')->first();
                // dd($request->files);
                if ($profileMedia) {
                    // Replace the 'banner' media with the new file
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
    }
}
