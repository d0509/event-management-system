<?php

namespace App\Http\Controllers\Company;

use App\Models\User;
use App\Services\Fcm;
use App\Models\DeviceUser;
use Illuminate\Http\Request;
use Jenssegers\Agent\Facades\Agent;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Services\NotificationService;

class NotificationSendController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function create(Request $request)
    {
        return $this->notificationService->create($request);
    }
}
