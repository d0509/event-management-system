<?php

namespace App\Jobs;

use App\Models\User;
use App\Notifications\EventApprovedNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NotifyEventUser implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    
    protected $event,$updatedStatus;

    public function __construct($updatedStatus,$event )
    {
        $this->event = $event;
        $this->updatedStatus = $updatedStatus;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // dd($this->event->city_id);
        $users = User::where('city_id',($this->event->city_id))->where('role_id',3)->get();

        foreach($users as $user){
            $user->notify(new EventApprovedNotification($this->event));
        }
    }
}
