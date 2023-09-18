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
        // dd($validated);
        $user = auth()->user();
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'mobile_no' => $request->mobile_no,
            'city_id' => $request->city_id
        ]);

        if ($request->hasFile('profile')) {
            $profileMedia = $user->getMedia('profile')->first();

            if ($profileMedia) {
                // Replace the 'banner' media with the new file
                MediaUploader::fromSource($request->file('profile'))
                    ->replace($profileMedia);

                // Optionally, you can also update the media's attributes if needed
                $user->syncMedia($profileMedia, 'profile');
            }
        }
    }
}
