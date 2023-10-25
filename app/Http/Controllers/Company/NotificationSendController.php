<?php

namespace App\Http\Controllers\Company;

use App\Models\User;
use App\Services\Fcm;
use App\Models\DeviceUser;
use Illuminate\Http\Request;
use Jenssegers\Agent\Facades\Agent;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class NotificationSendController extends Controller
{

    public function create(Request $request)
    {
        // dd($request->id);

        $user = User::find($request->id);
        // dd($user);
        $deviceUsers = DeviceUser::where('user_id', $request->id)->get();
        $token = $request->_token;
        dd($token);
        $boolean = false;
        // dd($deviceUsers);

        foreach ($deviceUsers as $deviceUser) {
            if ($token == $deviceUser->token) {
                $boolean = true;
            }
        }

        if ($boolean == false) {
            $this->update($request);
        }

        $data = [
            "to" => $user->deviceUser,
            "notification" =>
            [
                "title" => 'Web Push',
                "body" => "Sample Notification",
                "icon" => url('/logo.png')
            ],
        ];
        $dataString = json_encode($data);

        $headers = [
            'Authorization: key=AAAAPosz7eg:APA91bHAv-I5Di1XvwWjnrj-aKV9voPe4rlD-hdfmJLbYQFJ7FBjdpF717iuUUMOXBLUiOQ6C2Wu4iSGfTt_llGl3a7Lmbdo4JkoyPK69ozS4Z-QhQ29Ij2R-uA1ALpyh2NPL2wQOom-',
            'Content-Type: application/json',
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

        curl_exec($ch);

        return redirect()->route('home')->with('message', 'Notification sent!');
    }

    public function update(Request $request)
    {
       $ifExists =  DeviceUser::where('user_id',Auth::id())->where('token',$request->fcm_token);
       dd($ifExists);
        $deviceUser = DeviceUser::create([
            'user_id' => Auth::id(),
            'token' => $request->fcm_token,
            'device_type' => 'Web'
        ]);

        return response()->json(['Token successfully stored.']);
    }
}
