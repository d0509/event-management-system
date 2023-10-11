<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class QRCodeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        // $simple = \QrCode::size(120)->generate('231011090');
        
        // return view('User.pages.qr-code', compact('simple'));
    }
}
