<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Profile\Update;
use Plank\Mediable\Facades\MediaUploader;

class ProfileService
{

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
                $profileMedia = $user->getMedia('profile')->first();
                if ($profileMedia) {
                    MediaUploader::fromSource($request->file('profile'))
                        ->replace($profileMedia);

                    // Optionally, you can also update the media's attributes if needed
                    $user->syncMedia($profileMedia, 'profile');
                }
            } else {
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
